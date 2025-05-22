<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class KullanıcıYönetimi extends Model
{
    use HasFactory;

    protected $table = 'kullanıcı_yönetimis'; // ya da kullanici_yonetimis (i tavsiye edilir)

    protected $fillable = [
        'isim',
        'soyisim',
        'email',
        'password',
        'is_approved',
    ];
}
