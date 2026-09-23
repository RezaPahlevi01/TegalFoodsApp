@extends('layouts.admin')

@section('title', 'Edit Mitra UMKM')

@section('content')
<div class="container mx-auto px-6 py-10 max-w-3xl">

    <h1 class="text-2xl font-bold mb-6">Edit Mitra UMKM</h1>

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
          enctype="multipart/form-data"
          class="space-y-6">

        @csrf
        @method('PUT')

        {{-- SECTION 1: Data Diri Pemilik --}}
        <div class="bg-white border rounded-lg p-5">
            <h2 class="font-bold text-lg mb-4">Data Diri Pemilik</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name"
                           value="{{ old('name', $umkm->name) }}"
                           class="w-full border p-3 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="nik"
                           value="{{ old('nik', $umkm->nik) }}"
                           maxlength="16"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           class="w-full border p-3 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Foto KTP</label>
                    @if($umkm->foto_ktp)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $umkm->foto_ktp) }}" alt="Foto KTP"
                                 class="h-20 rounded border">
                        </div>
                    @endif
                    <input type="file" name="foto_ktp" accept="image/jpg,image/jpeg,image/png"
                           class="w-full border p-3 rounded">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak diubah. Format: JPG, JPEG, PNG. Maks 2MB.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Nomor WhatsApp <span class="text-red-500">*</span></label>
                    <input type="tel" name="nomor_whatsapp"
                           value="{{ old('nomor_whatsapp', $umkm->umkm->nomor_whatsapp ?? '') }}"
                           inputmode="numeric" maxlength="15"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           class="w-full border p-3 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email Akun UMKM <span class="text-red-500">*</span></label>
                    <input type="email" name="email"
                           value="{{ old('email', $umkm->email) }}"
                           class="w-full border p-3 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Password <span class="text-gray-400">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" placeholder="Password baru"
                           class="w-full border p-3 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password"
                           class="w-full border p-3 rounded">
                </div>
            </div>
        </div>

        {{-- SECTION 2: Data UMKM --}}
        <div class="bg-white border rounded-lg p-5">
            <h2 class="font-bold text-lg mb-4">Data UMKM</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nama UMKM <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_umkm"
                           value="{{ old('nama_umkm', $umkm->umkm->nama_umkm ?? '') }}"
                           class="w-full border p-3 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">NIB (Nomor Induk Berusaha) <span class="text-red-500">*</span></label>
                    <input type="text" name="nib"
                           value="{{ old('nib', $umkm->umkm->nib ?? '') }}"
                           class="w-full border p-3 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Dokumen NIB</label>
                    @if($umkm->umkm && $umkm->umkm->dokumen_nib)
                        <div class="mb-2">
                            @if(str_ends_with($umkm->umkm->dokumen_nib, '.pdf'))
                                <a href="{{ asset('storage/' . $umkm->umkm->dokumen_nib) }}" target="_blank"
                                   class="text-blue-500 underline text-sm">Lihat Dokumen NIB (PDF)</a>
                            @else
                                <img src="{{ asset('storage/' . $umkm->umkm->dokumen_nib) }}" alt="Dokumen NIB"
                                     class="h-20 rounded border">
                            @endif
                        </div>
                    @endif
                    <input type="file" name="dokumen_nib" accept="application/pdf,image/jpg,image/jpeg,image/png"
                           class="w-full border p-3 rounded">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak diubah. Format: PDF, JPG, JPEG, PNG. Maks 5MB.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Logo UMKM</label>
                    @if($umkm->umkm && $umkm->umkm->logo_url)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $umkm->umkm->logo_url) }}" alt="Logo"
                                 class="h-20 rounded border">
                        </div>
                    @endif
                    <input type="file" name="logo" accept="image/jpg,image/jpeg,image/png"
                           class="w-full border p-3 rounded">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak diubah.</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Alamat <span class="text-red-500">*</span></label>
                    <textarea name="alamat" rows="3"
                              class="w-full border p-3 rounded" required>{{ old('alamat', $umkm->umkm->alamat ?? '') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                              class="w-full border p-3 rounded">{{ old('deskripsi', $umkm->umkm->deskripsi ?? '') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Lokasi UMKM (Klik Peta)</label>
                    <div id="map" class="w-full h-72 rounded border mb-2"></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Latitude</label>
                            <input id="latitude" name="latitude" type="number" step="any"
                                   value="{{ old('latitude', $umkm->umkm->latitude ?? '') }}"
                                   class="w-full border p-3 rounded" readonly>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Longitude</label>
                            <input id="longitude" name="longitude" type="number" step="any"
                                   value="{{ old('longitude', $umkm->umkm->longitude ?? '') }}"
                                   class="w-full border p-3 rounded" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit"
                    class="px-6 py-3 bg-yellow-500 text-white rounded hover:bg-yellow-600 font-semibold">
                Update
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
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    const hasCoords = latInput.value && lngInput.value;
    const defaultLat = hasCoords ? parseFloat(latInput.value) : -6.9928;
    const defaultLng = hasCoords ? parseFloat(lngInput.value) : 109.4733;

    const map = L.map('map').setView([defaultLat, defaultLng], hasCoords ? 16 : 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker = null;

    function setMarker(lat, lng) {
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map);
        latInput.value = lat.toFixed(7);
        lngInput.value = lng.toFixed(7);
    }

    map.on('click', function (e) {
        setMarker(e.latlng.lat, e.latlng.lng);
    });

    if (hasCoords) {
        setMarker(parseFloat(latInput.value), parseFloat(lngInput.value));
    }
});
</script>

@endsection
