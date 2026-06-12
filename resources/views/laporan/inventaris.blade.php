@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-margin-mobile py-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="space-y-1">
            <h2 class="text-headline-md font-headline-md text-on-surface font-bold">Laporan Inventaris</h2>
            <p class="text-body-sm font-body-sm text-on-surface-variant">Data lengkap aset dan peralatan laboratorium aktif.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('laporan.inventaris.preview') }}" target="_blank" class="px-4 py-2.5 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-all text-sm no-underline flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-[18px]">table_view</span>
                <span>Preview Excel</span>
            </a>
            <a href="{{ route('laporan.inventaris.excel') }}" class="px-4 py-2.5 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 transition-all text-sm no-underline flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-[18px]">download</span>
                <span>Download Excel</span>
            </a>
        </div>
    </div>

    @foreach($labs as $lab)
        <section class="mb-10">
            <div class="flex items-center justify-between mb-4 px-2 border-b border-outline-variant/60 pb-2">
                <div class="flex items-center gap-3">
                    @if(Str::contains(Str::lower($lab->nama_lab), 'komputer'))
                        <span class="material-symbols-outlined text-primary text-3xl">computer</span>
                    @elseif(Str::contains(Str::lower($lab->nama_lab), 'kimia'))
                        <span class="material-symbols-outlined text-primary text-3xl">chemistry</span>
                    @elseif(Str::contains(Str::lower($lab->nama_lab), 'biologi'))
                        <span class="material-symbols-outlined text-primary text-3xl">biotech</span>
                    @else
                        <span class="material-symbols-outlined text-primary text-3xl">inventory_2</span>
                    @endif
                    <h3 class="text-headline-sm font-headline-sm text-primary font-bold">{{ $lab->nama_lab }}</h3>
                </div>
                {{-- Menampilkan Field Baru: Komputer Ready dari Tabel Labs --}}
                <div class="text-xs font-bold text-primary bg-primary-container px-3 py-1 rounded-full flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[14px]">desktop_windows</span>
                    <span>Ready: {{ $lab->komputer_ready ?? 0 }} PC</span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @forelse($lab->inventaris as $item)
                    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:shadow-md transition-all duration-200">
                        
                        {{-- Nama & ID Aset --}}
                        <div class="space-y-1 flex-1 min-w-0">
                            <h4 class="text-body-lg font-bold text-on-surface truncate">{{ $item->nama_barang }}</h4>
                            <p class="text-xs font-mono text-outline">ID ASET: #{{ sprintf('%04d', $item->id) }}</p>
                            
                            {{-- Box Keterangan Tambahan --}}
                            @if(!empty($item->keterangan))
                                <p class="text-xs text-on-surface-variant/80 bg-surface-container-low p-2 rounded-lg border border-outline-variant/30 mt-2 line-clamp-2">
                                    {{ $item->keterangan }}
                                </p>
                            @endif
                        </div>

                        {{-- Breakdown Kondisi 3 Pilar --}}
                        <div class="flex flex-wrap items-center gap-2 md:justify-end shrink-0">
                            {{-- Kondisi: Baik --}}
                            <div class="flex items-center gap-1 bg-green-50 border border-green-200 text-green-800 text-xs font-bold px-2.5 py-1 rounded-lg">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                                <span>{{ $item->baik }} Baik</span>
                            </div>

                            {{-- Kondisi: Rusak --}}
                            <div class="flex items-center gap-1 bg-red-50 border border-red-200 text-red-800 text-xs font-bold px-2.5 py-1 rounded-lg">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                                <span>{{ $item->rusak }} Rusak</span>
                            </div>

                            {{-- Kondisi: Cadangan --}}
                            <div class="flex items-center gap-1 bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold px-2.5 py-1 rounded-lg">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                <span>{{ $item->cadangan }} Cadangan</span>
                            </div>

                            {{-- Akumulasi Total Stok --}}
                            <div class="flex items-center gap-1 bg-surface-container-high border border-outline-variant text-on-surface text-xs font-black px-3 py-1 rounded-lg shadow-sm">
                                <span class="material-symbols-outlined text-[14px]">calculate</span>
                                <span>Total: {{ $item->total ?? ($item->baik + $item->rusak + $item->cadangan) }} Unit</span>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="bg-surface-container-low border-2 border-dashed border-outline-variant rounded-xl p-12 flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 bg-surface-container-highest rounded-full flex items-center justify-center mb-4 text-outline">
                            <span class="material-symbols-outlined text-3xl">inventory_2</span>
                        </div>
                        <h4 class="text-body-lg font-bold text-on-surface-variant">Tidak ada inventaris</h4>
                        <p class="text-body-sm text-on-surface-variant max-w-[280px] mt-1">Belum ada data barang atau aset yang terdaftar untuk laboratorium ini.</p>
                    </div>
                @endforelse
            </div>
        </section>
    @endforeach
</div>
@endsection