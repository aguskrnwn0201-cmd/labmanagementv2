@extends('layouts.app')

@section('content')

<div class="flex justify-between mb-6">


<h1 class="text-3xl font-bold">
    Laporan Kerusakan
</h1>

<a href="{{ route('laporan-kerusakan.create') }}"
   class="bg-red-600 text-white px-4 py-2 rounded">
    Buat Laporan
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

        <th class="p-3 text-left">Pelapor</th>
        <th class="p-3 text-left">Role</th>
        <th class="p-3 text-left">Lab</th>
        <th class="p-3 text-left">Kerusakan</th>
        <th class="p-3 text-left">Status</th>
        <th class="p-3 text-left">Aksi</th>

    </tr>

</thead>

<tbody>

@forelse($laporans as $laporan)

    <tr class="border-b">

        <td class="p-3">
            {{ $laporan->nama_pelapor }}
        </td>

        <td class="p-3">
            {{ ucfirst($laporan->role_pelapor) }}
        </td>

        <td class="p-3">
            {{ $laporan->lab->nama_lab }}
        </td>

        <td class="p-3">
            {{ $laporan->jenis_kerusakan }}
        </td>

        <td class="p-3">

<td class="p-3">


@if($laporan->status == 'pending')

    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
        Pending
    </span>

@elseif($laporan->status == 'diproses')

    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded">
        Diproses
    </span>

@else

    <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
        Selesai
    </span>

@endif


</td>

<td class="p-3">


<a href="{{ route('laporan-kerusakan.show', $laporan->id) }}"
   class="bg-blue-600 text-white px-3 py-1 rounded">

    Detail

</a>


</td>


        </td>

    </tr>

@empty

    <tr>

        <td colspan="6"
            class="text-center p-6 text-gray-500">

            Belum ada laporan

        </td>

    </tr>

@endforelse

</tbody>


</table>

@endsection
