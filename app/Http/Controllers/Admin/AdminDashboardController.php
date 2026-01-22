<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\Makanan;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUmkm'  => Umkm::count(),
            'totalMenu'  => class_exists(Makanan::class) ? Makanan::count() : 0,
            'totalAdmin' => User::where('role', 'admin')->count(),
        ]);
    }
}
