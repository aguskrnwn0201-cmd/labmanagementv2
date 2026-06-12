<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('labs', function (Blueprint $table) {
            // Menambahkan field komputer_ready setelah kolom kapasitas
            $table->integer('komputer_ready')->default(0)->after('kapasitas');
        });
    }

    public function down(): void
    {
        Schema::table('labs', function (Blueprint $table) {
            $table->dropColumn('komputer_ready');
        });
    }
};