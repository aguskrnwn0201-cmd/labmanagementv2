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
        // 1. Menghitung total seluruh laboratorium
        $totalLab = Lab::count();

        // 2. SINKRONISASI BARU: Menghitung semua komputer ready langsung dari field baru di tabel labs
        try {
            $totalKomputer = Lab::where('status', 'aktif')->sum('komputer_ready');
        } catch (\Exception $e) {
            // Skenario Cadangan: Jika ingin menghitung dari kolom 'baik' di tabel inventaris jika query di atas gagal
            try {
                $totalKomputer = DB::table('inventaris')
                    ->where(function($query) {
                        $query->where('nama_barang', 'like', '%komputer%')
                              ->orWhere('nama_barang', 'like', '%pc%')
                              ->orWhere('nama_barang', 'like', '%laptop%');
                    })->sum('baik'); // Menggunakan 'baik', karena kolom 'jumlah' sudah tidak ada
            } catch (\Exception $ex) {
                $totalKomputer = 0; 
            }
        }

        // 3. Mengambil data statistik lainnya
        $totalJadwal    = Jadwal::count();
        $totalBooking   = Booking::count();
        $bookingHariIni = Booking::whereDate('tanggal_booking', today())->count();

        // Ambil 5 aktivitas booking terbaru beserta relasi lab-nya
        $bookingTerbaru = Booking::with('lab')->latest()->take(5)->get();

        // 4. Kirim semua variabel ke file view dashboard
        return view('dashboard', compact(
            'totalLab', 
            'totalJadwal', 
            'totalBooking', 
            'bookingHariIni', 
            'bookingTerbaru', 
            'totalKomputer'
        ));
    }
}