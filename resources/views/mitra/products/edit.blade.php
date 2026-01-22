@extends('layouts.umkm')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">
        Edit Produk
    </h2>

    <form action="{{ route('umkm.products.update', $product->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text"
                   name="nama_makanan"
                   value="{{ $product->nama_makanan }}"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number"
                   name="harga"
                   value="{{ $product->harga }}"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <input type="text"
                   name="kategori"
                   value="{{ $product->kategori }}"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi"
                class="w-full border p-2 rounded">{{ $product->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
            <label>Foto Produk</label>
            <input type="file" name="gambar_url">

            @if($product->gambar_url)
                <img src="{{ asset('storage/'.$product->gambar_url) }}"
                     class="w-24 mt-2 rounded">
            @endif
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Update
        </button>

        <a href="{{ route('umkm.products.index') }}"
           class="ml-2 text-gray-600">
            Kembali
        </a>

    </form>

</div>

@endsection
