@extends('layouts.app')

@section('content')

<div class="flex justify-between mb-6">


<h1 class="text-3xl font-bold">
    Daftar Booking
</h1>

<a href="{{ route('booking.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded">
    Tambah Booking
</a>


</div>

@if(session('success'))

<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<table class="w-full bg-white rounded-xl shadow">


<thead>
    <tr class="border-b">
        <th class="p-3">Lab</th>
        <th class="p-3">Pemohon</th>
        <th class="p-3">Tanggal</th>
        <th class="p-3">Jam</th>
        <th class="p-3">Status</th>
        <th class="p-3">Aksi</th>
    </tr>
</thead>

<tbody>

@forelse($bookings as $booking)

    <tr class="border-b">

        <td class="p-3">
            {{ $booking->lab->nama_lab }}
        </td>

        <td class="p-3">
            {{ $booking->nama_pemohon }}
        </td>

        <td class="p-3">
            {{ $booking->tanggal_booking }}
        </td>

        <td class="p-3">
            {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }}
            -
            {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
        </td>

        <td class="p-3">

            @if($booking->status == 'pending')

                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                    Pending
                </span>

            @elseif($booking->status == 'accepted')

                <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                    Disetujui
                </span>

            @else

                <span class="bg-red-100 text-red-700 px-2 py-1 rounded">
                    Ditolak
                </span>

            @endif

        </td>

        <td class="p-3">

            <div class="flex gap-2">

                <a href="{{ route('booking.show', $booking->id) }}"
                   class="bg-blue-500 text-white px-3 py-1 rounded">
                    Detail
                </a>

                <a href="{{ route('booking.edit', $booking->id) }}"
                   class="bg-yellow-500 text-white px-3 py-1 rounded">
                    Edit
                </a>

                <form action="{{ route('booking.destroy', $booking->id) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus booking ini?')">

                    @csrf
                    @method('DELETE')

                    <button class="bg-red-600 text-white px-3 py-1 rounded">
                        Hapus
                    </button>

                </form>

            </div>

        </td>

    </tr>

@empty

    <tr>
        <td colspan="6"
            class="p-6 text-center text-gray-500">
            Belum ada booking
        </td>
    </tr>

@endforelse

</tbody>


</table>

@endsection
