<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tecnico\TipoMaterialResource;
use App\Services\Tecnico\TipoMaterialService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TipoMaterialController extends Controller
{
    public function __construct(
        private readonly TipoMaterialService $tipoMaterialService
    ) {}

    public function search(Request $request): JsonResponse
    {
        $term = trim((string) $request->query('q', ''));

        $tipoMateriales = $this->tipoMaterialService->search($term);

        return response()->json(
            TipoMaterialResource::keyedCollection($tipoMateriales)
        );
    }
}
