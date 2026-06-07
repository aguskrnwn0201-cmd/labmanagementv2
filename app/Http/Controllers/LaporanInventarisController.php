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
        if (session('role') !== 'teknisi') {
            abort(403);
        }

        $labs = Lab::with('inventaris')
            ->orderBy('nama_lab')
            ->get();

        return view(
            'laporan.inventaris',
            compact('labs')
        );
    }

    public function exportExcel()
    {
        if (session('role') !== 'teknisi') {
            abort(403);
        }

        return Excel::download(
            new InventarisExport(),
            'inventaris-' . now()->format('Y-m') . '.xlsx'
        );
    }
}