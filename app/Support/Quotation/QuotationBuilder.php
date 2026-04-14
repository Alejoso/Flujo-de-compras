<?php

namespace App\Support\Quotation;

use App\Models\QuotationVersion;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class QuotationBuilder
{
    // Builds the material type data array with their presentations for the create/edit form.
    public function buildMaterialTypeData(EloquentCollection $materialTypes): array
    {
        return $materialTypes->mapWithKeys(fn ($mt) => $this->buildMaterialTypeEntry($mt))->all();
    }

    // Builds the materials collection of a version to display in detail and edit views.
    public function buildVersionMaterials(QuotationVersion $version): Collection
    {
        return $version->getPresentationMaterialTypeQuotationVersions()->map(fn ($item) => $this->buildMaterialEntry($item));
    }

    // Builds the entry for a material type with its label and presentations.
    private function buildMaterialTypeEntry($mt): array
    {
        $unitOfMeasure = $mt->getType()->getUnitOfMeasure();

        return [$mt->getId() => [
            'label' => $mt->getMaterial()->getDescription().' — '.$mt->getType()->getSpecification(),
            'presentaciones' => $mt->getPresentationMaterialTypes()
                ->map(fn ($pmt) => $this->buildPresentationEntry($pmt, $unitOfMeasure))
                ->values(),
        ]];
    }

    // Builds the entry for a presentation with its id, name, and unit.
    private function buildPresentationEntry($pmt, $unitOfMeasure): array
    {
        return [
            'id' => $pmt->getId(),
            'nombre' => $pmt->getPresentation()->getName(),
            'unidad' => $pmt->getPresentationQuantity().($unitOfMeasure ? ' '.$unitOfMeasure->getAbbreviation() : ''),
        ];
    }

    // Builds the material entry for a version for the detail and edit views.
    private function buildMaterialEntry($item): array
    {
        $pmt = $item->getPresentationMaterialType();
        $mt = $pmt->getMaterialType();
        $unitOfMeasure = $mt->getType()->getUnitOfMeasure();

        return [
            'ptmId' => $pmt->getId(),
            'descripcion' => $mt->getMaterial()->getDescription(),
            'especificacion' => $mt->getType()->getSpecification(),
            'presentacion' => $pmt->getPresentation()->getName(),
            'unidad' => $pmt->getPresentationQuantity().($unitOfMeasure ? ' '.$unitOfMeasure->getAbbreviation() : ''),
            'cantidad' => $item->getQuantity(),
        ];
    }
}
