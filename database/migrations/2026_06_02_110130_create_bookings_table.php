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
    Schema::create('bookings', function (Blueprint $table) {

        $table->id();

        $table->foreignId('lab_id')
              ->constrained('labs')
              ->cascadeOnDelete();

        $table->enum('tipe_pemohon', [
            'guru',
            'siswa'
        ]);

        $table->string('nama_pemohon');

        $table->string('kelas')
              ->nullable();

        $table->string('no_hp');

        $table->date('tanggal_booking');

        $table->time('jam_mulai');
        $table->time('jam_selesai');

        $table->integer('jumlah_peserta')
              ->nullable();

        $table->text('keperluan');

        $table->enum('status', [
            'accepted',
            'cancelled'
        ])->default('accepted');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
