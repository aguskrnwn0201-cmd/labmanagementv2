<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Lab;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Helper untuk mengecek akses teknisi / admin.
     * Sudah diperbaiki agar aman dari error 'null' jika diakses oleh user non-login (Guru/Siswa).
     */
    private function authorizeTeknisi()
    {
        // Cek dulu apakah user sedang login, jika tidak login ATAU bukan teknisi/admin, langsung tolak.
        if (!auth()->check() || (auth()->user()->role !== 'teknisi' && auth()->user()->role !== 'admin')) {
            abort(403, 'Anda tidak memiliki akses sebagai teknisi atau admin.');
        }
    }

    public function index()
    {
        $jadwals = Jadwal::with('lab')
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        $labs = Lab::all();
        return view('jadwal.index', compact('jadwals', 'labs'));
    }

    public function create()
    {
        $this->authorizeTeknisi();
        $labs = Lab::all();
        return view('jadwal.create', compact('labs'));
    }

    public function store(Request $request)
    {
        $this->authorizeTeknisi();

        $request->validate([
            'lab_id'         => 'required|exists:labs,id',
            'hari'           => 'required',
            'jam_mulai'      => 'required|date_format:H:i', // Memastikan format 24 jam di backend
            'jam_selesai'    => 'required|date_format:H:i|after:jam_mulai',
            'mata_pelajaran' => 'required',
            'guru'           => 'required',
            'kelas'          => 'required',
            'lembaga'        => 'required|string|max:255', // Validasi kolom baru
            'semester'       => 'required|in:Ganjil,Genap', // Validasi kolom baru
        ]);

        if ($this->isBentrok($request)) {
            return back()->withInput()->withErrors(['jadwal' => 'Jadwal bentrok dengan jadwal lain pada jam dan lab yang sama.']);
        }

        Jadwal::create($request->all());
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show(Jadwal $jadwal)
    {
        return view('jadwal.show', ['jadwal' => $jadwal->load('lab')]);
    }

    public function edit(Jadwal $jadwal)
    {
        $this->authorizeTeknisi();
        $labs = Lab::all(); // Disamakan dengan create agar konsisten
        return view('jadwal.edit', compact('jadwal', 'labs'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $this->authorizeTeknisi();
        
        $request->validate([
            'lab_id'         => 'required|exists:labs,id',
            'hari'           => 'required',
            'jam_mulai'      => 'required|date_format:H:i',
            'jam_selesai'    => 'required|date_format:H:i|after:jam_mulai',
            'mata_pelajaran' => 'required',
            'guru'           => 'required',
            'kelas'          => 'required',
            'lembaga'        => 'required|string|max:255', // Validasi kolom baru
            'semester'       => 'required|in:Ganjil,Genap', // Validasi kolom baru
        ]);

        if ($this->isBentrok($request, $jadwal->id)) {
            return back()->withInput()->withErrors(['jadwal' => 'Jadwal bentrok dengan jadwal lain pada jam dan lab yang sama.']);
        }

        $jadwal->update($request->all());
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $this->authorizeTeknisi();
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Fungsi pembantu (Private) untuk mengecek jadwal tabrakan/bentrok
     */
    private function isBentrok(Request $request, $ignoreId = null)
    {
        $query = Jadwal::where('lab_id', $request->lab_id)
            ->where('hari', $request->hari)
            ->where(function ($q) use ($request) {
                $q->where('jam_mulai', '<', $request->jam_selesai)
                  ->where('jam_selesai', '>', $request->jam_mulai);
            });

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}