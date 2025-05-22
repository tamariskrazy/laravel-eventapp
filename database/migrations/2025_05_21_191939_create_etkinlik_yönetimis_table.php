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
        Schema::create('etkinlik_yönetimis', function (Blueprint $table) {
            $table->id();
            $table->string('etkinlik_adi');
            $table->date('tarih');
            $table->string('description')->nullable();
            $table->string('yeri');
            $table->string('turu');
            $table->string('ilgi_alani');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etkinlik_yönetimis');
    }
};
