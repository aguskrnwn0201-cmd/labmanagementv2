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
       Schema::create('labs', function (Blueprint $table) {
    $table->id();

    $table->string('nama_lab');
    $table->string('lokasi')->nullable();
    $table->integer('kapasitas')->default(0);
    $table->text('keterangan')->nullable();

    $table->enum('status', [
        'aktif',
        'nonaktif'
    ])->default('aktif');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labs');
    }
};
