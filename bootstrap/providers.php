<?php

use App\Providers\AppServiceProvider;
use App\Providers\OCRServiceProvider;
use App\Providers\MessageServiceProvider;

return [
    AppServiceProvider::class,
    MessageServiceProvider::class,
    OCRServiceProvider::class,
];
