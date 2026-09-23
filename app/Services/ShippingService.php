<?php

namespace App\Services;

use App\Models\ShippingSetting;
use Illuminate\Support\Facades\Log;

class ShippingService
{
    private RoutingService $routing;

    public function __construct(RoutingService $routing)
    {
        $this->routing = $routing;
    }

    /**
     * Hitung ongkir berdasarkan jarak jalan aktual (ORS).
     *
     * @return array{ongkir: float, distance_km: float, duration_minutes: float, error: string|null}
     */
    public function calculate(
        float $originLat,
        float $originLon,
        float $destLat,
        float $destLon
    ): array {
        $settings = ShippingSetting::instance();

        $route = $this->routing->getRoute($originLat, $originLon, $destLat, $destLon);

        if ($route === null) {
            return [
                'ongkir'            => 0,
                'distance_km'       => 0,
                'duration_minutes'  => 0,
                'error'             => 'Gagal menghitung jarak. Silakan pilih metode ambil di toko (Pick Up) atau coba lagi nanti.',
            ];
        }

        $distanceKm = $route['distance_km'];
        $duration   = $route['duration_minutes'];

        $ongkir = $settings->base_fare + ($distanceKm * $settings->price_per_km);
        $ongkir = max($ongkir, $settings->minimum_fare);
        $ongkir = min($ongkir, $settings->maximum_fare);

        if ($settings->rounding > 0) {
            $ongkir = ceil($ongkir / $settings->rounding) * $settings->rounding;
        }

        $ongkir = (float) number_format($ongkir, 0, '.', '');

        return [
            'ongkir'            => $ongkir,
            'distance_km'       => $distanceKm,
            'duration_minutes'  => $duration,
            'error'             => null,
        ];
    }

    /**
     * Hitung ongkir tanpa API (untuk admin preview).
     */
    public function calculateFromDistance(float $distanceKm): float
    {
        $settings = ShippingSetting::instance();

        $ongkir = $settings->base_fare + ($distanceKm * $settings->price_per_km);
        $ongkir = max($ongkir, $settings->minimum_fare);
        $ongkir = min($ongkir, $settings->maximum_fare);

        if ($settings->rounding > 0) {
            $ongkir = ceil($ongkir / $settings->rounding) * $settings->rounding;
        }

        return (float) number_format($ongkir, 0, '.', '');
    }
}
