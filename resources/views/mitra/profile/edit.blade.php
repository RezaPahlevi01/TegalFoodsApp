@extends('layouts.umkm')

@section('content')

@vite(['resources/css/app.css','resources/js/app.js'])

<link rel="stylesheet"
      href="https://unpkg.com/leaflet/dist/leaflet.css">

@stack('styles')

<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-green-600 to-emerald-500 rounded-3xl p-8 text-white shadow-lg mb-8">

        <h1 class="text-3xl font-bold text-black">
            Profil Toko
        </h1>

        <p class="mt-2 text-black text-opacity-80">
            Lengkapi informasi toko agar pelanggan lebih mudah menemukan dan menghubungi usaha Anda.
        </p>

    </div>

    @if ($errors->any())

        <div class="bg-red-50 border border-red-200 rounded-xl p-5 mb-6">

            <h3 class="font-semibold text-red-700 mb-2">
                Terjadi kesalahan
            </h3>

            <ul class="list-disc ml-5 text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    <form action="{{ route('umkm.profile.update') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-8">

        @csrf

        {{-- ========================= --}}
        {{-- INFORMASI TOKO --}}
        {{-- ========================= --}}

        <div class="bg-white rounded-2xl shadow-md p-8">

            <h2 class="text-xl font-bold mb-6 text-gray-700">
                Informasi Toko
            </h2>

            <div class="grid md:grid-cols-2 gap-6">

                <div>
                    <label class="block font-semibold mb-2">
                        Nama Toko
                    </label>

                    <input
                        type="text"
                        name="nama_umkm"
                        value="{{ old('nama_umkm',$umkm->nama_umkm) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
                </div>

                <div>
                    <label class="block font-semibold mb-2">
                        Nama Pemilik
                    </label>

                    <input
                        type="text"
                        name="nama_pemilik"
                        value="{{ old('nama_pemilik',$umkm->nama_pemilik) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
                </div>

                <div>
                    <label class="block font-semibold mb-2">
                        Nomor WhatsApp
                    </label>

                    <input
                        type="tel"
                        name="nomor_whatsapp"
                        value="{{ old('nomor_whatsapp',$umkm->nomor_whatsapp) }}"
                        inputmode="numeric"
                        maxlength="15"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        placeholder="Nomor WhatsApp"
                        class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block font-semibold mb-2">
                            Jam Buka
                        </label>

                        <input
                            type="time"
                            name="jam_buka"
                            value="{{ old('jam_buka',$umkm->jam_buka ? \Carbon\Carbon::parse($umkm->jam_buka)->format('H:i') : '') }}"
                            class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">
                            Jam Tutup
                        </label>

                        <input
                            type="time"
                            name="jam_tutup"
                            value="{{ old('jam_tutup',$umkm->jam_tutup ? \Carbon\Carbon::parse($umkm->jam_tutup)->format('H:i') : '') }}"
                            class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
                    </div>

                </div>

            </div>

            <div class="mt-6">

                <label class="block font-semibold mb-2">
                    Deskripsi Toko
                </label>

                <textarea
                    name="deskripsi"
                    rows="5"
                    class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">{{ old('deskripsi',$umkm->deskripsi) }}</textarea>

            </div>

        </div>

        {{-- ========================= --}}
        {{-- LOKASI --}}
        {{-- ========================= --}}

        <div class="bg-white rounded-2xl shadow-md p-8">

            <h2 class="text-xl font-bold mb-6 text-gray-700">
                Lokasi Toko
            </h2>

            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Alamat
                </label>

                <textarea
                    name="alamat"
                    rows="4"
                    class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">{{ old('alamat',$umkm->alamat) }}</textarea>

            </div>

            <div>

                <label class="block font-semibold mb-3">
                    Pilih Lokasi pada Peta
                </label>

                <div id="map"
                     class="rounded-2xl overflow-hidden border h-80 shadow-sm">
                </div>

                <input
                    type="hidden"
                    name="latitude"
                    id="latitude"
                    value="{{ old('latitude',$umkm->latitude) }}">

                <input
                    type="hidden"
                    name="longitude"
                    id="longitude"
                    value="{{ old('longitude',$umkm->longitude) }}">

                <div class="mt-3 text-sm text-gray-500">
                    Klik pada peta untuk menentukan lokasi toko secara akurat.
                </div>

            </div>

        </div>

        {{-- ========================= --}}
        {{-- FOTO --}}
        {{-- ========================= --}}

        <div class="bg-white rounded-2xl shadow-md p-8">

            <h2 class="text-xl font-bold mb-6 text-gray-700">
                Media Toko
            </h2>

            <div class="grid md:grid-cols-2 gap-8">

                {{-- Logo --}}

                <div>

                    <label class="block font-semibold mb-3">
                        Logo Toko
                    </label>

                    @if($umkm->logo_url)

                        <img
                            src="{{ $media_url($umkm->logo_url) }}"
                            class="w-40 h-40 rounded-2xl object-cover border shadow mb-4">

                    @else

                        <div class="w-40 h-40 rounded-2xl border flex items-center justify-center bg-gray-100 text-gray-400 mb-4">

                            Belum Ada Logo

                        </div>

                    @endif

                    <input
                        type="file"
                        name="logo"
                        class="block w-full rounded-xl border p-3">

                </div>

                {{-- QRIS --}}

                <div>

                    <label class="block font-semibold mb-3">
                        QRIS Pembayaran
                    </label>

                    @if($umkm->foto_qris)

                        <img
                            src="{{ $media_url($umkm->foto_qris) }}"
                            class="w-40 h-40 rounded-2xl object-contain border shadow mb-4">

                    @else

                        <div class="w-40 h-40 rounded-2xl border flex items-center justify-center bg-gray-100 text-gray-400 mb-4">

                            Belum Ada QRIS

                        </div>

                    @endif

                    <input
                        type="file"
                        name="foto_qris"
                        class="block w-full rounded-xl border p-3">

                </div>

            </div>

        </div>

        {{-- BUTTON --}}

        <div class="flex justify-end">

            <button
                class="px-10 py-4 rounded-xl bg-green-600 hover:bg-green-700 transition text-white font-semibold shadow-lg">

                Simpan Perubahan

            </button>

        </div>

    </form>

</div>

@stack('scripts')

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

var lat = {{ $umkm->latitude ?? '-6.8698' }};
var lng = {{ $umkm->longitude ?? '109.1402' }};

var map = L.map('map').setView([lat, lng], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
}).addTo(map);

var marker = L.marker([lat, lng], {
    draggable: true
}).addTo(map);

marker.on('dragend', function(e){

    let pos = marker.getLatLng();

    document.getElementById('latitude').value = pos.lat;
    document.getElementById('longitude').value = pos.lng;

});

map.on('click', function(e){

    marker.setLatLng(e.latlng);

    document.getElementById('latitude').value = e.latlng.lat;
    document.getElementById('longitude').value = e.latlng.lng;

});

</script>

@endsection