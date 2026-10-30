<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegistrationController::class, 'create'])->name('register.create');
Route::post('/daftar', [RegistrationController::class, 'store'])->name('register.store');
Route::get('/tiket/{registration}', [RegistrationController::class, 'success'])->name('register.success');
