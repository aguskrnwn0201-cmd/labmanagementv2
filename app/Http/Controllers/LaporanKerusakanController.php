<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\LaporanKerusakan;
use Illuminate\Http\Request;

class LaporanKerusakanController extends Controller
{
    public function index()
    {
        $laporans = LaporanKerusakan::with('lab')
            ->latest()
            ->get();

        return view(
            'laporan-kerusakan.index',
            compact('laporans')
        );
    }



    public function create()
    {
        $labs = Lab::where(
            'status',
            'aktif'
        )->get();

        return view(
            'laporan-kerusakan.create',
            compact('labs')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'lab_id' => 'required|exists:labs,id',
            'nama_pelapor' => 'required',
            'jenis_kerusakan' => 'required',
            'deskripsi' => 'required',
        ]);

        LaporanKerusakan::create([
            'lab_id' => $request->lab_id,
            'nama_pelapor' => $request->nama_pelapor,
            'role_pelapor' => session('role'),
            'jenis_kerusakan' => $request->jenis_kerusakan,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('laporan-kerusakan.index')
            ->with(
                'success',
                'Laporan berhasil dikirim.'
            );
    }

    public function show(LaporanKerusakan $laporan_kerusakan)
{
$laporan_kerusakan->load('lab');


return view(
    'laporan-kerusakan.show',
    compact('laporan_kerusakan')
);


}

public function update(
Request $request,
LaporanKerusakan $laporan_kerusakan
)
{
$request->validate([
'status' => 'required'
]);


$laporan_kerusakan->update([
    'status' => $request->status
]);

return redirect()
    ->route(
        'laporan-kerusakan.show',
        $laporan_kerusakan->id
    )
    ->with(
        'success',
        'Status berhasil diperbarui'
    );


}


}
