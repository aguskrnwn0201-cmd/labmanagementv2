<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Jadwal;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLab = Lab::count();

        // Mengambil jumlah aset komputer secara aman langsung dari database
        try {
            $totalKomputer = DB::table('inventaris')
                ->where(function($query) {
                    $query->where('nama_barang', 'like', '%komputer%')
                          ->orWhere('nama_barang', 'like', '%pc%')
                          ->orWhere('nama_barang', 'like', '%laptop%');
                })->sum('jumlah');
        } catch (\Exception $e) {
            $totalKomputer = 0; 
        }

        $totalJadwal    = Jadwal::count();
        $totalBooking   = Booking::count();
        $bookingHariIni = Booking::whereDate('tanggal_booking', today())->count();

        // Ambil 5 aktivitas booking terbaru beserta relasi lab-nya
        $bookingTerbaru = Booking::with('lab')->latest()->take(5)->get();

        // Pastikan di bagian return paling bawah fungsinya seperti ini:
            return view('dashboard', compact(
                'totalLab', 
                'totalJadwal', 
                'totalBooking', 
                'bookingHariIni', 
                'bookingTerbaru', 
                'totalKomputer' // parsing semua variabel ke satu file saja
            ));
    }
}