@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Laporan Kerusakan
</h1>

<form action="{{ route('laporan-kerusakan.store') }}"
      method="POST"
      class="bg-white rounded-xl shadow p-6">


@csrf

<div class="mb-4">

    <label class="block mb-2">
        Nama Pelapor
    </label>

    <input type="text"
           name="nama_pelapor"
           class="w-full border rounded p-2">

</div>

<div class="mb-4">

    <label class="block mb-2">
        Lab
    </label>

    <select name="lab_id"
            class="w-full border rounded p-2">

        @foreach($labs as $lab)

            <option value="{{ $lab->id }}">
                {{ $lab->nama_lab }}
            </option>

        @endforeach

    </select>

</div>

<div class="mb-4">

    <label class="block mb-2">
        Jenis Kerusakan
    </label>

    <input type="text"
           name="jenis_kerusakan"
           class="w-full border rounded p-2">

</div>

<div class="mb-4">

    <label class="block mb-2">
        Deskripsi
    </label>

    <textarea name="deskripsi"
              rows="5"
              class="w-full border rounded p-2"></textarea>

</div>

<button
    class="bg-red-600 text-white px-4 py-2 rounded">

    Kirim Laporan

</button>


</form>

@endsection
