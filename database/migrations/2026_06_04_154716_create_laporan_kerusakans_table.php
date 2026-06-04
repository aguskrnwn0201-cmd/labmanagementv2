<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_kerusakans', function (Blueprint $table) {

            $table->id();

            $table->foreignId('lab_id')
                  ->constrained('labs')
                  ->cascadeOnDelete();

            $table->string('nama_pelapor');

            $table->enum('role_pelapor', [
                'guru',
                'siswa'
            ]);

            $table->string('jenis_kerusakan');

            $table->text('deskripsi');

            $table->enum('status', [
                'pending',
                'diproses',
                'selesai'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_kerusakans');
    }
};
