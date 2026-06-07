@extends('layouts.app')

@section('content')
<!-- Header Section -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="font-headline-lg text-headline-lg text-primary">Kalender Lab</h1>
        <p class="text-body-md text-on-surface-variant">Jadwal dan booking laboratorium secara real-time</p>
    </div>
</div>

<!-- Interactive Calendar Widget Component -->
<section class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-4 mb-6">
    <div class="flex items-center justify-between mb-4 px-2">
        <button class="p-2 hover:bg-surface-container-low rounded-full transition-colors">
            <span class="material-symbols-outlined">chevron_left</span>
        </button>
        <div class="text-center">
            <h2 class="font-headline-sm text-headline-sm text-on-surface">{{ now()->translatedFormat('F Y') }}</h2>
            <p class="text-label-sm text-on-surface-variant uppercase tracking-widest mt-1">Minggu Ini</p>
        </div>
        <button class="p-2 hover:bg-surface-container-low rounded-full transition-colors">
            <span class="material-symbols-outlined">chevron_right</span>
        </button>
    </div>

    <!-- Mini Calendar Strip View -->
    <div class="grid grid-cols-7 gap-1 text-center">
        <div class="py-2 text-label-sm text-on-surface-variant font-bold">SN</div>
        <div class="py-2 text-label-sm text-on-surface-variant font-bold">SL</div>
        <div class="py-2 text-label-sm text-on-surface-variant font-bold">RB</div>
        <div class="py-2 text-label-sm text-on-surface-variant font-bold">KM</div>
        <div class="py-2 text-label-sm text-on-surface-variant font-bold">JM</div>
        <div class="py-2 text-label-sm text-on-surface-variant font-bold">SB</div>
        <div class="py-2 text-label-sm text-on-surface-variant font-bold">MG</div>
        
        <!-- Contoh Grid tanggal interaktif dinamis/statis -->
        <div class="py-3 flex flex-col items-center gap-1"><span class="text-body-md">23</span></div>
        <div class="py-3 flex flex-col items-center gap-1"><span class="text-body-md">24</span></div>
        <div class="py-3 flex flex-col items-center gap-1 bg-primary text-on-primary rounded-lg shadow-md">
            <span class="text-body-md font-bold">25</span>
            <div class="w-1.5 h-1.5 bg-on-primary rounded-full"></div>
        </div>
        <div class="py-3 flex flex-col items-center gap-1"><span class="text-body-md">26</span></div>
        <div class="py-3 flex flex-col items-center gap-1">
            <span class="text-body-md">27</span>
            <div class="w-1.5 h-1.5 bg-primary-container rounded-full"></div>
        </div>
        <div class="py-3 flex flex-col items-center gap-1 text-on-surface-variant opacity-50"><span class="text-body-md">28</span></div>
        <div class="py-3 flex flex-col items-center gap-1 text-on-surface-variant opacity-50"><span class="text-body-md">29</span></div>
    </div>

    <div class="mt-6 flex justify-center gap-4">
        <button class="px-4 py-2 bg-primary text-on-primary font-bold rounded-lg text-label-md">Mingguan</button>
        <button class="px-4 py-2 bg-surface-container-low text-on-surface-variant font-bold rounded-lg text-label-md">Bulanan</button>
    </div>
</section>

<!-- Dynamic Lab Activities List -->
<section class="space-y-4">
    <div class="flex items-center justify-between mb-2">
        <h3 class="font-headline-sm text-headline-sm">Daftar Aktivitas Laboratorium</h3>
        <span class="text-label-sm text-primary font-bold cursor-pointer hover:underline">Lihat Semua</span>
    </div>

    @if($jadwals->isEmpty() && $bookings->isEmpty())
        <!-- Empty State View -->
        <div class="py-12 text-center bg-surface-container-low/30 rounded-xl border-2 border-dashed border-outline-variant">
            <span class="material-symbols-outlined text-4xl text-outline-variant mb-2">event_available</span>
            <p class="text-body-sm text-on-surface-variant italic">Tidak ada jadwal atau booking terdaftar saat ini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4">
            {{-- LOOP DATA JADWAL UTAMA --}}
            @foreach($jadwals as $jadwal)
                <div class="bg-surface-container-lowest border border-outline-variant p-4 rounded-lg shadow-sm flex items-start gap-4 hover:border-primary/50 transition-colors duration-200">
                    <div class="bg-primary/10 text-primary p-3 rounded-lg flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">computer</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start gap-2 mb-1">
                            <h4 class="font-label-md text-label-md font-bold text-on-surface truncate">{{ $jadwal->lab->nama_lab }}</h4>
                            <span class="bg-primary-fixed text-on-primary-fixed px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shrink-0">Jadwal</span>
                        </div>
                        <p class="text-body-md text-on-surface-variant mb-3 font-medium">{{ $jadwal->mata_pelajaran }}</p>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-label-sm text-outline">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                                <span>{{ $jadwal->hari }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">schedule</span>
                                <span>{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- LOOP DATA BOOKING INCIDENT --}}
            @foreach($bookings as $booking)
                <div class="bg-surface-container-lowest border border-outline-variant p-4 rounded-lg shadow-sm flex items-start gap-4 hover:border-tertiary/50 transition-colors duration-200">
                    <div class="bg-tertiary/10 text-tertiary p-3 rounded-lg flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">science</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start gap-2 mb-1">
                            <h4 class="font-label-md text-label-md font-bold text-on-surface truncate">{{ $booking->lab->nama_lab }}</h4>
                            <span class="bg-tertiary-fixed text-on-tertiary-fixed-variant px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shrink-0">Booking</span>
                        </div>
                        <p class="text-body-md text-on-surface-variant mb-3 font-medium">Booking - {{ $booking->nama_pemohon }}</p>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-label-sm text-outline">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                                <span>{{ $booking->tanggal_booking }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">schedule</span>
                                <span>{{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

<!-- Floating Action Button for Creating Activities -->
@if(session('role') == 'teknisi' || session('role') == 'guru')
    <a href="{{ route('booking.index') }}" class="fixed bottom-6 right-6 w-14 h-14 bg-primary text-on-primary rounded-full shadow-lg flex items-center justify-center cursor-pointer hover:bg-primary-container active:scale-95 transition-all z-20">
        <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 0, 'wght' 600;">add</span>
    </a>
@endif
@endsection