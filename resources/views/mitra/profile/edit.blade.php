@extends('layouts.umkm')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">
        Edit Profil Toko
    </h2>

    {{-- Error Validation --}}
    @if ($errors->any())
        <div class="bg-red-100 p-3 mb-4">
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
                   value="{{ $umkm->nama_umkm }}"
                   class="w-full border p-2 rounded">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat"
                class="w-full border p-2 rounded">{{ $umkm->alamat }}</textarea>
        </div>

        <div class="mb-3">
            <label>Nama Pemilik</label>
            <input type="text" 
                   name="nama_pemilik"
                   value="{{ $umkm->nama_pemilik }}"
                   class="w-full border p-2 rounded">
        </div>

        <div class="mb-3">
            <label>Nomor WhatsApp</label>
            <input type="text" 
                   name="nomor_whatsapp"
                   value="{{ $umkm->nomor_whatsapp }}"
                   class="w-full border p-2 rounded">

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi"
                class="w-full border p-2 rounded">{{ $umkm->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
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
