<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SepetApiController;
use App\Http\Controllers\EtkinlikController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/sepet', [SepetApiController::class, 'index']);
    Route::post('/sepet/ekle', [SepetApiController::class, 'addToSepet']);
    Route::post('/sepet/guncelle', [SepetApiController::class, 'guncelle']);
    Route::delete('/sepet/sil/{index}', [SepetApiController::class, 'sil']);
    Route::get('/etkinlikler/api', [EtkinlikController::class, 'index']);
Route::get('/etkinlikler', [EtkinlikController::class, 'getEtkinlikler']);

});
