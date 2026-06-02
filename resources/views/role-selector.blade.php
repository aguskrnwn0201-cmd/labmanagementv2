@extends('layouts.app')

@section('content')

<h1>Sistem Manajemen Lab</h1>

<br>

<a href="{{ route('guru.dashboard') }}">
    <button>Guru</button>
</a>

<a href="{{ route('siswa.dashboard') }}">
    <button>Siswa</button>
</a>

<a href="{{ route('login') }}">
    <button>Teknisi</button>
</a>

@endsection