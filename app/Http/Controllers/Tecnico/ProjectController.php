<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['projects'] = Proyecto::paginate(12);

        return view('tecnico.project.index')->with('viewData', $viewData);
    }
}
