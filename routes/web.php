<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\KalenderController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\LaporanKerusakanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanInventarisController;

/*
|--------------------------------------------------------------------------
| Public Routes (Akses Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');


/*
|--------------------------------------------------------------------------
| Protected Routes (Wajib Login & Memiliki Session Auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // 1. Route Dashboard Utama & Logout Role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::post('/logout-role', function () {
        session()->forget('role');
        return redirect('/');
    })->name('role.logout');

    // 2. Fitur Umum (Bisa diakses Teknisi & Guru)
    Route::get('/kalender', [KalenderController::class, 'index'])->name('kalender.index');
    Route::resource('booking', BookingController::class);
    Route::resource('laporan-kerusakan', LaporanKerusakanController::class);

    // 3. Manajemen Lab & Jadwal (Akses Kontrol Utama)
    Route::resource('labs', LabController::class);
    Route::resource('jadwal', JadwalController::class);

    // 4. Manajemen Inventaris Barang Lab
    Route::resource('inventaris', InventarisController::class)->parameters([
        'inventaris' => 'inventaris'
    ]);

    // 5. Modul Pelaporan (Export & Rekapitulasi)
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/penggunaan', [LaporanController::class, 'penggunaan'])->name('penggunaan');
        Route::get('/inventaris', [LaporanInventarisController::class, 'index'])->name('inventaris');
        Route::get('/inventaris/export-excel', [LaporanInventarisController::class, 'exportExcel'])->name('inventaris.excel');
    });

    // 6. Route Legacy Dashboard Role Spesifik (Jika Masih Digunakan)
    Route::get('/guru', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/siswa', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');

});

/*
|--------------------------------------------------------------------------
| Laravel Breeze / Jetstream Auth Routes (Login, Register, dll)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';