<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function dashboard()
    {
        return view('pelanggan.dashboard');
    }

    public function profile()
    {
        return view('pelanggan.profile');
    }
}
