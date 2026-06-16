<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LandingController, DashboardController, GuruController, SiswaController,
    LabController, JadwalController, BookingController, KalenderController,
    InventarisController, LaporanKerusakanController, LaporanController,
    LaporanInventarisController, UserController
};

// --- Public Routes ---
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/guru', [GuruController::class, 'dashboard'])->name('guru.dashboard');
Route::get('/siswa', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
Route::post('/logout-role', function () {
    session()->forget('role');
    return redirect('/');
})->name('role.logout');

Route::resource('kalender', KalenderController::class)->only(['index']);
Route::resource('booking', BookingController::class);
Route::resource('laporan-kerusakan', LaporanKerusakanController::class);
Route::resource('jadwal', JadwalController::class);
Route::patch('/laporan-kerusakan/{laporan_kerusakan}/update-status', [LaporanKerusakanController::class, 'update'])->name('laporan-kerusakan.update-status');

// --- Pindahkan Rute Laporan ke Sini (Public) ---
Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/penggunaan', [LaporanController::class, 'penggunaan'])->name('penggunaan');
    Route::get('/penggunaan/preview', [LaporanController::class, 'previewPdf'])->name('penggunaan.preview');
    Route::get('/penggunaan/download', [LaporanController::class, 'exportPdf'])->name('penggunaan.download');
	Route::get('/penggunaan/export-excel', [LaporanController::class, 'exportExcel'])->name('penggunaan.excel');
    Route::get('/inventaris', [LaporanInventarisController::class, 'index'])->name('inventaris');
    Route::get('/inventaris/preview', [LaporanInventarisController::class, 'previewExcel'])->name('inventaris.preview');
    Route::get('/inventaris/export-excel', [LaporanInventarisController::class, 'exportExcel'])->name('inventaris.excel');
	Route::get('/inventaris/preview-pdf', [LaporanInventarisController::class, 'previewPdf'])->name('inventaris.preview-pdf'); // ← TAMBAH
    Route::get('/inventaris/export-pdf', [LaporanInventarisController::class, 'exportPdf'])->name('inventaris.pdf');
});

// --- Protected Routes (Khusus Teknisi) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class)->only(['index', 'store']);
    Route::resource('labs', LabController::class);
    Route::resource('inventaris', InventarisController::class)->parameters(['inventaris' => 'inventaris']);

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/kerusakan', [LaporanKerusakanController::class, 'index'])->name('kerusakan');
        Route::get('/kerusakan/preview', [LaporanKerusakanController::class, 'previewPdf'])->name('kerusakan.preview');
        Route::get('/kerusakan/export-pdf', [LaporanKerusakanController::class, 'exportPdf'])->name('kerusakan.pdf');
    	Route::get('/kerusakan/export-excel', [LaporanKerusakanController::class, 'exportExcel'])->name('kerusakan.excel');

    });
});

require __DIR__.'/auth.php';