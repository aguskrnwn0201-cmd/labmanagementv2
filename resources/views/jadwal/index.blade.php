@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
    <div class="space-y-1">
        <h3 class="font-headline-md text-headline-md text-on-surface">Manajemen Jadwal</h3>
        <p class="font-body-md text-body-md text-on-surface-variant">Pantau dan kelola penggunaan laboratorium secara real-time.</p>
    </div>
    
    <div class="flex items-center gap-2">
        @if(session('role') == 'teknisi')
        <a href="{{ route('jadwal.create') }}" class="flex items-center gap-2 bg-primary text-on-primary px-4 py-2 rounded-lg hover:opacity-90 transition-all font-label-md text-label-md shadow-sm">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Tambah Jadwal
        </a>
        @endif
        <button class="flex items-center gap-2 bg-surface-container-lowest border border-outline-variant px-4 py-2 rounded-lg text-on-surface hover:bg-surface-container-low transition-all font-label-md text-label-md">
            <span class="material-symbols-outlined text-[20px]">print</span>
            Cetak
        </button>
    </div>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2 font-body-sm">
    <span class="material-symbols-outlined text-[20px]">check_circle</span>
    {{ session('success') }}
</div>
@endif

@if($errors->has('jadwal'))
<div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2 font-body-sm">
    <span class="material-symbols-outlined text-[20px]">error</span>
    {{ $errors->first('jadwal') }}
</div>
@endif

<div class="bg-surface-container-lowest p-4 rounded-xl border border-outline-variant flex flex-wrap items-center gap-4 mb-6">
    <div class="flex-1 min-w-[240px]">
        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Pilih Laboratorium</label>
        <select class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-on-surface focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm">
            <option>Semua Laboratorium</option>
        </select>
    </div>
    <div class="flex items-center gap-2 bg-surface-container-low p-1 rounded-lg border border-outline-variant">
        <button class="px-4 py-1.5 rounded-md bg-white shadow-sm text-primary font-label-md text-label-md">Minggu Ini</button>
        <button class="px-4 py-1.5 rounded-md text-on-surface-variant font-label-md text-label-md hover:text-on-surface">Bulan</button>
    </div>
</div>

<div class="bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden shadow-sm">
    <div class="p-4 border-b border-outline-variant flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h4 class="font-headline-sm text-headline-sm">Rincian Penggunaan Lab</h4>
        <div class="relative w-full sm:w-64">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-[20px]">search</span>
            <input class="w-full pl-10 pr-4 py-1.5 bg-surface-container-low border border-outline-variant rounded-full text-sm focus:outline-none focus:ring-1 focus:ring-primary transition-all" placeholder="Cari jadwal..." type="text"/>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-surface-container-low">
                <tr>
                    <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase">Lab</th>
                    <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase">Hari</th>
                    <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase">Jam</th>
                    <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase">Mata Pelajaran</th>
                    <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase">Guru</th>
                    <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase">Kelas</th>
                    @if(session('role') == 'teknisi')
                    <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant">
                @forelse($jadwals as $jadwal)
                <tr class="hover:bg-surface-container-low/50 transition-colors">
                    <td class="px-6 py-4 font-body-sm text-body-sm font-semibold text-on-surface">
                        {{ $jadwal->lab->nama_lab }}
                    </td>
                    <td class="px-6 py-4 font-body-sm text-body-sm text-on-surface-variant">
                        {{ $jadwal->hari }}
                    </td>
                    <td class="px-6 py-4 font-label-md text-label-md text-primary">
                        {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}
                    </td>
                    <td class="px-6 py-4 font-body-sm text-body-sm font-medium text-on-surface">
                        {{ $jadwal->mata_pelajaran }}
                    </td>
                    <td class="px-6 py-4 font-body-sm text-body-sm text-on-surface-variant">
                        {{ $jadwal->guru }}
                    </td>
                    <td class="px-6 py-4 font-body-sm text-body-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-surface-variant text-on-surface-variant border border-outline-variant">
                            {{ $jadwal->kelas }}
                        </span>
                    </td>
                    @if(session('role') == 'teknisi')
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('jadwal.edit', $jadwal) }}" class="inline-flex items-center gap-1 bg-amber-100 hover:bg-amber-200 text-amber-800 border border-amber-200 px-3 py-1 rounded-md text-xs font-bold transition-colors">
                                <span class="material-symbols-outlined text-sm">edit</span>
                                Edit
                            </a>
                            <form action="{{ route('jadwal.destroy', $jadwal) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-800 border border-red-200 px-3 py-1 rounded-md text-xs font-bold transition-colors">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ session('role') == 'teknisi' ? 7 : 6 }}" class="px-6 py-12 text-center bg-surface-container-low/20">
                        <div class="flex flex-col items-center justify-center">
                            <span class="material-symbols-outlined text-4xl text-outline-variant mb-2">event_busy</span>
                            <p class="font-body-md text-body-md text-on-surface-variant">Belum ada jadwal penggunaan laboratorium.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection