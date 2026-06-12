@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant shadow-sm">
    
    {{-- Header Halaman --}}
    <div class="flex items-center gap-3 mb-6 border-b border-outline-variant/30 pb-4">
        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary">
            
        </div>
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-on-surface">
                Detail Jadwal Penggunaan Lab
            </h1>
            <p class="text-xs md:text-sm text-on-surface-variant">Informasi lengkap mengenai jadwal kelas tetap di laboratorium.</p>
        </div>
    </div>

    {{-- Detail Informasi --}}
    <div class="space-y-4">
        
        {{-- Baris Lab & Hari --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Laboratorium</span>
                <div class="flex items-center gap-2 font-bold text-on-surface">
                    <span class="material-symbols-outlined text-primary text-[20px]">science</span>
                    <span>{{ $jadwal->lab->nama_lab ?? 'Lab' }}</span>
                </div>
            </div>

            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Hari Pelaksanaan</span>
                <div class="flex items-center gap-2 font-bold text-on-surface">
                    <span class="material-symbols-outlined text-primary text-[20px]">today</span>
                    <span>{{ $jadwal->hari }}</span>
                </div>
            </div>
        </div>

        {{-- Baris Waktu --}}
        <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
            <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Alokasi Waktu (Jam Pelajaran)</span>
            <div class="flex items-center gap-2 font-bold text-primary text-lg">
                <span class="material-symbols-outlined text-[22px]">schedule</span>
                <span>{{ substr($jadwal->jam_mulai, 0, 5) }} WIB - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB</span>
            </div>
        </div>

        {{-- Baris Mata Pelajaran --}}
        <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
            <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Mata Pelajaran / Agenda</span>
            <div class="flex items-center gap-2 font-bold text-on-surface text-base">
                <span class="material-symbols-outlined text-primary text-[20px]">menu_book</span>
                <span>{{ $jadwal->mata_pelajaran }}</span>
            </div>
        </div>

        {{-- Baris Guru & Kelas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Guru Pengampu</span>
                <div class="flex items-center gap-2 font-medium text-on-surface">
                    <span class="material-symbols-outlined text-on-surface-variant text-[20px]">person</span>
                    <span>{{ $jadwal->guru }}</span>
                </div>
            </div>

            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Kelas</span>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-on-surface-variant text-[20px]">groups</span>
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-bold bg-primary/10 text-primary border border-primary/20">
                        {{ $jadwal->kelas }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Kolom Tambahan Jika Ada Kolom Baru Lembaga & Semester --}}
        @if(isset($jadwal->lembaga) || isset($jadwal->semester))
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if($jadwal->lembaga)
            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Lembaga / Instansi</span>
                <div class="flex items-center gap-2 text-sm text-on-surface">
                    <span class="material-symbols-outlined text-on-surface-variant text-[20px]">school</span>
                    <span>{{ $jadwal->lembaga }}</span>
                </div>
            </div>
            @endif

            @if($jadwal->semester)
            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Semester</span>
                <div class="flex items-center gap-2 text-sm text-on-surface">
                    <span class="material-symbols-outlined text-on-surface-variant text-[20px]">import_contacts</span>
                    <span>Semester {{ $jadwal->semester }}</span>
                </div>
            </div>
            @endif
        </div>
        @endif

    </div>

    {{-- Tombol Aksi di Bawah Form --}}
    <div class="mt-8 flex flex-col sm:flex-row gap-3 border-t border-outline-variant/30 pt-5">
        <a href="{{ route('jadwal.index') }}" class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-surface-container-high text-on-surface-variant px-6 py-3 rounded-xl font-bold hover:bg-surface-variant transition-all text-center no-underline text-sm shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Kembali ke Jadwal</span>
        </a>

        {{-- KUNCI BERLAPIS DETAIL: Tombol Edit hanya muncul untuk Teknisi/Admin --}}
        @if(Auth::check() && 
            strtolower(Auth::user()->role) !== 'guru' && 
            strtolower(Auth::user()->role) !== 'siswa' && 
            session('role') !== 'guru' && 
            session('role') !== 'siswa')
            
            <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-primary text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition-all text-center no-underline text-sm shadow-sm sm:ml-auto">
                <span class="material-symbols-outlined text-[18px]">edit</span>
                <span>Edit Jadwal</span>
            </a>
        @endif
    </div>

</div>
@endsection