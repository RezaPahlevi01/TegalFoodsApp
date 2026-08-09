<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class MitraUmkmController extends Controller
{
    public function index(Request $request, AnalyticsService $analytics)
    {
        $analytics->trackWebVisit($request, 'mitra-umkm');

        $mitra = Umkm::with(['makanans' => fn ($query) => $query->available()])
            ->whereHas('user', fn ($q) => $q->where('status', 'active'))
            ->latest()->get();
        return view('pages.mitra-umkm.index', compact('mitra'));
    }

    public function search(Request $request)
    {
        $q = $request->q;

        $mitra = Umkm::with(['makanans' => fn ($query) => $query->available()])
            ->whereHas('user', fn ($q) => $q->where('status', 'active'))
            ->when($q, function ($query) use ($q) {
            $query->where('nama_umkm', 'like', "%{$q}%");
        })->latest()->get();

        return view('partials.list', compact('mitra'));
    }
}
