<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Proyecto\SaveProyectoRequest;
use App\Http\Requests\Proyecto\UpdateProyectoRequest;
use App\Models\Cliente;
use App\Models\Proyecto;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search', '');
        $estado = $request->query('estado', '');

        $viewData['projects'] = Proyecto::when($search, fn ($q) => $q->where('nombre', 'ilike', "%{$search}%"))
            ->when($estado, fn ($q) => $q->where('estado', $estado))
            ->paginate(12)
            ->withQueryString();
        $viewData['search'] = $search;
        $viewData['estado'] = $estado;

        return view('admin.project.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['clients'] = Cliente::orderBy('nombre', 'asc')->get();

        return view('admin.project.create')->with('viewData', $viewData);
    }

    public function save(SaveProyectoRequest $request): RedirectResponse
    {
        $validatedProjectData = $request->validated();
        $validatedProjectData['creadoPor'] = auth()->user()->getId();

        try {
            $project = Proyecto::create($validatedProjectData);
            session()->flash('success', __('proyecto.project_created', ['name' => $project->getNombre()]));
        } catch (Exception $e) {
            session()->flash('error', __('proyecto.flash_save_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.project.index');
    }

    public function show(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($id);

        return view('admin.project.show')->with('viewData', $viewData);
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($id);
        $viewData['clients'] = Cliente::orderBy('nombre', 'asc')->get();

        return view('admin.project.edit')->with('viewData', $viewData);
    }

    public function update(UpdateProyectoRequest $request, string $id): RedirectResponse
    {
        $validatedProjectData = $request->validated();

        try {
            $project = Proyecto::findOrFail($id);
            $project->update($validatedProjectData);
            session()->flash('success', __('proyecto.project_updated', ['name' => $project->getNombre()]));
        } catch (Exception $e) {
            session()->flash('error', __('proyecto.flash_update_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.project.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $project = Proyecto::findOrFail($id);
            $project->delete();
            session()->flash('success', __('proyecto.flash_destroy_success' , ['name' => $project->getNombre()]));
        } catch (Exception $e) {
            session()->flash('error', __('proyecto.flash_destroy_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.project.index');
    }

    public function showQuotations(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($id);
        $viewData['cotizaciones'] = $viewData['project']->cotizaciones()
            ->withCount('versionCotizaciones')
            ->get();

        return view('admin.project.quotations')->with('viewData', $viewData);
    }
}
