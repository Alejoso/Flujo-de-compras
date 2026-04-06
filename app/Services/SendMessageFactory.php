<?php

namespace App\Services;

use App\Interfaces\SendMessageInterface;
use InvalidArgumentException;

class SendMessageFactory
{
    public function make(string $service): SendMessageInterface
    {
        return match ($service) {
            'email' => new EmailService,
            default => throw new InvalidArgumentException("Servicio '$service' no soportado")
        };
    }
}
