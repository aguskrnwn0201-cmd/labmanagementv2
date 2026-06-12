@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden rounded-xl mb-8 h-48 md:h-64 flex items-center px-8 bg-primary-container text-on-primary">
    <div class="absolute inset-0 z-0">
        <img alt="Lab Interior" class="w-full h-full object-cover opacity-30" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDthlLUly2wmF9qOq_bcgM0mh-AlbIUy83Lnx5LCCHCU5OzE4nHx6weMTKdTXEiWVGdHEEovwxooM5EUB1YhU-_0fab7WGVTSDx4_B3qH-BFgD0kWwEsqxk3kXnuEsN-jwxv8IV7ukcgLj2HTVlGxpw8gpvgDlYFWtLN0YEiHvETU4Y_GboHVKdX9XSBFJmu3rKj-xuO4qHYdm8wMpQ1aXWWGqz7-nmUUR-6rrBKoYZiaFbVr9Db0LnQ8ucZn3wGEAw6rurBu6DdYk2"/>
        <div class="absolute inset-0 bg-gradient-to-r from-primary-container to-transparent"></div>
    </div>
    <div class="relative z-10">
        <h1 class="font-headline-lg text-headline-lg text-white mb-2">Inventaris Laboratorium</h1>
        <p class="text-on-primary-container max-w-lg font-body-md text-body-md">Kelola seluruh aset perangkat keras dan furnitur laboratorium sekolah secara terpusat untuk efisiensi operasional.</p>
    </div>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2 font-body-sm">
    <span class="material-symbols-outlined text-[20px]">check_circle</span>
    {{ session('success') }}
</div>
@endif

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="font-headline-sm text-headline-sm text-on-surface">Daftar Inventaris</h2>
        <p class="text-on-surface-variant font-body-sm text-body-sm">Menampilkan semua item aset sarana prasarana laboratorium.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('inventaris.create') }}" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-bold flex items-center justify-center gap-2 hover:opacity-90 transition-opacity shadow-sm text-sm">
            <span class="material-symbols-outlined">add</span>
            <span class="font-label-md text-label-md">Tambah Inventaris</span>
        </a>
    </div>
</div>

<div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-surface-container-low border-b border-outline-variant">
                <tr>
                    <th class="px-6 py-4 font-label-sm text-label-sm text-outline uppercase tracking-wider">Laboratorium</th>
                    <th class="px-6 py-4 font-label-sm text-label-sm text-outline uppercase tracking-wider">Nama Barang</th>
                    <th class="px-6 py-4 font-label-sm text-label-sm text-outline uppercase tracking-wider">Rincian Kondisi</th>
                    <th class="px-6 py-4 font-label-sm text-label-sm text-outline uppercase tracking-wider">Total Stok</th>
                    <th class="px-6 py-4 font-label-sm text-label-sm text-outline uppercase tracking-wider">Keterangan</th>
                    <th class="px-6 py-4 font-label-sm text-label-sm text-outline uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant">
                @forelse($inventaris as $item)
                <tr class="hover:bg-surface-container-low/30 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded bg-primary-fixed flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined text-sm">layers</span>
                            </div>
                            <span class="font-body-md text-body-md text-on-surface font-medium">{{ $item->lab->nama_lab }}</span>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4">
                        <span class="font-body-md text-body-md text-on-surface font-semibold">{{ $item->nama_barang }}</span>
                    </td>
                    
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1.5">
                            <span class="inline-flex items-center rounded bg-green-50 px-2 py-0.5 text-xs font-bold text-green-700 ring-1 ring-inset ring-green-600/20" title="Kondisi Baik">
                                {{ $item->baik }} Baik
                            </span>
                            <span class="inline-flex items-center rounded bg-red-50 px-2 py-0.5 text-xs font-bold text-red-700 ring-1 ring-inset ring-red-600/20" title="Kondisi Rusak">
                                {{ $item->rusak }} Rusak
                            </span>
                            <span class="inline-flex items-center rounded bg-amber-50 px-2 py-0.5 text-xs font-bold text-amber-700 ring-1 ring-inset ring-amber-600/20" title="Kondisi Cadangan">
                                {{ $item->cadangan }} Cadangan
                            </span>
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <span class="font-body-md text-body-md text-primary font-bold">{{ $item->total }} Unit</span>
                    </td>
                    
                    <td class="px-6 py-4">
                        <p class="font-body-sm text-body-sm text-on-surface-variant max-w-xs truncate" title="{{ $item->keterangan }}">
                            {{ $item->keterangan ?? '-' }}
                        </p>
                    </td>
                    
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2 md:opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <a href="{{ route('inventaris.edit', $item->id) }}" class="p-2 text-primary hover:bg-primary-fixed rounded-lg transition-colors flex items-center justify-center" title="Edit Item">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            
                            <form action="{{ route('inventaris.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data inventaris ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-error hover:bg-error-container/40 rounded-lg transition-colors flex items-center justify-center" title="Hapus Item">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center max-w-sm mx-auto p-4">
                            <span class="material-symbols-outlined text-4xl text-outline-variant mb-2">inventory_2</span>
                            <h5 class="font-headline-sm text-headline-sm text-on-surface mb-1">Belum Ada Data</h5>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Database inventaris kosong. Silakan tambahkan aset peralatan atau furnitur baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
    <div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-2xl">inventory_2</span>
        </div>
        <div>
            <p class="text-sm text-on-surface-variant">Total Jenis Aset</p>
            <h3 class="text-2xl font-bold text-on-surface">{{ $inventaris->count() }} <span class="text-xs font-normal text-on-surface-variant">Nama Barang</span></h3>
        </div>
    </div>
    <div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-tertiary-fixed flex items-center justify-center text-tertiary">
            <span class="material-symbols-outlined text-2xl">verified</span>
        </div>
        <div>
            <p class="text-sm text-on-surface-variant">Total Unit Baik</p>
            <h3 class="text-2xl font-bold text-on-surface">{{ $inventaris->sum('baik') }} <span class="text-xs font-normal text-on-surface-variant">Unit</span></h3>
        </div>
    </div>
    <div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-error-container flex items-center justify-center text-error">
            <span class="material-symbols-outlined text-2xl">construction</span>
        </div>
        <div>
            <p class="text-sm text-on-surface-variant">Total Unit Rusak</p>
            <h3 class="text-2xl font-bold text-on-surface">{{ $inventaris->sum('rusak') }} <span class="text-xs font-normal text-on-surface-variant">Unit</span></h3>
        </div>
    </div>
</div>
@endsection