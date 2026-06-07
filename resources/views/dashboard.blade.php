@extends('layouts.app')

@section('content')
<!-- Content Area Container -->
<div class="p-4 md:p-margin-desktop">
    
    <!-- Title & Subheadline -->
    <div class="mb-8">
        <h1 class="font-headline-sm text-headline-sm md:font-headline-lg md:text-headline-lg font-bold text-primary dark:text-primary-fixed-dim mb-1">
            Dashboard Teknisi
        </h1>
        <p class="font-body-md text-on-surface-variant">
            Ringkasan aktivitas laboratorium hari ini
        </p>
    </div>

    <!-- Summary Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mb-8">
        
        <!-- Total Lab -->
        <div class="bg-surface-container-lowest p-6 rounded-lg border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-primary/10 rounded-lg">
                    <span class="material-symbols-outlined text-primary">biotech</span>
                </div>
            </div>
            <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Total Lab</p>
            <h3 class="font-headline-lg text-headline-lg text-on-surface">
                {{ $totalLab }}
            </h3>
        </div>

        <!-- Total Jadwal -->
        <div class="bg-surface-container-lowest p-6 rounded-lg border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-secondary/10 rounded-lg">
                    <span class="material-symbols-outlined text-secondary">event_note</span>
                </div>
            </div>
            <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Total Jadwal</p>
            <h3 class="font-headline-lg text-headline-lg text-on-surface">
                {{ $totalJadwal }}
            </h3>
        </div>

        <!-- Total Booking -->
        <div class="bg-surface-container-lowest p-6 rounded-lg border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-tertiary-container/10 rounded-lg">
                    <span class="material-symbols-outlined text-tertiary-container">bookmark_add</span>
                </div>
            </div>
            <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Total Booking</p>
            <h3 class="font-headline-lg text-headline-lg text-on-surface">
                {{ $totalBooking }}
            </h3>
        </div>

        <!-- Booking Hari Ini -->
        <div class="bg-primary text-on-primary p-6 rounded-lg shadow-lg transform scale-[1.02] transition-transform">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-white/20 rounded-lg">
                    <span class="material-symbols-outlined text-white">today</span>
                </div>
                <span class="text-[10px] font-bold bg-white text-primary px-2 py-1 rounded-full uppercase tracking-wider">Prioritas</span>
            </div>
            <p class="font-label-sm text-label-sm text-on-primary/80 mb-1">Booking Hari Ini</p>
            <h3 class="font-headline-lg text-headline-lg">
                {{ $bookingHariIni }}
            </h3>
        </div>
    </div>

    <!-- Recent Bookings Section -->
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h4 class="font-headline-sm text-headline-sm text-on-surface">Booking Terbaru</h4>
            <button class="text-primary font-label-md hover:underline transition-all">Lihat Semua</button>
        </div>

        <!-- Mobile & Desktop Friendly Responsive Booking Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
            @forelse($bookingTerbaru as $booking)
                <div class="bg-white p-5 rounded-lg border border-outline-variant shadow-sm hover:border-primary transition-all group flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <!-- Inisial Nama Pemohon -->
                                <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center font-bold text-primary uppercase">
                                    {{ substr($booking->nama_pemohon, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-label-md text-label-md text-on-surface">{{ $booking->nama_pemohon }}</p>
                                    <p class="text-xs text-on-surface-variant">Pemohon Lab</p>
                                </div>
                            </div>
                            
                            <!-- Status Badge Dinamis -->
                            @if(str_contains(strtolower($booking->status), 'setuju') || strtolower($booking->status) == 'approved')
                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            @elseif(str_contains(strtolower($booking->status), 'tunggu') || strtolower($booking->status) == 'pending')
                                <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-700 ring-1 ring-inset ring-yellow-600/20">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-600/20">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            @endif
                        </div>

                        <!-- Data Informasi Detail Booking -->
                        <div class="space-y-3 pt-4 border-t border-outline-variant">
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                <span class="material-symbols-outlined text-sm">science</span>
                                <span class="font-body-sm text-body-sm">{{ $booking->lab->nama_lab }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                <span class="material-symbols-outlined text-sm">calendar_month</span>
                                <span class="font-body-sm text-body-sm">{{ $booking->tanggal_booking }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                <span class="material-symbols-outlined text-sm">schedule</span>
                                <span class="font-body-sm text-body-sm">
                                    {{ substr($booking->jam_mulai,0,5) }} - {{ substr($booking->jam_selesai,0,5) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <button class="w-full mt-5 py-2 bg-surface-container text-on-surface font-label-md rounded-md group-hover:bg-primary group-hover:text-white transition-colors">
                        Detail Booking
                    </button>
                </div>
            @empty
                <!-- Tampilan jika data kosong -->
                <div class="col-span-full bg-surface-container-lowest p-8 rounded-lg border border-dashed border-outline-variant text-center">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-2">layers_clear</span>
                    <p class="font-body-md text-on-surface-variant">Belum ada data booking terbaru.</p>
                </div>
            @endforelse
        </div>
    </section>

</div>
@endsection