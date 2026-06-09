<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    
   public function store(Request $request)
{
    $request->validate([
        'username' => 'required|unique:users,username',
        'password' => 'required|min:6',
    ]);

    User::create([
        'name' => 'Teknisi', // Isi default nama
        'email' => $request->username . '@lab.local', // Ide: buat email dummy agar tidak null
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'role' => 'teknisi',
    ]);

    return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
}      
    }
