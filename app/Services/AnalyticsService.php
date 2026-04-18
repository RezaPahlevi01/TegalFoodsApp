<?php

namespace App\Services;

use App\Models\ArticleView;
use App\Models\FoodBlog;
use App\Models\Makanan;
use App\Models\MenuView;
use App\Models\Umkm;
use App\Models\UmkmView;
use App\Models\WebVisit;
use Illuminate\Http\Request;
use Throwable;

class AnalyticsService
{
    public function trackWebVisit(Request $request, ?string $pageKey = null): void
    {
        $this->safeTrack(function () use ($request, $pageKey): void {
            WebVisit::firstOrCreate(
                [
                    'session_id' => $request->session()->getId(),
                    'page_key' => $pageKey ?? $request->path(),
                    'view_date' => now()->toDateString(),
                ],
                $this->buildMetadata($request)
            );
        });
    }

    public function trackArticleView(FoodBlog $blog, Request $request): void
    {
        $this->safeTrack(function () use ($blog, $request): void {
            ArticleView::firstOrCreate(
                [
                    'food_blog_id' => $blog->id,
                    'session_id' => $request->session()->getId(),
                    'view_date' => now()->toDateString(),
                ],
                $this->buildMetadata($request)
            );
        });
    }

    public function trackUmkmView(Umkm $umkm, Request $request): void
    {
        $this->safeTrack(function () use ($umkm, $request): void {
            UmkmView::firstOrCreate(
                [
                    'umkm_id' => $umkm->id,
                    'session_id' => $request->session()->getId(),
                    'view_date' => now()->toDateString(),
                ],
                $this->buildMetadata($request)
            );
        });
    }

    public function trackMenuView(Makanan $makanan, Request $request): void
    {
        $this->safeTrack(function () use ($makanan, $request): void {
            MenuView::firstOrCreate(
                [
                    'makanan_id' => $makanan->id,
                    'session_id' => $request->session()->getId(),
                    'view_date' => now()->toDateString(),
                ],
                [
                    'umkm_id' => $makanan->umkm_id,
                    ...$this->buildMetadata($request),
                ]
            );
        });
    }

    private function buildMetadata(Request $request): array
    {
        return [
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
        ];
    }

    private function safeTrack(callable $callback): void
    {
        try {
            $callback();
        } catch (Throwable) {
            // Analytics is optional; halaman utama tetap harus bisa dibuka.
        }
    }
}
