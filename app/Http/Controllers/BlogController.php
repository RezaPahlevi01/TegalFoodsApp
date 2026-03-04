<?php

namespace App\Http\Controllers;

use App\Models\FoodBlog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // PAGE LIST BLOG
    public function index()
    {
        $blogs = FoodBlog::latest()->paginate(9);
        return view('blog.index', compact('blogs'));
    }

    // PAGE DETAIL BLOG
    public function show($slug)
    {
        $blog = FoodBlog::where('slug', $slug)->firstOrFail();
        return view('blog.show', compact('blog'));
    }
}