<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Lab;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

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
            'lab_id'          => 'required|exists:labs,id',
            'tipe_pemohon'    => 'required',
            'nama_pemohon'    => 'required',
            'no_hp'           => 'required',
            'tanggal_booking' => [
                'required',
                'date',
                'after_or_equal:today',
                'before_or_equal:' . now()->addDays(7)->format('Y-m-d'),
            ],
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'keperluan'   => 'required',
        ], [
            'tanggal_booking.before_or_equal' =>
                'Booking hanya dapat dilakukan maksimal 7 hari ke depan.',
            'tanggal_booking.after_or_equal' =>
                'Tanggal booking tidak boleh tanggal yang sudah lewat.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CEK BENTROK DENGAN JADWAL TETAP
        |--------------------------------------------------------------------------
        */

        $hariMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        $hari         = Carbon::parse($request->tanggal_booking)->format('l');
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

        $booking = Booking::create([
            'lab_id'         => $request->lab_id,
            'tipe_pemohon'   => $request->tipe_pemohon,
            'nama_pemohon'   => $request->nama_pemohon,
            'kelas'          => $request->kelas,
            'no_hp'          => $request->no_hp,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'jumlah_peserta' => $request->jumlah_peserta,
            'keperluan'      => $request->keperluan,
            'status'         => 'accepted',
        ]);

        $booking->load('lab');

        /*
        |--------------------------------------------------------------------------
        | KIRIM NOTIFIKASI WHATSAPP
        |--------------------------------------------------------------------------
        */

        $message =
            "📅 BOOKING LAB BARU\n\n" .
            "Lab: {$booking->lab->nama_lab}\n" .
            "Pemohon: {$booking->nama_pemohon}\n" .
            "Tanggal: {$booking->tanggal_booking}\n" .
            "Jam: {$booking->jam_mulai} - {$booking->jam_selesai}\n" .
            "Keperluan: {$booking->keperluan}";

        try {
            Http::timeout(10)->post(
                'http://127.0.0.1:3001/send-message',
                [
                    'number'  => env('WA_TEKNISI'),
                    'message' => $message,
                ]
            );
        } catch (\Exception $e) {
            logger($e->getMessage());
        }

        return redirect()
            ->route('booking.index')
            ->with('success', 'Booking berhasil dibuat.');
    }

    public function show(Booking $booking)
    {
        $booking->load('lab');

        return view('booking.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $labs = Lab::where('status', 'aktif')->get();

        return view('booking.edit', compact('booking', 'labs'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'lab_id'          => 'required|exists:labs,id',
            'tipe_pemohon'    => 'required',
            'nama_pemohon'    => 'required',
            'no_hp'           => 'required',
            'tanggal_booking' => [
                'required',
                'date',
                'after_or_equal:today',
                'before_or_equal:' . now()->addDays(7)->format('Y-m-d'),
            ],
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'keperluan'   => 'required',
        ], [
            'tanggal_booking.before_or_equal' =>
                'Booking hanya dapat dilakukan maksimal 7 hari ke depan.',
            'tanggal_booking.after_or_equal' =>
                'Tanggal booking tidak boleh tanggal yang sudah lewat.',
        ]);

        $hariMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        $hari          = Carbon::parse($request->tanggal_booking)->format('l');
        $hariIndonesia = $hariMap[$hari] ?? null;

        /*
        |--------------------------------------------------------------------------
        | CEK BENTROK DENGAN JADWAL
        |--------------------------------------------------------------------------
        */

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

        $bookingBentrok = Booking::where('id', '!=', $booking->id)
            ->where('lab_id', $request->lab_id)
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

        $booking->update([
            'lab_id'          => $request->lab_id,
            'tipe_pemohon'    => $request->tipe_pemohon,
            'nama_pemohon'    => $request->nama_pemohon,
            'kelas'           => $request->kelas,
            'no_hp'           => $request->no_hp,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_mulai'       => $request->jam_mulai,
            'jam_selesai'     => $request->jam_selesai,
            'jumlah_peserta'  => $request->jumlah_peserta,
            'keperluan'       => $request->keperluan,
        ]);

        return redirect()
            ->route('booking.index')
            ->with('success', 'Booking berhasil diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()
            ->route('booking.index')
            ->with('success', 'Booking berhasil dihapus.');
    }
}