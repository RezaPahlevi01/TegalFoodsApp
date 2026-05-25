@extends('layouts.umkm')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">
        Edit Profil Toko
    </h2>

    @if ($errors->any())
        <div class="bg-red-100 p-3 mb-4 rounded">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('umkm.profile.update') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="mb-3">
            <label>Nama Toko</label>
            <input type="text"
                   name="nama_umkm"
                   value="{{ old('nama_umkm', $umkm->nama_umkm) }}"
                   class="w-full border p-2 rounded">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat"
                class="w-full border p-2 rounded">{{ old('alamat', $umkm->alamat) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Nama Pemilik</label>
            <input type="text"
                   name="nama_pemilik"
                   value="{{ old('nama_pemilik', $umkm->nama_pemilik) }}"
                   class="w-full border p-2 rounded">
        </div>

        <div class="mb-3">
            <label>Nomor WhatsApp</label>
            <input type="text"
                   name="nomor_whatsapp"
                   value="{{ old('nomor_whatsapp', $umkm->nomor_whatsapp) }}"
                   class="w-full border p-2 rounded">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
            <div>
                <label>Jam Buka</label>
                <input type="time"
                       name="jam_buka"
                       value="{{ old('jam_buka', $umkm->jam_buka ? \Carbon\Carbon::parse($umkm->jam_buka)->format('H:i') : '') }}"
                       class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Jam Tutup</label>
                <input type="time"
                       name="jam_tutup"
                       value="{{ old('jam_tutup', $umkm->jam_tutup ? \Carbon\Carbon::parse($umkm->jam_tutup)->format('H:i') : '') }}"
                       class="w-full border p-2 rounded">
            </div>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi"
                class="w-full border p-2 rounded">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
        </div>

        <div class="mb-4">
            <label>Logo</label>
            <input type="file" name="logo">

            @if($umkm->logo_url)
                <img src="{{ asset('storage/'.$umkm->logo_url) }}"
                     class="w-24 mt-2">
            @endif
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Simpan
        </button>

    </form>

</div>

@endsection
