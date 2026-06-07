@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h3 class="font-headline-lg text-headline-lg text-on-surface mb-1">Data Lab</h3>
        <p class="font-body-md text-body-md text-on-surface-variant">Kelola daftar laboratorium dan kapasitas operasional secara real-time.</p>
    </div>
    <a href="{{ route('labs.create') }}" class="bg-primary-container text-on-primary-container px-6 py-3 rounded-lg font-bold flex items-center gap-2 hover:opacity-90 transition-opacity shadow-sm">
        <span class="material-symbols-outlined">add</span>
        <span>Tambah Lab</span>
    </a>
</div>

<div class="flex flex-col lg:flex-row gap-4 bg-surface-container-lowest p-4 rounded-xl border border-outline-variant shadow-sm mb-8">
    <div class="relative flex-1">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
        <input class="w-full pl-11 pr-4 py-2.5 bg-background border border-outline rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all font-body-md" placeholder="Cari nama lab atau lokasi..." type="text"/>
    </div>
    <div class="flex gap-2">
        <button class="px-4 py-2.5 border border-outline rounded-lg flex items-center gap-2 text-on-surface hover:bg-surface-container-low transition-colors">
            <span class="material-symbols-outlined text-sm">filter_list</span>
            <span class="font-label-md">Filter Status</span>
        </button>
        <button class="px-4 py-2.5 border border-outline rounded-lg flex items-center gap-2 text-on-surface hover:bg-surface-container-low transition-colors">
            <span class="material-symbols-outlined text-sm">sort</span>
            <span class="font-label-md">Urutkan</span>
        </button>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
    
    @forelse($labs as $lab)
        <div class="group bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="h-40 relative bg-surface-container-high">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                         src="https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=600&q=80" 
                         alt="{{ $lab->nama_lab }}"/>
                    <div class="absolute top-4 right-4">
                        @if($lab->status == 'aktif')
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full border border-green-200">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full border border-red-200">
                                Nonaktif
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <h4 class="font-headline-sm text-headline-sm text-on-surface">{{ $lab->nama_lab }}</h4>
                        <div class="flex items-center gap-2 text-on-surface-variant mt-1">
                            <span class="material-symbols-outlined text-sm">location_on</span>
                            <span class="font-body-sm text-body-sm">{{ $lab->lokasi }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="bg-background p-3 rounded-lg flex flex-col">
                            <span class="text-[10px] uppercase font-bold text-outline">Kapasitas</span>
                            <span class="font-headline-sm text-primary">{{ $lab->kapasitas }} Siswa</span>
                        </div>
                        <div class="bg-background p-3 rounded-lg flex flex-col justify-center">
                            <span class="text-[10px] uppercase font-bold text-outline">Operasional</span>
                            <span class="text-body-sm font-semibold text-on-surface mt-0.5">Ready</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 pb-6 pt-2">
                <a href="{{ route('labs.show', $lab->id) }}" class="block w-full py-2 text-center border border-primary text-primary font-bold rounded-lg hover:bg-primary-fixed transition-colors">
                    Lihat Detail
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-1 md:col-span-2 lg:col-span-3 py-16 text-center bg-surface-container-low/30 rounded-xl border-2 border-dashed border-outline-variant">
            <span class="material-symbols-outlined text-5xl text-outline-variant mb-3">layers_clear</span>
            <h4 class="font-headline-sm text-headline-sm text-on-surface">Belum Ada Data Lab</h4>
            <p class="text-on-surface-variant font-body-sm mt-1">Klik tombol 'Tambah Lab' di atas untuk memasukkan unit ruang baru.</p>
        </div>
    @endforelse

    <a href="{{ route('labs.create') }}" class="group border-2 border-dashed border-outline-variant rounded-xl flex flex-col items-center justify-center p-8 hover:bg-surface-container-low transition-colors min-h-[380px]">
        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-4xl">add_circle</span>
        </div>
        <h4 class="font-headline-sm text-headline-sm text-on-surface text-center">Tambah Unit Baru</h4>
        <p class="text-on-surface-variant text-center font-body-sm max-w-[200px] mt-2">Daftarkan laboratorium atau ruang praktikum baru ke sistem.</p>
    </a>
</div>
@endsection