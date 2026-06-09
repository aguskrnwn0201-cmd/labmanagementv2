<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

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

        public function previewPdf()
            {
                $data = Booking::with(['lab'])->get();
                return view('laporan.pdf_penggunaan', compact('data'));
            }

        public function exportPdf()
            {
                $data = Booking::with(['lab'])->get();
                $pdf = Pdf::loadView('laporan.pdf_penggunaan', compact('data'));
                return $pdf->stream('laporan-penggunaan.pdf'); // 'stream' untuk preview, 'download' untuk unduh
            }

}
