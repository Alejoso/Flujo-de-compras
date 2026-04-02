<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendQuote;
use App\Models\User;

class SendQuoteService
{
    public function send(string $action , string $emailSubject , string $description , string $projectName , string $employeeName , string $version , string $pathToQuote): void
    {
        $emails = User::where('recibeNotificaciones', true)->pluck('email')->toArray();
        
        if(empty($emails)){
            throw new Exception('Error, no hay correos asginaddos para mandar la notificación');
        }

        $mailable = new SendQuote($action, $emailSubject, $description, $projectName, $employeeName, $version , $pathToQuote);

        Mail::to($emails)->send($mailable);
    }
}