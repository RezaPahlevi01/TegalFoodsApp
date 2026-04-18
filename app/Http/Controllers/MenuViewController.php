<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class MenuViewController extends Controller
{
    public function store(Request $request, Makanan $makanan, AnalyticsService $analytics)
    {
        $analytics->trackMenuView($makanan, $request);

        return response()->noContent();
    }
}
