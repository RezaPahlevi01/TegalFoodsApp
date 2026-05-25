<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Models\Umkm;
use App\Models\Slider;
use App\Models\FoodBlog;
use Illuminate\Http\Request;
use App\Services\AnalyticsService;

class HomeController extends Controller
{


public function index(Request $request, AnalyticsService $analytics)
{
    $analytics->trackWebVisit($request, 'home');

    $sliderFood = Slider::latest()->get();
    $listUmkm   = Umkm::with(['makanans' => fn ($query) => $query->available()])->get();
    $menuPopuler = Makanan::with('umkm')->available()->latest()->take(4)->get();
    $blogs = FoodBlog::where('status', 'published')->latest()->take(3)->get();

    return view('welcome', compact(
        'sliderFood',
        'listUmkm',
        'menuPopuler',
        'blogs'
    ));
}
}
