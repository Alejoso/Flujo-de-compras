<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SaveUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
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

    public function save(SaveUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['receives_notifications'] = $request->has('receives_notifications') ? 1 : 0;

        User::create($data);
        session()->flash('success', __('admin_user.flash_store_success'));

        return redirect()->route('admin.user.index');
    }

    public function edit(int $id): View
    {
        $viewData = [];
        $viewData['user'] = User::findOrFail($id);

        return view('admin.user.edit')->with('viewData', $viewData);
    }

    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $data = $request->validated();
        $data['receives_notifications'] = $request->has('receives_notifications') ? 1 : 0;

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        session()->flash('success', __('admin_user.flash_update_success'));

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
