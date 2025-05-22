<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtkinlikYönetimi extends Model
{
    protected $table = 'etkinlik_yönetimis';  // tablo adı

    protected $fillable = [
        'etkinlik_adi',
        'tarih',
        'description',
        'yeri',
        'turu',
        'ilgi_alani',
    ];

    protected $casts = [
        'ilgi_alani' => 'array',
    ];
}
