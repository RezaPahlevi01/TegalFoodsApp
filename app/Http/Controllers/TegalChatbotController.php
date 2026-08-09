<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class TegalChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        $message = strtolower(trim($validated['message']));

        try {
            $response = Http::timeout(15)
                ->acceptJson()
                ->post(env('FLASK_CHATBOT_URL', 'http://127.0.0.1:5000/chat'), [
                    'message' => $message,
                ]);

            if ($response->successful()) {
                $payload = $response->json();
                $reply = $payload['reply']
                    ?? $payload['response']
                    ?? $payload['answer']
                    ?? null;

                if (filled($reply)) {
                    return response()->json([
                        'reply' => $reply,
                        'source' => 'flask',
                    ]);
                }
            }
        } catch (Throwable) {
            // Fallback ke respons lokal agar chat tidak error total saat Flask mati.
        }

        return response()->json([
            'reply' => $this->fallbackReply($message),
            'source' => 'laravel-fallback',
        ]);
    }

    public function context()
    {
        return response()->json($this->buildContext());
    }

    private function fallbackReply(string $message): string
    {
        $products = Makanan::with('umkm')
            ->available()
            ->when(
                str_contains($message, 'murah') || str_contains($message, 'hemat'),
                fn ($query) => $query->orderBy('harga'),
                fn ($query) => $query->latest()
            )
            ->take(3)
            ->get();

        if ($products->isNotEmpty() && (
            str_contains($message, 'makan')
            || str_contains($message, 'kuliner')
            || str_contains($message, 'rekomendasi')
            || str_contains($message, 'murah')
            || str_contains($message, 'hemat')
        )) {
            $reply = "Saya belum bisa mengambil jawaban NLP dari Flask, tapi ini rekomendasi dari data toko saat ini:\n\n";

            foreach ($products as $product) {
                $reply .= "- {$product->nama_makanan} ({$product->umkm?->nama_umkm})";
                $reply .= " - Rp" . number_format($product->harga, 0, ',', '.') . "\n";
            }

            return trim($reply);
        }

        return 'Server chatbot Flask belum merespons dengan benar. Pastikan API Flask aktif dan mengembalikan JSON dengan key seperti `reply`, `response`, atau `answer`.';
    }

    private function buildContext(): array
    {
        $stores = Umkm::with(['makanans' => fn ($query) => $query->available()->orderBy('harga')])
            ->whereHas('user', fn ($q) => $q->where('status', 'active'))
            ->latest()
            ->get()
            ->map(function (Umkm $umkm) {
                return [
                    'id' => $umkm->id,
                    'nama_umkm' => $umkm->nama_umkm,
                    'nama_pemilik' => $umkm->nama_pemilik,
                    'alamat' => $umkm->alamat,
                    'deskripsi' => $umkm->deskripsi,
                    'nomor_whatsapp' => $umkm->nomor_whatsapp,
                    'jam_buka' => $umkm->jam_buka ? $umkm->jam_buka->format('H:i') : null,
                    'jam_tutup' => $umkm->jam_tutup ? $umkm->jam_tutup->format('H:i') : null,
                    'is_open' => $umkm->isOpenNow(),
                    'products' => $umkm->makanans->map(function (Makanan $makanan) use ($umkm) {
                        return [
                            'id' => $makanan->id,
                            'nama_makanan' => $makanan->nama_makanan,
                            'kategori' => $makanan->kategori,
                            'harga' => $makanan->harga,
                            'deskripsi' => $makanan->deskripsi,
                            'umkm' => $umkm->nama_umkm,
                        ];
                    })->values()->all(),
                ];
            })
            ->values();

        $products = $stores
            ->flatMap(fn ($store) => $store['products'])
            ->sortBy('harga')
            ->values()
            ->all();

        return [
            'stores' => $stores->all(),
            'products' => $products,
            'open_stores' => $stores->where('is_open', true)->values()->all(),
        ];
    }
}
