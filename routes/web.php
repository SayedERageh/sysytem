<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\AppointmentPDFController;

Route::get('/appointment/{id}/pdf', [AppointmentPDFController::class, 'show'])
    ->name('appointment.pdf');