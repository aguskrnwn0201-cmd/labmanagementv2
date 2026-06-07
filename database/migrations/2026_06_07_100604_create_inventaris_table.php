<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaris', function (Blueprint $table) {

            $table->id();

            $table->foreignId('lab_id')
                ->constrained('labs')
                ->cascadeOnDelete();

            $table->string('nama_barang');

            $table->integer('jumlah');

            $table->enum('kondisi', [
                'Baik',
                'Rusak Ringan',
                'Rusak Berat'
            ]);

            $table->text('keterangan')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};