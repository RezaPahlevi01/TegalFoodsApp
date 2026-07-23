@extends('layouts.umkm')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">
        Tambah Produk
    </h2>

    <form action="{{ route('umkm.products.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text"
                   name="nama_makanan"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="w-full border p-2 rounded" required>
                <option value="" disabled selected>Pilih Kategori...</option>
                <option value="Makanan Berat">Makanan Berat</option>
                <option value="Camilan">Camilan</option>
                <option value="Makanan Penutup">Makanan Penutup</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number"
                   name="harga"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi"
                class="w-full border p-2 rounded"></textarea>
        </div>

        <div class="mb-3">
            <label>Foto Produk</label>
            <input type="file" name="gambar_url">
        </div>

        <div class="mb-4">
            <label class="flex items-center gap-2">
                <input type="checkbox"
                       name="is_available"
                       value="1"
                       checked>
                <span>Produk aktif dan ditampilkan ke user</span>
            </label>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Simpan
        </button>

        <a href="{{ route('umkm.products.index') }}"
           class="ml-2 text-gray-600">
           Kembali
        </a>

    </form>

</div>

@endsection
