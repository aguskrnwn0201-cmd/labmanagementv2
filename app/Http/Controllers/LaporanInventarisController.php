<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Lab;
use Illuminate\Http\Request;

class LaporanInventarisController extends Controller
{
    public function index(Request $request)
    {
        if (session('role') !== 'teknisi') {
            abort(403);
        }

        $labId = $request->lab_id;

        $labs = Lab::all();

        $inventaris = Inventaris::with('lab')
            ->when($labId, function ($query) use ($labId) {
                $query->where('lab_id', $labId);
            })
            ->orderBy('lab_id')
            ->get();

        return view(
            'laporan.inventaris',
            compact(
                'inventaris',
                'labs',
                'labId'
            )
        );
    }
}