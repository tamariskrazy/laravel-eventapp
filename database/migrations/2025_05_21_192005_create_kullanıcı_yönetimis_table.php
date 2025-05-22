<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kullanıcı_yönetimis', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('isim');
            $table->string('soyisim');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_approved')->default(false); // Yönetici onayı
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kullanıcı_yönetimis');
    }
};
