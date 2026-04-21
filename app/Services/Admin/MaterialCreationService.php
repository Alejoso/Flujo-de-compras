<?php

namespace App\Services\Admin;

use App\Models\Material;
use App\Models\MaterialType;
use App\Models\Presentation;
use App\Models\PresentationMaterialType;
use App\Models\Type;
use App\Models\UnitOfMeasure;
use Illuminate\Support\Facades\DB;

class MaterialCreationService
{
    public function createFullMaterial(array $data): Material
    {
        return DB::transaction(function () use ($data) {
            $material = $this->resolveMaterial($data);

            foreach ($data['types'] as $typeData) {
                $type = $this->resolveType($typeData);
                $materialType = $this->attachType($material, $type);

                foreach ($typeData['presentations'] as $presData) {
                    $presentation = $this->resolvePresentation($presData);
                    $this->attachPresentation($materialType, $presentation, $presData);
                }
            }

            return $material;
        });
    }

    private function resolveMaterial(array $data): Material
    {
        if ($data['material_mode'] === 'new') {
            return Material::create(['description' => $data['description']]);
        }

        return Material::findOrFail($data['material_id']);
    }

    private function resolveType(array $typeData): Type
    {
        if ($typeData['type_mode'] === 'existing') {
            return Type::findOrFail($typeData['type_id']);
        }

        $unitId = $typeData['unit_of_measure_id'] ?? null;

        if (($typeData['unit_mode'] ?? 'existing') === 'new' && ! empty($typeData['unit_name'])) {
            $unit = UnitOfMeasure::create([
                'name' => $typeData['unit_name'],
                'abbreviation' => $typeData['unit_abbreviation'],
            ]);
            $unitId = $unit->getId();
        }

        return Type::create([
            'specification' => $typeData['specification'],
            'unit_of_measure_id' => $unitId,
        ]);
    }

    private function resolvePresentation(array $presData): Presentation
    {
        if ($presData['presentation_mode'] === 'existing') {
            return Presentation::findOrFail($presData['presentation_id']);
        }

        return Presentation::create([
            'name' => $presData['presentation_name'],
        ]);
    }

    private function attachType(Material $material, Type $type): MaterialType
    {
        return MaterialType::create([
            'material_id' => $material->getId(),
            'type_id' => $type->getId(),
        ]);
    }

    private function attachPresentation(
        MaterialType $materialType,
        Presentation $presentation,
        array $presData
    ): PresentationMaterialType {
        return PresentationMaterialType::create([
            'presentation_quantity' => $presData['presentation_quantity'],
            'presentation_id' => $presentation->getId(),
            'material_type_id' => $materialType->getId(),
        ]);
    }
}
