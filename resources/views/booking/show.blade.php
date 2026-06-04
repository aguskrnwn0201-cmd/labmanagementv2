@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Detail Booking
</h1>

<div class="bg-white rounded-xl shadow p-6 space-y-4">

    <p>
        <strong>Lab:</strong>
        {{ $booking->lab->nama_lab }}
    </p>

    <p>
        <strong>Pemohon:</strong>
        {{ $booking->nama_pemohon }}
    </p>

    <p>
        <strong>Tipe:</strong>
        {{ $booking->tipe_pemohon }}
    </p>

    <p>
        <strong>Kelas:</strong>
        {{ $booking->kelas }}
    </p>

    <p>
        <strong>No HP:</strong>
        {{ $booking->no_hp }}
    </p>

    <p>
        <strong>Tanggal:</strong>
        {{ $booking->tanggal_booking }}
    </p>

    <p>
        <strong>Jam:</strong>
        {{ substr($booking->jam_mulai,0,5) }}
        -
        {{ substr($booking->jam_selesai,0,5) }}
    </p>

    <p>
        <strong>Peserta:</strong>
        {{ $booking->jumlah_peserta }}
    </p>

    <p>
        <strong>Keperluan:</strong>
        {{ $booking->keperluan }}
    </p>

    <p>
        <strong>Status:</strong>
        {{ ucfirst($booking->status) }}
    </p>

</div>

@endsection