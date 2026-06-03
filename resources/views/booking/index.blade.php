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
        {{ ucfirst($booking->status) }}
    </td>

</tr>

    @empty

        <tr>
            <td colspan="5"
                class="p-6 text-center text-gray-500">
                Belum ada booking
            </td>
        </tr>

    @endforelse

    </tbody>

</table>

@endsection