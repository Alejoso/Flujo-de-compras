<?php

namespace App\Support\Material;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'label' => $this->buildLabel(),
            'presentations' => PresentationMaterialTypeResource::collection(
                $this->resource->getPresentationMaterialTypes()
            ),
        ];
    }

    public static function keyedCollection(Collection $items): array
    {
        $keyed = [];

        foreach ($items as $item) {
            $keyed[$item->getId()] = (new static($item))->resolve();
        }

        return $keyed;
    }

    private function buildLabel(): string
    {
        return $this->resource->getMaterial()->getDescription()
            .' — '
            .$this->resource->getType()->getSpecification();
    }
}
