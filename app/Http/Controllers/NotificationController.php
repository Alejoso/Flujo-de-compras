<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        return view('notification.index');
    }

    public function send(Request $request): RedirectResponse
    {
        $email = $request->input("email");
        session()->flash("success","Una notificacion ha sido enviada");
        return back();
    }
}
