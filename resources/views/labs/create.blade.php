@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2>Tambah Lab</h2>

<form method="POST" action="{{ route('labs.store') }}">
    @csrf

    <p>
        Nama Lab<br>
        <input type="text" name="nama_lab">
    </p>

    <p>
        Lokasi<br>
        <input type="text" name="lokasi">
    </p>

    <p>
        Kapasitas<br>
        <input type="number" name="kapasitas">
    </p>

    <p>
        Keterangan<br>
        <textarea name="keterangan"></textarea>
    </p>

    <button type="submit">
        Simpan
    </button>

</form>

@endsection