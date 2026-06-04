@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Edit Booking
</h1>

@if ($errors->any())

<div class="bg-red-100 text-red-700 p-4 rounded mb-4">

```
<ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</ul>
```

</div>

@endif

<form action="{{ route('booking.update', $booking->id) }}"
      method="POST"
      class="bg-white p-6 rounded-xl shadow">

```
@csrf
@method('PUT')

<div class="mb-4">

    <label class="block mb-1">
        Lab
    </label>

    <select name="lab_id"
            class="w-full border rounded p-2">

        @foreach($labs as $lab)

            <option value="{{ $lab->id }}"
                {{ $booking->lab_id == $lab->id ? 'selected' : '' }}>
                {{ $lab->nama_lab }}
            </option>

        @endforeach

    </select>

</div>

<div class="mb-4">

    <label class="block mb-1">
        Nama Pemohon
    </label>

    <input type="text"
           name="nama_pemohon"
           value="{{ old('nama_pemohon', $booking->nama_pemohon) }}"
           class="w-full border rounded p-2">

</div>

<div class="mb-4">

    <label class="block mb-1">
        Tanggal
    </label>

    <input type="date"
           name="tanggal_booking"
           value="{{ old('tanggal_booking', $booking->tanggal_booking) }}"
           class="w-full border rounded p-2">

</div>

<div class="mb-4">

    <label class="block mb-1">
        Jam Mulai
    </label>

    <input type="time"
           name="jam_mulai"
           value="{{ substr($booking->jam_mulai,0,5) }}"
           class="w-full border rounded p-2">

</div>

<div class="mb-4">

    <label class="block mb-1">
        Jam Selesai
    </label>

    <input type="time"
           name="jam_selesai"
           value="{{ substr($booking->jam_selesai,0,5) }}"
           class="w-full border rounded p-2">

</div>

<div class="mb-4">

    <label class="block mb-1">
        Keperluan
    </label>

    <textarea name="keperluan"
              class="w-full border rounded p-2">{{ old('keperluan', $booking->keperluan) }}</textarea>

</div>

<button type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded">

    Update Booking

</button>
```

</form>

@endsection
