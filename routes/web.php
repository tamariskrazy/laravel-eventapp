<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtkinlikYönetimiController;
use App\Http\Controllers\AuthController;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Anasayfa boşsa login sayfasına yönlendir
Route::get('/', function () {
    return redirect()->route('login.form');
});
//Route::get('/anasayfa', [EtkinlikYönetimiController::class, 'index'])->name('etkinlikler.index');

Route::get('/', [EtkinlikYönetimiController::class, 'index'])->name('anasayfa');
