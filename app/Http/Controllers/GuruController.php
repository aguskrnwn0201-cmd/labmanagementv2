<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Jadwal;
use App\Models\Booking;

class GuruController extends Controller
{
    public function dashboard()
    {
        session([
            'role' => 'guru'
        ]);

        $totalLab = Lab::where(
            'status',
            'aktif'
        )->count();

        $totalJadwal = Jadwal::count();

        $totalBooking = Booking::count();

        return view(
            'guru.dashboard',
            compact(
                'totalLab',
                'totalJadwal',
                'totalBooking'
            )
        );
    }
}
