@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Laporan Kerusakan</h1>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Kelola dan pantau status perbaikan fasilitas laboratorium</p>
    </div>
    <a href="{{ route('laporan-kerusakan.create') }}" class="inline-flex items-center justify-center gap-2 bg-primary-container text-on-primary px-6 py-3 rounded-lg font-bold hover:opacity-90 active:scale-95 transition-all shadow-md">
        <span class="material-symbols-outlined">add_circle</span>
        <span class="font-label-md text-label-md">Buat Laporan</span>
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2 font-body-sm">
    <span class="material-symbols-outlined text-[20px]">check_circle</span>
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-8">
    <div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm">
        <div class="flex items-center gap-4">
            <div class="p-3 rounded-lg bg-error-container text-on-error-container flex items-center justify-center">
                <span class="material-symbols-outlined">pending_actions</span>
            </div>
            <div>
                <p class="text-label-sm font-label-sm text-on-surface-variant">Menunggu Perbaikan</p>
                <h3 class="text-headline-md font-headline-md text-on-surface">
                    {{ $laporans->where('status', 'pending')->count() }}
                </h3>
            </div>
        </div>
    </div>
    <div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm">
        <div class="flex items-center gap-4">
            <div class="p-3 rounded-lg bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center">
                <span class="material-symbols-outlined">construction</span>
            </div>
            <div>
                <p class="text-label-sm font-label-sm text-on-surface-variant">Dalam Proses</p>
                <h3 class="text-headline-md font-headline-md text-on-surface">
                    {{ $laporans->where('status', 'diproses')->count() }}
                </h3>
            </div>
        </div>
    </div>
    <div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm">
        <div class="flex items-center gap-4">
            <div class="p-3 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="text-label-sm font-label-sm text-on-surface-variant">Selesai Diperbaiki</p>
                <h3 class="text-headline-md font-headline-md text-on-surface">
                    {{ $laporans->where('status', 'selesai')->count() }}
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-4">
    @forelse($laporans as $laporan)
        <div class="group bg-surface-container-lowest rounded-xl border border-outline-variant p-6 flex flex-col lg:flex-row lg:items-center justify-between gap-6 hover:shadow-md transition-shadow duration-300">
            <div class="grid grid-cols-1 md:grid-cols-12 flex-1 items-center gap-4">
                
                <div class="md:col-span-4 space-y-2">
                    @if($laporan->status == 'pending')
                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-800 ring-1 ring-inset ring-amber-600/20 uppercase tracking-wider">
                            Pending
                        </span>
                    @elseif($laporan->status == 'diproses')
                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-800 ring-1 ring-inset ring-blue-600/20 uppercase tracking-wider">
                            Diproses
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-1 text-xs font-bold text-green-800 ring-1 ring-inset ring-green-600/20 uppercase tracking-wider">
                            Selesai
                        </span>
                    @endif

                    <h4 class="font-headline-sm text-headline-sm text-on-surface font-bold">
                        {{ $laporan->lab->nama_lab }}
                    </h4>
                </div>

                <div class="md:col-span-5 space-y-1">
                    <span class="text-[10px] uppercase font-bold text-outline tracking-wider block">Kerusakan</span>
                    <p class="font-body-md text-body-md text-on-surface font-medium line-clamp-1">
                        {{ $laporan->jenis_kerusakan }}
                    </p>
                </div>

                <div class="md:col-span-3 flex items-center gap-3 border-t md:border-t-0 md:border-l border-outline-variant/60 pt-4 md:pt-0 md:pl-4">
                    <div class="w-9 h-9 rounded-full bg-surface-container flex items-center justify-center font-bold text-primary uppercase shrink-0">
                        {{ substr($laporan->nama_pelapor, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-label-md text-label-md text-on-surface font-semibold truncate">{{ $laporan->nama_pelapor }}</p>
                        <p class="text-xs text-on-surface-variant">{{ ucfirst($laporan->role_pelapor) }}</p>
                    </div>
                </div>

            </div>

            <div class="flex items-center justify-end border-t lg:border-t-0 border-outline-variant/40 pt-4 lg:pt-0 shrink-0">
                <a href="{{ route('laporan-kerusakan.show', $laporan->id) }}" class="w-full lg:w-auto inline-flex items-center justify-center gap-2 border border-primary text-primary font-bold px-5 py-2.5 rounded-lg hover:bg-primary-fixed transition-colors text-sm">
                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                    <span>Detail</span>
                </a>
            </div>
        </div>
    @empty
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-12 flex flex-col items-center justify-center text-center relative overflow-hidden">
            <div class="w-full max-w-sm aspect-video mb-6 rounded-lg overflow-hidden bg-surface-container-low flex items-center justify-center border border-outline-variant">
                <span class="material-symbols-outlined text-5xl text-outline-variant">verified_user</span>
            </div>
            <div class="max-w-md">
                <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Belum Ada Laporan</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">
                    Sepertinya semua fasilitas laboratorium dalam kondisi prima. Klik tombol di bawah jika Anda menemukan kerusakan sarana yang perlu ditindaklanjuti.
                </p>
                <div class="mt-6 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('laporan-kerusakan.create') }}" class="bg-primary-container text-on-primary px-6 py-3 rounded-lg font-bold flex items-center justify-center gap-2 hover:opacity-90 transition-all active:scale-95 shadow-sm text-sm">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        <span>Buat Laporan Pertama</span>
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection