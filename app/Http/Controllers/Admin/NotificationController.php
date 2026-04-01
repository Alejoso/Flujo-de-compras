<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendQuote;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

    public function send(): RedirectResponse
    {
        $emails = User::where('recibeNotificaciones', true)->pluck('email')->toArray();

        $action = 'Actualizacion';
        $description = 'Se ha actualizado la cotizacion numero 10';
        $projectName = 'Casa 12';
        $technicianName = 'Pacho';
        $version = 'v.1';

        try {
            foreach ($emails as $email) {
                $sendQuote = new SendQuote($action, $description, $projectName, $technicianName, $version);
                Mail::to($email)->send($sendQuote);
            }
            session()->flash('success', 'Una notificacion ha sido enviada');
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return back();
    }

    // Vista para probar el envio del correo

    public function test(): View
    {
        return view('notification.test');
    }

    // Vista para probar si el correo se ve bien
    public function correo()
    {
        $state = 'Editado tecnico';
        $description = 'Se ha actualizado la cotizacion numero 10';
        $projectName = 'Casa 12';
        $technicianName = 'Pacho';
        $version = 'v.1';

        return new SendQuote($state, $description, $projectName, $technicianName, $version);
    }
}
