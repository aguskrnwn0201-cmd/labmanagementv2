@extends('layouts.app')

@section('content')

<h2>Data Lab</h2>

<a href="{{ route('labs.create') }}">
    Tambah Lab
</a>

<hr>

<table border="1" cellpadding="10">
    <tr>
        <th>Nama Lab</th>
        <th>Lokasi</th>
        <th>Kapasitas</th>
        <th>Status</th>
    </tr>

    @foreach($labs as $lab)
        <tr>
            <td>{{ $lab->nama_lab }}</td>
            <td>{{ $lab->lokasi }}</td>
            <td>{{ $lab->kapasitas }}</td>
            <td>{{ $lab->status }}</td>
        </tr>
    @endforeach

</table>

@endsection