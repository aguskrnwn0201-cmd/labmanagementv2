<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">
                    Jadwal Lab
                </h1>

                <a href="{{ route('jadwal.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded">
                    + Tambah Jadwal
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded shadow overflow-hidden">

                <table class="w-full">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Lab</th>
                            <th class="p-3 text-left">Hari</th>
                            <th class="p-3 text-left">Jam</th>
                            <th class="p-3 text-left">Mapel</th>
                            <th class="p-3 text-left">Guru</th>
                            <th class="p-3 text-left">Kelas</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($jadwals as $jadwal)

                        <tr class="border-t">

                            <td class="p-3">
                                {{ $jadwal->lab->nama_lab }}
                            </td>

                            <td class="p-3">
                                {{ $jadwal->hari }}
                            </td>

                            <td class="p-3">
                                {{ $jadwal->jam_mulai }}
                                -
                                {{ $jadwal->jam_selesai }}
                            </td>

                            <td class="p-3">
                                {{ $jadwal->mata_pelajaran }}
                            </td>

                            <td class="p-3">
                                {{ $jadwal->guru }}
                            </td>

                            <td class="p-3">
                                {{ $jadwal->kelas }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="p-5 text-center">
                                Belum ada jadwal
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>
</x-app-layout>