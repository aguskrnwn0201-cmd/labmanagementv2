<x-app-layout>

<div class="py-6">
<div class="max-w-4xl mx-auto px-4">

    <h1 class="text-2xl font-bold mb-6">
        Tambah Jadwal
    </h1>
    @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form method="POST"
          action="{{ route('jadwal.store') }}"
          class="bg-white p-6 rounded shadow">

        @csrf

        <div class="mb-4">
            <label>Lab</label>

            <select name="lab_id"
                    class="w-full border rounded p-2">

                @foreach($labs as $lab)

                    <option value="{{ $lab->id }}">
                        {{ $lab->nama_lab }}
                    </option>

                @endforeach

            </select>
        </div>

        <div class="mb-4">
            <label>Hari</label>

            <select name="hari"
                    class="w-full border rounded p-2">

                <option>Senin</option>
                <option>Selasa</option>
                <option>Rabu</option>
                <option>Kamis</option>
                <option>Jumat</option>
                <option>Sabtu</option>

            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">

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

        </div>

        <div class="mt-4">
            <label>Mata Pelajaran</label>

            <input type="text"
                   name="mata_pelajaran"
                   class="w-full border rounded p-2">
        </div>

        <div class="mt-4">
            <label>Guru</label>

            <input type="text"
                   name="guru"
                   class="w-full border rounded p-2">
        </div>

        <div class="mt-4">
            <label>Kelas</label>

            <input type="text"
                   name="kelas"
                   class="w-full border rounded p-2">
        </div>

        <div class="mt-4">
            <label>Semester</label>

            <input type="text"
                   name="semester"
                   class="w-full border rounded p-2">
        </div>

        <div class="mt-4">
            <label>Tahun Ajaran</label>

            <input type="text"
                   name="tahun_ajaran"
                   class="w-full border rounded p-2"
                   placeholder="2026/2027">
        </div>

        <button
            class="mt-6 bg-blue-600 text-white px-6 py-2 rounded">

            Simpan Jadwal

        </button>

    </form>

</div>
</div>

</x-app-layout>