<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use App\Models\Umkm;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminWartegImageController extends Controller
{
    private array $images = [
        'Ayam Goreng'              => 'https://images.unsplash.com/photo-1562967916-eb82221dfb92?w=600',
        'Ayam Bacem'               => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=600',
        'Ayam Bakar'               => 'https://images.unsplash.com/photo-1606728035253-49e8a23146de?w=600',
        'Ikan Goreng'              => 'https://images.unsplash.com/photo-1580217593608-61931cefc821?w=600',
        'Ikan Asin Goreng'         => 'https://images.unsplash.com/photo-1534766555764-ce878a9398cd?w=600',
        'Sambal Goreng Tempe'      => 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=600',
        'Tempe Goreng'             => 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=600',
        'Tahu Goreng'              => 'https://images.unsplash.com/photo-1541592106381-b31e9677c0e4?w=600',
        'Tahu Tempe Bacem'         => 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=600',
        'Telur Dadar'              => 'https://images.unsplash.com/photo-1510693206972-df098062cb71?w=600',
        'Telur Balado'             => 'https://images.unsplash.com/photo-1482049016688-2d3e1b311543?w=600',
        'Telur Ceplok Balado'      => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=600',
        'Perkedel Kentang'         => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600',
        'Sambal Goreng Kentang'    => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600',
        'Kepala Ikan Bumbu Kuning' => 'https://images.unsplash.com/photo-1534766555764-ce878a9398cd?w=600',
        'Jengkol Balado'           => 'https://images.unsplash.com/photo-1563379926898-05f4575a45d8?w=600',
        'Paru Goreng'              => 'https://images.unsplash.com/photo-1529692236671-f1f6cf9683ba?w=600',
        'Oseng-oseng Kikil'        => 'https://images.unsplash.com/photo-1547592180-85f173990554?w=600',
        'Sayur Asem'               => 'https://images.unsplash.com/photo-1547592180-85f173990554?w=600',
        'Sayur Lodeh'              => 'https://images.unsplash.com/photo-1547592180-85f173990554?w=600',
        'Sayur Bayam'              => 'https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=600',
        'Sayur Nangka'             => 'https://images.unsplash.com/photo-1547592180-85f173990554?w=600',
        'Tumis Kangkung'           => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=600',
        'Tumis Tauge'              => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=600',
        'Gado-gado'                => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=600',
        'Nasi Putih'               => 'https://images.unsplash.com/photo-1516684732162-798a0062be99?w=600',
        'Sambal Terasi'            => 'https://images.unsplash.com/photo-1455813870877-04a32045af63?w=600',
        'Lalapan'                  => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=600',
        'Kerupuk'                  => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=600',
        'Mie Goreng'               => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=600',
        'Bakmi Godog'              => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=600',
        'Es Teh Manis'             => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600',
        'Es Jeruk'                 => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?w=600',
        'Es Kelapa Muda'           => 'https://images.unsplash.com/photo-1536657464919-892534f60d6e?w=600',
        'Kopi Hitam'               => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=600',
    ];

    public function upload()
    {
        $umkm = Umkm::where('nama_umkm', 'like', '%warteg%')
            ->whereHas('user', fn ($q) => $q->where('name', 'like', '%SITI NURHIDAYAH%'))
            ->first();

        if (!$umkm) {
            return response()->json(['error' => 'UMKM warteg tidak ditemukan'], 404);
        }

        $cloudinary = app(CloudinaryService::class);
        $products = Makanan::where('umkm_id', $umkm->id)->whereNull('gambar_url')->get();
        $results = ['success' => 0, 'failed' => 0, 'details' => []];

        foreach ($products as $product) {
            if (!isset($this->images[$product->nama_makanan])) {
                continue;
            }

            $url = $this->images[$product->nama_makanan];
            $response = Http::timeout(30)->get($url);

            if (!$response->successful()) {
                $results['failed']++;
                $results['details'][] = "FAIL download: {$product->nama_makanan}";
                continue;
            }

            $ext = 'jpg';
            $contentType = $response->header('Content-Type');
            if (str_contains($contentType, 'png')) {
                $ext = 'png';
            }

            $tempFile = tempnam(sys_get_temp_dir(), 'warteg_') . '.' . $ext;
            file_put_contents($tempFile, $response->body());

            $uploadedFile = new \Illuminate\Http\UploadedFile(
                $tempFile,
                "warteg_{$product->id}.{$ext}",
                $contentType,
                null,
                true
            );

            $imagePath = $cloudinary->upload($uploadedFile, 'warteg');

            if ($imagePath) {
                $product->update(['gambar_url' => $imagePath]);
                $results['success']++;
                $results['details'][] = "OK: {$product->nama_makanan}";
            } else {
                $results['failed']++;
                $results['details'][] = "FAIL upload: {$product->nama_makanan}";
            }

            @unlink($tempFile);
            usleep(200000);
        }

        return response()->json($results);
    }
}
