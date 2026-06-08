@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

{{-- Kontainer Utama: Mengikuti alur layout bawaan app.blade.php secara natural tanpa margin-left manual --}}
<div class="w-full relative p-4 md:p-6">
    
    {{-- Header Area --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h3 class="font-headline-lg text-headline-lg text-on-surface mb-1">Data Lab</h3>
            <p class="font-body-md text-body-md text-on-surface-variant">Kelola daftar laboratorium dan kapasitas operasional secara real-time.</p>
        </div>
        
        {{-- Tombol Tambah Lab dengan Logika Penyelamat jika Role Kosong --}}
        @if(Auth::check() && Auth::user()->role != 'guru' && Auth::user()->role != 'siswa')
            <a href="{{ route('labs.create') }}" class="bg-primary text-white px-5 py-2.5 rounded-lg font-bold flex items-center gap-2 hover:bg-blue-700 transition-colors shadow-sm self-start md:self-auto no-underline font-label-md text-label-md">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span>Tambah Lab</span>
            </a>
        @endif
    </div>

    {{-- KONTEN UTAMA: Layout List Vertikal Tunggal --}}
    <div class="space-y-4">
        
        @forelse($labs as $lab)
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-5 hover:border-primary transition-all flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                
                {{-- Sisi Kiri: Icon dan Informasi Detail Lab --}}
                <div class="flex items-center gap-4 min-w-0">
                    <div class="bg-primary/10 text-primary p-3 rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-2xl">computer</span>
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="text-base font-bold text-on-surface truncate">{{ $lab->nama_lab }}</h4>
                            
                            {{-- Badge Status Aktif / Nonaktif Dinamis --}}
                            @if($lab->status == 'aktif')
                                <span class="bg-green-50 text-green-700 border border-green-200 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    Aktif
                                </span>
                            @else
                                <span class="bg-red-50 text-red-700 border border-red-200 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    Nonaktif
                                </span>
                            @endif
                        </div>
                        
                        {{-- Meta Data: Lokasi & Kapasitas --}}
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-on-surface-variant">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">location_on</span>
                                <span>{{ $lab->lokasi }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">groups</span>
                                <span>Kapasitas: <strong class="text-primary">{{ $lab->kapasitas }} Siswa</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Sisi Kanan: Status Operasional & Tombol Aksi Menuju Detail --}}
                <div class="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-end border-t sm:border-t-0 pt-3 sm:pt-0 border-outline-variant">
                    <div class="text-left sm:text-right">
                        <p class="text-[10px] text-on-surface-variant font-medium uppercase tracking-wider">Operasional</p>
                        <p class="text-sm font-bold text-green-600">Ready</p>
                    </div>
                    
                    <a href="{{ route('labs.show', $lab->id) }}" class="inline-flex items-center gap-1 bg-surface-container-low hover:bg-primary hover:text-white text-on-surface px-4 py-2 rounded-lg text-xs font-bold transition-all no-underline shadow-sm border border-outline-variant">
                        <span>Lihat Detail</span>
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </a>
                </div>
            </div>
        @empty
            {{-- State jika seandainya data kosong --}}
            <div class="py-16 text-center bg-surface-container-low/30 rounded-xl border-2 border-dashed border-outline-variant">
                <span class="material-symbols-outlined text-5xl text-outline-variant mb-3">layers_clear</span>
                <h4 class="font-headline-sm text-headline-sm text-on-surface">Belum Ada Data Lab</h4>
                <p class="text-on-surface-variant font-body-sm mt-1">Klik tombol 'Tambah Lab' di atas untuk memasukkan unit ruang baru.</p>
            </div>
        @endforelse

        {{-- Slot Tombol Cepat Tambah Unit Baru di Paling Bawah List --}}
        @if(Auth::check() && Auth::user()->role != 'guru' && Auth::user()->role != 'siswa')
            <a href="{{ route('labs.create') }}" class="flex items-center justify-center gap-2 py-4 border border-dashed border-outline-variant hover:border-primary hover:bg-surface-container-lowest rounded-xl text-xs font-bold text-on-surface-variant hover:text-primary transition-all no-underline cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>Tambah Unit Laboratorium Baru</span>
            </a>
        @endif

    </div>
</div>
@endsection