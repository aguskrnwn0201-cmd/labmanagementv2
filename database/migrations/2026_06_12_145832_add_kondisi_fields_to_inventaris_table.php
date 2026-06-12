<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pengecekan dilakukan DI LUAR Schema::table
        if (!Schema::hasColumn('jadwals', 'lembaga')) {
            Schema::table('jadwals', function (Blueprint $table) {
                $table->string('lembaga')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('jadwals', 'lembaga')) {
            Schema::table('jadwals', function (Blueprint $table) {
                $table->dropColumn('lembaga');
            });
        }
    }
};