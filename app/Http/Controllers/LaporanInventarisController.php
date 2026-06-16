<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;
use App\Exports\InventarisExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanInventarisController extends Controller
{
    public function index()
    {
        $sessionRole = session('role');

        if (auth()->check()) {
            if (!in_array(auth()->user()->role, ['teknisi', 'admin', 'guru'])) {
                abort(403, 'Anda tidak memiliki akses.');
            }
        } elseif ($sessionRole !== 'guru') {
            return redirect()->route('login');
        }

        $labs = Lab::with('inventaris')->orderBy('nama_lab')->get();

        return view('laporan.inventaris', compact('labs'));
    }

    public function previewExcel()
    {
        $labs = Lab::with('inventaris')->orderBy('nama_lab')->get();

        return view('laporan.inventaris_preview', compact('labs'));
    }

    public function exportExcel()
    {
        $isTeknisi = auth()->check() && auth()->user()->role === 'teknisi';
        $isGuru    = session('role') === 'guru';

        if (!$isTeknisi && !$isGuru) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return Excel::download(
            new InventarisExport(),
            'inventaris-' . now()->format('Y-m') . '.xlsx'
        );
    }

public function previewPdf()
{
    $sessionRole = session('role');

    if (auth()->check()) {
        if (!in_array(auth()->user()->role, ['teknisi', 'admin', 'guru'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }
    } elseif ($sessionRole !== 'guru') {
        return redirect()->route('login');
    }

    $labs = Lab::with('inventaris')->orderBy('nama_lab')->get();

    return view('laporan.pdf_inventaris', compact('labs'));
}

public function exportPdf()
{
    $isTeknisi = auth()->check() && in_array(auth()->user()->role, ['teknisi', 'admin']);
    $isGuru    = session('role') === 'guru';

    if (!$isTeknisi && !$isGuru) {
        abort(403, 'Anda tidak memiliki akses.');
    }

    $labs = Lab::with('inventaris')->orderBy('nama_lab')->get();

    $pdf = Pdf::loadView('laporan.pdf_inventaris', compact('labs'))
              ->setPaper('a4', 'portrait');

    return $pdf->download('inventaris-' . now()->format('Y-m-d') . '.pdf');
}
}