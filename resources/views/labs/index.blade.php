@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">

    <div>
        <h1 class="text-2xl font-bold">
            Data Lab
        </h1>

        <p class="text-slate-500">
            Daftar laboratorium komputer
        </p>
    </div>

    <a href="{{ route('labs.create') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded-lg">
        Tambah Lab
    </a>

</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-slate-50">

        <tr>
            <th class="p-4 text-left">Nama Lab</th>
            <th class="p-4 text-left">Lokasi</th>
            <th class="p-4 text-left">Kapasitas</th>
            <th class="p-4 text-left">Status</th>
        </tr>

        </thead>

        <tbody>

        @forelse($labs as $lab)

        <tr class="border-t">

            <td class="p-4">
                {{ $lab->nama_lab }}
            </td>

            <td class="p-4">
                {{ $lab->lokasi }}
            </td>

            <td class="p-4">
                {{ $lab->kapasitas }}
            </td>

            <td class="p-4">

                @if($lab->status == 'aktif')

                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                        Aktif
                    </span>

                @else

                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">
                        Nonaktif
                    </span>

                @endif

            </td>

        </tr>

        @empty

        <tr>
            <td colspan="4" class="p-8 text-center text-slate-500">
                Belum ada data lab
            </td>
        </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection