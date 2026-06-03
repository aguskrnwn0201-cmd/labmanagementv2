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
    <aside class="w-64 bg-slate-900 text-white">

        <div class="p-6 border-b border-slate-700">
            <h1 class="text-xl font-bold">
                Management Lab
            </h1>
        </div>

        <nav class="p-4 space-y-2">

           <a href="{{ route('dashboard') }}"
   class="block px-4 py-2 hover:bg-blue-800 rounded">
    Dashboard
</a>

            <a href="/labs"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Data Lab
            </a>

          <a href="{{ route('jadwal.index') }}"
   class="block px-4 py-2 hover:bg-blue-800 rounded">
    Jadwal
</a>

            <a href="/booking"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Booking
            </a>

        </nav>

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