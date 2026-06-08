<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Lab;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        // Mengambil data jadwal yang diurutkan
        $jadwals = Jadwal::with('lab')
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        // MENGAMBIL DATA LAB agar bisa dipakai di filter dropdown view index
        $labs = Lab::all();

        // Mengirimkan kedua variabel ke view
        return view('jadwal.index', compact('jadwals', 'labs'));
    }

    public function create()
    {
        // Memperbaiki logika akses
        if (session('role') !== 'teknisi') {
            abort(403);
        }

        $labs = Lab::where('status', 'aktif')->get();

        return view('jadwal.create', compact('labs'));
    }

    public function store(Request $request)
    {
        if (session('role') !== 'teknisi') {
            abort(403);
        }

        $request->validate([
            'lab_id'         => 'required|exists:labs,id',
            'hari'           => 'required',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required|after:jam_mulai',
            'mata_pelajaran' => 'required',
            'guru'           => 'required',
            'kelas'          => 'required',
        ]);

        $conflict = Jadwal::where('lab_id', $request->lab_id)
            ->where('hari', $request->hari)
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->jam_selesai)
                      ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->exists();

        if ($conflict) {
            return back()->withInput()->withErrors(['jadwal' => 'Jadwal bentrok dengan jadwal yang sudah ada.']);
        }

        Jadwal::create($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show(Jadwal $jadwal)
    {
        $jadwal->load('lab');
        return view('jadwal.show', compact('jadwal'));
    }

    public function edit(Jadwal $jadwal)
    {
        if (session('role') !== 'teknisi') {
            abort(403);
        }
        $labs = Lab::where('status', 'aktif')->get();

        return view('jadwal.edit', compact('jadwal', 'labs'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        if (session('role') !== 'teknisi') {
            abort(403);
        }
        
        $request->validate([
            'lab_id'         => 'required|exists:labs,id',
            'hari'           => 'required',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required|after:jam_mulai',
            'mata_pelajaran' => 'required',
            'guru'           => 'required',
            'kelas'          => 'required',
        ]);

        $conflict = Jadwal::where('id', '!=', $jadwal->id)
            ->where('lab_id', $request->lab_id)
            ->where('hari', $request->hari)
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->jam_selesai)
                      ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->exists();

        if ($conflict) {
            return back()->withInput()->withErrors(['jadwal' => 'Jadwal bentrok dengan jadwal yang sudah ada.']);
        }

        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        if (session('role') !== 'teknisi') {
            abort(403);
        }
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}