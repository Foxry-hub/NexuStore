<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('role', 'pelanggan')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        
        return view('admin.dashboard', compact('totalUsers', 'totalAdmin'));
    }
}
