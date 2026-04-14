<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Material\StoreMaterialRequest;
use App\Models\Material;
use App\Models\MaterialType;
use App\Models\Presentation;
use App\Models\PresentationMaterialType;
use App\Models\Type;
use App\Models\UnitOfMeasure;
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
        $viewData['materials'] = Material::with(['materialTypes.type.unitOfMeasure', 'materialTypes.presentationMaterialTypes.presentation'])
            ->when($search, fn ($q) => $q->where('description', 'ilike', "%{$search}%"))
            ->orderBy('description', 'asc')
            ->paginate(15);
        $viewData['search'] = $search;

        return view('admin.material.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['materials'] = Material::orderBy('description')->get();
        $viewData['unitOfMeasures'] = UnitOfMeasure::orderBy('name')->get();
        $viewData['presentations'] = Presentation::orderBy('name')->get();

        return view('admin.material.create')->with('viewData', $viewData);
    }

    public function save(StoreMaterialRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            if ($data['material_mode'] === 'new') {
                $material = Material::create(['description' => $data['description']]);
            } else {
                $material = Material::findOrFail($data['material_id']);
            }

            foreach ($data['types'] as $typeData) {
                $type = Type::create([
                    'specification' => $typeData['specification'],
                    'unit_of_measure_id' => $typeData['unit_of_measure_id'] ?? null,
                ]);

                $materialType = MaterialType::create([
                    'material_id' => $material->getId(),
                    'type_id' => $type->getId(),
                ]);

                foreach ($typeData['presentations'] as $presData) {
                    PresentationMaterialType::create([
                        'presentation_quantity' => $presData['presentation_quantity'],
                        'presentation_id' => $presData['presentation_id'],
                        'material_type_id' => $materialType->getId(),
                    ]);
                }
            }

            DB::commit();
            session()->flash('success', __('material.success_created', ['name' => $material->getDescription()]));
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('error', __('material.error_create', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.material.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $material = Material::findOrFail($id);
            $description = $material->getDescription();
            $material->delete();
            session()->flash('success', __('material.success_deleted', ['name' => $description]));
        } catch (Exception $e) {
            session()->flash('error', __('material.error_delete', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.material.index');
    }
}
