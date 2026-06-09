<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LandingController, DashboardController, GuruController, SiswaController,
    LabController, JadwalController, BookingController, KalenderController,
    InventarisController, LaporanKerusakanController, LaporanController,
    LaporanInventarisController, UserController
};

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| Protected Routes (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- Dashboard & Session ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout-role', function () {
        session()->forget('role');
        return redirect('/');
    })->name('role.logout');

    // --- Core Modules ---
    Route::get('/kalender', [KalenderController::class, 'index'])->name('kalender.index');
    
    Route::resource('booking', BookingController::class);
    Route::resource('laporan-kerusakan', LaporanKerusakanController::class);
    Route::resource('labs', LabController::class);
    Route::resource('jadwal', JadwalController::class);
    Route::resource('inventaris', InventarisController::class)->parameters(['inventaris' => 'inventaris']);

    // --- Reporting Module ---
    Route::prefix('laporan')->name('laporan.')->group(function () {
        
        // Laporan Penggunaan
        Route::get('/penggunaan', [LaporanController::class, 'penggunaan'])->name('penggunaan');
        Route::get('/penggunaan/preview', [LaporanController::class, 'previewPdf'])->name('penggunaan.preview');
        Route::get('/penggunaan/download', [LaporanController::class, 'exportPdf'])->name('penggunaan.download');

        // Laporan Inventaris
        Route::get('/inventaris', [LaporanInventarisController::class, 'index'])->name('inventaris');
        Route::get('/inventaris/preview', [LaporanInventarisController::class, 'previewExcel'])->name('inventaris.preview');
        Route::get('/inventaris/export-excel', [LaporanInventarisController::class, 'exportExcel'])->name('inventaris.excel');

        // Laporan Kerusakan
        Route::get('/kerusakan', [LaporanKerusakanController::class, 'index'])->name('kerusakan');
        Route::get('/kerusakan/preview', [LaporanKerusakanController::class, 'previewPdf'])->name('kerusakan.preview');
        Route::get('/kerusakan/export-pdf', [LaporanKerusakanController::class, 'exportPdf'])->name('kerusakan.pdf');
    });

    // --- User & Role Management ---
    Route::get('/guru', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/siswa', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::resource('users', UserController::class)->only(['index', 'store']);

});

require __DIR__.'/auth.php';