<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData["users"] = User::all();

        return view('admin.user.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        return view('admin.user.create');
    }

    public function save(Request $request): RedirectResponse
    {
        $validatedUserData = $request->only(['name', 'email', 'password', 'rol', 'cedula', 'sueldo', 'numeroTelefono', 'recibeNotificaciones']);
        $validatedUserData['password'] = Hash::make($validatedUserData['password']);

        User::create($validatedUserData);

        session()->flash('success', 'Usuario creado exitosamente');

        return redirect()->route('admin.user.index');
    }

    public function edit(int $id): View
    {
        $viewData = [];
        $viewData['user'] = User::findOrFail($id);

        return view('admin.user.edit')->with('viewData', $viewData);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $data = $request->only(['name', 'email', 'rol', 'cedula', 'sueldo', 'numeroTelefono', 'recibeNotificaciones']);
        $data['recibeNotificaciones'] = $request->has('recibeNotificaciones') ? 1 : 0;

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $user->update($data);

        session()->flash('success', 'Usuario actualizado exitosamente');

        return redirect()->route('admin.user.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('success', 'Usuario eliminado exitosamente');

        return redirect()->route('admin.user.index');
    }
}
