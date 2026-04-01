<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Proyecto;
use App\Http\Requests\Proyecto\SaveProyectoRequest;
use App\Http\Requests\Proyecto\UpdateProyectoRequest;
use App\Models\Cliente;
use Exception;

class ProjectController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['projects'] = Proyecto::paginate(12);

        return view('admin.project.index')->with('viewData' , $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['clients'] = Cliente::orderBy('nombre','asc')->get();

        return view('admin.project.create')->with('viewData' , $viewData);
    }

    public function save(SaveProyectoRequest $request): RedirectResponse
    {
        $validatedProjectData = $request->validated();
        $validatedProjectData['creadoPor'] = auth()->user()->getId();

        try {
            $project = Proyecto::create($validatedProjectData);
            session()->flash('success','Se ha creado con exito el proyecto ' . $project->getNombre());
        } 
        catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('admin.project.index');
    }

    public function show(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($id);

        return view('admin.project.show');
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($id);
        $viewData['clients'] = Cliente::orderBy('nombre','asc')->get();

        return view('admin.project.edit')->with('viewData', $viewData);
    }

    public function update(UpdateProyectoRequest $request , string $id): RedirectResponse
    {
        $validatedProjectData = $request->validated();

        try{
            $project = Proyecto::findOrFail($id);
            $project->update($validatedProjectData);
            session()->flash('success','Se ha actualizado el proyecto '. $project->getNombre());
        }
        catch (Exception $e){
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('admin.project.index');
    }


}
