@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Manajemen User (Teknisi)</h2>

    {{-- Form Tambah User --}}
    <div class="bg-white p-4 rounded border mb-6">
        <form action="{{ route('users.store') }}" method="POST">
    @csrf
    <div class="flex gap-4">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="bg-blue-600 text-white p-2 rounded">Tambah Teknisi</button>
    </div>
</form>
    </div>

    {{-- Tabel User --}}
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2">Username</th>
                <th class="p-2">Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="p-2 border">{{ $user->username }}</td>
                <td class="p-2 border">{{ $user->role }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection