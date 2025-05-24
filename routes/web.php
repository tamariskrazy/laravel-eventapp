<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtkinlikYönetimiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SepetController;
use App\Http\Controllers\EtkinlikController;






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

Route::get('/sifre-degistir', [AuthController::class, 'showChangePasswordForm'])->name('password.change.form');
Route::post('/sifre-degistir', [AuthController::class, 'changePassword'])->name('password.change');


Route::post('/odeme', [SepetController::class, 'odemeYap'])->name('odeme.yap');
Route::post('/sepet/guncelle', [SepetController::class, 'guncelle'])->name('sepet.guncelle');
Route::delete('/sepet/sil/{index}', [SepetController::class, 'sil'])->name('sepet.sil');


Route::get('/', [EtkinlikController::class, 'index']);


Route::post('/sepet/ekle', [SepetController::class, 'addToSepet'])->name('sepet.ekle');


Route::get('/sepet', [SepetController::class, 'index'])->name('sepet');
Route::get('/', [EtkinlikController::class, 'index'])->name('anasayfa');

