<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use App\Models\User;
use App\Models\FoodBlog;
use App\Models\Umkm;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Hitung total UMKM per bulan tahun ini
        $umkmPerBulan = Umkm::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month'); // pluck(value, key)

        // Siapkan array 12 bulan agar chart selalu tampil 12 bulan
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $umkmPerBulan->get($i) ?? 0;
        }

        // Label bulan
        $chartLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        return view('admin.dashboard', [
            'totalUmkm' => User::where('role', 'umkm')->count(),
            'totalMenu' => Makanan::count(),
            'totalBlog' => FoodBlog::count(),
            'chartData' => $chartData,
            'chartLabels' => $chartLabels
        ]);
    }
}
