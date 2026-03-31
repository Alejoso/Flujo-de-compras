<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Proyecto;
use App\Http\Requests\SaveProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
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
        return view('admin.project.create');
    }

    public function save(SaveProjectRequest $request): RedirectResponse
    {
        $validatedProjectData = $request->validated();

        try {
            $project = Proyecto::create($validatedProjectData);
            session()->flash('success','Se ha creado con exito el proyecto ' . $project->getNombre());
        } 
        catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return back();
    }

    public function show(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($id);

        return view('admin.project.show');
    }

    public function update(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Proyecto::findOrFail($id);

        return view('admin.project.edit');
    }

    public function patch(UpdateProjectRequest $request): RedirectResponse
    {
        return back();
    }


}
