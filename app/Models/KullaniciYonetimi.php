<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;

class KullaniciYonetimi extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable;

    protected $table = 'kullanici_yonetimis';

    protected $fillable = [
        'isim',
        'soyisim',
        'email',
        'password',
        'is_approved',
        'interests',
    ];

    protected $casts = [
        'interests' => 'array',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Parola hashlemek için setter
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    // Filament'te kullanıcı adı olarak gösterilecek değer
    public function getFilamentName(): string
    {
        return "{$this->isim} {$this->soyisim}";
    }

    // Filament paneline erişim kontrolü (Yeni sürümde gerekli olan metod)
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->is_approved;
    }
}
