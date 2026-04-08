<?php

namespace App\Services\Tecnico;

use App\Models\TipoMaterial;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TipoMaterialService
{
    private const RELATIONS = [
        'material',
        'tipo.unidadMedida',
        'presentacionTipoMateriales.presentacion',
    ];

    public function search(string $term): Collection
    {
        $query = TipoMaterial::with(self::RELATIONS);

        if ($term === '') {
            return $query->limit(50)->get();
        }

        return $query
            ->whereHas('material', fn (Builder $sub) => $sub->where('descripcion', 'ilike', "%{$term}%"))
            ->orWhereHas('tipo', fn (Builder $sub) => $sub->where('especificacion', 'ilike', "%{$term}%"))
            ->limit(20)
            ->get();
    }
}
