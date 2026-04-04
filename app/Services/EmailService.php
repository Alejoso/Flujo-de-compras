<?php

namespace App\Services;

use App\Mail\SendQuote;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\SendMessageInterface;

class EmailService implements SendMessageInterface
{
    public function send(string $state, string $emailSubject, string $description, string $projectName, string $employeeName, string $version, string $pathToQuote): void
    {
        $emails = User::where('recibeNotificaciones', true)->pluck('email')->toArray();

        if (empty($emails)) {
            throw new Exception('Error, no hay correos asginaddos para mandar la notificación');
        }

        $mailable = new SendQuote($state, $emailSubject, $description, $projectName, $employeeName, $version, $pathToQuote);

        Mail::to($emails)->send($mailable);
    }
}
