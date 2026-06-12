@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-margin-mobile md:px-margin-desktop py-8 space-y-8 print:p-0 print:max-w-full">
    
    {{-- Bagian Judul Utama & Kontrol Filter (Sesuai Konteks Dashboard Anda) --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-outline-variant/60 pb-6 print:mb-6">
        <div>
            <h1 class="text-2xl font-bold text-on-surface tracking-tight print:text-xl">Rekap Penggunaan Laboratorium</h1>
            <p class="text-sm text-on-surface-variant mt-1">
                Periode: <span class="font-semibold text-on-surface">{{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</span>
                <span class="mx-2 print:hidden">•</span>
                <span class="print:block print:mt-1 print:text-xs text-xs font-mono">Dicetak: {{ now()->format('d F Y, H:i') }}</span>
            </p>
        </div>
        
        <div class="flex items-center gap-2 print:hidden">
            <a href="{{ route('laporan.penggunaan.preview', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank" class="px-4 py-2 bg-surface-container-lowest border border-outline-variant text-on-surface font-bold rounded-lg hover:bg-surface-container-low transition-all text-sm flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                <span>Preview PDF</span>
            </a>
            <button onclick="window.print()" class="px-4 py-2 bg-primary text-white font-bold rounded-lg hover:bg-blue-700 active:scale-95 transition-all text-sm flex items-center gap-2 shadow-md">
                <span class="material-symbols-outlined text-[18px]">print</span>
                <span>Cetak Rekap</span>
            </button>
        </div>
    </div>

    {{-- Form Filter Bulan & Tahun (Tetap Dipertahankan untuk Kebutuhan Web Dashboard) --}}
    <section class="bg-surface-container-lowest border border-outline-variant rounded-xl p-5 shadow-sm print:hidden">
        <form method="GET" action="{{ url()->current() }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div class="space-y-1.5">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider block">Bulan</label>
                <select name="bulan" class="w-full h-11 bg-surface-container-low border border-outline rounded-lg px-4 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm text-on-surface">
                    @for($i=1; $i<=12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider block">Tahun</label>
                <input type="number" name="tahun" value="{{ $tahun }}" class="w-full h-11 bg-surface-container-low border border-outline rounded-lg px-4 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm text-on-surface"/>
            </div>

            <button type="submit" class="bg-primary text-white h-11 font-bold rounded-lg px-6 hover:brightness-110 active:scale-95 transition-all text-sm flex items-center justify-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-lg">search</span>
                <span>Tampilkan Data</span>
            </button>
        </form>
    </section>

    {{-- 2. Empat Pilar Ringkasan Indikator Statistik (PERSIS TEMPLATE PDF) --}}
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 print:grid-cols-3 print:gap-2">
        <div class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl shadow-sm text-center print:border-black print:p-2">
            <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider">Jadwal Tetap</p>
            <h3 class="text-2xl font-black text-primary mt-1">
                {{ collect($semuaAktivitas)->where('tipe', 'Jadwal Rutin')->count() }}
            </h3>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl shadow-sm text-center print:border-black print:p-2">
            <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider">Booking</p>
            <h3 class="text-2xl font-black text-secondary mt-1">
                {{ collect($semuaAktivitas)->where('tipe', '!=', 'Jadwal Rutin')->count() }}
            </h3>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl shadow-sm text-center bg-primary-container/10 print:border-black print:p-2">
            <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider">Total Terpakai</p>
            <h3 class="text-2xl font-black text-green-700 mt-1">
                {{ collect($semuaAktivitas)->count() }}
            </h3>
        </div>
    
    </div>

    {{-- SEKSI 1: TABEL JADWAL TETAP (PERSIS TEMPLATE PDF) --}}
    <section class="space-y-3 break-inside-avoid">
        <div class="flex items-center gap-2 border-l-4 border-primary pl-3 py-0.5">
            <h2 class="text-base font-bold text-on-surface">Jadwal Tetap</h2>
        </div>
        <div class="overflow-x-auto border border-outline-variant rounded-xl bg-surface-container-lowest print:border-black print:rounded-none">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant font-semibold border-b border-outline-variant print:bg-gray-100 print:border-black">
                        <th class="p-3 print:p-2">Hari</th>
                        <th class="p-3 print:p-2">Slot Waktu</th>
                        <th class="p-3 print:p-2">Guru/Pengajar</th>
                        <th class="p-3 print:p-2">Kelas</th>
                        <th class="p-3 print:p-2">Mata Pelajaran</th>
                        <th class="p-3 print:p-2 text-center">Frekuensi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/60 print:divide-black">
                    @forelse(collect($semuaAktivitas)->where('tipe', 'Jadwal Rutin') as $item)
                    <tr class="hover:bg-surface-container-lowest/50">
                        <td class="p-3 print:p-2 font-medium">{{ $item['waktu'] }}</td>
                        <td class="p-3 print:p-2 text-xs font-mono text-primary">{{ $item['jam'] }}</td>
                        <td class="p-3 print:p-2">{{ $item['pengguna'] }}</td>
                        <td class="p-3 print:p-2"><span class="bg-surface-container-high px-2 py-0.5 rounded text-xs print:border print:p-0.5">{{ $item['keterangan'] }}</span></td>
                        <td class="p-3 print:p-2 font-semibold">{{ $item['agenda'] }}</td>
                        <td class="p-3 print:p-2 text-center text-xs">4x/bln</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-on-surface-variant italic">Tidak ada jadwal rutin pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- SEKSI 2: TABEL BOOKING DISETUJUI (PERSIS TEMPLATE PDF) --}}
    <section class="space-y-3">
        <div class="flex items-center gap-2 border-l-4 border-secondary pl-3 py-0.5">
            <h2 class="text-base font-bold text-on-surface">Booking Disetujui</h2>
        </div>
        <div class="overflow-x-auto border border-outline-variant rounded-xl bg-surface-container-lowest print:border-black print:rounded-none">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface-variant font-semibold border-b border-outline-variant print:bg-gray-100 print:border-black">
                        <th class="p-3 print:p-2">Tanggal</th>
                        <th class="p-3 print:p-2">Slot Waktu</th>
                        <th class="p-3 print:p-2">Pengajar</th>
                        <th class="p-3 print:p-2">Kelas</th>
                        <th class="p-3 print:p-2">Kegiatan / Mapel</th>
                        <th class="p-3 print:p-2 text-center">Peserta</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/60 print:divide-black">
                    @forelse(collect($semuaAktivitas)->where('tipe', '!=', 'Jadwal Rutin') as $item)
                    <tr class="hover:bg-surface-container-lowest/50">
                        <td class="p-3 print:p-2 text-xs font-medium">{{ $item['waktu'] }}</td>
                        <td class="p-3 print:p-2 text-xs font-mono text-secondary">{{ $item['jam'] }}</td>
                        <td class="p-3 print:p-2 text-xs">{{ $item['pengguna'] }}</td>
                        <td class="p-3 print:p-2 text-xs">{{ $item['keterangan'] }}</td>
                        <td class="p-3 print:p-2 text-xs font-semibold text-on-surface">{{ $item['agenda'] }}</td>
                        <td class="p-3 print:p-2 text-center text-xs font-bold">{{ $item['durasi_jam'] ?? '3' }} org</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-on-surface-variant italic">Tidak ada log booking pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Footer Cetak Penanda Aplikasi --}}
    <div class="hidden print:flex items-center justify-between text-[10px] text-gray-400 mt-12 border-t border-gray-200 pt-2">
        <div>Lab Management | Dicetak Otomatis</div>
        <div>Halaman Rekap Penggunaan Laboratorium</div>
    </div>

</div>

{{-- Style Tambahan untuk Kompatibilitas Kertas Cetak PDF Browser --}}
<style>
    @media print {
        body { background: white; color: black; font-size: 12px; }
        .print\:hidden { display: none !important; }
        .print\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)) !important; }
        .print\:border-black { border-color: #000000 !important; border-width: 1px !important; }
        .print\:rounded-none { border-radius: 0px !important; }
        .print\:p-2 { padding: 6px 8px !important; }
        table { page-break-inside: auto; }
        tr { page-break-inside: avoid; page-break-after: auto; }
        thead { display: table-header-group; }
    }
</style>
@endsection