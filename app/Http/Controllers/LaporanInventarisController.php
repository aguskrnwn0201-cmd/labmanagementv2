<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;
use App\Exports\InventarisExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanInventarisController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
        $userRole = auth()->user()->role;
        if ($userRole !== 'teknisi' && $userRole !== 'admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }
    } else {
        // Jika belum login, arahkan ke halaman login
        return redirect()->route('login');
    }

        $labs = Lab::with('inventaris')
            ->orderBy('nama_lab')
            ->get();

        return view(
            'laporan.inventaris',
            compact('labs')
        );
    }

    public function previewExcel()
    {
        // Mengambil data untuk ditampilkan di view (HTML)
        $labs = Lab::with('inventaris')->orderBy('nama_lab')->get();
        
        // Anda bisa membuat file view baru: resources/views/laporan/inventaris_preview.blade.php
        return view('laporan.inventaris_preview', compact('labs'));
    }

    public function exportExcel()
        {
            // Menggunakan Auth langsung (lebih akurat daripada session)
            if (auth()->check() && auth()->user()->role === 'teknisi') {
                return Excel::download(
                    new InventarisExport(),
                    'inventaris-' . now()->format('Y-m') . '.xlsx'
                );
            }

            // Jika bukan teknisi, lempar 403
            abort(403, 'Anda tidak memiliki akses sebagai teknisi.');
        }
}