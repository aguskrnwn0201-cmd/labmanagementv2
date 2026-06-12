<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Lab;
use Illuminate\Http\Request;
use App\Models\LaporanKerusakan;

class InventarisController extends Controller
{
    private function cekTeknisi()
    {
        // Cek session, jika tidak ada, ambil dari database user yang login
        $role = session('role') ?? auth()->user()->role;

        if ($role !== 'teknisi' && $role !== 'admin') {
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->cekTeknisi();

        $inventaris = Inventaris::with('lab')
            ->latest()
            ->get();

        return view(
            'inventaris.index',
            compact('inventaris')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->cekTeknisi();

        $labs = Lab::all();

        return view(
            'inventaris.create',
            compact('labs')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'lab_id' => 'required|exists:labs,id',
        'nama_barang' => 'required|string',
        'baik' => 'required|integer|min:0',
        'rusak' => 'required|integer|min:0',
        'cadangan' => 'required|integer|min:0',
    ]);

    // 1. Hitung total secara otomatis sebelum disimpan
    $total = (int)$request->baik + (int)$request->rusak + (int)$request->cadangan;

    // 2. Simpan data ke tabel inventaris
    $inventaris = Inventaris::create([
        'lab_id' => $request->lab_id,
        'nama_barang' => $request->nama_barang,
        'baik' => $request->baik,
        'rusak' => $request->rusak,
        'cadangan' => $request->cadangan,
        'total' => $total,
        'keterangan' => $request->keterangan,
    ]);

    // 3. SINKRONISASI: Jika saat input pertama kali langsung ada yang rusak, buatkan laporannya
    if ((int)$request->rusak > 0) {
        LaporanKerusakan::create([
            'lab_id' => $inventaris->lab_id,
            'inventaris_id' => $inventaris->id,
            'jumlah_rusak' => $inventaris->rusak,
            'nama_pelapor' => auth()->user()->name ?? 'Sistem Inventaris',
            'role_pelapor' => auth()->user()->role ?? 'teknisi',
            'no_hp' => auth()->user()->no_hp ?? '6282332671812', // Sesuaikan default no HP instansi
            'jenis_kerusakan' => 'Kerusakan Aset Awal: ' . $inventaris->nama_barang,
            'deskripsi' => 'Data otomatis terbuat saat input inventaris baru dengan kondisi rusak.',
            'status' => 'diproses', // Langsung set diproses/pending sesuai kebutuhan
        ]);
    }

    return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil ditambahkan.');
}

    /**
     * Display the specified resource.
     */
    public function show(Inventaris $inventaris)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventaris $inventaris)
    {
        $this->cekTeknisi();

        $labs = Lab::all();

        return view(
            'inventaris.edit',
            compact(
                'inventaris',
                'labs'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Inventaris $inventaris)
{
    $request->validate([
        'lab_id' => 'required|exists:labs,id',
        'nama_barang' => 'required|string',
        'baik' => 'required|integer|min:0',
        'rusak' => 'required|integer|min:0',
        'cadangan' => 'required|integer|min:0',
    ]);

    // Hitung selisih kerusakan baru untuk memicu pembuatan laporan
    $rusakLama = (int)$inventaris->rusak;
    $rusakBaru = (int)$request->rusak;
    
    $total = (int)$request->baik + $rusakBaru + (int)$request->cadangan;

    // 1. Update data inventaris
    $inventaris->update([
        'lab_id' => $request->lab_id,
        'nama_barang' => $request->nama_barang,
        'baik' => $request->baik,
        'rusak' => $request->rusak,
        'cadangan' => $request->cadangan,
        'total' => $total,
        'keterangan' => $request->keterangan,
    ]);

    // 2. SINKRONISASI: Jika jumlah rusak bertambah dari kondisi sebelumnya, buat laporan baru
    if ($rusakBaru > $rusakLama) {
        $selisihKerusakan = $rusakBaru - $rusakLama;

        LaporanKerusakan::create([
            'lab_id' => $inventaris->lab_id,
            'inventaris_id' => $inventaris->id,
            'jumlah_rusak' => $selisihKerusakan,
            'nama_pelapor' => auth()->user()->name ?? 'Teknisi Lab',
            'role_pelapor' => auth()->user()->role ?? 'teknisi',
            'no_hp' => auth()->user()->no_hp ?? '6282332671812',
            'jenis_kerusakan' => 'Penambahan Kerusakan: ' . $inventaris->nama_barang,
            'deskripsi' => 'Laporan otomatis dibuat karena ada penambahan jumlah barang rusak di manajemen inventaris.',
            'status' => 'diproses',
        ]);
    }

    return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventaris $inventaris)
    {
        $this->cekTeknisi();

        $inventaris->delete();

        return redirect()
            ->route('inventaris.index')
            ->with(
                'success',
                'Inventaris berhasil dihapus'
            );
    }
}