<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use App\Support\Cotizacion\CotizacionPdfBuilder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;

class CotizacionPdfController extends Controller
{
    public function __construct(private readonly CotizacionPdfBuilder $pdfBuilder) {}

    // Muestra la previsualización en pantalla del PDF de una versión específica.
    public function pdfView(string $projectId, string $versionId): View
    {
        [$project, $datos] = $this->cargarDatosPdf($projectId, $versionId);

        return view('tecnico.cotizacion.pdf-view', array_merge(['project' => $project], $datos));
    }

    // Genera y descarga directamente el PDF de una versión específica.
    public function pdfDownload(string $projectId, string $versionId)
    {
        [$project, $datos] = $this->cargarDatosPdf($projectId, $versionId);

        return Pdf::loadView('pdf.cotizacion', array_merge(['project' => $project], $datos))
            ->setPaper('a4', 'portrait')
            ->download('p'.$project->getId().'_c'.$datos['numeroCotizacion'].'_v'.$datos['version']->getNumeroVersion().'.pdf');
    }

    // Carga el proyecto y prepara todos los datos necesarios para renderizar el PDF.
    private function cargarDatosPdf(string $projectId, string $versionId): array
    {
        $project = Proyecto::findOrFail($projectId);
        $version = $this->pdfBuilder->cargarVersionConRelaciones($versionId);
        $datos = $this->pdfBuilder->prepararDatosPdf($version);

        return [$project, $datos];
    }
}
