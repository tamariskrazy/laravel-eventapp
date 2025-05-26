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
        Schema::create('etkinlikler', function (Blueprint $table) {
        $table->id();
        $table->string('ticketmaster_id')->unique();
        $table->string('etkinlik_adi');
        $table->text('description')->nullable();
        $table->dateTime('tarih')->nullable();
        $table->string('url')->nullable();
        $table->timestamps();
        
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etkinlikler');
    }
};
