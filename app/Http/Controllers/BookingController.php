<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Lab;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('lab')
            ->latest()
            ->get();

        return view('booking.index', compact('bookings'));
    }

    public function create()
    {
        $labs = Lab::where('status', 'aktif')->get();

        return view('booking.create', compact('labs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lab_id' => 'required|exists:labs,id',
            'tipe_pemohon' => 'required',
            'nama_pemohon' => 'required',
            'no_hp' => 'required',
            'tanggal_booking' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'keperluan' => 'required',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CEK BENTROK DENGAN JADWAL TETAP
        |--------------------------------------------------------------------------
        */

       $hari = Carbon::parse($request->tanggal_booking)
    ->format('l');

        $hariMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        $hariIndonesia = $hariMap[$hari] ?? null;

        $jadwalBentrok = Jadwal::where('lab_id', $request->lab_id)
            ->where('hari', $hariIndonesia)
            ->where(function ($query) use ($request) {

                $query->where('jam_mulai', '<', $request->jam_selesai)
                      ->where('jam_selesai', '>', $request->jam_mulai);

            })
            ->exists();

        if ($jadwalBentrok) {

            return back()
                ->withInput()
                ->withErrors([
                    'booking' => 'Lab sedang digunakan untuk jadwal pelajaran.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK BENTROK BOOKING LAIN
        |--------------------------------------------------------------------------
        */

        $bookingBentrok = Booking::where('lab_id', $request->lab_id)
            ->where('tanggal_booking', $request->tanggal_booking)
            ->where('status', 'accepted')
            ->where(function ($query) use ($request) {

                $query->where('jam_mulai', '<', $request->jam_selesai)
                      ->where('jam_selesai', '>', $request->jam_mulai);

            })
            ->exists();

        if ($bookingBentrok) {

            return back()
                ->withInput()
                ->withErrors([
                    'booking' => 'Lab sudah dibooking pada jam tersebut.'
                ]);
        }

        Booking::create([
            'lab_id' => $request->lab_id,
            'tipe_pemohon' => $request->tipe_pemohon,
            'nama_pemohon' => $request->nama_pemohon,
            'kelas' => $request->kelas,
            'no_hp' => $request->no_hp,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'jumlah_peserta' => $request->jumlah_peserta,
            'keperluan' => $request->keperluan,
            'status' => 'accepted',
        ]);

        return redirect()
            ->route('booking.index')
            ->with('success', 'Booking berhasil dibuat.');
    }
}