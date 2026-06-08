<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KalenderController extends Controller
{
    public function index()
    {
        // 1. Ambil data mentah untuk daftar di bawah kalender
        $jadwals = Jadwal::with('lab')->get();
        $bookings = Booking::with('lab')->get();

        // Array penampung semua tanggal aktif yang akan diberi titik kuning
        $activeDates = [];

        // 2. Ambil semua tanggal dari tabel BOOKING (Format: YYYY-MM-DD)
        $bookingDates = Booking::whereNotNull('tanggal_booking')
            ->pluck('tanggal_booking')
            ->map(function($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->toArray();
        
        $activeDates = array_merge($activeDates, $bookingDates);

        // 3. MAPPING HARI KE ANGKA CARBON (1 = Senin, 7 = Minggu)
        $hariSistem = [
            'senin'  => 1,
            'selasa' => 2,
            'rabu'   => 3,
            'kamis'  => 4,
            'jumat'  => 5,
            'sabtu'  => 6,
            'minggu' => 7,
        ];

        // Ambil daftar hari unik yang terdaftar di jadwal rutin teknisi
        $jadwalHariList = Jadwal::pluck('hari')->map(fn($h) => strtolower($h))->unique();

        // Tentukan rentang generate tanggal (30 hari ke belakang sampai 60 hari ke depan)
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now()->addDays(60);

        // Lakukan perulangan hari demi hari di dalam rentang waktu tersebut
        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            $dayOfWeek = $current->dayOfWeekIso; // Mengembalikan angka 1 (Senin) sampai 7 (Minggu)
            
            foreach ($jadwalHariList as $hariNama) {
                if (isset($hariSistem[$hariNama]) && $hariSistem[$hariNama] === $dayOfWeek) {
                    $activeDates[] = $current->format('Y-m-d');
                }
            }
            
            $current->addDay(); // Maju 1 hari
        }

        // 4. Bersihkan dari duplikasi tanggal
        $activeDates = array_values(array_unique($activeDates));

        // 5. Kirim ke View kalender/index.blade.php
        return view('kalender.index', compact('jadwals', 'bookings', 'activeDates'));
    }
}