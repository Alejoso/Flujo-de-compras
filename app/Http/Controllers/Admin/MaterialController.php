<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Material\StoreMaterialRequest;
use App\Models\Material;
use App\Models\Presentation;
use App\Models\Type;
use App\Models\UnitOfMeasure;
use App\Services\Admin\MaterialCreationService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function __construct(
        private readonly MaterialCreationService $materialCreationService
    ) {}

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
        $viewData['types'] = Type::with('unitOfMeasure')->orderBy('specification')->get();
        $viewData['typesJson'] = $viewData['types']->map(fn ($type) => [
            'id' => $type->getId(),
            'specification' => $type->getSpecification(),
            'unit' => $type->unitOfMeasure
                ? $type->unitOfMeasure->getName().' ('.$type->unitOfMeasure->getAbbreviation().')'
                : null,
        ])->toJson();

        return view('admin.material.create')->with('viewData', $viewData);
    }

    public function save(StoreMaterialRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $material = $this->materialCreationService->createFullMaterial($data);
            session()->flash('success', __('material.success_created', ['name' => $material->getDescription()]));
        } catch (Exception $e) {
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
