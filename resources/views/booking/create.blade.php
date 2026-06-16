@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant shadow-sm">

    <div class="flex items-center gap-3 mb-6 border-b border-outline-variant/30 pb-4">
        <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">add_task</span>
        </div>
        <h1 class="text-2xl md:text-3xl font-bold text-on-surface">
            Form Booking Laboratorium
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

    <form method="POST" action="{{ route('booking.store') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Pilihan Lab --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-on-surface-variant">Pilih Ruang Lab</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">science</span>
                    <select name="lab_id" class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md appearance-none" required>
                        <option value="" disabled selected>Pilih Ruang Lab</option>
                        @foreach($labs as $lab)
                            <option value="{{ $lab->id }}" {{ old('lab_id') == $lab->id ? 'selected' : '' }}>
                                {{ $lab->nama_lab }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Tipe Pemohon --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-on-surface-variant">Tipe Pemohon</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">badge</span>
                    <select name="tipe_pemohon" class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md appearance-none" required>
                        <option value="guru" {{ old('tipe_pemohon') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="siswa" {{ old('tipe_pemohon') == 'tentor' ? 'selected' : '' }}>Tentor</option>
                    </select>
                </div>
            </div>

            {{-- Nama Pemohon --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-on-surface-variant">Nama Pemohon</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">person</span>
                    <input type="text" name="nama_pemohon" value="{{ old('nama_pemohon') }}" class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md" placeholder="Nama lengkap Anda" required>
                </div>
            </div>

            {{-- Kelas --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-on-surface-variant">Kelas</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">groups</span>
                    <input type="text" name="kelas" value="{{ old('kelas') }}" class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md" placeholder="Contoh: XII TKJ 2 (Isi '-' jika Guru)">
                </div>
            </div>

            {{-- Lembaga --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-on-surface-variant">Lembaga</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">school</span>
                    <input type="text" name="lembaga" value="{{ old('lembaga') }}" class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md" placeholder="Nama Sekolah/Instansi" required>
                </div>
            </div>

            {{-- No HP --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-on-surface-variant">No. HP / WhatsApp</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">call</span>
                    <input type="tel" name="no_hp" value="{{ old('no_hp') }}" class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md" placeholder="Contoh: 08123456789" required>
                </div>
            </div>

            {{-- Tanggal Booking --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-on-surface-variant">Tanggal Pinjam</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">calendar_month</span>
                    <input type="date" 
                           name="tanggal_booking" 
                           value="{{ old('tanggal_booking') }}"
                           min="{{ now()->format('Y-m-d') }}"
                           max="{{ now()->addDays(7)->format('Y-m-d') }}"
                           class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md" 
                           required>
                </div>
            </div>

            {{-- Jumlah Peserta --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-on-surface-variant">Jumlah Peserta / Siswa</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-xl">person_add</span>
                    <input type="number" name="jumlah_peserta" value="{{ old('jumlah_peserta') }}" class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md" placeholder="Contoh: 36" required>
                </div>
            </div>

            {{-- Jam Mulai (Format 24 Jam) --}}
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

            {{-- Jam Selesai (Format 24 Jam) --}}
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

            {{-- Keperluan --}}
            <div class="space-y-2 md:col-span-2">
                <label class="block text-sm font-semibold text-on-surface-variant">Keperluan / Keterangan</label>
                <div class="relative">
                    <textarea name="keperluan" rows="3" class="w-full p-4 bg-surface-container-lowest border border-outline-variant rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-body-md shadow-inner" placeholder="Tuliskan detail agenda penggunaan laboratorium..." required>{{ old('keperluan') }}</textarea>
                </div>
            </div>

        </div>

        {{-- Action Buttons --}}
        <div class="mt-8 flex gap-3 border-t border-outline-variant/30 pt-5">
            <button type="submit" class="flex-1 md:flex-initial flex items-center justify-center gap-2 bg-primary text-white px-6 py-3.5 rounded-xl font-bold hover:bg-primary/90 transition-all shadow-md active:scale-95">
                <span class="material-symbols-outlined text-xl">save</span>
                <span>Simpan Booking</span>
            </button>
            <a href="{{ route('booking.index') }}" class="flex-1 md:flex-initial flex items-center justify-center gap-2 bg-surface-container-high text-on-surface-variant px-6 py-3.5 rounded-xl font-bold hover:bg-surface-variant transition-all text-center">
                Batal
            </a>
        </div>

    </form>

</div>

@endsection