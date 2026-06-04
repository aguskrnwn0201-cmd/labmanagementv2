<?php

namespace App\Http\Controllers;

class TeknisiController extends Controller
{
    public function dashboard()
    {
        session([
    'role' => 'teknisi'
]);
        return view('teknisi.dashboard');
    }
}