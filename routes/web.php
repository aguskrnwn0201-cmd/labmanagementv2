<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\KalenderController;
use App\Http\Controllers\LaporanKerusakanController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanInventarisController;

Route::get('/', [LandingController::class, 'index'])
    ->name('landing');

Route::get('/guru', [GuruController::class, 'dashboard'])
    ->name('guru.dashboard');

Route::get('/siswa', [SiswaController::class, 'dashboard'])
    ->name('siswa.dashboard');

Route::post('/logout-role', function () {
    session()->forget('role');
    return redirect('/');
})->name('role.logout');

Route::resource('booking', BookingController::class);

Route::get('/kalender', [KalenderController::class, 'index'])
    ->name('kalender.index');

Route::resource('laporan-kerusakan', LaporanKerusakanController::class);

/*
|--------------------------------------------------------------------------
| JADWAL
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [TeknisiController::class, 'dashboard'])
    ->name('dashboard');

Route::resource('labs', LabController::class);

Route::resource('jadwal', JadwalController::class);


Route::resource('inventaris', InventarisController::class)
    ->parameters([
        'inventaris' => 'inventaris'
    ]);
        Route::get(
            '/laporan/penggunaan',
            [LaporanController::class, 'penggunaan']
        )->name('laporan.penggunaan');

        Route::get(
    '/laporan/inventaris',
    [LaporanInventarisController::class, 'index']
)->name('laporan.inventaris');

require __DIR__.'/auth.php';