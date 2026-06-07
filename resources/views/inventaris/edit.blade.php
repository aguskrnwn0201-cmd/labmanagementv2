@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">
        Edit Inventaris
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

    <form
        action="{{ route('inventaris.update', ['inventaris' => $inventaris->id]) }}"
        method="POST">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">

            <div>

                <label>Lab</label>

                <select
                    name="lab_id"
                    class="w-full border rounded p-2">

                    @foreach($labs as $lab)

                        <option
                            value="{{ $lab->id }}"
                            {{ $inventaris->lab_id == $lab->id ? 'selected' : '' }}>

                            {{ $lab->nama_lab }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div>

                <label>Nama Barang</label>

                <input
                    type="text"
                    name="nama_barang"
                    value="{{ $inventaris->nama_barang }}"
                    class="w-full border rounded p-2">

            </div>

            <div>

                <label>Jumlah</label>

                <input
                    type="number"
                    name="jumlah"
                    value="{{ $inventaris->jumlah }}"
                    class="w-full border rounded p-2">

            </div>

            <div>

                <label>Kondisi</label>

                <select
                    name="kondisi"
                    class="w-full border rounded p-2">

                    <option
                        value="Baik"
                        {{ $inventaris->kondisi == 'Baik' ? 'selected' : '' }}>
                        Baik
                    </option>

                    <option
                        value="Rusak Ringan"
                        {{ $inventaris->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>
                        Rusak Ringan
                    </option>

                    <option
                        value="Rusak Berat"
                        {{ $inventaris->kondisi == 'Rusak Berat' ? 'selected' : '' }}>
                        Rusak Berat
                    </option>

                </select>

            </div>

        </div>

        <div class="mt-4">

            <label>Keterangan</label>

            <textarea
                name="keterangan"
                rows="4"
                class="w-full border rounded p-2">{{ $inventaris->keterangan }}</textarea>

        </div>

        <div class="mt-6">

            <button
                type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded">

                Update Inventaris

            </button>

        </div>

    </form>

</div>

@endsection