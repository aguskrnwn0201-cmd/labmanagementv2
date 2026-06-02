<?php

namespace App\Http\Controllers;

class GuruController extends Controller
{
    public function dashboard()
    {
        session(['role' => 'guru']);

        return view('guru.dashboard');
    }
}