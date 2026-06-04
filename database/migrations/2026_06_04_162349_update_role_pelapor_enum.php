<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE laporan_kerusakans
            MODIFY role_pelapor
            ENUM('guru','siswa','teknisi')
            NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE laporan_kerusakans
            MODIFY role_pelapor
            ENUM('guru','siswa')
            NOT NULL
        ");
    }
};