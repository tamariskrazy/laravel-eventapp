<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etkinlik extends Model
{
    protected $table = 'etkinlikler';

    protected $fillable = [
        
        'ticketmaster_id',
        'etkinlik_adi',
        'description',
        'tarih',
        'url',
        'fiyat',
        
    ];
}
