<?php

namespace App\Http\Controllers;

use App\Models\FoodBlog;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // PAGE LIST BLOG
    public function index(Request $request, AnalyticsService $analytics)
    {
        $analytics->trackWebVisit($request, 'blog-index');

        $blogs = FoodBlog::where('status', 'published')->latest()->paginate(9);
        return view('blog.index', compact('blogs'));
    }

    // PAGE DETAIL BLOG
    public function show(Request $request, $slug, AnalyticsService $analytics)
    {
        $blog = FoodBlog::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $analytics->trackWebVisit($request, 'blog:' . $blog->slug);
        $analytics->trackArticleView($blog, $request);

        return view('blog.show', compact('blog'));
    }
}
