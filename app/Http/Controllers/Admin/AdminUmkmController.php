<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;

class AdminUmkmController extends Controller
{
    public function index()
    {
        $umkms = Umkm::latest()->paginate(10);
        return view('admin.umkm.index', compact('umkms'));
    }

    public function create()
    {
        return view('admin.umkm.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_umkm'       => 'required|string|max:255',
            'nama_pemilik'    => 'required|string|max:255',
            'deskripsi'       => 'required',
            'nomor_whatsapp'  => 'required',
            'alamat'          => 'required',
            'logo_url'        => 'required|url',
        ]);

        Umkm::create($data);

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil ditambahkan');
    }

    public function edit($id)
    {
        $umkm = Umkm::findOrFail($id);
        return view('admin.umkm.edit', compact('umkm'));
    }

    public function update(Request $request, Umkm $umkm)
    {
        $data = $request->validate([
            'nama_umkm'       => 'required|string|max:255',
            'nama_pemilik'    => 'required|string|max:255',
            'deskripsi'       => 'required',
            'nomor_whatsapp'  => 'required',
            'alamat'          => 'required',
            'logo_url'        => 'required|url',
        ]);

        $umkm->update($data);

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil diperbarui');
    }

    public function destroy(Umkm $umkm)
    {
        $umkm->delete();

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil dihapus');
    }
}
