<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendQuote;
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
            session()->flash('success', 'Se ha añadido a '.$user->getName().' para recibir notificaciones');
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return back();
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->setRecibeNotificaciones(false);
            $user->save();
            session()->flash('success', 'Se ha eliminado a '.$user->getName().' de recibir notificaciones');
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return back();
    }

    // Vista para probar el envio del correo

    public function test(): View
    {
        return view('admin.notification.test');
    }

}
