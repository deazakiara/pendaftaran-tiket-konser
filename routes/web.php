<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

// Halaman form pendaftaran
Route::get('/', [RegistrationController::class, 'create'])->name('register.create');

// Tujuan form saat tombol daftar ditekan
Route::post('/daftar', [RegistrationController::class, 'store'])->name('register.store');

// Halaman bukti registrasi, contoh: /tiket/GSF-7KQ2XM
Route::get('/tiket/{registration}', [RegistrationController::class, 'success'])->name('register.success');
