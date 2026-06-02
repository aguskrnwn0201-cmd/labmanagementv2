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
       Schema::create('jadwals', function (Blueprint $table) {
    $table->id();

    $table->foreignId('lab_id')
          ->constrained('labs')
          ->cascadeOnDelete();

    $table->enum('hari', [
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu'
    ]);

    $table->time('jam_mulai');
    $table->time('jam_selesai');

    $table->string('mata_pelajaran');
    $table->string('guru');
    $table->string('kelas');

    $table->string('semester')->nullable();

    $table->string('tahun_ajaran')->nullable();


    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
