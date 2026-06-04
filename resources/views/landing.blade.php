<!DOCTYPE html>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Laboratorium</title>

```
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

</head>

<body class="bg-slate-100">

<div class="min-h-screen flex items-center justify-center p-6">

```
<div class="max-w-5xl w-full">

    <div class="text-center mb-12">

        <h1 class="text-5xl font-bold text-slate-800">
            Sistem Manajemen Laboratorium
        </h1>

        <p class="text-slate-500 mt-4 text-lg">
            Pilih akses sesuai peran Anda
        </p>

    </div>

    <div class="grid md:grid-cols-3 gap-8">

        <!-- Teknisi -->

        <a href="/dashboard"
           class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition">

            <div class="text-5xl mb-4">
                🛠️
            </div>

            <h2 class="text-2xl font-bold mb-2">
                Teknisi
            </h2>

            <p class="text-slate-500">
                Kelola laboratorium, jadwal, booking, dan laporan kerusakan.
            </p>

        </a>

        <!-- Guru -->

        <a href="/guru"
           class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition">

            <div class="text-5xl mb-4">
                👨‍🏫
            </div>

            <h2 class="text-2xl font-bold mb-2">
                Guru
            </h2>

            <p class="text-slate-500">
                Lihat jadwal laboratorium dan lakukan booking penggunaan lab.
            </p>

        </a>

        <!-- Siswa -->

        <a href="/siswa"
           class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition">

            <div class="text-5xl mb-4">
                👨‍🎓
            </div>

            <h2 class="text-2xl font-bold mb-2">
                Siswa
            </h2>

            <p class="text-slate-500">
                Lihat jadwal laboratorium dan laporkan kerusakan fasilitas.
            </p>

        </a>

    </div>

    <div class="text-center mt-12 text-slate-400">

        © {{ date('Y') }}
        Sistem Manajemen Laboratorium

    </div>

</div>
```

</div>

</body>
</html>
