@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto py-6">

    <h1 class="text-3xl font-bold mb-6 text-on-surface">
        Edit Inventaris Perangkat
    </h1>

    {{-- Kotak Notifikasi Gagal Validasi --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl mb-6 text-sm font-medium">
            <p class="font-bold mb-1">Gagal memperbarui! Sila periksa kembali inputan Anda:</p>
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Inisialisasi Alpine.js untuk Kalkulasi Otomatis (Catatan C) --}}
    <form
        action="{{ route('inventaris.update', ['inventaris' => $inventaris->id]) }}"
        method="POST"
        x-data="{
            baik: {{ old('baik', $inventaris->baik ?? 0) }},
            rusak: {{ old('rusak', $inventaris->rusak ?? 0) }},
            cadangan: {{ old('cadangan', $inventaris->cadangan ?? 0) }},
            get total() {
                return parseInt(this.baik || 0) + parseInt(this.rusak || 0) + parseInt(this.cadangan || 0);
            }
        }">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Pilihan Laboratorium --}}
            <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-sm text-on-surface-variant">Laboratorium Penempatan</label>
                <select
                    name="lab_id"
                    class="w-full border border-outline-variant rounded-lg p-2.5 bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none">
                    @foreach($labs as $lab)
                        <option
                            value="{{ $lab->id }}"
                            {{ $inventaris->lab_id == $lab->id ? 'selected' : '' }}>
                            {{ $lab->nama_lab }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nama Aset Barang --}}
            <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-sm text-on-surface-variant">Nama Barang</label>
                <input
                    type="text"
                    name="nama_barang"
                    value="{{ old('nama_barang', $inventaris->nama_barang) }}"
                    class="w-full border border-outline-variant rounded-lg p-2.5 focus:ring-2 focus:ring-primary outline-none"
                    required>
            </div>

            {{-- Input Kondisi: Baik --}}
            <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-sm text-green-700 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span> Jumlah Baik
                </label>
                <input
                    type="number"
                    name="baik"
                    x-model.number="baik"
                    min="0"
                    class="w-full border border-outline-variant rounded-lg p-2.5 focus:ring-2 focus:ring-primary outline-none"
                    required>
            </div>

            {{-- Input Kondisi: Rusak --}}
            <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-sm text-red-700 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">cancel</span> Jumlah Rusak
                </label>
                <input
                    type="number"
                    name="rusak"
                    x-model.number="rusak"
                    min="0"
                    class="w-full border border-outline-variant rounded-lg p-2.5 focus:ring-2 focus:ring-primary outline-none"
                    required>
            </div>

            {{-- Input Kondisi: Cadangan --}}
            <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-sm text-amber-700 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">hourglass_empty</span> Jumlah Cadangan
                </label>
                <input
                    type="number"
                    name="cadangan"
                    x-model.number="cadangan"
                    min="0"
                    class="w-full border border-outline-variant rounded-lg p-2.5 focus:ring-2 focus:ring-primary outline-none"
                    required>
            </div>

            {{-- Akumulasi Total Stok (ReadOnly Otomatis via Alpine) --}}
            <div class="flex flex-col gap-1.5">
                <label class="font-semibold text-sm text-primary flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">calculate</span> Total Keseluruhan Stok
                </label>
                <input
                    type="number"
                    name="total"
                    x-bind:value="total"
                    readonly
                    class="w-full border border-outline-variant rounded-lg p-2.5 bg-surface-container-low font-bold text-primary outline-none cursor-not-allowed"
                    title="Dihitung otomatis berdasarkan penjumlahan kondisi barang">
            </div>

        </div>

        {{-- Catatan Keterangan Tambahan --}}
        <div class="mt-5 flex flex-col gap-1.5">
            <label class="font-semibold text-sm text-on-surface-variant">Keterangan / Spesifikasi Tambahan</label>
            <textarea
                name="keterangan"
                rows="4"
                placeholder="Contoh: Merk, spesifikasi prosessor, RAM, nomor seri perangkat, dsb..."
                class="w-full border border-outline-variant rounded-lg p-2.5 focus:ring-2 focus:ring-primary outline-none">{{ old('keterangan', $inventaris->keterangan) }}</textarea>
        </div>

        {{-- Tombol Aksi Form --}}
        <div class="mt-6 flex items-center gap-3">
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-lg shadow-sm transition-colors duration-150">
                Update Inventaris
            </button>
            <a 
                href="{{ route('inventaris.index') }}" 
                class="border border-outline-variant hover:bg-surface-container-low text-on-surface-variant font-medium px-5 py-2.5 rounded-lg transition-colors duration-150">
                Batal
            </a>
        </div>

    </form>

</div>

@endsection