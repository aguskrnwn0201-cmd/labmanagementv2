<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Jadwal;

class SiswaController extends Controller
{
    public function dashboard()
    {
        session([
            'role' => 'siswa'
        ]);

        $totalLab = Lab::where(
            'status',
            'aktif'
        )->count();

        $totalJadwal = Jadwal::count();

        return view(
            'siswa.dashboard',
            compact(
                'totalLab',
                'totalJadwal'
            )
        );
    }
}
