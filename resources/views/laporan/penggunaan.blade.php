@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Laporan Penggunaan Lab
</h1>

<form method="GET" class="mb-6 flex gap-3">

    <select
        name="bulan"
        class="border rounded px-3 py-2">

        @for($i=1; $i<=12; $i++)

            <option
                value="{{ $i }}"
                {{ $bulan == $i ? 'selected' : '' }}>

                {{ DateTime::createFromFormat('!m', $i)->format('F') }}

            </option>

        @endfor

    </select>

    <input
        type="number"
        name="tahun"
        value="{{ $tahun }}"
        class="border rounded px-3 py-2">

    <button
        class="bg-blue-600 text-white px-4 py-2 rounded">

        Tampilkan

    </button>

</form>

<div class="bg-white rounded shadow p-5 mb-6">

    <h2 class="font-bold text-lg mb-3">
        Ringkasan Penggunaan
    </h2>

    <table class="w-full">

        <thead>

            <tr class="border-b">

                <th class="text-left p-2">
                    Lab
                </th>

                <th class="text-left p-2">
                    Jumlah Booking
                </th>

                <th class="text-left p-2">
                    Total Jam
                </th>

            </tr>

        </thead>

        <tbody>

        @foreach($rekapLab as $lab => $data)

            <tr class="border-b">

                <td class="p-2">
                    {{ $lab }}
                </td>

                <td class="p-2">
                    {{ $data['jumlah_booking'] }}
                </td>

                <td class="p-2">
                    {{ $data['total_jam'] }}
                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

<div class="bg-white rounded shadow p-5">

    <h2 class="font-bold text-lg mb-3">
        Detail Penggunaan
    </h2>

    <table class="w-full">

        <thead>

            <tr class="border-b">

                <th class="p-2">
                    Tanggal
                </th>

                <th class="p-2">
                    Lab
                </th>

                <th class="p-2">
                    Pemohon
                </th>

                <th class="p-2">
                    Jam
                </th>

            </tr>

        </thead>

        <tbody>

        @foreach($bookings as $booking)

            <tr class="border-b">

                <td class="p-2">
                    {{ $booking->tanggal_booking }}
                </td>

                <td class="p-2">
                    {{ $booking->lab->nama_lab }}
                </td>

                <td class="p-2">
                    {{ $booking->nama_pemohon }}
                </td>

                <td class="p-2">

                    {{ $booking->jam_mulai }}

                    -

                    {{ $booking->jam_selesai }}

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection