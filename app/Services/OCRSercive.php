<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class OCRSercive
{
    private string $apiKey;
    private string $baseUrl = 'https://api.mistral.ai/v1';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function extractMarkdown(string $fileContent, string $fileName): string
    {
        $base64 = base64_encode($fileContent);
        $mimeType = str_ends_with(strtolower($fileName), '.pdf') ? 'application/pdf' : 'image/jpeg';

        $response = Http::withHeaders([

            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',

        ])->post("{$this->baseUrl}/ocr", [ // Send to this place https://api.mistral.ai/v1/ocr

            'model'    => 'mistral-ocr-latest',

            'document' => [
                'type'         => 'document_url',
                'document_url' => "data:{$mimeType};base64,{$base64}",
            ],

        ]);

        if ($response->failed()) {
            throw new Exception('Error en OCR: ' . $response->body());
        }

        return $response->json('pages.0.markdown'); // ojo: índice 0, no 1
    }

    public function structureData(string $markdown): array
    {
        $response = Http::withHeaders([

            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',

        ])->post("{$this->baseUrl}/chat/completions", [ // Send to this place https://api.mistral.ai/v1/chat/completions

            'model'           => 'mistral-small-latest',
            'response_format' => ['type' => 'json_object'],

            'messages' => [
                [
                    'role'    => 'system',
                    'content' => $this->buildPrompt(),
                ],
                [
                    'role'    => 'user',
                    'content' => $markdown,
                ],
            ],

        ]);

        if ($response->failed()) {
            throw new Exception('Error estructurando datos: ' . $response->body());
        }

        $content = $response->json('choices.0.message.content');

        return json_decode($content, true);
    }

    public function validate(array $markdownJSONData): array
    {
        $subtotal = $markdownJSONData['subtotal'] ?? 0;
        $iva      = $markdownJSONData['iva'] ?? 0;
        $total    = $markdownJSONData['total'] ?? 0;
        $tolerance = max(1, $total * 0.001); // 0.1% of tolerance. Min is $1

        // Validate that subtotal + iva ≈ total 
        $markdownJSONData['validatedSubtotalIVA'] = abs(($subtotal + $iva) - $total) <= $tolerance;

        // Validate if items sum the subtotal (Tolerate $1 if there are aproximates)
        if (!empty($markdownJSONData['items'])) {
            $sumItems = collect($markdownJSONData['items'])->sum('valor_total'); // Sum every item total value. Same as a foreach but cleaner
            
            $validationItems = abs($sumItems - $total) <= $tolerance;

            // Try to see if the provider does not have IVA included in the product prices
            if($validationItems == false) {
                $validationItems = abs(($sumItems * 1.19) - $total) <= $tolerance;
            }

            $markdownJSONData['validatedItems'] = $validationItems;
        }

        return $markdownJSONData;
    }

    public function processInvoice(string $fileContent , string $fileName): array
    {
        $markdown  = $this->extractMarkdown($fileContent , $fileName);
        $markdownJSONData    = $this->structureData($markdown);
        $validatedData = $this->validate($markdownJSONData);

        return $validatedData;
    }

    private function buildPrompt(): string
    {
        return '
Eres un extractor de facturas colombianas. Devuelve SOLO JSON válido, sin texto adicional.
Si un campo no existe en el documento, ponlo en null. NUNCA inventes valores.

Estructura requerida:
{
  "numero_factura": string,
  "nit_proveedor": string,
  "nombre_proveedor": string,
  "fecha_emision": string (YYYY-MM-DD),
  "items": [
    {
      "codigo": string o null,
      "descripcion": string,
      "cantidad": number,
      "valor_unitario": float,
      "valor_total": float
    }
  ],
  "subtotal": float
  "iva": float
  "total": float
}

Reglas:
- Valores numéricos sin símbolos ($, puntos de miles, comas)
- Los valores flotantes deben estar sin símbolos. Se separan los decimeles con un punto.
- Fechas siempre en formato YYYY-MM-DD
- Si el IVA no aparece explícito, calcularlo como total - subtotal
- Es importante que el nit conserve los simbolos de guion (-) que estan casi al final
        ';
    }
}
