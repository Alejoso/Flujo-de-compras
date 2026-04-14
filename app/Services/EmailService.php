<?php

namespace App\Services;

use App\Mail\SendQuote;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function send(string $state, string $emailSubject, string $description, string $projectName, string $employeeName, string $version, string $pathToQuote): void
    {
        $emails = User::where('receives_notifications', true)->pluck('email')->toArray();

        if (empty($emails)) {
            throw new Exception('Error: no email recipients are assigned to receive notifications');
        }

        $mailable = new SendQuote($state, $emailSubject, $description, $projectName, $employeeName, $version, $pathToQuote);

        Mail::to($emails)->send($mailable);
    }
}
