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
        Schema::table('laporan_kerusakans', function (Blueprint $table) {
    $table->foreignId('inventaris_id')->nullable()->constrained('inventaris')->onDelete('set null');
    $table->integer('jumlah_rusak')->default(1); // Mencatat berapa unit yang rusak
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_kerusakans', function (Blueprint $table) {
            //
        });
    }
};
