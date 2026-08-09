<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use App\Models\Umkm;

class AdminWartegImageCleanupController extends Controller
{
    public function __invoke()
    {
        $umkm = Umkm::where('nama_umkm', 'like', '%warteg%')
            ->whereHas('user', fn ($q) => $q->where('name', 'like', '%SITI NURHIDAYAH%'))
            ->first();

        if (!$umkm) {
            return response()->json(['error' => 'UMKM warteg tidak ditemukan'], 404);
        }

        $updated = Makanan::where('umkm_id', $umkm->id)
            ->whereNotNull('gambar_url')
            ->update(['gambar_url' => null]);

        return response()->json([
            'message' => "Berhasil reset {$updated} gambar_url ke null"
        ]);
    }
}
