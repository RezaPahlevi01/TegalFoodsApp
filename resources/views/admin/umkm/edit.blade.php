@extends('layouts.admin')

@section('title', 'Edit Mitra UMKM')

@section('content')
<div class="container mx-auto px-6 py-10 max-w-2xl">

    <h1 class="text-2xl font-bold mb-6">
        Edit Mitra UMKM
    </h1>

    {{-- Error Validation --}}
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.umkm.update', $umkm->id) }}"
          method="POST"
          class="space-y-4">

        @csrf
        @method('PUT')

        {{-- Nama UMKM --}}
        <div>
            <label class="block mb-1 font-semibold">Nama UMKM</label>
            <input
                type="text"
                name="nama_umkm"
                value="{{ old('nama_umkm', $umkm->nama_umkm) }}"
                class="w-full border p-3 rounded"
                required
            >
        </div>

        {{-- Nama Pemilik --}}
        <div>
            <label class="block mb-1 font-semibold">Nama Pemilik</label>
            <input
                type="text"
                name="nama_pemilik"
                value="{{ old('name', $umkm->name) }}"
                class="w-full border p-3 rounded"
                required>
        </div>

        {{-- Nomor WhatsApp --}}
        <div>
            <label class="block mb-1 font-semibold">Nomor WhatsApp</label>
            <input
                type="text"
                name="nomor_whatsapp"
                value="{{ old('nomor_whatsapp', $umkm->nomor_whatsapp) }}"
                class="w-full border p-3 rounded"
                required
            >
        </div>

        {{-- Alamat --}}
        <div>
            <label class="block mb-1 font-semibold">Alamat</label>
            <input
                type="text"
                name="alamat"
                value="{{ old('alamat', $umkm->alamat) }}"
                class="w-full border p-3 rounded"
                required
            >
        </div>

        {{-- Logo URL --}}
        <div>
            <label class="block mb-1 font-semibold">Logo URL</label>
            <input
                type="url"
                name="logo_url"
                value="{{ old('logo_url', $umkm->logo_url) }}"
                class="w-full border p-3 rounded"
                required
            >

            {{-- Preview Logo --}}
            <div class="mt-3">
                <p class="text-sm text-gray-500 mb-1">Preview Logo:</p>
                <img src="{{ $umkm->logo_url }}"
                     alt="Logo UMKM"
                     class="w-24 h-24 object-cover rounded-full border">
            </div>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block mb-1 font-semibold">Deskripsi</label>
            <textarea
                name="deskripsi"
                rows="4"
                class="w-full border p-3 rounded"
                required
            >{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
        </div>

        {{-- Button --}}
        <div class="flex gap-4 mt-6">
            <button
                type="submit"
                class="px-6 py-3 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                Update
            </button>

            <a href="{{ route('admin.umkm.index') }}"
               class="px-6 py-3 bg-gray-300 rounded hover:bg-gray-400">
                Batal
            </a>
        </div>

    </form>

</div>
@endsection
