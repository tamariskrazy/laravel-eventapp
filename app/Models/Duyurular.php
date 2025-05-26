<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Duyurular extends Model
{
    use HasFactory;

    protected $table = 'duyurular';
 // Duyuruların veritabanı tablosu ismi

    protected $fillable = [
        'baslik',
        'icerik',
        'tarih',
    ];

    public $timestamps = false; // Eğer created_at ve updated_at yoksa
}
