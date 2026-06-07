<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Lab;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    private function cekTeknisi()
    {
        if (session('role') !== 'teknisi') {
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
        $this->cekTeknisi();

        $request->validate([
            'lab_id' => 'required|exists:labs,id',
            'nama_barang' => 'required',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required',
        ]);

        Inventaris::create([
            'lab_id' => $request->lab_id,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('inventaris.index')
            ->with(
                'success',
                'Inventaris berhasil ditambahkan'
            );
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
   public function update(
    Request $request,
    Inventaris $inventaris
)
{
    $this->cekTeknisi();

    $request->validate([
        'lab_id' => 'required|exists:labs,id',
        'nama_barang' => 'required',
        'jumlah' => 'required|integer|min:1',
        'kondisi' => 'required',
    ]);

    $inventaris->update([
        'lab_id' => $request->lab_id,
        'nama_barang' => $request->nama_barang,
        'jumlah' => $request->jumlah,
        'kondisi' => $request->kondisi,
        'keterangan' => $request->keterangan,
    ]);

    return redirect()
        ->route('inventaris.index')
        ->with(
            'success',
            'Inventaris berhasil diperbarui'
        );
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(
    Inventaris $inventaris
)
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