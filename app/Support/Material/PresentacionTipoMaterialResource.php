<?php

namespace App\Support\Material;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PresentacionTipoMaterialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $unidadMedida = $this->resource->tipoMaterial->getTipo()->getUnidadMedida();

        return [
            'id' => $this->resource->getId(),
            'nombre' => $this->resource->getPresentacion()->getNombre(),
            'unidad' => $this->buildUnidad($unidadMedida),
        ];
    }

    private function buildUnidad($unidadMedida): string
    {
        $cantidad = $this->resource->getCantidadPresentacion();

        return $unidadMedida
            ? $cantidad.' '.$unidadMedida->getAbreviatura()
            : (string) $cantidad;
    }
}
