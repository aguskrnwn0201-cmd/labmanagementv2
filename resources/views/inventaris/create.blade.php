@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant shadow-sm"
     x-data="{ 
        baik: 0, 
        rusak: 0, 
        cadangan: 0,
        get total() { return (parseInt(this.baik) || 0) + (parseInt(this.rusak) || 0) + (parseInt(this.cadangan) || 0) }
     }">
    
    <div class="flex items-center gap-3 mb-6 border-b border-outline-variant/30 pb-4">
        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-[24px]">inventory_2</span>
        </div>
        <div>
            <h1 class="text-xl font-bold text-on-surface">Tambah Data Inventaris Lab</h1>
            <p class="text-xs text-on-surface-variant">Masukkan aset sarana prasarana baru dengan kalkulasi kondisi otomatis.</p>
        </div>
    </div>

    <form action="{{ route('inventaris.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-bold text-on-surface mb-1">Nama Barang / Fasilitas</label>
            <input type="text" name="nama_barang" required class="w-full px-4 py-2 bg-surface-container-low border border-outline-variant rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Contoh: Komputer Client, Router Mikrotik">
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface mb-1">Pilih Laboratorium Tempat Barang</label>
            <select name="lab_id" required class="w-full px-4 py-2 bg-surface-container-low border border-outline-variant rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-primary cursor-pointer">
                @foreach($labs as $lab)
                    <option value="{{ $lab->id }}">{{ $lab->nama_lab }}</option>
                @endforeach
            </select>
        </div>

        {{-- GRID LOGIKA HITUNG KONDISI BARANG BARU --}}
        <div class="p-4 bg-surface-container-low border border-outline-variant rounded-xl">
            <p class="text-xs font-bold uppercase tracking-wider text-primary mb-3">Kalkulasi Kondisi Unit</p>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant mb-1">Kondisi Baik</label>
                    <input type="number" name="baik" min="0" x-model.number="baik" class="w-full px-3 py-2 bg-surface-container-lowest border border-outline-variant rounded-lg text-sm text-center font-bold focus:outline-none focus:ring-1 focus:ring-primary">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant mb-1">Kondisi Rusak</label>
                    <input type="number" name="rusak" min="0" x-model.number="rusak" class="w-full px-3 py-2 bg-surface-container-lowest border border-outline-variant rounded-lg text-sm text-center font-bold text-error focus:outline-none focus:ring-1 focus:ring-primary">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-on-surface-variant mb-1">Unit Cadangan</label>
                    <input type="number" name="cadangan" min="0" x-model.number="cadangan" class="w-full px-3 py-2 bg-surface-container-lowest border border-outline-variant rounded-lg text-sm text-center font-bold text-amber-700 focus:outline-none focus:ring-1 focus:ring-primary">
                </div>

                <div>
                    <label class="block text-xs font-bold text-primary mb-1">Total Unit (Auto)</label>
                    {{-- Input total di-bind ke fungsi get total milik Alpine JS dan dibuat Readonly --}}
                    <input type="number" name="total" x-bind:value="total" readonly class="w-full px-3 py-2 bg-primary/10 border border-primary/20 rounded-lg text-sm text-center font-black text-primary focus:outline-none shadow-inner cursor-not-allowed">
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface mb-1">Keterangan / Spesifikasi Tambahan (Opsional)</label>
            <textarea name="keterangan" rows="3" class="w-full px-4 py-2 bg-surface-container-low border border-outline-variant rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Merk, RAM, tipe, dll..."></textarea>
        </div>

        <div class="mt-6 flex gap-3 border-t border-outline-variant/30 pt-4">
            <a href="{{ route('inventaris.index') }}" class="flex-1 text-center py-2.5 bg-surface-container-high text-on-surface-variant font-bold rounded-xl text-sm no-underline hover:bg-surface-variant transition-all">Kembali</a>
            <button type="submit" class="flex-1 py-2.5 bg-primary text-white font-bold rounded-xl text-sm hover:bg-blue-700 transition-all cursor-pointer">Simpan Aset</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection