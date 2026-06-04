@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Detail Laporan Kerusakan
</h1>

@if(session('success'))

<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
    {{ session('success') }}
</div>

@endif

<div class="bg-white rounded-xl shadow p-6">

```
<p>
    <strong>Pelapor:</strong>
    {{ $laporan_kerusakan->nama_pelapor }}
</p>

<p class="mt-3">
    <strong>Role:</strong>
    {{ ucfirst($laporan_kerusakan->role_pelapor) }}
</p>

<p class="mt-3">
    <strong>Lab:</strong>
    {{ $laporan_kerusakan->lab->nama_lab }}
</p>

<p class="mt-3">
    <strong>Kerusakan:</strong>
    {{ $laporan_kerusakan->jenis_kerusakan }}
</p>

<p class="mt-3">
    <strong>Deskripsi:</strong>
    {{ $laporan_kerusakan->deskripsi }}
</p>

<hr class="my-6">

<form
    action="{{ route(
        'laporan-kerusakan.update',
        $laporan_kerusakan->id
    ) }}"
    method="POST">

    @csrf
    @method('PUT')

    <label class="block mb-2">
        Status
    </label>

    <select
        name="status"
        class="border rounded p-2">

        <option value="pending"
            {{ $laporan_kerusakan->status == 'pending' ? 'selected' : '' }}>
            Pending
        </option>

        <option value="diproses"
            {{ $laporan_kerusakan->status == 'diproses' ? 'selected' : '' }}>
            Diproses
        </option>

        <option value="selesai"
            {{ $laporan_kerusakan->status == 'selesai' ? 'selected' : '' }}>
            Selesai
        </option>

    </select>

    <button
        class="bg-green-600 text-white px-4 py-2 rounded ml-2">

        Simpan Status

    </button>

</form>
```

</div>

@endsection
