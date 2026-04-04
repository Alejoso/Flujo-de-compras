<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\TipoMaterial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TipoMaterialController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $term = trim((string) $request->query('q', ''));

        $query = TipoMaterial::with([
            'material',
            'tipo.unidadMedida',
            'presentacionTipoMateriales.presentacion',
        ]);

        if ($term === '') {
            // Si no busca nada, traemos los primeros 50 (puedes ordenarlos por los más recientes o más usados)
            $query->limit(50);
        } else {
            // Si busca algo, aplicamos los filtros y traemos hasta 20 resultados
            $query->where(function ($q) use ($term) {
                $q->whereHas('material', function ($sub) use ($term) {
                    $sub->where('descripcion', 'ilike', '%'.$term.'%');
                })->orWhereHas('tipo', function ($sub) use ($term) {
                    $sub->where('especificacion', 'ilike', '%'.$term.'%');
                });
            })->limit(20);
        }

        $tipoMateriales = $query->get();

        $tmData = $tipoMateriales->mapWithKeys(function ($tm) {
            $unidadMedida = $tm->getTipo()->getUnidadMedida();

            return [$tm->getId() => [
                'label' => $tm->getMaterial()->getDescripcion().' — '.$tm->getTipo()->getEspecificacion(),
                'presentaciones' => $tm->getPresentacionTipoMateriales()->map(function ($ptm) use ($unidadMedida) {
                    return [
                        'id' => $ptm->getId(),
                        'nombre' => $ptm->getPresentacion()->getNombre(),
                        'unidad' => $ptm->getCantidadPresentacion().($unidadMedida ? ' '.$unidadMedida->getAbreviatura() : ''),
                    ];
                })->values(),
            ]];
        });

        return response()->json($tmData);
    }
}
