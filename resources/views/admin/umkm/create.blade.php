@extends('layouts.admin')

@section('title', 'Tambah UMKM')

@section('content')
<div class="container mx-auto px-6 py-10 max-w-3xl">

    <h1 class="text-2xl font-bold mb-6">Tambah Mitra UMKM</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.umkm.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- SECTION 1: Data Diri Pemilik --}}
        <div class="bg-white border rounded-lg p-5">
            <h2 class="font-bold text-lg mb-4">Data Diri Pemilik</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input name="name" value="{{ old('name') }}" placeholder="Nama lengkap pemilik"
                           class="w-full border p-3 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">NIK <span class="text-red-500">*</span></label>
                    <input name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK"
                           class="w-full border p-3 rounded" required maxlength="16"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Foto KTP <span class="text-red-500">*</span></label>
                    <input type="file" name="foto_ktp" accept="image/jpg,image/jpeg,image/png"
                           class="w-full border p-3 rounded" required>
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maks 2MB.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Nomor WhatsApp <span class="text-red-500">*</span></label>
                    <input name="nomor_whatsapp" type="tel" value="{{ old('nomor_whatsapp') }}"
                           placeholder="Nomor WhatsApp" inputmode="numeric" maxlength="15"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           class="w-full border p-3 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email Akun UMKM <span class="text-red-500">*</span></label>
                    <input name="email" type="email" value="{{ old('email') }}" placeholder="Email untuk login"
                           class="w-full border p-3 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Password <span class="text-red-500">*</span></label>
                    <input name="password" type="password" placeholder="Password"
                           class="w-full border p-3 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input name="password_confirmation" type="password" placeholder="Ulangi password"
                           class="w-full border p-3 rounded" required>
                </div>
            </div>
        </div>

        {{-- SECTION 2: Data UMKM --}}
        <div class="bg-white border rounded-lg p-5">
            <h2 class="font-bold text-lg mb-4">Data UMKM</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nama UMKM <span class="text-red-500">*</span></label>
                    <input name="nama_umkm" value="{{ old('nama_umkm') }}" placeholder="Nama UMKM"
                           class="w-full border p-3 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">NIB (Nomor Induk Berusaha) <span class="text-red-500">*</span></label>
                    <input name="nib" value="{{ old('nib') }}" placeholder="Masukkan NIB"
                           class="w-full border p-3 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Dokumen NIB <span class="text-red-500">*</span></label>
                    <input type="file" name="dokumen_nib" accept="application/pdf,image/jpg,image/jpeg,image/png"
                           class="w-full border p-3 rounded" required>
                    <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, JPEG, PNG. Maks 5MB.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Logo UMKM</label>
                    <input type="file" name="logo" accept="image/jpg,image/jpeg,image/png"
                           class="w-full border p-3 rounded">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maks 2MB.</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Alamat <span class="text-red-500">*</span></label>
                    <textarea name="alamat" rows="3" placeholder="Alamat lengkap UMKM"
                              class="w-full border p-3 rounded" required>{{ old('alamat') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" placeholder="Deskripsi UMKM (opsional)"
                              class="w-full border p-3 rounded">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Lokasi UMKM (Klik Peta)</label>
                    <div id="map" class="w-full h-72 rounded border mb-2"></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Latitude</label>
                            <input id="latitude" name="latitude" type="number" step="any"
                                   value="{{ old('latitude') }}" placeholder="-7.1234567"
                                   class="w-full border p-3 rounded" readonly>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Longitude</label>
                            <input id="longitude" name="longitude" type="number" step="any"
                                   value="{{ old('longitude') }}" placeholder="110.1234567"
                                   class="w-full border p-3 rounded" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit"
                    class="px-6 py-3 bg-yellow-500 text-white rounded hover:bg-yellow-600 font-semibold">
                Simpan
            </button>
            <a href="{{ route('admin.umkm.index') }}"
               class="px-6 py-3 bg-gray-300 rounded hover:bg-gray-400">
                Batal
            </a>
        </div>
    </form>

</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const defaultLat = -6.9928;
    const defaultLng = 109.4733;
    const map = L.map('map').setView([defaultLat, defaultLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker = null;
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    function setMarker(lat, lng) {
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map);
        latInput.value = lat.toFixed(7);
        lngInput.value = lng.toFixed(7);
    }

    map.on('click', function (e) {
        setMarker(e.latlng.lat, e.latlng.lng);
    });

    if (latInput.value && lngInput.value) {
        setMarker(parseFloat(latInput.value), parseFloat(lngInput.value));
    }
});
</script>

@endsection
