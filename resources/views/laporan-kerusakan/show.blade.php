@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant shadow-sm">
    
    {{-- Header Halaman --}}
    <div class="flex items-center gap-3 mb-6 border-b border-outline-variant/30 pb-4">
        <div class="w-10 h-10 bg-error/10 rounded-lg flex items-center justify-center text-error">
            <span class="material-symbols-outlined text-[24px]">report_problem</span>
        </div>
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-on-surface">
                Detail Laporan Kerusakan
            </h1>
            <p class="text-xs md:text-sm text-on-surface-variant">Informasi lengkap mengenai kerusakan fasilitas laboratorium.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2 font-body-sm">
        <span class="material-symbols-outlined text-[20px]">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    {{-- Detail Informasi Laporan --}}
    <div class="space-y-4">
        
        {{-- Baris Lab & Status Saat Ini --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Laboratorium</span>
                <div class="flex items-center gap-2 font-bold text-on-surface">
                    <span class="material-symbols-outlined text-primary text-[20px]">science</span>
                    <span>{{ $laporan_kerusakan->lab->nama_lab ?? 'Tidak diketahui' }}</span>
                </div>
            </div>

            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Status Perbaikan</span>
                <div class="mt-1">
                    @if($laporan_kerusakan->status == 'pending')
                        <span class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-800 ring-1 ring-inset ring-amber-600/20 uppercase tracking-wider">Pending</span>
                    @elseif($laporan_kerusakan->status == 'diproses')
                        <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-800 ring-1 ring-inset ring-blue-600/20 uppercase tracking-wider">Diproses</span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-800 ring-1 ring-inset ring-green-600/20 uppercase tracking-wider">Selesai</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Baris Identitas Pelapor --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Nama Pelapor</span>
                <div class="flex items-center gap-2 font-medium text-on-surface">
                    <span class="material-symbols-outlined text-on-surface-variant text-[20px]">person</span>
                    <span>{{ $laporan_kerusakan->nama_pelapor }}</span>
                </div>
            </div>

            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Role Pelapor</span>
                <div class="flex items-center gap-2 font-medium text-on-surface-variant text-sm">
                    <span class="material-symbols-outlined text-on-surface-variant text-[20px]">badge</span>
                    <span>{{ ucfirst($laporan_kerusakan->role_pelapor) }}</span>
                </div>
            </div>
        </div>

        {{-- Baris Jenis Kerusakan --}}
        <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
            <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Komponen / Fasilitas Yang Rusak</span>
            <div class="flex items-center gap-2 font-bold text-error text-base">
                <span class="material-symbols-outlined text-[20px]">build_circle</span>
                <span>{{ $laporan_kerusakan->jenis_kerusakan }}</span>
            </div>
        </div>

        {{-- Baris Deskripsi --}}
        <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
            <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Deskripsi Kronologi / Detail Kerusakan</span>
            <p class="text-sm text-on-surface font-medium leading-relaxed mt-1 whitespace-pre-line">
                {{ $laporan_kerusakan->deskripsi }}
            </p>
        </div>

    </div>

    {{-- KUNCI BERLAPIS: Bagian update status hanya dirender & bisa diakses oleh Teknisi/Admin --}}
    @if(Auth::check() && 
        strtolower(Auth::user()->role) !== 'guru' && 
        strtolower(Auth::user()->role) !== 'siswa' && 
        session('role') !== 'guru' && 
        session('role') !== 'siswa')
        
        <div class="mt-6 p-5 border border-outline-variant bg-surface-container-low rounded-xl">
            <form action="{{ route('laporan-kerusakan.update', $laporan_kerusakan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <label class="block text-sm font-bold text-on-surface-variant mb-2">Pembaruan Status Laporan:</label>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <div class="relative flex-1 max-w-xs">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">update</span>
                        <select name="status" class="w-full pl-11 pr-4 py-2.5 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm font-semibold appearance-none cursor-pointer">
                            <option value="pending" {{ $laporan_kerusakan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ $laporan_kerusakan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $laporan_kerusakan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <button type="submit" class="flex items-center justify-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-bold hover:bg-blue-700 transition-all shadow-sm text-sm active:scale-95">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        <span>Simpan Status</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Tombol Navigasi Kembali --}}
    <div class="mt-8 flex border-t border-outline-variant/30 pt-5">
        <a href="{{ route('laporan-kerusakan.index') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-surface-container-high text-on-surface-variant px-6 py-3 rounded-xl font-bold hover:bg-surface-variant transition-all text-center no-underline text-sm shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Kembali ke Daftar Laporan</span>
        </a>
    </div>

</div>
@endsection