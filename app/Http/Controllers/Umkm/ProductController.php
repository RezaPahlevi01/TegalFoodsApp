<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private function currentUmkm()
    {
        return Auth::guard('umkm')->user()->umkm;
    }

    private function redirectIfNoUmkmProfile()
    {
        if (!$this->currentUmkm()) {
            return redirect()
                ->route('umkm.profile.edit')
                ->withErrors(['umkm' => 'Lengkapi profil UMKM terlebih dahulu.']);
        }

        return null;
    }

    // =============================
    // LIST PRODUK UMKM
    // =============================
    public function index()
    {
        if ($redirect = $this->redirectIfNoUmkmProfile()) {
            return $redirect;
        }

        $umkm = $this->currentUmkm();

        $products = Makanan::where('umkm_id', $umkm->id)->get();

        return view('mitra.products.index', compact('umkm', 'products'));
    }

    // =============================
    // FORM TAMBAH PRODUK
    // =============================
    public function create()
    {
        if ($redirect = $this->redirectIfNoUmkmProfile()) {
            return $redirect;
        }

        return view('mitra.products.create');
    }

    // =============================
    // SIMPAN PRODUK
    // =============================
    public function store(Request $request)
    {
        if ($redirect = $this->redirectIfNoUmkmProfile()) {
            return $redirect;
        }

        $request->validate([
            'nama_makanan' => 'required',
            'harga' => 'required',
            'gambar_url' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $gambar = null;

        if ($request->hasFile('gambar_url')) {
            $cloudinary = app(CloudinaryService::class);
            $gambar = $cloudinary->upload($request->file('gambar_url'), 'products');
        }

        Makanan::create([
            'umkm_id' => $this->currentUmkm()->id,
            'nama_makanan' => $request->nama_makanan,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar_url' => $gambar,
            'is_available' => $request->boolean('is_available', true),
        ]); 

        return redirect()->route('umkm.products.index')
            ->with('success','Produk berhasil ditambahkan');
    }


    // =============================
    // FORM EDIT
    // =============================
    public function edit($id)
    {
        if ($redirect = $this->redirectIfNoUmkmProfile()) {
            return $redirect;
        }

        $product = Makanan::findOrFail($id);

        // Security: hanya produk sendiri
        if ($product->umkm_id != $this->currentUmkm()->id) {
            abort(403);
        }

        return view('mitra.products.edit', compact('product'));
    }

    // =============================
    // UPDATE PRODUK
    // =============================
    public function update(Request $request, $id)
    {
        if ($redirect = $this->redirectIfNoUmkmProfile()) {
            return $redirect;
        }

        $product = Makanan::findOrFail($id);

        if ($product->umkm_id != $this->currentUmkm()->id) {
            abort(403);
        }

        $request->validate([
            'nama_makanan' => 'required',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
            'gambar_url' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('gambar_url')) {
            $cloudinary = app(CloudinaryService::class);
            $product->gambar_url = $cloudinary->upload($request->file('gambar_url'), 'products');
        }

        $product->nama_makanan = $request->nama_makanan;
        $product->kategori = $request->kategori;
        $product->harga = $request->harga;
        $product->deskripsi = $request->deskripsi;
        $product->is_available = $request->boolean('is_available', true);
        $product->save();

        return redirect()
            ->route('umkm.products.index')
            ->with('success','Produk berhasil diupdate');
    }

    // =============================
    // HAPUS PRODUK
    // =============================
    public function destroy($id)
    {
        if ($redirect = $this->redirectIfNoUmkmProfile()) {
            return $redirect;
        }

        $product = Makanan::findOrFail($id);

        if ($product->umkm_id != $this->currentUmkm()->id) {
            abort(403);
        }

        $product->delete();

        return back()->with('success','Produk berhasil dihapus');
    }

    public function toggleAvailability($id)
    {
        if ($redirect = $this->redirectIfNoUmkmProfile()) {
            return $redirect;
        }

        $product = Makanan::findOrFail($id);

        if ($product->umkm_id != $this->currentUmkm()->id) {
            abort(403);
        }

        $product->update([
            'is_available' => !$product->is_available,
        ]);

        return back()->with(
            'success',
            $product->is_available
                ? 'Produk ditampilkan ke user.'
                : 'Produk disembunyikan dari user.'
        );
    }
}
