@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Manajemen Laboratorium</p>
        <h3 class="font-headline-lg-mobile lg:font-headline-lg text-headline-lg-mobile lg:text-headline-lg text-on-surface">Daftar Booking</h3>
    </div>
    <a href="{{ route('booking.create') }}" class="bg-primary-container text-on-primary-container px-6 py-3 rounded-lg font-bold flex items-center justify-center gap-2 hover:opacity-90 transition-opacity shadow-sm">
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
    <div class="group bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden hover:shadow-lg transition-all duration-300 p-6 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
            <div class="flex-shrink-0">
                @if($booking->status == 'pending')
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full border border-amber-200 uppercase tracking-tight">
                        Pending
                    </span>
                @elseif($booking->status == 'accepted')
                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full border border-green-200 uppercase tracking-tight">
                        Disetujui
                    </span>
                @else
                    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full border border-red-200 uppercase tracking-tight">
                        Ditolak
                    </span>
                @endif

                <h4 class="font-headline-sm text-headline-sm text-on-surface mt-2">
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

            <div class="flex items-center gap-3 border-t sm:border-t-0 sm:border-l border-outline-variant pt-4 sm:pt-0 sm:pl-6">
                <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed font-bold uppercase">
                    {{ substr($booking->nama_pemohon, 0, 1) }}
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] uppercase font-bold text-outline">Pemohon</span>
                    <span class="font-body-md font-semibold text-on-surface">{{ $booking->nama_pemohon }}</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-3 w-full md:w-auto justify-end">
            <a href="{{ route('booking.show', $booking->id) }}" class="flex-1 sm:flex-none px-4 py-2 border border-primary text-primary font-bold rounded-lg hover:bg-primary-fixed transition-colors flex items-center justify-center gap-1 text-sm">
                <span class="material-symbols-outlined text-sm">visibility</span>
                Detail
            </a>
            
            <a href="{{ route('booking.edit', $booking->id) }}" class="p-2 border border-outline rounded-lg text-on-surface-variant hover:bg-surface-container-low transition-colors flex items-center justify-center" title="Edit">
                <span class="material-symbols-outlined text-[20px]">edit</span>
            </a>

            <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Hapus booking ini?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-2 border border-error/20 rounded-lg text-error hover:bg-error-container/20 transition-colors flex items-center justify-center" title="Hapus">
                    <span class="material-symbols-outlined text-[20px]">delete</span>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="bg-surface-container-lowest rounded-xl border border-dashed border-outline-variant p-12 text-center shadow-sm">
        <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
            <span class="material-symbols-outlined text-5xl text-outline-variant mb-3">bookmark_remove</span>
            <h5 class="font-headline-sm text-headline-sm text-on-surface mb-1">Belum Ada Booking</h5>
            <p class="font-body-sm text-body-sm text-on-surface-variant mb-6">Saat ini belum ada pengajuan laboratorium dari pengajar atau instansi manapun.</p>
            <a href="{{ route('booking.create') }}" class="bg-primary text-on-primary px-4 py-2 rounded-lg font-bold text-sm hover:opacity-90 transition-opacity">
                Buat Pengajuan Pertama
            </a>
        </div>
    </div>
    @endforelse
</div>
@endsection