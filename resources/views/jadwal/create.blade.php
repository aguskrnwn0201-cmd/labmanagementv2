@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">
        Tambah Jadwal
    </h1>

    <script>
    document.querySelectorAll('input[name="semester"]').forEach((radio) => {
        radio.addEventListener('change', (e) => {
            document.querySelectorAll('label').forEach(el => el.classList.remove('bg-blue-100', 'border-blue-500'));
            e.target.parentElement.classList.add('bg-blue-100', 'border-blue-500');
        });
    });
</script>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jadwal.store') }}" method="POST">

        @csrf

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label>Lab</label>
                <select name="lab_id" class="w-full border rounded p-2">
                    <option value="">Pilih Lab</option>

                    @foreach($labs as $lab)
                        <option value="{{ $lab->id }}">
                            {{ $lab->nama_lab }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Hari</label>
                <select name="hari" class="w-full border rounded p-2">
                    <option>Senin</option>
                    <option>Selasa</option>
                    <option>Rabu</option>
                    <option>Kamis</option>
                    <option>Jumat</option>
                    <option>Sabtu</option>
                </select>
            </div>

            <div>
                <label>Jam Mulai</label>
                <input type="time"
                       name="jam_mulai"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label>Jam Selesai</label>
                <input type="time"
                       name="jam_selesai"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label>Mata Pelajaran</label>
                <input type="text"
                       name="mata_pelajaran"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label>Guru</label>
                <input type="text"
                       name="guru"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label>Kelas</label>
                <input type="text"
                       name="kelas"
                       class="w-full border rounded p-2">
            </div>

           <div class="mb-4">
    <label class="block font-semibold">Lembaga</label>
    <input type="text" name="lembaga" class="w-full border rounded p-2" placeholder="Contoh: SMK Negeri 1" required>
</div>

<div class="mb-4">
    <label class="block font-semibold mb-2">Semester</label>
    <div class="flex gap-4">
        <label class="flex items-center gap-2 cursor-pointer bg-gray-100 px-4 py-2 rounded-lg border hover:bg-blue-50">
            <input type="radio" name="semester" value="Ganjil" class="w-4 h-4" checked>
            Ganjil
        </label>
        <label class="flex items-center gap-2 cursor-pointer bg-gray-100 px-4 py-2 rounded-lg border hover:bg-blue-50">
            <input type="radio" name="semester" value="Genap" class="w-4 h-4">
            Genap
        </label>
    </div>
</div>

        </div>

        <div class="mt-6">
            <button
                type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded">

                Simpan Jadwal

            </button>
        </div>

    </form>

</div>

@endsection