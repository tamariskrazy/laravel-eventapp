<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('etkinlikler', function (Blueprint $table) {
            $table->id();
            $table->string('isim')->nullable();
            $table->text('aciklama')->nullable();
            $table->datetime('tarih')->nullable();
            $table->integer('fiyat')->nullable();
            $table->string('url')->nullable();
            $table->string('eventbrite_id')->nullable()->unique();
            $table->string('ticketmaster_id')->nullable()->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('etkinlikler', function (Blueprint $table) {
            $table->string('eventbrite_id')->nullable(false)->change();
        });
    }
};