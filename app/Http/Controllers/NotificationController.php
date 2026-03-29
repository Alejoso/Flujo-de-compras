<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Mail\SendQuote;
use Illuminate\Support\Facades\Mail;


class NotificationController extends Controller
{
    public function index(): View
    {
        return view('notification.index');
    }

    public function send(Request $request)
    {
        $email = $request->input("email");
        session()->flash("success","Una notificacion ha sido enviada");
    
        $action = 'Actualizacion';
        $description = 'Se ha actualizado la cotizacion numero 10';
        $projectName = 'Casa 12';
        $technicianName = 'Pacho';
        $sendQuote = new SendQuote($action , $description , $projectName , $technicianName);

        Mail::to($email)->send($sendQuote);

        return back();
    }
}
