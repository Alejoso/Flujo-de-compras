<?php

namespace App\Services;

use App\Models\Cotizacion;
use App\Models\PresentacionTipoMaterialVersionCotizacion;
use App\Models\Proyecto;
use App\Models\VersionCotizacion;
use Illuminate\Support\Facades\Auth;

class CotizacionService
{
    // Crea la cotización inicial con su primera versión y materiales dentro de una transacción.
    public function crearCotizacion(Proyecto $project, array $materiales): array
    {
        $cotizacionId = null;
        $versionId = null;

        Cotizacion::query()->getConnection()->transaction(function () use ($project, $materiales, &$cotizacionId, &$versionId) {
            $cotizacion = Cotizacion::create([
                'proyectoId' => $project->getId(),
                'estado' => 'Tecnico',
                'creadoPor' => Auth::id(),
            ]);
            $cotizacionId = $cotizacion->getId();

            $version = VersionCotizacion::create([
                'numeroVersion' => '1',
                'esLaMasReciente' => true,
                'cotizacionId' => $cotizacion->getId(),
            ]);
            $versionId = $version->getId();

            foreach ($materiales as $item) {
                PresentacionTipoMaterialVersionCotizacion::create([
                    'cantidad' => $item['cantidad'],
                    'versionCotizacionId' => $version->getId(),
                    'presentacionTipoMaterialId' => $item['presentacionTipoMaterialId'],
                ]);
            }
        });

        return ['cotizacionId' => $cotizacionId, 'versionId' => $versionId];
    }

    // Crea una nueva versión de la cotización con los materiales dados dentro de una transacción.
    public function crearNuevaVersion(Cotizacion $cotizacion, array $materiales): int
    {
        $nuevaVersionId = null;

        Cotizacion::query()->getConnection()->transaction(function () use ($cotizacion, $materiales, &$nuevaVersionId) {
            $cotizacion->setEstado('Tecnico Editada');
            $cotizacion->save();

            $cotizacion->versionCotizaciones()->update(['esLaMasReciente' => false]);

            $nuevoNumeroVersion = $cotizacion->versionCotizaciones()->count() + 1;

            $nuevaVersion = VersionCotizacion::create([
                'numeroVersion' => (string) $nuevoNumeroVersion,
                'esLaMasReciente' => true,
                'cotizacionId' => $cotizacion->getId(),
            ]);
            $nuevaVersionId = $nuevaVersion->getId();

            foreach ($materiales as $item) {
                PresentacionTipoMaterialVersionCotizacion::create([
                    'cantidad' => $item['cantidad'],
                    'versionCotizacionId' => $nuevaVersion->getId(),
                    'presentacionTipoMaterialId' => $item['presentacionTipoMaterialId'],
                ]);
            }
        });

        return $nuevaVersionId;
    }

}
