<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Lab;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with('lab')
            ->orderBy('hari')
            ->get();

        return view('jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $labs = Lab::where('status', 'aktif')->get();

        return view('jadwal.create', compact('labs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lab_id' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'mata_pelajaran' => 'required',
            'guru' => 'required',
            'kelas' => 'required'
        ]);

        $conflict = Jadwal::where('lab_id', $request->lab_id)
    ->where('hari', $request->hari)
    ->where(function ($query) use ($request) {

        $query->where('jam_mulai', '<', $request->jam_selesai)
              ->where('jam_selesai', '>', $request->jam_mulai);

    })
    ->exists();

    if ($conflict) {

    return back()
        ->withInput()
        ->withErrors([
            'jadwal' => 'Jadwal bentrok dengan jadwal yang sudah ada.'
        ]);
}

        Jadwal::create($request->all());

        return redirect()
            ->route('jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }
}