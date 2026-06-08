@extends('layouts.app')

@section('content')
<div class="p-4 md:p-margin-desktop">
    
    <div class="mb-8">
        <h1 class="font-headline-sm text-headline-sm md:font-headline-lg md:text-headline-lg font-bold text-primary dark:text-primary-fixed-dim mb-1">
            Dashboard {{ session('role') == 'teknisi' ? 'Teknisi' : 'Guru' }}
        </h1>
        <p class="font-body-md text-on-surface-variant">
            Selamat datang kembali. Berikut adalah ringkasan operasional laboratorium hari ini.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-surface-container-lowest p-6 rounded-lg border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-primary/10 rounded-lg">
                    <span class="material-symbols-outlined text-primary">biotech</span>
                </div>
                <span class="text-xs font-bold text-green-700 px-2.5 py-1 bg-green-100 rounded-full border border-green-200">Aktif</span>
            </div>
            <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Total Lab</p>
            <h3 class="text-3xl font-extrabold text-on-surface">{{ $totalLab ?? 0 }}</h3>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-lg border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-secondary/10 rounded-lg">
                    <span class="material-symbols-outlined text-secondary">
                        {{ session('role') == 'teknisi' ? 'computer' : 'event_note' }}
                    </span>
                </div>
            </div>
            @if(session('role') == 'teknisi')
                <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Jumlah Komputer</p>
                <h3 class="text-3xl font-extrabold text-on-surface">{{ $totalKomputer ?? 0 }}</h3>
            @else
                <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Total Jadwal</p>
                <h3 class="text-3xl font-extrabold text-on-surface">{{ $totalJadwal ?? 0 }}</h3>
            @endif
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-lg border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-error/10 rounded-lg">
                    <span class="material-symbols-outlined text-error">pending_actions</span>
                </div>
            </div>
            <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Booking Hari Ini</p>
            <h3 class="text-3xl font-extrabold text-on-surface">{{ $bookingHariIni ?? 0 }}</h3>
        </div>

        <div class="bg-primary text-on-primary p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-white/20 rounded-lg">
                    <span class="material-symbols-outlined text-white">calendar_month</span>
                </div>
            </div>
            <p class="font-label-sm text-label-sm text-on-primary/80 mb-1">Total Booking</p>
            <h3 class="text-3xl font-extrabold">{{ $totalBooking ?? 0 }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-8 flex flex-col gap-6">
            @if(session('role') == 'teknisi')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('labs.index') }}" class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl flex items-center gap-4 hover:border-primary/70 hover:shadow-sm transition-all duration-200 group no-underline text-current">
                        <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors shrink-0">
                            <span class="material-symbols-outlined">database</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-on-surface">Data Lab</h4>
                            <p class="text-xs text-on-surface-variant mt-0.5">Kelola aset & fasilitas</p>
                        </div>
                    </a>

                    <a href="{{ route('jadwal.index') }}" class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl flex items-center gap-4 hover:border-primary/70 hover:shadow-sm transition-all duration-200 group no-underline text-current">
                        <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors shrink-0">
                            <span class="material-symbols-outlined">schedule</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-on-surface">Jadwal Lab</h4>
                            <p class="text-xs text-on-surface-variant mt-0.5">Monitoring harian</p>
                        </div>
                    </a>
                </div>
            @endif

            <div class="relative overflow-hidden rounded-xl bg-slate-900 min-h-[12rem] shadow-sm flex items-center">
                <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/60 to-transparent z-10 p-6 flex flex-col justify-center">
                    <h3 class="text-white text-base md:text-lg font-bold mb-2">Maintenance & Operasional Sistem</h3>
                    <p class="text-gray-300 max-w-md text-xs leading-relaxed">
                        Pastikan semua logbook penggunaan dan data kondisi komputer terisi dengan valid demi kenyamanan praktikum bersama.
                    </p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 flex flex-col gap-6">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-base font-bold text-on-surface">Booking Terbaru</h3>
                </div>
                
                <ul class="flex flex-col gap-5 list-none p-0 m-0">
                    @forelse($bookingTerbaru ?? [] as $booking)
                        <li class="flex gap-3 items-start border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                            <div class="w-2 h-2 rounded-full bg-primary mt-1.5 shrink-0"></div>
                            <div>
                                <p class="text-xs md:text-sm font-bold text-on-surface">
                                    {{ $booking->lab->nama_lab ?? 'Lab' }} - <span class="font-normal text-xs">{{ $booking->nama_pemohon }}</span>
                                </p>
                                <p class="text-[11px] text-on-surface-variant mt-0.5">
                                    Tgl: {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }} ({{ substr($booking->jam_mulai,0,5) }})
                                </p>
                            </div>
                        </li>
                    @empty
                        <div class="text-center py-6">
                            <span class="material-symbols-outlined text-gray-300 text-4xl">calendar_today</span>
                            <p class="text-xs text-on-surface-variant italic mt-1">Belum ada aktivitas booking.</p>
                        </div>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection