<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\SaveProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Client;
use App\Models\Project;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search', '');
        $status = $request->query('status', '');

        $viewData['projects'] = Project::when($search, fn ($q) => $q->where('name', 'ilike', "%{$search}%"))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->paginate(12)
            ->withQueryString();
        $viewData['search'] = $search;
        $viewData['status'] = $status;

        return view('admin.project.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['clients'] = Client::orderBy('name', 'asc')->get();

        return view('admin.project.create')->with('viewData', $viewData);
    }

    public function save(SaveProjectRequest $request): RedirectResponse
    {
        $validatedProjectData = $request->validated();
        $validatedProjectData['created_by'] = auth()->user()->getId();

        try {
            $project = Project::create($validatedProjectData);
            session()->flash('success', __('proyecto.project_created', ['name' => $project->getName()]));
        } catch (Exception $e) {
            session()->flash('error', __('proyecto.flash_save_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.project.index');
    }

    public function show(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Project::findOrFail($id);

        return view('admin.project.show')->with('viewData', $viewData);
    }

    public function edit(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Project::findOrFail($id);
        $viewData['clients'] = Client::orderBy('name', 'asc')->get();
        $viewData['states'] = ['Negotiation', 'In Progress', 'Completed'];

        return view('admin.project.edit')->with('viewData', $viewData);
    }

    public function update(UpdateProjectRequest $request, string $id): RedirectResponse
    {
        $validatedProjectData = $request->validated();

        try {
            $project = Project::findOrFail($id);
            $project->update($validatedProjectData);
            session()->flash('success', __('proyecto.project_updated', ['name' => $project->getName()]));
        } catch (Exception $e) {
            session()->flash('error', __('proyecto.flash_update_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.project.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();
            session()->flash('success', __('proyecto.flash_destroy_success', ['name' => $project->getName()]));
        } catch (Exception $e) {
            session()->flash('error', __('proyecto.flash_destroy_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.project.index');
    }

    public function showQuotations(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Project::findOrFail($id);
        $viewData['quotations'] = $viewData['project']->quotations()
            ->withCount('quotationVersions')
            ->get();

        return view('admin.project.quotations')->with('viewData', $viewData);
    }
}
