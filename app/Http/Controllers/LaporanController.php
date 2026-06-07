<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class LaporanController extends Controller
{
    public function penggunaan(Request $request)
{
    $bulan = $request->bulan ?? now()->month;
    $tahun = $request->tahun ?? now()->year;

    $bookings = Booking::with('lab')
        ->whereMonth('tanggal_booking', $bulan)
        ->whereYear('tanggal_booking', $tahun)
        ->where('status', 'accepted')
        ->get();

    $rekapLab = [];

    foreach ($bookings as $booking) {

        $lab = $booking->lab->nama_lab;

        $jam = \Carbon\Carbon::parse($booking->jam_mulai)
            ->diffInHours(
                \Carbon\Carbon::parse($booking->jam_selesai)
            );

        if (!isset($rekapLab[$lab])) {

            $rekapLab[$lab] = [
                'jumlah_booking' => 0,
                'total_jam' => 0,
            ];
        }

        $rekapLab[$lab]['jumlah_booking']++;

        $rekapLab[$lab]['total_jam'] += $jam;
    }

    return view(
        'laporan.penggunaan',
        compact(
            'bookings',
            'bulan',
            'tahun',
            'rekapLab'
        )
    );
}
}
