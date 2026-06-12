<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            // Menghapus kolom lama yang sudah tidak digunakan agar tidak memicu error NOT NULL
            if (Schema::hasColumn('inventaris', 'jumlah')) {
                $table->dropColumn('jumlah');
            }
            if (Schema::hasColumn('inventaris', 'kondisi')) {
                $table->dropColumn('kondisi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            // Mengembalikan kolom jika di-rollback (opsional)
            $table->integer('jumlah')->nullable();
            $table->string('kondisi')->nullable();
        });
    }
};