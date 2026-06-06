@extends('layouts.app')

@section('content')

<div class="flex justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold">
            Jadwal Lab
        </h1>
        <p class="text-gray-500">
            Daftar jadwal penggunaan laboratorium
        </p>
    </div>

    @if(session('role') == 'teknisi')
    <a href="{{ route('jadwal.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded">
        Tambah Jadwal
    </a>
    @endif
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

@if($errors->has('jadwal'))
<div class="bg-red-100 text-red-700 p-3 rounded mb-4">
    {{ $errors->first('jadwal') }}
</div>
@endif

<table class="w-full bg-white rounded-xl shadow">
    <thead>
        <tr class="border-b">
            <th class="p-3 text-left">Lab</th>
            <th class="p-3 text-left">Hari</th>
            <th class="p-3 text-left">Jam</th>
            <th class="p-3 text-left">Mapel</th>
            <th class="p-3 text-left">Guru</th>
            <th class="p-3 text-left">Kelas</th>
            @if(session('role') == 'teknisi')
            <th class="p-3 text-left">Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse($jadwals as $jadwal)
        <tr class="border-b">
            <td class="p-3">{{ $jadwal->lab->nama_lab }}</td>
            <td class="p-3">{{ $jadwal->hari }}</td>
            <td class="p-3">
                {{ substr($jadwal->jam_mulai, 0, 5) }}
                -
                {{ substr($jadwal->jam_selesai, 0, 5) }}
            </td>
            <td class="p-3">{{ $jadwal->mata_pelajaran }}</td>
            <td class="p-3">{{ $jadwal->guru }}</td>
            <td class="p-3">{{ $jadwal->kelas }}</td>
            @if(session('role') == 'teknisi')
            <td class="p-3 flex gap-2">
                <a href="{{ route('jadwal.edit', $jadwal) }}"
                    class="bg-yellow-400 text-white px-3 py-1 rounded text-sm">
                    Edit
                </a>
                <form action="{{ route('jadwal.destroy', $jadwal) }}"
                    method="POST"
                    onsubmit="return confirm('Hapus jadwal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                        Hapus
                    </button>
                </form>
            </td>
            @endif
        </tr>
        @empty
        <tr>
            <td colspan="{{ session('role') == 'teknisi' ? 7 : 6 }}"
                class="p-6 text-center text-gray-500">
                Belum ada jadwal
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection