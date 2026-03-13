<?php

use App\Http\Controllers\TeethProcedureController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/teeth', function () {
    return view('teeth');
});
Route::get('/teeth/{patient}', [TeethProcedureController::class, 'index'])->name('teeth.index');
use App\Http\Controllers\AppointmentPDFController;

Route::get('/appointment/{id}/pdf', [AppointmentPDFController::class, 'show'])
    ->name('appointment.pdf');

Route::post('/teeth/{patient}/update', [TeethProcedureController::class, 'update'])->name('teeth.update');

