@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold">
        Laporan Inventaris
    </h1>

    <a href="{{ route('laporan.inventaris.excel') }}"
   style="
        background:#16a34a;
        color:white;
        padding:10px 16px;
        border-radius:8px;
        text-decoration:none;
        font-weight:bold;
   ">

    📊 Export Excel

</a>

</div>

@foreach($labs as $lab)

<div class="bg-white rounded-xl shadow mb-6">

    <div class="border-b px-6 py-4">

        <h2 class="text-xl font-semibold">
            {{ $lab->nama_lab }}
        </h2>

    </div>

    <div class="p-6">

        <table class="w-full">

            <thead>

                <tr class="border-b">

                    <th class="text-left p-3">
                        Nama Barang
                    </th>

                    <th class="text-left p-3">
                        Jumlah
                    </th>

                    <th class="text-left p-3">
                        Kondisi
                    </th>

                    <th class="text-left p-3">
                        Keterangan
                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($lab->inventaris as $item)

                <tr class="border-b">

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

                </tr>

            @empty

                <tr>

                    <td colspan="4"
                        class="p-6 text-center text-gray-500">

                        Tidak ada inventaris

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endforeach

@endsection