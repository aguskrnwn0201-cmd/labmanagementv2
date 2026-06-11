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
| Public Routes (Bisa Diakses Siapa Saja: Teknisi, Guru, Siswa)
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');

// --- Halaman Utama Guru & Siswa (Guest Mode) ---
Route::get('/guru', [GuruController::class, 'dashboard'])->name('guru.dashboard');
Route::get('/siswa', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');

// --- Tombol Keluar dari Role (Dipindah ke Luar Auth Agar Guru/Siswa Bisa Mengaksesnya) ---
Route::post('/logout-role', function () {
    session()->forget('role');
    return redirect('/');
})->name('role.logout');

// --- Fitur yang Dipakai Bersama (Dikeluarkan dari Middleware Auth agar Guru & Siswa Bisa Akses) ---
Route::resource('kalender', KalenderController::class)->only(['index']);
Route::resource('booking', BookingController::class);
Route::resource('laporan-kerusakan', LaporanKerusakanController::class);
Route::resource('jadwal', JadwalController::class);


/*
|--------------------------------------------------------------------------
| Protected Routes (KHUSUS TEKNISI - Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- Dashboard Teknisi ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- Manajemen User & Core Lab Khusus Teknisi ---
    Route::resource('users', UserController::class)->only(['index', 'store']);
    Route::resource('labs', LabController::class);
    Route::resource('inventaris', InventarisController::class)->parameters(['inventaris' => 'inventaris']);

    // --- Reporting Module (Hanya Teknisi) ---
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

});

require __DIR__.'/auth.php';