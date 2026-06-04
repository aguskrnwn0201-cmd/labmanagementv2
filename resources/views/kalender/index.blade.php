@extends('layouts.app')

@section('content')

<div class="flex justify-between mb-6">

    <div>
        <h1 class="text-3xl font-bold">
            Kalender Lab
        </h1>

        <p class="text-gray-500">
            Jadwal dan booking laboratorium
        </p>
    </div>

</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-50">

            <tr>
                <th class="p-3 text-left">Hari/Tanggal</th>
                <th class="p-3 text-left">Lab</th>
                <th class="p-3 text-left">Kegiatan</th>
                <th class="p-3 text-left">Jam</th>
                <th class="p-3 text-left">Tipe</th>
            </tr>

        </thead>

        <tbody>

            {{-- JADWAL --}}

            @foreach($jadwals as $jadwal)

            <tr class="border-b">

                <td class="p-3">
                    {{ $jadwal->hari }}
                </td>

                <td class="p-3">
                    {{ $jadwal->lab->nama_lab }}
                </td>

                <td class="p-3">
                    {{ $jadwal->mata_pelajaran }}
                </td>

                <td class="p-3">
                    {{ substr($jadwal->jam_mulai,0,5) }}
                    -
                    {{ substr($jadwal->jam_selesai,0,5) }}
                </td>

                <td class="p-3">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded">
                        Jadwal
                    </span>
                </td>

            </tr>

            @endforeach

            {{-- BOOKING --}}

            @foreach($bookings as $booking)

            <tr class="border-b">

                <td class="p-3">
                    {{ $booking->tanggal_booking }}
                </td>

                <td class="p-3">
                    {{ $booking->lab->nama_lab }}
                </td>

                <td class="p-3">
                    Booking - {{ $booking->nama_pemohon }}
                </td>

                <td class="p-3">
                    {{ substr($booking->jam_mulai,0,5) }}
                    -
                    {{ substr($booking->jam_selesai,0,5) }}
                </td>

                <td class="p-3">
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                        Booking
                    </span>
                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection