<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
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
        $project = Proyecto::findOrFail($projectId);
        $version = $this->pdfBuilder->cargarVersionConRelaciones($versionId);
        [
            'tecnico' => $tecnico,
            'fecha' => $fecha,
            'materiales' => $materiales,
            'numeroCotizacion' => $numeroCotizacion,
            'version' => $version,
        ] = $this->pdfBuilder->prepararDatosPdf($version);

        return view('tecnico.cotizacion.pdf-view', compact('project', 'version', 'tecnico', 'fecha', 'materiales', 'numeroCotizacion'));
    }

    // Genera y descarga directamente el PDF de una versión específica.
    public function pdfDownload(string $projectId, string $versionId)
    {
        $project = Proyecto::findOrFail($projectId);
        $version = $this->pdfBuilder->cargarVersionConRelaciones($versionId);
        [
            'tecnico' => $tecnico,
            'fecha' => $fecha,
            'materiales' => $materiales,
            'numeroCotizacion' => $numeroCotizacion,
            'version' => $version,
        ] = $this->pdfBuilder->prepararDatosPdf($version);

        $numeroVersion = $version->getNumeroVersion();
        $numeroCotizacion = Cotizacion::where('proyectoId', $project->getId())
            ->where('id', '<=', $version->getCotizacion()->getId())
            ->count();

        return Pdf::loadView('pdf.cotizacion', compact('project', 'tecnico', 'fecha', 'materiales', 'numeroCotizacion', 'version'))
            ->setPaper('a4', 'portrait')
            ->download('p'.$project->getId().'_c'.$numeroCotizacion.'_v'.$numeroVersion.'.pdf');
    }
}
