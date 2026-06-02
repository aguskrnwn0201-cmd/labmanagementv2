<?php

namespace App\Http\Controllers;

class TeknisiController extends Controller
{
    public function dashboard()
    {
        return view('teknisi.dashboard');
    }
}