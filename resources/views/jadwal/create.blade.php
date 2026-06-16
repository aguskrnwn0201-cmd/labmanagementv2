@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant shadow-sm">

    <div class="flex items-center gap-3 mb-6 border-b border-outline-variant/30 pb-4">
        <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">event_note</span>
        </div>
        <h1 class="text-2xl md:text-3xl font-bold text-on-surface">
            Tambah Jadwal Laboratorium
        </h1>
    </div>

    {{-- Alert Error Validasi --}}
    @if ($errors->any())
        <div class="bg-error/10 text-error p-4 rounded-xl border border-error/20 mb-6 space-y-1">
            <div class="flex items-center gap-2 font-bold text-sm">
                <span class="material-symbols-outlined text-lg">error</span>
                <span>Mohon perbaiki kesalahan berikut:</span>
            </div>
            <ul class="text-sm pl-7 list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jadwal.store') }}" method="POST" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Pilihan Lab --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-on-surface-variant">Pilih Ruang Lab</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">science</span>
                    <select name="lab_id" class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md appearance-none" required>
                        <option value="">Pilih Lab</option>
                        @foreach($labs as $lab)
                            <option value="{{ $lab->id }}" {{ old('lab_id') == $lab->id ? 'selected' : '' }}>
                                {{ $lab->nama_lab }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Pilihan Hari --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-on-surface-variant">Hari</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">calendar_today</span>
                    <select name="hari" class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md appearance-none" required>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                            <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Input Jam Mulai (Format 24 Jam) --}}
            <div class="space-y-2">
                <label for="jam_mulai" class="block text-sm font-semibold text-on-surface-variant">Jam Mulai</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">schedule</span>
                    <input type="time"
                           id="jam_mulai"
                           name="jam_mulai"
                           step="60"
                           value="{{ old('jam_mulai') }}"
                           class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md"
                           required>
                </div>
            </div>

            {{-- Input Jam Selesai (Format 24 Jam) --}}
            <div class="space-y-2">
                <label for="jam_selesai" class="block text-sm font-semibold text-on-surface-variant">Jam Selesai</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">more_time</span>
                    <input type="time"
                           id="jam_selesai"
                           name="jam_selesai"
                           step="60"
                           value="{{ old('jam_selesai') }}"
                           class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md"
                           required>
                </div>
            </div>

            {{-- Mata Pelajaran --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-on-surface-variant">Mata Pelajaran</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">book</span>
                    <input type="text" name="mata_pelajaran" value="{{ old('mata_pelajaran') }}" class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md" placeholder="Contoh: Pemrograman Web" required>
                </div>
            </div>

            {{-- Nama Guru --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-on-surface-variant">Nama Guru Pengajar</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">person</span>
                    <input type="text" name="guru" value="{{ old('guru') }}" class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md" placeholder="Contoh: Budi Santoso, S.Kom" required>
                </div>
            </div>
			
            
			<div class="space-y-2">
   				<label class="block text-sm font-semibold text-on-surface-variant">No. HP Guru</label>
    			<div class="relative">
        		<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">phone</span>
        		<input type="tel" name="no_hp" value="{{ old('no_hp') }}"
               		class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md"
               		placeholder="Contoh: 08123456789">
   				</div>
			</div>
            
            {{-- Kelas --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-on-surface-variant">Kelas</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">groups</span>
                    <input type="text" name="kelas" value="{{ old('kelas') }}" class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md" placeholder="Contoh: XI RPL 1" required>
                </div>
            </div>

            {{-- Lembaga / Instansi --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-on-surface-variant">Lembaga</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">school</span>
                    <input type="text" name="lembaga" value="{{ old('lembaga',) }}" class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md" placeholder="Contoh: SMK Negeri 1" required>
                </div>
            </div>

            {{-- Pilihan Semester --}}
            <div class="space-y-2 md:col-span-2">
                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Semester</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-3 cursor-pointer bg-surface-container-low px-5 py-3 rounded-xl border border-outline-variant/60 hover:bg-primary/5 transition-all relative flex-1 text-center justify-center font-medium shadow-sm" id="label-ganjil">
                        <input type="radio" name="semester" value="Ganjil" class="w-4 h-4 text-primary focus:ring-primary" checked>
                        <span>Semester Ganjil</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer bg-surface-container-low px-5 py-3 rounded-xl border border-outline-variant/60 hover:bg-primary/5 transition-all relative flex-1 text-center justify-center font-medium shadow-sm" id="label-genap">
                        <input type="radio" name="semester" value="Genap" class="w-4 h-4 text-primary focus:ring-primary">
                        <span>Semester Genap</span>
                    </label>
                </div>
            </div>

        </div>

        {{-- Action Buttons --}}
        <div class="mt-8 flex gap-3 border-t border-outline-variant/30 pt-5">
            <button type="submit" class="flex-1 md:flex-initial flex items-center justify-center gap-2 bg-primary text-white px-6 py-3.5 rounded-xl font-bold hover:bg-primary/90 transition-all shadow-md active:scale-95">
                <span class="material-symbols-outlined text-xl">save</span>
                <span>Simpan Jadwal</span>
            </button>
            <a href="{{ route('jadwal.index') }}" class="flex-1 md:flex-initial flex items-center justify-center gap-2 bg-surface-container-high text-on-surface-variant px-6 py-3.5 rounded-xl font-bold hover:bg-surface-variant transition-all text-center">
                Batal
            </a>
        </div>

    </form>

</div>

{{-- Script Perbaikan Penggantian Warna Border Radio Button --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const radios = document.querySelectorAll('input[name="semester"]');
        
        function updateRadioStyles() {
            radios.forEach(radio => {
                const parentLabel = radio.closest('label');
                if (radio.checked) {
                    parentLabel.classList.remove('bg-surface-container-low', 'border-outline-variant/60');
                    parentLabel.classList.add('bg-primary/10', 'border-primary', 'text-primary');
                } else {
                    parentLabel.classList.add('bg-surface-container-low', 'border-outline-variant/60');
                    parentLabel.classList.remove('bg-primary/10', 'border-primary', 'text-primary');
                }
            });
        }

        radios.forEach(radio => {
            radio.addEventListener('change', updateRadioStyles);
        });

        // Jalankan saat pertama kali halaman dimuat
        updateRadioStyles();
    });
</script>

@endsection