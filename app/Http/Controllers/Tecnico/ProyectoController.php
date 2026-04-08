<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProyectoController extends Controller
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

        return view('tecnico.project.index')->with('viewData', $viewData);
    }
}
