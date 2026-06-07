@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Laporan Inventaris
</h1>

<form method="GET" class="mb-6">

    <select
        name="lab_id"
        onchange="this.form.submit()"
        class="border rounded p-2">

        <option value="">
            Semua Lab
        </option>

        @foreach($labs as $lab)

            <option
                value="{{ $lab->id }}"
                {{ $labId == $lab->id ? 'selected' : '' }}>

                {{ $lab->nama_lab }}

            </option>

        @endforeach

    </select>

</form>

<table class="w-full bg-white shadow rounded">

    <thead>

        <tr class="border-b">

            <th class="p-3">Lab</th>
            <th class="p-3">Barang</th>
            <th class="p-3">Jumlah</th>
            <th class="p-3">Kondisi</th>
            <th class="p-3">Keterangan</th>

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
                {{ $item->kondisi }}
            </td>

            <td class="p-3">
                {{ $item->keterangan }}
            </td>

        </tr>

        @empty

        <tr>

            <td colspan="5"
                class="text-center p-6">

                Tidak ada data

            </td>

        </tr>

        @endforelse

    </tbody>

</table>

@endsection