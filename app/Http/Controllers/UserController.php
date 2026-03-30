<?php

namespace App\Http\Controllers;

use App\Mail\SendQuote;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData["users"] = User::all();

        return view('user.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        return view('user.create');
    }

    public function save(Request $request): RedirectResponse
    {
        $validatedUserData = $request->only(['name', 'email', 'password', 'rol', 'cedula', 'sueldo', 'numeroTelefono', 'recibeNotificaciones']);
        $validatedUserData['password'] = Hash::make($validatedUserData['password']);
        
        User::create($validatedUserData);

        session()->flash('success', 'Usuario creado exitosamente');

        return redirect()->route('user.index');
    }


}