@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">
        Tambah Inventaris
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

    <form action="{{ route('inventaris.store') }}"
          method="POST">

        @csrf

        <div class="grid grid-cols-2 gap-4">

            <div>

                <label>Lab</label>

                <select
                    name="lab_id"
                    class="w-full border rounded p-2">

                    <option value="">
                        Pilih Lab
                    </option>

                    @foreach($labs as $lab)

                        <option value="{{ $lab->id }}">

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
                    class="w-full border rounded p-2">

            </div>

            <div>

                <label>Jumlah</label>

                <input
                    type="number"
                    name="jumlah"
                    min="1"
                    class="w-full border rounded p-2">

            </div>

            <div>

                <label>Kondisi</label>

                <select
                    name="kondisi"
                    class="w-full border rounded p-2">

                    <option value="Baik">
                        Baik
                    </option>

                    <option value="Rusak Ringan">
                        Rusak Ringan
                    </option>

                    <option value="Rusak Berat">
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
                class="w-full border rounded p-2"></textarea>

        </div>

        <div class="mt-6">

            <button
                type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded">

                Simpan Inventaris

            </button>

        </div>

    </form>

</div>

@endsection