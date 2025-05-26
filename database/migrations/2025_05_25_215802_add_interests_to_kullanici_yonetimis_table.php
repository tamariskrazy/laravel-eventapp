<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kullanici_yonetimis', function (Blueprint $table) {
            $table->json('interests')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('kullanici_yonetimis', function (Blueprint $table) {
            $table->dropColumn('interests');
        });
    }
};