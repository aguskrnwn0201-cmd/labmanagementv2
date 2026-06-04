@extends('layouts.app')

@section('content')

<div class="mb-8">

<h1 class="text-3xl font-bold">
    Dashboard Guru
</h1>

<p class="text-gray-500">
    Informasi penggunaan laboratorium
</p>

</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

<div class="bg-white rounded-xl shadow p-6">

    <h3 class="text-gray-500">
        Lab Aktif
    </h3>

    <div class="text-4xl font-bold mt-2">
        {{ $totalLab }}
    </div>

</div>

<div class="bg-white rounded-xl shadow p-6">

    <h3 class="text-gray-500">
        Total Jadwal
    </h3>

    <div class="text-4xl font-bold mt-2">
        {{ $totalJadwal }}
    </div>

</div>

<div class="bg-white rounded-xl shadow p-6">

    <h3 class="text-gray-500">
        Total Booking
    </h3>

    <div class="text-4xl font-bold mt-2">
        {{ $totalBooking }}
    </div>

</div>


</div>

<div class="grid md:grid-cols-2 gap-6">


<a href="{{ route('jadwal.index') }}"
   class="bg-white rounded-xl shadow p-6 hover:shadow-lg">

    <h2 class="text-xl font-bold mb-2">
        📅 Lihat Jadwal Lab
    </h2>

    <p class="text-gray-500">
        Melihat jadwal penggunaan laboratorium.
    </p>

</a>

<a href="{{ route('booking.index') }}"
   class="bg-white rounded-xl shadow p-6 hover:shadow-lg">

    <h2 class="text-xl font-bold mb-2">
        📝 Booking Lab
    </h2>

    <p class="text-gray-500">
        Mengajukan penggunaan laboratorium.
    </p>

</a>


</div>

<div class="mt-8 bg-yellow-50 border border-yellow-300 rounded-xl p-6">

<h2 class="text-xl font-bold text-yellow-700">
    🚧 Laporan Kerusakan
</h2>

<p class="text-yellow-600 mt-2">
    Fitur sedang dalam pengembangan.
</p>


</div>

@endsection
