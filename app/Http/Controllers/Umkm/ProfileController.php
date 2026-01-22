<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Umkm;

class ProfileController extends Controller
{
    public function create()
    {
        return view('umkm.profile.create');
    }

    public function store(Request $request)
    {
        Umkm::create([
            'user_id' => Auth::id(),
            'nama_umkm' => $request->nama_umkm,
            'nama_pemilik' => $request->nama_pemilik,
            'deskripsi' => $request->deskripsi,
            'nomor_whatsapp' => $request->nomor_whatsapp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('umkm.dashboard')
            ->with('success','Profil toko berhasil dibuat');
    }
}
