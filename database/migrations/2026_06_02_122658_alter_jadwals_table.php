<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {

            $table->string('semester')
                  ->nullable()
                  ->after('kelas');

            $table->string('tahun_ajaran')
                  ->nullable()
                  ->after('semester');

            $table->dropColumn('is_prioritas');
        });
    }

    public function down(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {

            $table->boolean('is_prioritas')
                  ->default(true);

            $table->dropColumn([
                'semester',
                'tahun_ajaran'
            ]);
        });
    }
};