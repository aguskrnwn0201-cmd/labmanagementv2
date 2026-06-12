@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant shadow-sm">
    
    {{-- Header Halaman --}}
    <div class="flex items-center gap-3 mb-6 border-b border-outline-variant/30 pb-4">
        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-[24px]">bookmark_heart</span>
        </div>
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-on-surface">
                Detail Pengajuan Booking Lab
            </h1>
            <p class="text-xs md:text-sm text-on-surface-variant">Informasi lengkap terkait peminjaman atau reservasi ruang laboratorium.</p>
        </div>
    </div>

    {{-- Detail Informasi Booking --}}
    <div class="space-y-4">
        
        {{-- Baris Lab & Status Peminjaman --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Laboratorium</span>
                <div class="flex items-center gap-2 font-bold text-on-surface">
                    <span class="material-symbols-outlined text-primary text-[20px]">science</span>
                    <span>{{ $booking->lab->nama_lab }}</span>
                </div>
            </div>

            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Status Persetujuan</span>
                <div class="mt-1">
                    @if($booking->status == 'pending')
                        <span class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-800 ring-1 ring-inset ring-amber-600/20 uppercase tracking-wider">Pending</span>
                    @elseif($booking->status == 'accepted')
                        <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-800 ring-1 ring-inset ring-green-600/20 uppercase tracking-wider">Disetujui</span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-800 ring-1 ring-inset ring-red-600/20 uppercase tracking-wider">Ditolak</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Baris Identitas Pemohon --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Nama Pemohon</span>
                <div class="flex items-center gap-2 font-bold text-on-surface text-sm truncate">
                    <span class="material-symbols-outlined text-on-surface-variant text-[18px]">person</span>
                    <span>{{ $booking->nama_pemohon }}</span>
                </div>
            </div>

            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Tipe Instansi</span>
                <div class="flex items-center gap-2 font-medium text-on-surface-variant text-sm">
                    <span class="material-symbols-outlined text-on-surface-variant text-[18px]">badge</span>
                    <span>{{ ucfirst($booking->tipe_pemohon) }}</span>
                </div>
            </div>

            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Kontak (No. HP)</span>
                <div class="flex items-center gap-2 font-medium text-on-surface text-sm">
                    <span class="material-symbols-outlined text-success text-[18px]">call</span>
                    <span>{{ $booking->no_hp }}</span>
                </div>
            </div>
        </div>

        {{-- Baris Waktu & Kuota --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Tanggal Peminjaman</span>
                <div class="flex items-center gap-2 font-semibold text-on-surface text-sm">
                    <span class="material-symbols-outlined text-primary text-[18px]">calendar_month</span>
                    <span>{{ $booking->tanggal_booking }}</span>
                </div>
            </div>

            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Alokasi Jam</span>
                <div class="flex items-center gap-2 font-bold text-primary text-sm">
                    <span class="material-symbols-outlined text-[18px]">schedule</span>
                    <span>{{ substr($booking->jam_mulai,0,5) }} - {{ substr($booking->jam_selesai,0,5) }}</span>
                </div>
            </div>

            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Kelas / Jumlah Peserta</span>
                <div class="flex items-center gap-2 text-sm text-on-surface font-medium">
                    <span class="material-symbols-outlined text-on-surface-variant text-[18px]">groups</span>
                    <span>{{ $booking->kelas }} ({{ $booking->jumlah_peserta }} Orang)</span>
                </div>
            </div>
        </div>

        {{-- Baris Keperluan --}}
        <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
            <span class="text-xs font-semibold text-on-surface-variant block mb-1 uppercase tracking-wider">Tujuan / Keperluan Penggunaan</span>
            <p class="text-sm text-on-surface font-medium leading-relaxed mt-1">
                {{ $booking->keperluan }}
            </p>
        </div>

    </div>

    {{-- Tombol Aksi & Proteksi Navigasi --}}
    <div class="mt-8 flex flex-col sm:flex-row gap-3 border-t border-outline-variant/30 pt-5">
        <a href="{{ route('booking.index') }}" class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-surface-container-high text-on-surface-variant px-6 py-3 rounded-xl font-bold hover:bg-surface-variant transition-all text-center no-underline text-sm shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Kembali ke Daftar</span>
        </a>

        {{-- KUNCI BERLAPIS DETAIL: Tombol Edit hanya dirender jika login BUKAN guru/siswa --}}
        @if(Auth::check() && 
            strtolower(Auth::user()->role) !== 'guru' && 
            strtolower(Auth::user()->role) !== 'siswa' && 
            session('role') !== 'guru' && 
            session('role') !== 'siswa')
            
            <a href="{{ route('booking.edit', $booking->id) }}" class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-primary text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition-all text-center no-underline text-sm shadow-sm sm:ml-auto">
                <span class="material-symbols-outlined text-[18px]">edit</span>
                <span>Edit Booking</span>
            </a>
        @endif
    </div>

</div>
@endsection