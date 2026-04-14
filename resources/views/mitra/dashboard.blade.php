@extends('layouts.umkm')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">
        Dashboard UMKM
    </h1>
</div>

<div class="bg-white shadow rounded-lg p-6">

    <div class="flex items-center gap-6 mb-6">

        <div>
            @if($umkm->logo_url)
                <img src="{{ asset('storage/'.$umkm->logo_url) }}"
                     class="w-24 h-24 rounded-full object-cover border">
            @else
                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500 text-sm">No Logo</span>
                </div>
            @endif
        </div>

        {{-- INFO UTAMA --}}
        <div>
            <h2 class="text-xl font-semibold">
                {{ $umkm->nama_umkm }}
            </h2>

            <p class="text-gray-600">
                Pemilik: {{ $umkm->nama_pemilik }}
            </p>

            <p class="text-gray-600">
                WhatsApp: {{ $umkm->nomor_whatsapp }}
            </p>
        </div>

    </div>

    <hr class="mb-4">

    {{-- DETAIL --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <p class="font-semibold mb-1">Alamat</p>
            <p class="text-gray-700">
                {{ $umkm->alamat }}
            </p>
        </div>

        <div>
            <p class="font-semibold mb-1">Deskripsi Toko</p>
            <p class="text-gray-700">
                {{ $umkm->deskripsi ?? '-' }}
            </p>
        </div>

    </div>

</div>

@endsection
