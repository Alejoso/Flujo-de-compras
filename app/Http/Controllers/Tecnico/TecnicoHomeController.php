<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TecnicoHomeController extends Controller
{
    public function index(): View
    {
        return view('tecnico.home.index');
    }
}
