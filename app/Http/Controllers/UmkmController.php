<?php
namespace App\Http\Controllers;

use App\Models\Umkm; // <-- Import Model
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index()
    {
        $dataUmkm = Umkm::with('makanans')->get();

        $allFood = $dataUmkm->flatMap(function ($umkm) {
            return $umkm->makanans;
        });

        return view('welcome', [
            'listUmkm' => $dataUmkm,
            'sliderFood' => $allFood 
        ]);
    }

    public function show($id)
    {
        // Cari UMKM berdasarkan ID, 
        // ambil juga relasi makanannya (eager loading)
        // 'findOrFail' akan otomatis error 404 jika ID tidak ditemukan
        $umkm = Umkm::with('makanans')->findOrFail($id);

        // Kirim data UMKM tunggal itu ke view baru
        return view('pages.mitra-umkm.umkm-detail', [
            'umkm' => $umkm
        ]);
    }
}