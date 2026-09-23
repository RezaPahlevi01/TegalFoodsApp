<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RoutingService
{
    private string $apiKey;

    private string $baseUrl = 'https://api.openrouteservice.org/v2/directions/driving-car';

    public function __construct()
    {
        $this->apiKey = config('services.openrouteservice.key', '');
    }

    /**
     * Hitung jarak & durasi via ORS driving-car.
     *
     * @return array{distance_km: float, duration_minutes: float}|null
     */
    public function getRoute(
        float $originLat,
        float $originLon,
        float $destLat,
        float $destLon
    ): ?array {
        if (empty($this->apiKey)) {
            Log::error('RoutingService: OPENROUTESERVICE_API_KEY belum dikonfigurasi.');
            return null;
        }

        $coordinates = [
            [$originLon, $originLat],
            [$destLon, $destLat],
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
                'Content-Type'  => 'application/json',
            ])->timeout(15)->post($this->baseUrl, [
                'coordinates' => $coordinates,
            ]);

            if ($response->failed()) {
                Log::error('RoutingService: ORS API gagal.', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return null;
            }

            $data = $response->json();

            $segment = $data['routes'][0]['summary'] ?? null;

            if (!$segment) {
                Log::warning('RoutingService: Respons ORS tidak memiliki routes.', [
                    'response' => $data,
                ]);
                return null;
            }

            $distanceMeters = $segment['distance'] ?? 0;
            $durationSeconds = $segment['duration'] ?? 0;

            return [
                'distance_km'       => round($distanceMeters / 1000, 2),
                'duration_minutes'  => round($durationSeconds / 60, 1),
            ];
        } catch (\Throwable $e) {
            Log::error('RoutingService: Exception saat call ORS API.', [
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }
}
