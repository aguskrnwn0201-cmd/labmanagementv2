<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('jadwals', function (Blueprint $table) {
        // Cek dulu apakah kolom tahun_ajaran ada, jika ada baru di-rename
        if (Schema::hasColumn('jadwals', 'tahun_ajaran')) {
            $table->renameColumn('tahun_ajaran', 'lembaga');
        } else {
            // Jika tidak ada, buat saja kolom 'lembaga' agar tetap jalan
            $table->string('lembaga')->nullable();
        }
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
