<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleView;
use App\Models\FoodBlog;
use App\Models\Makanan;
use App\Models\Umkm;
use App\Models\UmkmView;
use App\Models\User;
use App\Models\WebVisit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $startDate = now()->subDays(6)->toDateString();
        $endDate = now()->toDateString();

        $dailyVisitors = WebVisit::select(
                'view_date',
                DB::raw('COUNT(DISTINCT session_id) as total')
            )
            ->whereBetween('view_date', [$startDate, $endDate])
            ->groupBy('view_date')
            ->orderBy('view_date')
            ->pluck('total', 'view_date');

        $dailyArticleReaders = ArticleView::select(
                'view_date',
                DB::raw('COUNT(DISTINCT session_id) as total')
            )
            ->whereBetween('view_date', [$startDate, $endDate])
            ->groupBy('view_date')
            ->orderBy('view_date')
            ->pluck('total', 'view_date');

        $chartLabels = [];
        $visitorChartData = [];
        $articleChartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $chartLabels[] = Carbon::parse($date)->translatedFormat('d M');
            $visitorChartData[] = $dailyVisitors->get($date) ?? 0;
            $articleChartData[] = $dailyArticleReaders->get($date) ?? 0;
        }

        $popularArticles = FoodBlog::query()
            ->leftJoin('article_views', 'food_blogs.id', '=', 'article_views.food_blog_id')
            ->select(
                'food_blogs.id',
                'food_blogs.title',
                DB::raw('COUNT(article_views.id) as total_views')
            )
            ->groupBy('food_blogs.id', 'food_blogs.title')
            ->orderByDesc('total_views')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'totalUmkm' => User::where('role', 'umkm')->count(),
            'totalMenu' => Makanan::count(),
            'totalBlog' => FoodBlog::count(),
            'totalWebVisitors' => WebVisit::distinct('session_id')->count('session_id'),
            'totalArticleViews' => ArticleView::count(),
            'totalStoreViews' => UmkmView::count(),
            'chartLabels' => $chartLabels,
            'visitorChartData' => $visitorChartData,
            'articleChartData' => $articleChartData,
            'popularArticlesLabels' => $popularArticles->pluck('title')->map(
                fn ($title) => str($title)->limit(24)->toString()
            )->all(),
            'popularArticlesData' => $popularArticles->pluck('total_views')->all(),
        ]);
    }
}
