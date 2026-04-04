<?php

namespace App\Support\Cotizacion;

use App\Models\Cotizacion;
use App\Models\Proyecto;
use App\Models\VersionCotizacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CotizacionPdfBuilder
{
    // Carga una versión de cotización con todas las relaciones necesarias para el PDF.
    public function cargarVersionConRelaciones(int|string $versionId): VersionCotizacion
    {
        return VersionCotizacion::with([
            'cotizacion.creador',
            'cotizacion.proyecto',
            'presentacionTipoMaterialVersionCotizaciones.presentacionTipoMaterial.presentacion',
            'presentacionTipoMaterialVersionCotizaciones.presentacionTipoMaterial.tipoMaterial.material',
            'presentacionTipoMaterialVersionCotizaciones.presentacionTipoMaterial.tipoMaterial.tipo.unidadMedida',
        ])->findOrFail($versionId);
    }

    // Prepara los datos necesarios para renderizar el PDF (técnico, fecha, materiales y número de cotización).
    public function prepararDatosPdf(VersionCotizacion $version): array
    {
        $cotizacion = $version->getCotizacion();
        $tecnico = $cotizacion->getCreadoPor();
        $numeroCotizacion = Cotizacion::where('proyectoId', $cotizacion->proyecto->getId())
            ->where('id', '<=', $cotizacion->getId())
            ->count();

        $fecha = Carbon::parse($version->getCreatedAt())->locale('es')->isoFormat('MMMM D, YYYY');

        $materiales = $version->getPresentacionTipoMaterialVersionCotizaciones()->map(function ($item) {
            $ptm = $item->getPresentacionTipoMaterial();
            $tm = $ptm->getTipoMaterial();
            $unidadMedida = $tm->getTipo()->getUnidadMedida();
            $unidades = $ptm->getCantidadPresentacion().($unidadMedida ? ' '.$unidadMedida->getAbreviatura() : '');

            return [
                'cantidad' => $item->getCantidad(),
                'unidades' => $unidades,
                'presentacion' => $ptm->getPresentacion()->getNombre(),
                'descripcion' => $tm->getMaterial()->getDescripcion(),
                'especificacion' => strtoupper($tm->getTipo()->getEspecificacion()),
            ];
        });

        return compact('tecnico', 'fecha', 'materiales', 'numeroCotizacion', 'version');
    }

    // Genera el PDF de una versión, lo guarda en el storage público y actualiza el campo pdfPath de la versión.
    public function generarYGuardarPdf(int $versionId, Proyecto $project): void
    {
        $version = $this->cargarVersionConRelaciones($versionId);
        [
            'tecnico' => $tecnico,
            'fecha' => $fecha,
            'materiales' => $materiales,
            'numeroCotizacion' => $numeroCotizacion,
            'version' => $version,
        ] = $this->prepararDatosPdf($version);

        $pdf = Pdf::loadView('pdf.cotizacion', compact('project', 'tecnico', 'fecha', 'materiales', 'numeroCotizacion', 'version'))
            ->setPaper('a4', 'portrait');

        $numeroVersion = $version->getNumeroVersion();
        $relativePath = 'proyecto_'.$project->getId()
            .'/cotizacion_'.$numeroCotizacion
            .'/p'.$project->getId().'_c'.$numeroCotizacion.'_v'.$numeroVersion.'.pdf';

        Storage::disk('public')->put($relativePath, $pdf->output());

        $version->pdfPath = $relativePath;
        $version->save();
    }
}
