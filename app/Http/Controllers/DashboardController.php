<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Jadwal;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLab = Lab::count();

        $totalJadwal = Jadwal::count();

        $totalBooking = Booking::count();

        $bookingHariIni = Booking::whereDate(
            'tanggal_booking',
            today()
        )->count();

         $bookingTerbaru = Booking::with('lab')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalLab',
            'totalJadwal',
            'totalBooking',
            'bookingHariIni'
        ));
    }
}