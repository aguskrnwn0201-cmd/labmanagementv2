<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\LaporanKerusakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

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
            'no_hp' => 'required',
            'jenis_kerusakan' => 'required',
            'deskripsi' => 'required',
        ]);

        $laporan = LaporanKerusakan::create([
    'lab_id' => $request->lab_id,
    'nama_pelapor' => $request->nama_pelapor,
    'role_pelapor' => session('role'),
    'no_hp' => $request->no_hp,
    'jenis_kerusakan' => $request->jenis_kerusakan,
    'deskripsi' => $request->deskripsi,
    'status' => 'pending',
]);

try {

    Http::timeout(10)->post(
        'http://127.0.0.1:3001/send-message',
        [
            'number' => '6282332671812',
            'message' =>
                "🚨 LAPORAN KERUSAKAN BARU\n\n" .
                "Pelapor: {$laporan->nama_pelapor}\n" .
                "Role: {$laporan->role_pelapor}\n" .
                "Kerusakan: {$laporan->jenis_kerusakan}\n" .
                "Status: Pending"
        ]
    );

} catch (\Exception $e) {

    logger($e->getMessage());

}

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

public function update(Request $request, LaporanKerusakan $laporan_kerusakan)
{
    // Ganti pengecekan session menjadi auth()
    if (auth()->user()->role !== 'teknisi') {
        abort(403, 'Hanya teknisi yang bisa mengubah status.');
    }

    $request->validate([
        'status' => 'required'
    ]);


$laporan_kerusakan->update([
    'status' => $request->status
]);

$laporan_kerusakan->load('lab');

$status = ucfirst($request->status);

$message =
"Status laporan kerusakan Anda telah diperbarui.\n\n" .
"Lab: {$laporan_kerusakan->lab->nama_lab}\n" .
"Kerusakan: {$laporan_kerusakan->jenis_kerusakan}\n" .
"Status: {$status}";

try {

Http::timeout(10)->post(
    'http://127.0.0.1:3001/send-message',
    [
        'number' => $laporan_kerusakan->no_hp,
        'message' => $message
    ]
);

} catch (\Exception $e) {

    logger($e->getMessage());

}

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

public function previewPdf()
{
    $laporans = LaporanKerusakan::with('lab')->get();
    // Gunakan view yang sama dengan export
    return view('laporan-kerusakan.pdf', compact('laporans'));
}

public function exportPdf()
{
    // Gunakan pengecekan auth()->user()
    if (auth()->user()->role !== 'teknisi') {
        abort(403, 'Anda tidak memiliki akses.');
    }

    $laporans = LaporanKerusakan::with('lab')->get();
    $pdf = Pdf::loadView('laporan-kerusakan.pdf', compact('laporans'));
    
    return $pdf->download('laporan-kerusakan-' . now()->format('Y-m-d') . '.pdf');
}
}
