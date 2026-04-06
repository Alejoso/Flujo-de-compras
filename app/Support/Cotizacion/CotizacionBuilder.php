<?php

namespace App\Support\Cotizacion;

use App\Models\VersionCotizacion;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class CotizacionBuilder
{
    // Construye el array de datos de tipos de material con sus presentaciones para el formulario de crear/editar.
    public function buildTmData(EloquentCollection $tipoMateriales): array
    {
        return $tipoMateriales->mapWithKeys(fn ($tm) => $this->buildTmEntry($tm))->all();
    }

    // Construye la colección de materiales de una versión para mostrarlos en las vistas de detalle y edición.
    public function buildMateriasVersion(VersionCotizacion $version): Collection
    {
        return $version->getPresentacionTipoMaterialVersionCotizaciones()->map(fn ($item) => $this->buildMaterialEntry($item));
    }

    // Construye la entrada de un tipo de material con su label y presentaciones.
    private function buildTmEntry($tm): array
    {
        $unidadMedida = $tm->getTipo()->getUnidadMedida();

        return [$tm->getId() => [
            'label' => $tm->getMaterial()->getDescripcion().' — '.$tm->getTipo()->getEspecificacion(),
            'presentaciones' => $tm->getPresentacionTipoMateriales()
                ->map(fn ($ptm) => $this->buildPresentacionEntry($ptm, $unidadMedida))
                ->values(),
        ]];
    }

    // Construye la entrada de una presentación con id, nombre y unidad.
    private function buildPresentacionEntry($ptm, $unidadMedida): array
    {
        return [
            'id' => $ptm->getId(),
            'nombre' => $ptm->getPresentacion()->getNombre(),
            'unidad' => $ptm->getCantidadPresentacion().($unidadMedida ? ' '.$unidadMedida->getAbreviatura() : ''),
        ];
    }

    // Construye la entrada de un material de versión para las vistas de detalle y edición.
    private function buildMaterialEntry($item): array
    {
        $ptm = $item->getPresentacionTipoMaterial();
        $tm = $ptm->getTipoMaterial();
        $unidadMedida = $tm->getTipo()->getUnidadMedida();

        return [
            'ptmId' => $ptm->getId(),
            'descripcion' => $tm->getMaterial()->getDescripcion(),
            'especificacion' => $tm->getTipo()->getEspecificacion(),
            'presentacion' => $ptm->getPresentacion()->getNombre(),
            'unidad' => $ptm->getCantidadPresentacion().($unidadMedida ? ' '.$unidadMedida->getAbreviatura() : ''),
            'cantidad' => $item->getCantidad(),
        ];
    }
}
