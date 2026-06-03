@extends('layouts.app')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold">
        Dashboard Teknisi
    </h1>

    <p class="text-gray-500">
        Ringkasan aktivitas laboratorium
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white rounded-xl shadow p-6">
        <h3>Total Lab</h3>
        <div class="text-4xl font-bold">
            {{ $totalLab }}
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h3>Total Jadwal</h3>
        <div class="text-4xl font-bold">
            {{ $totalJadwal }}
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h3>Total Booking</h3>
        <div class="text-4xl font-bold">
            {{ $totalBooking }}
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h3>Booking Hari Ini</h3>
        <div class="text-4xl font-bold">
            {{ $bookingHariIni }}
        </div>
    </div>

</div>

<!-- TAMBAHKAN BAGIAN INI -->

<div class="mt-8 bg-white rounded-xl shadow">

    <div class="p-4 border-b">
        <h2 class="font-bold text-lg">
            Booking Terbaru
        </h2>
    </div>

    <table class="w-full">

       <thead>
    <tr>
        <th class="p-3 text-left">Pemohon</th>
        <th class="p-3 text-left">Lab</th>
        <th class="p-3 text-left">Tanggal</th>
        <th class="p-3 text-left">Jam</th>
        <th class="p-3 text-left">Status</th>
    </tr>
</thead>

        <tbody>

        @forelse($bookingTerbaru as $booking)

            <tr class="border-t">

                <td class="p-3">
                    {{ $booking->nama_pemohon }}
                </td>

                <td class="p-3">
                    {{ $booking->lab->nama_lab }}
                </td>

                <td class="p-3">
                    {{ $booking->tanggal_booking }}
                </td>

                <td class="p-3">
                    {{ substr($booking->jam_mulai,0,5) }}
                    -
                    {{ substr($booking->jam_selesai,0,5) }}
                </td>

                <td class="p-3">
    <span class="px-2 py-1 rounded text-sm bg-green-100 text-green-700">
        {{ ucfirst($booking->status) }}
    </span>
</td>

            </tr>

        @empty

            <tr>
                <td colspan="4" class="p-4 text-center text-gray-500">
                    Belum ada booking
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection