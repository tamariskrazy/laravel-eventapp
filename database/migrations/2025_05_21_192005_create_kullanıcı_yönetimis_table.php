<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kullanici_yonetimis', function (Blueprint $table) {
            $table->id();
            $table->string('isim');
            $table->string('soyisim');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_approved')->default(false); // Yönetici onayı
            $table->boolean('password_changed')->default(false);
            $table->json('interests')->nullable(); // İlgi alanları
            $table->rememberToken(); // remember_token alanı
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kullanici_yonetimis');
    }
};
