<?php

use App\Http\Controllers\ConcertRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ConcertRegistrationController::class, 'index'])->name('concert.index');
Route::post('/registrasi', [ConcertRegistrationController::class, 'store'])->name('concert.register');
