@extends('layouts.admin')

@section('title', 'Detail UMKM')

@section('content')
<div class="container mx-auto px-6 py-10 max-w-3xl">

    <h1 class="text-2xl font-bold mb-6">Detail UMKM</h1>

    {{-- SECTION 1: Data Diri Pemilik --}}
    <div class="bg-white border rounded-lg p-5 mb-6">
        <h2 class="font-bold text-lg mb-4">Data Diri Pemilik</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Nama Lengkap</p>
                <p class="font-semibold">{{ $umkm->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">NIK</p>
                <p class="font-semibold">{{ $umkm->nik ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Foto KTP</p>
                @if($umkm->foto_ktp)
                    <img src="{{ asset('storage/' . $umkm->foto_ktp) }}" alt="Foto KTP"
                         class="h-32 rounded border mt-1">
                @else
                    <p class="text-gray-400">Tidak ada</p>
                @endif
            </div>
            <div>
                <p class="text-sm text-gray-500">Nomor WhatsApp</p>
                <p class="font-semibold">{{ $umkm->umkm->nomor_whatsapp ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-semibold">{{ $umkm->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status Akun</p>
                @if($umkm->status === 'active')
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-sm font-semibold">Aktif</span>
                @else
                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-sm font-semibold">Non-aktif</span>
                @endif
            </div>
        </div>
    </div>

    {{-- SECTION 2: Data UMKM --}}
    <div class="bg-white border rounded-lg p-5 mb-6">
        <h2 class="font-bold text-lg mb-4">Data UMKM</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Nama UMKM</p>
                <p class="font-semibold">{{ $umkm->umkm->nama_umkm ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">NIB</p>
                <p class="font-semibold">{{ $umkm->umkm->nib ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Dokumen NIB</p>
                @if($umkm->umkm && $umkm->umkm->dokumen_nib)
                    @if(str_ends_with($umkm->umkm->dokumen_nib, '.pdf'))
                        <a href="{{ asset('storage/' . $umkm->umkm->dokumen_nib) }}" target="_blank"
                           class="text-blue-500 underline">Lihat Dokumen (PDF)</a>
                    @else
                        <img src="{{ asset('storage/' . $umkm->umkm->dokumen_nib) }}" alt="Dokumen NIB"
                             class="h-32 rounded border mt-1">
                    @endif
                @else
                    <p class="text-gray-400">Tidak ada</p>
                @endif
            </div>
            <div>
                <p class="text-sm text-gray-500">Logo</p>
                @if($umkm->umkm && $umkm->umkm->logo_url)
                    <img src="{{ asset('storage/' . $umkm->umkm->logo_url) }}" alt="Logo"
                         class="h-20 rounded border mt-1">
                @else
                    <p class="text-gray-400">Tidak ada</p>
                @endif
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Alamat</p>
                <p class="font-semibold">{{ $umkm->umkm->alamat ?? '-' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Deskripsi</p>
                <p class="font-semibold">{{ $umkm->umkm->deskripsi ?? '-' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500 mb-1">Lokasi</p>
                @if($umkm->umkm->latitude && $umkm->umkm->longitude)
                    <div id="map" class="w-full h-64 rounded border"></div>
                @else
                    <p class="text-gray-400">Belum ada lokasi</p>
                @endif
            </div>
        </div>
    </div>

    <div class="flex gap-4">
        <a href="{{ route('admin.umkm.edit', $umkm->id) }}"
           class="px-6 py-3 bg-yellow-500 text-white rounded hover:bg-yellow-600 font-semibold">
            Edit
        </a>
        <a href="{{ route('admin.umkm.index') }}"
           class="px-6 py-3 bg-gray-300 rounded hover:bg-gray-400">
            Kembali
        </a>
    </div>

</div>

@if($umkm->umkm->latitude && $umkm->umkm->longitude)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lat = {{ $umkm->umkm->latitude }};
    const lng = {{ $umkm->umkm->longitude }};
    const map = L.map('map').setView([lat, lng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    L.marker([lat, lng]).addTo(map);
});
</script>
@endif

@endsection
