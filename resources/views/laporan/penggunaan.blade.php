@extends('layouts.app')

@section('content')
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-8">
    
    <div class="mb-8">
        <h2 class="text-headline-lg-mobile md:text-headline-lg font-headline-lg text-on-surface">Laporan Penggunaan Lab</h2>
        <p class="text-body-md font-body-md text-on-surface-variant mt-2">Pantau dan analisis aktivitas penggunaan laboratorium sekolah Anda secara real-time.</p>
    </div>

    <section class="bg-surface-container-lowest border border-outline-variant rounded-lg p-6 mb-8 shadow-sm">
        <form method="GET" action="{{ url()->current() }}" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            <div class="space-y-2">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider block">Bulan</label>
                <select name="bulan" class="w-full h-12 bg-surface-container-low border border-outline rounded-lg px-4 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-body-md text-on-surface">
                    @for($i=1; $i<=12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="space-y-2">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider block">Tahun</label>
                <input type="number" name="tahun" value="{{ $tahun }}" class="w-full h-12 bg-surface-container-low border border-outline rounded-lg px-4 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-body-md text-on-surface"/>
            </div>

            <button type="submit" class="bg-primary text-white h-12 font-bold rounded-lg px-8 hover:brightness-110 active:scale-95 transition-all flex items-center justify-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-lg">search</span>
                <span>Tampilkan</span>
            </button>
        </form>
    </section>

    <section class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-headline-sm font-headline-sm text-on-surface font-semibold">Ringkasan Penggunaan</h3>
            <span class="text-label-md font-label-md text-primary bg-primary-fixed px-3 py-1 rounded-full font-medium">
                {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}
            </span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($rekapLab as $lab => $data)
                <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-5 flex flex-col gap-3 shadow-sm hover:border-primary transition-colors duration-200">
                    <div class="flex items-center justify-between">
                        @if(Str::contains(Str::lower($lab), 'komputer'))
                            <span class="material-symbols-outlined text-primary text-3xl">desktop_windows</span>
                        @elseif(Str::contains(Str::lower($lab), 'kimia') || Str::contains(Str::lower($lab), 'ipa'))
                            <span class="material-symbols-outlined text-secondary text-3xl">science</span>
                        @else
                            <span class="material-symbols-outlined text-tertiary text-3xl">biotech</span>
                        @endif
                        <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider border border-green-200">Aktif</span>
                    </div>
                    <h4 class="font-headline-sm text-headline-sm text-on-surface font-semibold truncate">{{ $lab }}</h4>
                    <div class="flex justify-between border-t border-outline-variant pt-3 mt-1">
                        <div>
                            <p class="text-label-sm font-label-sm text-on-surface-variant">Jumlah Booking</p>
                            <p class="text-headline-md font-headline-md text-primary font-bold mt-0.5">{{ $data['jumlah_booking'] }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-label-sm font-label-sm text-on-surface-variant">Total Durasi</p>
                            <p class="text-headline-md font-headline-md text-primary font-bold mt-0.5">{{ $data['total_jam'] }} Jam</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section>
        <div class="flex items-center justify-between mb-4 px-2">
            <h3 class="text-headline-sm font-headline-sm text-on-surface font-semibold">Detail Penggunaan</h3>
            <button type="button" class="text-primary font-label-md font-semibold hover:underline flex items-center gap-1 transition-colors">
                <span class="material-symbols-outlined text-lg">download</span>
                <span>Export PDF</span>
            </button>
        </div>

        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden shadow-sm">
            <div class="hidden md:grid grid-cols-5 bg-surface-container-low px-6 py-4 border-b border-outline-variant">
                <div class="text-label-md font-bold text-on-surface-variant uppercase tracking-wider">Tanggal</div>
                <div class="text-label-md font-bold text-on-surface-variant uppercase tracking-wider">Laboratorium</div>
                <div class="text-label-md font-bold text-on-surface-variant uppercase tracking-wider">Pemohon</div>
                <div class="text-label-md font-bold text-on-surface-variant uppercase tracking-wider">Jam Aktivitas</div>
                <div class="text-label-md font-bold text-on-surface-variant uppercase tracking-wider text-right">Status</div>
            </div>

            <div class="divide-y divide-outline-variant">
                @forelse($bookings as $booking)
                    <div class="grid grid-cols-1 md:grid-cols-5 px-6 py-5 hover:bg-surface-container-low/50 transition-colors items-center gap-3 md:gap-4">
                        
                        <div class="flex items-center gap-3 md:block">
                            <div class="md:hidden w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined">calendar_month</span>
                            </div>
                            <div>
                                <p class="text-body-md font-semibold md:font-normal text-on-surface">{{ $booking->tanggal_booking }}</p>
                                <p class="md:hidden text-label-sm font-medium text-primary mt-0.5">{{ $booking->lab->nama_lab }}</p>
                            </div>
                        </div>

                        <div class="hidden md:block">
                            <p class="text-body-md text-on-surface font-medium">{{ $booking->lab->nama_lab }}</p>
                        </div>

                        <div class="flex flex-row md:block justify-between items-center">
                            <span class="text-label-sm text-on-surface-variant md:hidden font-medium">Pemohon:</span>
                            <p class="text-body-md text-on-surface">{{ $booking->nama_pemohon }}</p>
                        </div>

                        <div class="flex flex-row md:block justify-between items-center">
                            <span class="text-label-sm text-on-surface-variant md:hidden font-medium">Waktu:</span>
                            <p class="text-body-md text-on-surface font-mono bg-surface-container border border-outline-variant/30 px-2 py-0.5 rounded md:bg-transparent md:border-none md:p-0">
                                {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                            </p>
                        </div>

                        <div class="text-right flex items-center justify-between md:justify-end mt-1 md:mt-0">
                            <span class="text-label-sm text-on-surface-variant md:hidden font-medium">Status:</span>
                            <span class="bg-green-100 text-green-700 font-label-sm font-semibold px-3 py-1 rounded-full border border-green-200 text-xs">
                                Selesai
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center flex flex-col items-center justify-center gap-3">
                        <span class="material-symbols-outlined text-outline text-5xl">folder_open</span>
                        <p class="text-body-lg text-on-surface-variant font-medium">Tidak ada data penggunaan laboratorium pada periode ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const items = document.querySelectorAll('section > div > div');
        items.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(8px)';
            setTimeout(() => {
                item.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, index * 60);
        });
    });
</script>
@endsection