<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    // ===============================
    // DASHBOARD UMKM
    // ===============================
    public function index()
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        // Jika belum buat profil
        if (!$umkm) {
            return redirect()->route('umkm.profile.create');
        }

        return view('mitra.dashboard', compact('umkm'));
    }

    // ===============================
    // FORM EDIT PROFILE
    // ===============================
    public function editProfile()
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        return view('mitra.profile.edit', compact('umkm'));
    }

    // ===============================
    // UPDATE PROFILE UMKM
    // ===============================
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        $request->validate([
            'nama_umkm' => 'required',
            'nama_pemilik' => 'required',
            'nomor_whatsapp' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'nullable',
            'logo_url' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // ===============================
        // UPLOAD LOGO
        // ===============================
        if ($request->hasFile('logo')) {

            // hapus logo lama
            if ($umkm->logo_url) {
                Storage::disk('public')->delete($umkm->logo_url);
            }

            // simpan logo baru
            $path = $request->file('logo')
                ->store('umkm/logo', 'public');

            $umkm->logo_url = $path;
        }

        // ===============================
        // UPDATE DATA UMKM
        // ===============================
        $umkm->update([
            'nama_umkm' => $request->nama_umkm,
            'nama_pemilik' => $request->nama_pemilik,
            'nomor_whatsapp' => $request->nomor_whatsapp,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('umkm.dashboard')
            ->with('success', 'Profil UMKM berhasil diperbarui');
    }
}
