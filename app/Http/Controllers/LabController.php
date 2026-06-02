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
            'nama_lab' => 'required',
            'kapasitas' => 'required|integer'
        ]);

        Lab::create([
            'nama_lab' => $request->nama_lab,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'keterangan' => $request->keterangan,
            'status' => 'aktif'
        ]);

        return redirect()
            ->route('labs.index')
            ->with('success', 'Lab berhasil ditambahkan');
    }
}