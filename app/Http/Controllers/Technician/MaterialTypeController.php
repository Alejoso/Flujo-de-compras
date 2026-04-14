<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Services\Technician\MaterialTypeService;
use App\Support\Material\MaterialTypeResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaterialTypeController extends Controller
{
    public function __construct(
        private readonly MaterialTypeService $materialTypeService
    ) {}

    public function search(Request $request): JsonResponse
    {
        $term = trim((string) $request->query('q', ''));

        $materialTypes = $this->materialTypeService->search($term);

        return response()->json(
            MaterialTypeResource::keyedCollection($materialTypes)
        );
    }
}
