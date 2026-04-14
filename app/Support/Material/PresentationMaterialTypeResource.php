<?php

namespace App\Support\Material;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PresentationMaterialTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $unitOfMeasure = $this->resource->materialType->getType()->getUnitOfMeasure();

        return [
            'id' => $this->resource->getId(),
            'nombre' => $this->resource->getPresentation()->getName(),
            'unidad' => $this->buildUnit($unitOfMeasure),
        ];
    }

    private function buildUnit($unitOfMeasure): string
    {
        $quantity = $this->resource->getPresentationQuantity();

        return $unitOfMeasure
            ? $quantity.' '.$unitOfMeasure->getAbbreviation()
            : (string) $quantity;
    }
}
