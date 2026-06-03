@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">
        Tambah Jadwal
    </h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jadwal.store') }}" method="POST">

        @csrf

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label>Lab</label>
                <select name="lab_id" class="w-full border rounded p-2">
                    <option value="">Pilih Lab</option>

                    @foreach($labs as $lab)
                        <option value="{{ $lab->id }}">
                            {{ $lab->nama_lab }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Hari</label>
                <select name="hari" class="w-full border rounded p-2">
                    <option>Senin</option>
                    <option>Selasa</option>
                    <option>Rabu</option>
                    <option>Kamis</option>
                    <option>Jumat</option>
                    <option>Sabtu</option>
                </select>
            </div>

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

            <div>
                <label>Mata Pelajaran</label>
                <input type="text"
                       name="mata_pelajaran"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label>Guru</label>
                <input type="text"
                       name="guru"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label>Kelas</label>
                <input type="text"
                       name="kelas"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label>Semester</label>
                <input type="text"
                       name="semester"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label>Tahun Ajaran</label>
                <input type="text"
                       name="tahun_ajaran"
                       placeholder="2025/2026"
                       class="w-full border rounded p-2">
            </div>

        </div>

        <div class="mt-6">
            <button
                type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded">

                Simpan Jadwal

            </button>
        </div>

    </form>

</div>

@endsection