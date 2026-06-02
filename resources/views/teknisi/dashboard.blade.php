@extends('layouts.app')

@section('content')

<h2>Dashboard Teknisi</h2>

<ul>
    <li>
        <a href="{{ route('labs.index') }}">
            Data Lab
        </a>
    </li>

    <li>
        Jadwal Lab
    </li>

    <li>
        Booking Lab
    </li>

    <li>
        Export Laporan
    </li>
</ul>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">
        Logout
    </button>
</form>

@endsection