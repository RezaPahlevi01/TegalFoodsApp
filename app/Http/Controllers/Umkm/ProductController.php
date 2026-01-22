<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // =============================
    // LIST PRODUK UMKM
    // =============================
    public function index()
    {
        $umkm = Auth::user()->umkm;

        $products = Makanan::where('umkm_id', $umkm->id)->get();

        return view('mitra.products.index', compact('umkm', 'products'));
    }

    // =============================
    // FORM TAMBAH PRODUK
    // =============================
    public function create()
    {
        return view('mitra.products.create');
    }

    // =============================
    // SIMPAN PRODUK
    // =============================
    public function store(Request $request)
    {
        $request->validate([
            'nama_makanan' => 'required',
            'harga' => 'required',
            'gambar_url' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $gambar = null;

        if ($request->hasFile('gambar_url')) {

            $gambar = $request->file('gambar_url')
                        ->store('products', 'public');
        }

        Makanan::create([
            'umkm_id' => auth()->user()->umkm->id, // atau session umkm kamu
            'nama_makanan' => $request->nama_makanan,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar_url' => $gambar
        ]); 

        return redirect()->route('umkm.products.index')
            ->with('success','Produk berhasil ditambahkan');
    }


    // =============================
    // FORM EDIT
    // =============================
    public function edit($id)
    {
        $product = Makanan::findOrFail($id);

        // Security: hanya produk sendiri
        if ($product->umkm_id != Auth::user()->umkm->id) {
            abort(403);
        }

        return view('mitra.products.edit', compact('product'));
    }

    // =============================
    // UPDATE PRODUK
    // =============================
    public function update(Request $request, $id)
    {
        $product = Makanan::findOrFail($id);

        if ($product->umkm_id != Auth::user()->umkm->id) {
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

            $file = $request->file('gambar_url');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/products', $filename);

            $product->gambar_url = $filename;
        }

        $product->nama_makanan = $request->nama_makanan;
        $product->kategori = $request->kategori;
        $product->harga = $request->harga;
        $product->deskripsi = $request->deskripsi;
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
        $product = Makanan::findOrFail($id);

        if ($product->umkm_id != Auth::user()->umkm->id) {
            abort(403);
        }

        $product->delete();

        return back()->with('success','Produk berhasil dihapus');
    }
}
