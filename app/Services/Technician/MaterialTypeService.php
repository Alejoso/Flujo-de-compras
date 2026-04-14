<?php

namespace App\Services\Technician;

use App\Models\MaterialType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class MaterialTypeService
{
    private const RELATIONS = [
        'material',
        'type.unitOfMeasure',
        'presentationMaterialTypes.presentation',
    ];

    public function search(string $term): Collection
    {
        $query = MaterialType::with(self::RELATIONS);

        if ($term === '') {
            return $query->limit(50)->get();
        }

        return $query
            ->whereHas('material', fn (Builder $sub) => $sub->where('description', 'ilike', "%{$term}%"))
            ->orWhereHas('type', fn (Builder $sub) => $sub->where('specification', 'ilike', "%{$term}%"))
            ->limit(20)
            ->get();
    }
}
