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
        Schema::table('kullanıcı_yönetimis', function (Blueprint $table) {
        $table->boolean('password_changed')->default(false);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kullanıcı_yönetimis', function (Blueprint $table) {
        $table->dropColumn('is_password_changed');
    });
    }
};
