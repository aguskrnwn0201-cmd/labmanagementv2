<!DOCTYPE html>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Lab</title>


@vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">


<!-- Sidebar -->
<aside class="w-64 bg-slate-900 text-white flex flex-col">

    <div class="p-6 border-b border-slate-700">
        <h1 class="text-xl font-bold">
            Management Lab
        </h1>
    </div>

    <nav class="p-4 space-y-2 flex-1">

        @if(session('role') == 'guru')

            <a href="{{ route('guru.dashboard') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Dashboard Guru
            </a>

            <a href="{{ route('jadwal.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Jadwal Lab
            </a>

            <a href="{{ route('booking.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Booking Lab
            </a>

            <a href="{{ route('laporan-kerusakan.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Laporan Kerusakan
            </a>

        @elseif(session('role') == 'siswa')

            <a href="{{ route('siswa.dashboard') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Dashboard Siswa
            </a>

            <a href="{{ route('jadwal.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Jadwal Lab
            </a>

            <a href="{{ route('laporan-kerusakan.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Laporan Kerusakan
            </a>

        @elseif(session('role') == 'teknisi')

            <a href="{{ route('dashboard') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Dashboard
            </a>

            <a href="{{ route('kalender.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Kalender
            </a>

            <a href="{{ route('labs.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Data Lab
            </a>

            <a href="{{ route('jadwal.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Jadwal
            </a>

            <a href="{{ route('booking.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Booking
            </a>

            <a href="{{ route('laporan-kerusakan.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Laporan Kerusakan
            </a>

        @endif

    </nav>

    @if(session()->has('role'))

    <div class="p-4 border-t border-slate-700">

        <form action="{{ route('role.logout') }}"
              method="POST">

            @csrf

            <button
                type="submit"
                class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700">

                Logout

            </button>

        </form>

    </div>

    @endif

</aside>

<!-- Main -->
<main class="flex-1">

    <header class="bg-white shadow-sm p-5">
        <h2 class="text-xl font-semibold">
            Sistem Manajemen Laboratorium
        </h2>
    </header>

    <section class="p-6">
        @yield('content')
    </section>

</main>


</div>

</body>
</html>

</div>

</body>
</html>