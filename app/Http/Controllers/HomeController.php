<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Models\Umkm;
use App\Models\Slider;
use App\Models\FoodBlog;
use Illuminate\Http\Request;

class HomeController extends Controller
{


public function index()
{
    $sliderFood = Slider::latest()->get();
    $listUmkm   = Umkm::with('makanans')->get();
    $menuPopuler = Makanan::latest()->take(4)->get();
    $blogs = FoodBlog::where('status', 'published')->latest()->take(3)->get();

    return view('welcome', compact(
        'sliderFood',
        'listUmkm',
        'menuPopuler',
        'blogs'
    ));
}
}
