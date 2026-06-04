<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Booking;

class KalenderController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with('lab')->get();

        $bookings = Booking::with('lab')->get();

        return view(
            'kalender.index',
            compact('jadwals', 'bookings')
        );
    }
}