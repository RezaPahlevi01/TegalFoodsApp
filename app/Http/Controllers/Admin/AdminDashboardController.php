<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use App\Models\User;
use App\Models\FoodBlog;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUmkm' => User::where('role', 'umkm')->count(),
            'totalMenu'  => class_exists(Makanan::class) ? Makanan::count() : 0,
            'totalBlog' => class_exists(FoodBlog::class) ? FoodBlog::count() : 0,
        ]);
    }
}
