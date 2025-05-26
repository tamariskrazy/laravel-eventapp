<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtkinlikYönetimiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SepetController;
use App\Http\Controllers\EtkinlikController;
use App\Http\Controllers\DuyurularController;
use App\Http\Controllers\ProfilController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [EtkinlikController::class, 'index'])->name('anasayfa');

Route::get('/sifre-degistir', [AuthController::class, 'showChangePasswordForm'])->name('password.change.form');
Route::post('/sifre-degistir', [AuthController::class, 'changePassword'])->name('password.change');

Route::get('/sepet', [SepetController::class, 'index'])->name('sepet');
Route::post('/sepet/ekle', [SepetController::class, 'ekle'])->name('sepet.ekle');
Route::post('/sepet/guncelle', [SepetController::class, 'guncelle'])->name('sepet.guncelle');
Route::delete('/sepet/sil/{index}', [SepetController::class, 'sil'])->name('sepet.sil');
Route::post('/odeme', [SepetController::class, 'odemeYap'])->name('odeme.yap');

Route::get('/etkinlik/{id}', [EtkinlikController::class, 'detay'])->name('etkinlik.detay');


// Profil sayfaları - auth korumalı, prefix yok
Route::middleware(['auth'])->group(function () {
    Route::get('/profilim', [ProfilController::class, 'index'])->name('profilim');
   
});


// Admin paneli route'ları (auth korumalı)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('duyurular', DuyurularController::class);
    Route::get('/onerilen-etkinlikler', [EtkinlikController::class, 'onerilenEtkinlikler'])->name('etkinlikler.onerilen');
});


Route::put('/profil/interests', [ProfilController::class, 'updateInterests'])->name('profil.interests.update');
Route::get('/etkinlikler/arama', [EtkinlikController::class, 'arama'])->name('etkinlikler.arama');


