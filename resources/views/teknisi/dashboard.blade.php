@extends('layouts.app')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 md:px-8 py-6">
    
    <div class="mb-8 border-b border-outline-variant/30 pb-4">
        <h2 class="text-2xl md:text-3xl font-bold text-on-surface tracking-tight mb-1">
            Dashboard Teknisi
        </h2>
        <p class="text-sm md:text-base text-on-surface-variant">
            Selamat datang kembali. Berikut adalah ringkasan operasional laboratorium hari ini.
        </p>
    </div>

    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between mb-4">
                <span class="material-symbols-outlined text-primary text-3xl">biotech</span>
                <span class="text-xs font-bold text-green-700 px-2.5 py-1 bg-green-100 rounded-full border border-green-200">Aktif</span>
            </div>
            <h3 class="text-3xl font-extrabold text-on-surface">{{ $totalLab ?? 0 }}</h3>
            <p class="text-sm font-medium text-on-surface-variant mt-1">Total Lab</p>
        </div>

        <div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between mb-4">
                <span class="material-symbols-outlined text-secondary text-3xl">computer</span>
                <span class="text-xs font-bold text-purple-700 bg-purple-100 px-2.5 py-1 rounded-full border border-purple-200">Aset</span>
            </div>
            <h3 class="text-3xl font-extrabold text-on-surface">{{ $totalKomputer ?? 0 }}</h3>
            <p class="text-sm font-medium text-on-surface-variant mt-1">Jumlah Komputer</p>
        </div>

        <div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between mb-4">
                <span class="material-symbols-outlined text-error text-3xl">pending_actions</span>
                @if(($bookingHariIni ?? 0) > 0)
                    <span class="text-xs font-bold text-red-700 bg-red-100 px-2.5 py-1 rounded-full border border-red-200">Hari Ini</span>
                @else
                    <span class="text-xs font-bold text-gray-700 bg-gray-100 px-2.5 py-1 rounded-full border border-gray-200">Kosong</span>
                @endif
            </div>
            <h3 class="text-3xl font-extrabold text-on-surface">{{ $bookingHariIni ?? 0 }}</h3>
            <p class="text-sm font-medium text-on-surface-variant mt-1">Booking Hari Ini</p>
        </div>

        <div class="bg-primary-container p-6 rounded-xl shadow-sm flex flex-col justify-between text-on-primary-container overflow-hidden relative group cursor-pointer hover:opacity-95 transition-all">
            <div class="relative z-10">
                <span class="material-symbols-outlined text-4xl mb-2">calendar_month</span>
                <h3 class="text-xl font-bold">Total Booking</h3>
                <p class="text-xs opacity-80 mt-1">{{ $totalBooking ?? 0 }} Riwayat Tercatat →</p>
            </div>
            <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-8 flex flex-col gap-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <a href="{{ route('labs.index') }}" class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl flex items-center gap-4 hover:border-primary/70 hover:shadow-sm transition-all duration-200 group no-underline text-current">
                    <div class="w-12 h-12 rounded-lg bg-primary-fixed flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors shrink-0">
                        <span class="material-symbols-outlined">database</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-on-surface">Data Lab</h4>
                        <p class="text-xs text-on-surface-variant mt-0.5">Kelola aset & fasilitas</p>
                    </div>
                </a>

                <a href="{{ route('jadwal.index') }}" class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl flex items-center gap-4 hover:border-primary/70 hover:shadow-sm transition-all duration-200 group no-underline text-current">
                    <div class="w-12 h-12 rounded-lg bg-primary-fixed flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors shrink-0">
                        <span class="material-symbols-outlined">schedule</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-on-surface">Jadwal Lab</h4>
                        <p class="text-xs text-on-surface-variant mt-0.5">Monitoring harian (Total: {{ $totalJadwal ?? 0 }})</p>
                    </div>
                </a>

                <a href="{{ route('booking.index') }}" class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl flex items-center gap-4 hover:border-primary/70 hover:shadow-sm transition-all duration-200 group no-underline text-current">
                    <div class="w-12 h-12 rounded-lg bg-primary-fixed flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors shrink-0">
                        <span class="material-symbols-outlined">book_online</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-on-surface">Booking Lab</h4>
                        <p class="text-xs text-on-surface-variant mt-0.5">Konfirmasi permintaan user</p>
                    </div>
                </a>

                <a href="{{ route('laporan.inventaris') }}" class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl flex items-center gap-4 hover:border-primary/70 hover:shadow-sm transition-all duration-200 group no-underline text-current">
                    <div class="w-12 h-12 rounded-lg bg-primary-fixed flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors shrink-0">
                        <span class="material-symbols-outlined">file_export</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-on-surface">Export Laporan</h4>
                        <p class="text-xs text-on-surface-variant mt-0.5">Unduh data laporan bulanan</p>
                    </div>
                </a>
            </div>

            <div class="relative overflow-hidden rounded-xl bg-slate-900 min-h-[14rem] shadow-sm flex items-center">
                <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/60 to-transparent z-10 p-6 md:p-8 flex flex-col justify-center">
                    <h3 class="text-white text-lg md:text-xl font-bold mb-2">Maintenance Terjadwal</h3>
                    <p class="text-gray-300 max-w-sm text-xs md:text-sm leading-relaxed">
                        Pengecekan perangkat keras sistem jaringan laboratorium dimulai secara berkala. Pastikan semua logbook terisi demi validitas data.
                    </p>
                    <button class="mt-4 px-5 py-2 bg-primary text-white text-xs font-bold rounded-lg w-fit hover:bg-blue-700 transition-colors">
                        Detail Pemeliharaan
                    </button>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 flex flex-col gap-6">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-base font-bold text-on-surface">Aktivitas Terbaru</h3>
                    <button class="text-primary text-xs font-bold hover:underline">Lihat Semua</button>
                </div>
                
                <ul class="flex flex-col gap-5 list-none p-0 m-0">
                    @forelse($bookingTerbaru ?? [] as $booking)
                        <li class="flex gap-3 items-start">
                            <div class="w-2 h-2 rounded-full bg-purple-500 mt-1.5 shrink-0"></div>
                            <div>
                                <p class="text-xs md:text-sm font-bold text-on-surface">
                                    Booking: {{ $booking->lab->nama_lab ?? 'Lab Tidak Diketahui' }}
                                </p>
                                <p class="text-xs text-on-surface-variant mt-0.5">
                                    Oleh User pada Tanggal: {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                </p>
                                <p class="text-[10px] text-gray-400 mt-1">
                                    {{ $booking->created_at ? $booking->created_at->diffForHumans() : '-' }}
                                </p>
                            </div>
                        </li>
                    @empty
                        <div class="text-center py-6">
                            <span class="material-symbols-outlined text-gray-300 text-4xl">calendar_today</span>
                            <p class="text-xs text-on-surface-variant italic mt-1">Belum ada aktivitas booking terbaru.</p>
                        </div>
                    @endforelse
                </ul>
            </div>

            <div class="bg-surface-container-high/50 border border-outline-variant/50 rounded-xl p-6">
                <h3 class="text-xs uppercase tracking-wider font-bold text-on-surface-variant mb-4">Utilisasi Lab Minggu Ini</h3>
                <div class="flex items-end gap-3 h-20 mb-3">
                    <div class="flex-1 bg-primary/80 rounded-t-md" style="height: 60%"></div>
                    <div class="flex-1 bg-primary/80 rounded-t-md" style="height: 85%"></div>
                    <div class="flex-1 bg-primary/80 rounded-t-md" style="height: 40%"></div>
                    <div class="flex-1 bg-primary rounded-t-md" style="height: 95%"></div>
                    <div class="flex-1 bg-primary/80 rounded-t-md" style="height: 70%"></div>
                </div>
                <div class="flex justify-between text-[10px] font-bold text-on-surface-variant/70 uppercase px-1">
                    <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection