@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">
    Booking Lab
</h1>

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-4 rounded mb-4">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('booking.store') }}"
      class="bg-white p-6 rounded-xl shadow">

    @csrf

    <div class="mb-4">
        <label>Lab</label>
        <select name="lab_id" class="w-full border rounded p-2">
            @foreach($labs as $lab)
                <option value="{{ $lab->id }}">
                    {{ $lab->nama_lab }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>Tipe Pemohon</label>
        <select name="tipe_pemohon" class="w-full border rounded p-2">
            <option value="guru">Guru</option>
            <option value="siswa">Siswa</option>
        </select>
    </div>

    <div class="mb-4">
        <label>Nama Pemohon</label>
        <input type="text"
               name="nama_pemohon"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label>Kelas</label>
        <input type="text"
               name="kelas"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
    <label class="block font-semibold">Lembaga</label>
    <input type="text" name="lembaga" class="w-full border rounded p-2" placeholder="Contoh: SMK Negeri 1" required>
</div>

    <div class="mb-4">
        <label>No HP</label>
        <input type="text"
               name="no_hp"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label>Tanggal</label>
        <input type="date"
               name="tanggal_booking"
               min="{{ now()->format('Y-m-d') }}"
                max="{{ now()->addDays(7)->format('Y-m-d') }}"
               class="w-full border rounded p-2">
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">

        <div>
            <label>Jam Mulai</label>
            <input type="time"
                   name="jam_mulai"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label>Jam Selesai</label>
            <input type="time"
                   name="jam_selesai"
                   class="w-full border rounded p-2">
        </div>

    </div>

    <div class="mb-4">
        <label>Jumlah Peserta</label>
        <input type="number"
               name="jumlah_peserta"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
    <label class="block font-semibold">Keperluan</label>
    <textarea name="keperluan" class="w-full border rounded p-2" required></textarea>
</div>

    <button
        class="bg-blue-600 text-white px-4 py-2 rounded">
        Simpan Booking
    </button>

</form>

@endsection