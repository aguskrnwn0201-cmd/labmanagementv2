@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Manajemen Laboratorium</p>
        <h3 class="font-headline-lg-mobile lg:font-headline-lg text-headline-lg-mobile lg:text-headline-lg text-on-surface">Daftar Booking</h3>
    </div>
    <a href="{{ route('booking.create') }}" class="bg-primary text-white px-6 py-3 rounded-lg font-bold flex items-center justify-center gap-2 hover:bg-blue-700 transition-all shadow-sm no-underline">
        <span class="material-symbols-outlined">add</span>
        <span>Tambah Booking</span>
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2 font-body-sm">
    <span class="material-symbols-outlined text-[20px]">check_circle</span>
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 gap-6">
    @forelse($bookings as $booking)
    <div class="group bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden hover:shadow-md transition-all duration-300 p-6 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 flex-1">
            <div class="flex-shrink-0">
                @if($booking->status == 'pending')
                    <span class="px-3 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded-full border border-amber-200 uppercase tracking-tight">
                        Pending
                    </span>
                @elseif($booking->status == 'accepted')
                    <span class="px-3 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-full border border-green-200 uppercase tracking-tight">
                        Disetujui
                    </span>
                @else
                    <span class="px-3 py-1 bg-red-50 text-red-700 text-xs font-bold rounded-full border border-red-200 uppercase tracking-tight">
                        Ditolak
                    </span>
                @endif

                <h4 class="font-headline-sm text-headline-sm text-on-surface mt-2 font-bold">
                    {{ $booking->lab->nama_lab }}
                </h4>
                
                <div class="flex items-center gap-2 text-on-surface-variant mt-1">
                    <span class="material-symbols-outlined text-sm">calendar_month</span>
                    <span class="font-body-sm">{{ $booking->tanggal_booking }}</span>
                    <span class="mx-1">•</span>
                    <span class="font-body-sm font-semibold text-primary">
                        {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-3 border-t sm:border-t-0 sm:border-l border-outline-variant/60 pt-4 sm:pt-0 sm:pl-6 w-full sm:w-auto">
                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold uppercase shrink-0">
                    {{ substr($booking->nama_pemohon, 0, 1) }}
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-[10px] uppercase font-bold text-outline">Pemohon</span>
                    <span class="font-body-md font-semibold text-on-surface truncate">{{ $booking->nama_pemohon }}</span>
                </div>
            </div>
        </div>

        {{-- Wadah Tombol Aksi - Layout Flexbox Bersih Tanpa Tag TD Tabel --}}
        <div class="flex items-center flex-wrap gap-2 w-full md:w-auto justify-end border-t md:border-t-0 border-outline-variant/40 pt-4 md:pt-0 shrink-0">
            {{-- Tombol Detail (Dapat diakses oleh siapa saja termasuk Guru/Siswa/Guest) --}}
            <a href="{{ route('booking.show', $booking->id) }}" class="px-4 py-2 border border-primary text-primary font-bold rounded-lg hover:bg-primary/5 transition-colors flex items-center justify-center gap-1 text-sm no-underline">
                <span class="material-symbols-outlined text-[18px]">visibility</span>
                <span>Detail</span>
            </a>
            
            {{-- KUNCI BERLAPIS: Tombol Edit & Hapus hanya muncul jika login BUKAN guru/siswa --}}
            @if(Auth::check() && 
                strtolower(Auth::user()->role) !== 'guru' && 
                strtolower(Auth::user()->role) !== 'siswa' && 
                session('role') !== 'guru' && 
                session('role') !== 'siswa')
                
                <a href="{{ route('booking.edit', $booking->id) }}" class="px-4 py-2 border border-blue-600 text-blue-600 font-bold rounded-lg hover:bg-blue-50 transition-colors flex items-center justify-center gap-1 text-sm no-underline">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    <span>Edit</span>
                </a>
                
                <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data booking ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 border border-error text-error font-bold rounded-lg hover:bg-red-50 transition-colors flex items-center justify-center gap-1 text-sm bg-transparent cursor-pointer">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                        <span>Hapus</span>
                    </button>
                </form>
            @endif
        </div>
    </div>
    @empty
    <div class="bg-surface-container-lowest rounded-xl border border-dashed border-outline-variant p-12 text-center shadow-sm">
        <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
            <span class="material-symbols-outlined text-5xl text-outline-variant mb-3">bookmark_remove</span>
            <h5 class="font-headline-sm text-headline-sm text-on-surface mb-1">Belum Ada Booking</h5>
            <p class="font-body-sm text-body-sm text-on-surface-variant mb-6">Saat ini belum ada pengajuan laboratorium dari pengajar atau instansi manapun.</p>
            <a href="{{ route('booking.create') }}" class="bg-primary text-white px-5 py-2.5 rounded-lg font-bold text-sm hover:bg-blue-700 transition-all no-underline shadow-sm">
                Buat Pengajuan Pertama
            </a>
        </div>
    </div>
    @endforelse
</div>
@endsection