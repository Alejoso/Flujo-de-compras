<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['usersWithNoNotifications'] = User::where('recibeNotificaciones', false)->get();
        $viewData['userWithNotifications'] = User::where('recibeNotificaciones', true)->get();

        return view('admin.notification.index')->with('viewData', $viewData);
    }

    public function save(Request $request): RedirectResponse
    {
        try {
            $user = User::findOrFail($request->input('user_id'));
            $user->setRecibeNotificaciones(true);
            $user->save();
            session()->flash('success', __('notificacion.user_added', ['name' => $user->getName()]));
        } catch (Exception $e) {
            session()->flash('error', __('notificacion.flash_save_error', ['error' => $e->getMessage()]));
        }

        return back();
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->setRecibeNotificaciones(false);
            $user->save();
            session()->flash('success', __('notificacion.user_removed', ['name' => $user->getName()]));
        } catch (Exception $e) {
            session()->flash('error', __('notificacion.flash_destroy_error', ['error' => $e->getMessage()]));
        }

        return back();
    }
}
