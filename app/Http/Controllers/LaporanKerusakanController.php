<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\LaporanKerusakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;
use DateTime;

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
    $labs = Lab::where('status', 'aktif')->get();
    
    // Ambil semua barang inventaris untuk pilihan di form pelaporan
    $inventaris = \App\Models\Inventaris::all();

    return view(
        'laporan-kerusakan.create',
        compact('labs', 'inventaris')
    );
}

    public function store(Request $request)
{
    $request->validate([
        'lab_id'          => 'required|exists:labs,id',
        'nama_pelapor'    => 'required',
        'no_hp'           => 'required',
        'jenis_kerusakan' => 'required',
        'deskripsi'       => 'required',
    ]);

    // 1. Simpan Laporan Kerusakan ke Database
    $laporan = LaporanKerusakan::create([
        'lab_id'          => $request->lab_id,
        'inventaris_id'   => $request->inventaris_id,
        'nama_pelapor'    => $request->nama_pelapor,
        'role_pelapor' => session('role') ?? (auth()->check() ? auth()->user()->role : 'siswa'),
        'no_hp'           => $request->no_hp,
        'jenis_kerusakan' => $request->jenis_kerusakan,
        'deskripsi'       => $request->deskripsi,
        'status'          => 'pending',
    ]);

    // 2. SINKRONISASI: Pindahkan stok BARANG BAIK ke BARANG RUSAK
    $inventaris = \App\Models\Inventaris::find($request->inventaris_id);
    if ($inventaris && $inventaris->baik >= $request->jumlah_rusak) {
        $inventaris->baik  -= (int)$request->jumlah_rusak;
        $inventaris->rusak += (int)$request->jumlah_rusak;
        // Total stok tetap sama (hanya kondisinya yang berubah dari baik menjadi rusak)
        $inventaris->total = $inventaris->baik + $inventaris->rusak + $inventaris->cadangan;
        $inventaris->save();
    }

    // 3. Kirim Notifikasi WhatsApp (Sama seperti kode Anda)
    try {
        Http::timeout(10)->post('http://172.19.0.1:3001/send-message', [
            'number' => '6282332671812',
            'message' => "🚨 LAPORAN KERUSAKAN BARU\n\nPelapor: {$laporan->nama_pelapor}\nBarang: {$inventaris->nama_barang}\nJumlah Rusak: {$laporan->jumlah_rusak} Unit\nKerusakan: {$laporan->jenis_kerusakan}\nStatus: Pending"
        ]);
    } catch (\Exception $e) {
        logger($e->getMessage());
    }

    return redirect()->route('laporan-kerusakan.index')->with('success', 'Laporan berhasil dikirim dan stok inventaris diperbarui.');
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
    if (auth()->user()->role !== 'teknisi') {
        abort(403, 'Hanya teknisi yang bisa mengubah status.');
    }

    // 1. Ubah validasi agar menerima kata 'diproses' sesuai ENUM MySQL Anda
    $request->validate([
        'status' => 'required|in:pending,diproses,selesai'
    ]);

    $statusLama = $laporan_kerusakan->status;
    $statusBaru = $request->status;

    // 2. Update status laporan kerusakan
    $laporan_kerusakan->update([
        'status' => $statusBaru
    ]);

    // 3. SINKRONISASI STOK: Jika status berubah MENJADI SELESAI
    if ($statusLama !== 'selesai' && $statusBaru === 'selesai') {
        $inventaris = \App\Models\Inventaris::find($laporan_kerusakan->inventaris_id);
        
        if ($inventaris && $inventaris->rusak >= $laporan_kerusakan->jumlah_rusak) {
            $inventaris->rusak -= (int)$laporan_kerusakan->jumlah_rusak;
            $inventaris->baik  += (int)$laporan_kerusakan->jumlah_rusak;
            $inventaris->total = $inventaris->baik + $inventaris->rusak + $inventaris->cadangan;
            $inventaris->save();
        }
    }

    // 4. Kirim WhatsApp Pemberitahuan ke Pelapor
    $laporan_kerusakan->load('lab');
    $statusText = $statusBaru === 'diproses' ? 'Diproses' : ucfirst($statusBaru);
    
    $message = "Status laporan kerusakan Anda telah diperbarui.\n\n" .
               "Lab: {$laporan_kerusakan->lab->nama_lab}\n" .
               "Kerusakan: {$laporan_kerusakan->jenis_kerusakan}\n" .
               "Status: {$statusText}";

    try {
        Http::timeout(10)->post('http://172.19.0.1:3001/send-message', [
            'number' => $laporan_kerusakan->no_hp,
            'message' => $message
        ]);
    } catch (\Exception $e) {
        logger($e->getMessage());
    }

    return redirect()
        ->route('laporan-kerusakan.show', $laporan_kerusakan->id)
        ->with('success', 'Status berhasil diperbarui dan kondisi barang disinkronkan.');
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

public function previewPdf()
{
    $laporans = LaporanKerusakan::with('lab')->latest()->get();
    return view('laporan-kerusakan.pdf', compact('laporans'));
}

public function exportExcel(): StreamedResponse
{
    $laporans = LaporanKerusakan::with('lab')->latest()->get();
    $filename = 'laporan-kerusakan-' . now()->format('Y-m-d') . '.csv';

    $headers = [
        'Content-Type'        => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    return response()->stream(function () use ($laporans) {
        $file = fopen('php://output', 'w');

        // BOM UTF-8 agar Excel tidak rusak
        fputs($file, "\xEF\xBB\xBF");

        // Judul
        fputcsv($file, ['Laporan Kerusakan Laboratorium']);
        fputcsv($file, ['Dicetak: ' . now()->format('d F Y, H:i')]);
        fputcsv($file, []);

        // Header kolom
        fputcsv($file, ['No', 'Laboratorium', 'Nama Pelapor', 'Role', 'Jenis Kerusakan', 'Deskripsi', 'Status', 'Tanggal']);

        foreach ($laporans as $i => $laporan) {
            fputcsv($file, [
                $i + 1,
                $laporan->lab->nama_lab ?? '-',
                $laporan->nama_pelapor,
                ucfirst($laporan->role_pelapor),
                $laporan->jenis_kerusakan,
                $laporan->deskripsi,
                ucfirst($laporan->status),
                $laporan->created_at->format('d F Y'),
            ]);
        }

        fclose($file);
    }, 200, $headers);
}
}
