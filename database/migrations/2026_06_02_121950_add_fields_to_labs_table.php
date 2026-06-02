<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('labs', function (Blueprint $table) {

            $table->integer('jumlah_komputer')
                  ->default(0)
                  ->after('kapasitas');

            $table->text('deskripsi')
                  ->nullable()
                  ->after('jumlah_komputer');

            $table->enum('status', [
                'aktif',
                'maintenance',
                'nonaktif'
            ])->default('aktif')->change();
        });
    }

    public function down(): void
    {
        Schema::table('labs', function (Blueprint $table) {

            $table->dropColumn([
                'jumlah_komputer',
                'deskripsi'
            ]);
        });
    }
};