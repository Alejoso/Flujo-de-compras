<?php

namespace App\Interfaces;

interface SendMessageInterface
{
    public function send(string $state, string $messageSubject, string $description, string $projectName, string $employeeName, string $version, string $pathToQuote): void;
}
