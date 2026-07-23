<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Models\Umkm;
use App\Models\Slider;
use App\Models\FoodBlog;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\AnalyticsService;

class HomeController extends Controller
{


public function index()
{
    if(auth()->check()){
        return redirect()->route('dashboard');
    }

    $sliderFood = Slider::all();
    $blogs = FoodBlog::latest()->take(6)->get();

    return view('welcome', compact(
        'sliderFood',
        'blogs'
    ));
}

public function dashboard()
{
    $umkms = Umkm::whereHas('user', function ($q) {
        $q->where('status', 'active');
    })
    ->latest()
    ->get();

    $makanans = Makanan::with('umkm')
        ->where('is_available', true)
        ->latest()
        ->take(8)
        ->get();

    $blogs = FoodBlog::latest()
        ->take(3)
        ->get();

    $lastOrders = Order::where('user_id', auth()->id())
        ->latest()
        ->take(5)
        ->get();

    return view(
        'user.dashboard',
        compact(
            'umkms',
            'makanans',
            'blogs',
            'lastOrders'
        )
    );
}
}
