@extends('layouts.admin')

@section('title', 'Tambah UMKM')

@section('content')
<div class="container mx-auto px-6 py-10 max-w-2xl">

    <h1 class="text-2xl font-bold mb-6">Tambah Mitra UMKM</h1>

    <form action="{{ route('admin.umkm.store') }}" method="POST" class="space-y-4">
        @csrf

        <input name="nama_umkm" placeholder="Nama UMKM" class="w-full border p-3 rounded">
        <input name="nama_pemilik" placeholder="Nama Pemilik" class="w-full border p-3 rounded">
        <input name="nomor_whatsapp" placeholder="Nomor WhatsApp" class="w-full border p-3 rounded">
        <input name="alamat" placeholder="Alamat" class="w-full border p-3 rounded">
        <input name="logo_url" placeholder="URL Logo" class="w-full border p-3 rounded">

        <textarea name="deskripsi" rows="4" placeholder="Deskripsi"
                  class="w-full border p-3 rounded"></textarea>

        <button class="px-6 py-3 bg-yellow-500 text-white rounded">
            Simpan
        </button>
    </form>

</div>
@endsection
