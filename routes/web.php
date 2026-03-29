<?php

use Illuminate\Support\Facades\Route;

$controllerRoute = 'App\Http\Controllers';

Route::get('/', $controllerRoute . '\NotificationController@index')->name('notification.index');
Route::get('/notification/send', $controllerRoute . '\NotificationController@send')->name('notification.send');
