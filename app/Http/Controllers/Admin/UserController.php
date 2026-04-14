<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['users'] = User::orderBy('name', 'asc')->get();

        return view('admin.user.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        return view('admin.user.create');
    }

    public function save(Request $request): RedirectResponse
    {
        // TODO: update Blade form input names to match new column names (role, id_number, salary, phone_number, receives_notifications)
        $validatedUserData = $request->only(['name', 'email', 'password', 'role', 'id_number', 'salary', 'phone_number', 'receives_notifications']);
        $validatedUserData['password'] = Hash::make($validatedUserData['password']);

        try {
            User::create($validatedUserData);
            session()->flash('success', __('admin_user.flash_store_success'));
        } catch (Exception $e) {
            session()->flash('error', __('admin_user.flash_store_error', ['error' => $e->getMessage()]));
        }

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

        // TODO: update Blade form input names to match new column names (role, id_number, salary, phone_number, receives_notifications)
        $data = $request->only(['name', 'email', 'role', 'id_number', 'salary', 'phone_number', 'receives_notifications']);
        $data['receives_notifications'] = $request->has('receives_notifications') ? 1 : 0;

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        try {
            $user->update($data);
            session()->flash('success', __('admin_user.flash_update_success'));
        } catch (Exception $e) {
            session()->flash('error', __('admin_user.flash_update_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.user.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $user = User::findOrFail($id);

            if ($user->projects()->exists()) {
                session()->flash('error', __('admin_user.cant_delete_has_projects', ['name' => $user->getName()]));

                return redirect()->route('admin.user.index');
            }

            $user->delete();
            session()->flash('success', __('admin_user.flash_destroy_success'));
        } catch (Exception $e) {
            session()->flash('error', __('admin_user.flash_destroy_error', ['error' => $e->getMessage()]));
        }

        return redirect()->route('admin.user.index');
    }
}
