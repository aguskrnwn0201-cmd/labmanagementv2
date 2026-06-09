@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-margin-mobile py-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="space-y-1">
            <h2 class="text-headline-md font-headline-md text-on-surface font-bold">Laporan Inventaris</h2>
            <p class="text-body-sm font-body-sm text-on-surface-variant">Data lengkap aset dan peralatan laboratorium aktif.</p>
        </div>
        <div class="mb-4 flex gap-2">
    <a href="{{ route('laporan.inventaris.preview') }}" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        Preview Excel
    </a>
    <a href="{{ route('laporan.inventaris.excel') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        Download Excel
    </a>
    </div>
    </div>

    @foreach($labs as $lab)
        <section class="mb-10">
            <div class="flex items-center gap-3 mb-4 px-2">
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

            <div class="grid grid-cols-1 gap-4">
                @forelse($lab->inventaris as $item)
                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-sm hover:border-primary/50 transition-colors duration-200">
                        <div class="flex justify-between items-start mb-3 gap-4">
                            <div class="space-y-1 min-w-0">
                                <h4 class="text-body-lg font-bold text-on-surface truncate">{{ $item->nama_barang }}</h4>
                                <p class="text-label-sm font-label-sm text-on-surface-variant">ID / Kode: #{{ $item->id ?? 'INV-'.$item->id }}</p>
                            </div>
                            
                            @if($item->kondisi == 'Baik')
                                <span class="bg-green-100 text-green-800 text-[10px] uppercase tracking-wider font-bold px-2.5 py-1 rounded-full border border-green-200 shrink-0">
                                    Baik
                                </span>
                            @elseif($item->kondisi == 'Rusak Ringan')
                                <span class="bg-orange-100 text-orange-800 text-[10px] uppercase tracking-wider font-bold px-2.5 py-1 rounded-full border border-orange-200 shrink-0">
                                    Rusak Ringan
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 text-[10px] uppercase tracking-wider font-bold px-2.5 py-1 rounded-full border border-red-200 shrink-0">
                                    Rusak Berat
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center gap-4 text-body-sm font-body-sm text-on-surface-variant mb-3">
                            <div class="flex items-center gap-1 bg-surface-container-low px-2 py-0.5 rounded-md border border-outline-variant/20">
                                <span class="material-symbols-outlined text-[18px]">inventory</span>
                                <span class="font-semibold text-on-surface">{{ $item->jumlah }} Unit</span>
                            </div>
                        </div>

                        @if(!empty($item->keterangan))
                            <p class="text-body-sm font-body-sm text-on-surface-variant bg-surface-container-low p-2.5 rounded-lg border border-dashed border-outline-variant break-words">
                                {{ $item->keterangan }}
                            </p>
                        @else
                            <p class="text-body-sm font-body-sm text-on-surface-variant/50 bg-surface-container-low p-2.5 rounded-lg border border-dashed border-outline-variant italic">
                                Tidak ada keterangan tambahan.
                            </p>
                        @endif
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