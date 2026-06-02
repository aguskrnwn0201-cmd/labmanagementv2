<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\JadwalController;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/guru', [GuruController::class, 'dashboard'])
    ->name('guru.dashboard');

Route::get('/siswa', [SiswaController::class, 'dashboard'])
    ->name('siswa.dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [TeknisiController::class, 'dashboard'])
        ->name('dashboard');

    Route::resource('labs', LabController::class);
    Route::resource('jadwal', JadwalController::class);

});

require __DIR__.'/auth.php';