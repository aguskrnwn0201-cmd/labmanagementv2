@extends('layouts.app')

@section('content')

<div class="flex justify-between mb-6">

    <h1 class="text-3xl font-bold">
        Inventaris Lab
    </h1>

    <a href="{{ route('inventaris.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded">

        Tambah Inventaris

    </a>

</div>

@if(session('success'))

<div class="bg-green-100 text-green-700 p-3 rounded mb-4">

    {{ session('success') }}

</div>

@endif

<table class="w-full bg-white rounded-xl shadow">

    <thead>

        <tr class="border-b">

            <th class="p-3">Lab</th>
            <th class="p-3">Nama Barang</th>
            <th class="p-3">Jumlah</th>
            <th class="p-3">Kondisi</th>
            <th class="p-3">Keterangan</th>
            <th class="p-3">Aksi</th>

        </tr>

    </thead>

    <tbody>

    @forelse($inventaris as $item)

        <tr class="border-b">

            <td class="p-3">
                {{ $item->lab->nama_lab }}
            </td>

            <td class="p-3">
                {{ $item->nama_barang }}
            </td>

            <td class="p-3">
                {{ $item->jumlah }}
            </td>

            <td class="p-3">

                @if($item->kondisi == 'Baik')

                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                        Baik
                    </span>

                @elseif($item->kondisi == 'Rusak Ringan')

                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                        Rusak Ringan
                    </span>

                @else

                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded">
                        Rusak Berat
                    </span>

                @endif

            </td>

            <td class="p-3">
                {{ $item->keterangan }}
            </td>

            <td class="p-3">

                <div class="flex gap-2">

                    <a href="{{ route('inventaris.edit', $item->id) }}"
                       class="bg-yellow-500 text-white px-3 py-1 rounded">

                        Edit

                    </a>

                    <form
                        action="{{ route('inventaris.destroy', $item->id) }}"
                        method="POST"
                        onsubmit="return confirm('Hapus data inventaris ini?')">

                        @csrf
                        @method('DELETE')

                        <button
                            class="bg-red-600 text-white px-3 py-1 rounded">

                            Hapus

                        </button>

                    </form>

                </div>

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="6"
                class="p-6 text-center text-gray-500">

                Belum ada data inventaris

            </td>

        </tr>

    @endforelse

    </tbody>

</table>

@endsection