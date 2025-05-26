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
        Schema::table('etkinlikler', function (Blueprint $table) {
        $table->string('kategori')->nullable(); // Müzik, Spor, vb.
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etkinlikler', function (Blueprint $table) {
            //
        });
    }
};
