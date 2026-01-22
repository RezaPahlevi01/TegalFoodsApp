<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;

class MitraUmkmController extends Controller
{
    public function index()
    {
        $mitra = Umkm::latest()->get();
        return view('pages.mitra-umkm.index', compact('mitra'));
    }

    public function search(Request $request)
    {
        $q = $request->q;

        $mitra = Umkm::when($q, function ($query) use ($q) {
            $query->where('nama_umkm', 'like', "%{$q}%");
        })->latest()->get();

        return view('partials.list', compact('mitra'));
    }
}
