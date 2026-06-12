@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6">
    
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('labs.index') }}" class="inline-flex items-center justify-center p-2 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-low transition-colors" title="Kembali">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-on-surface tracking-tight">Tambah Laboratorium Baru</h1>
            <p class="text-sm text-on-surface-variant">Dafrtarkan ruangan atau kluster laboratorium sekolah yang baru</p>
        </div>
    </div>

    {{-- Kotak Pemberitahuan Jika Validasi Gagal --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 text-sm">
            <div class="flex items-center gap-2 font-bold mb-1 text-red-800">
                <span class="material-symbols-outlined text-[18px]">error</span>
                <span>Gagal Menyimpan Ruangan:</span>
            </div>
            <ul class="list-disc pl-5 space-y-0.5 text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Utama Canvas Container --}}
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
        <form method="POST" action="{{ route('labs.store') }}" class="space-y-5">
            @csrf

            <div class="flex flex-col gap-1.5">
                <label for="nama_lab" class="font-semibold text-sm text-on-surface-variant">Nama Laboratorium</label>
                <input 
                    type="text" 
                    id="nama_lab"
                    name="nama_lab" 
                    value="{{ old('nama_lab') }}"
                    placeholder="Contoh: Lab Komputer Jaringan, Lab Bahasa"
                    class="w-full border border-outline-variant rounded-lg p-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-surface-container-lowest text-on-surface transition-all"
                    required>
            </div>

           <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    
    <div class="flex flex-col gap-1.5">
        <label for="lokasi" class="font-semibold text-sm text-on-surface-variant">Lokasi / Gedung</label>
        <input 
            type="text" 
            id="lokasi"
            name="lokasi" 
            value="{{ old('lokasi') }}"
            placeholder="Contoh: Gedung B"
            class="w-full border border-outline-variant rounded-lg p-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-surface-container-lowest text-on-surface transition-all"
            required>
    </div>

    <div class="flex flex-col gap-1.5">
        <label for="kapasitas" class="font-semibold text-sm text-on-surface-variant">Kapasitas</label>
        <div class="relative flex items-center">
            <input 
                type="number" 
                id="kapasitas"
                name="kapasitas" 
                value="{{ old('kapasitas') }}"
                min="1"
                placeholder="36"
                class="w-full border border-outline-variant rounded-lg p-2.5 pr-12 focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-surface-container-lowest text-on-surface transition-all"
                required>
            <span class="absolute right-3 text-xs font-bold text-outline uppercase tracking-wider select-none">Meja</span>
        </div>
    </div>

    <div class="flex flex-col gap-1.5">
        <label for="komputer_ready" class="font-semibold text-sm text-primary flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">desktop_windows</span> Komputer Ready
        </label>
        <div class="relative flex items-center">
            <input 
                type="number" 
                id="komputer_ready"
                name="komputer_ready" 
                value="{{ old('komputer_ready', 0) }}"
                min="0"
                placeholder="30"
                class="w-full border border-outline-variant rounded-lg p-2.5 pr-12 focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-surface-container-lowest text-on-surface transition-all"
                required>
            <span class="absolute right-3 text-xs font-bold text-primary uppercase tracking-wider select-none">Unit</span>
        </div>
    </div>

</div>
            <div class="pt-2 flex items-center justify-end gap-3 border-t border-outline-variant/60">
                <a href="{{ route('labs.index') }}" class="px-5 py-2.5 border border-outline-variant hover:bg-surface-container-low text-on-surface-variant font-medium rounded-lg transition-colors text-sm text-center">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary text-white font-bold rounded-lg hover:bg-blue-700 active:scale-95 transition-all shadow-md text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Simpan Lab</span>
                </button>
            </div>

        </form>
    </div>
</div>
@endsection