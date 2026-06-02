<?php

namespace App\Http\Controllers;

class SiswaController extends Controller
{
    public function dashboard()
    {
        session(['role' => 'siswa']);

        return view('siswa.dashboard');
    }
}