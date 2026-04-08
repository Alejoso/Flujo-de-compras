<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Material\StoreMaterialRequest;
use App\Models\Material;
use App\Models\Presentacion;
use App\Models\PresentacionTipoMaterial;
use App\Models\Tipo;
use App\Models\TipoMaterial;
use App\Models\UnidadMedida;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search', '');

        $viewData = [];
        $viewData['materiales'] = Material::with(['tipoMateriales.tipo.unidadMedida', 'tipoMateriales.presentacionTipoMateriales.presentacion'])
            ->when($search, fn ($q) => $q->where('descripcion', 'ilike', "%{$search}%"))
            ->orderBy('descripcion', 'asc')
            ->paginate(15);
        $viewData['search'] = $search;

        return view('admin.material.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['materiales'] = Material::orderBy('descripcion')->get();
        $viewData['unidades'] = UnidadMedida::orderBy('nombre')->get();
        $viewData['presentaciones'] = Presentacion::orderBy('nombre')->get();

        return view('admin.material.create')->with('viewData', $viewData);
    }

    public function save(StoreMaterialRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            if ($data['material_mode'] === 'new') {
                $material = Material::create(['descripcion' => $data['descripcion']]);
            } else {
                $material = Material::findOrFail($data['material_id']);
            }

            foreach ($data['tipos'] as $tipoData) {
                $tipo = Tipo::create([
                    'especificacion' => $tipoData['especificacion'],
                    'unidadMedidaId' => $tipoData['unidadMedidaId'] ?? null,
                ]);

                $tipoMaterial = TipoMaterial::create([
                    'materialId' => $material->getId(),
                    'tipoId'     => $tipo->getId(),
                ]);

                foreach ($tipoData['presentaciones'] as $presData) {
                    PresentacionTipoMaterial::create([
                        'cantidadPresentacion' => $presData['cantidadPresentacion'],
                        'presentacionId'       => $presData['presentacionId'],
                        'tipoMaterialId'       => $tipoMaterial->getId(),
                    ]);
                }
            }

            DB::commit();
            session()->flash('success', 'Material "' . $material->getDescripcion() . '" creado exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al crear el material: ' . $e->getMessage());
        }

        return redirect()->route('admin.material.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $material = Material::findOrFail($id);
            $nombre = $material->getDescripcion();
            $material->delete();
            session()->flash('success', 'Material "' . $nombre . '" eliminado exitosamente.');
        } catch (Exception $e) {
            session()->flash('error', 'Error al eliminar: ' . $e->getMessage());
        }

        return redirect()->route('admin.material.index');
    }
}