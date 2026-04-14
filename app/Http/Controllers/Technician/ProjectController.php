<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Project;
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

        return view('tecnico.project.index')->with('viewData', $viewData);
    }
}
