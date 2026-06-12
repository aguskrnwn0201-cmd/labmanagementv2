<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function index()
    {
        $labs = Lab::latest()->get();

        return view('labs.index', compact('labs'));
    }

    public function create()
    {
        return view('labs.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_lab' => 'required|string|max:255',
        'lokasi' => 'required|string|max:255',
        'kapasitas' => 'required|integer|min:1',
        'komputer_ready' => 'required|integer|min:0', // <-- Tambahkan validasi ini
        'keterangan' => 'nullable|string',
    ]);

    Lab::create([
        'nama_lab' => $request->nama_lab,
        'lokasi' => $request->lokasi,
        'kapasitas' => $request->kapasitas,
        'komputer_ready' => $request->komputer_ready, // <-- Simpan ke database
        'keterangan' => $request->keterangan,
        'status' => 'aktif',
    ]);

    return redirect()->route('labs.index')->with('success', 'Laboratorium baru berhasil didaftarkan.');
}
}