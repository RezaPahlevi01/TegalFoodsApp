@extends('layouts.user')

@section('content')

<div class="max-w-3xl mx-auto py-10">

    <div class="bg-white p-8 rounded-2xl shadow">

        <h1 class="text-2xl font-bold mb-6">
            Pembayaran QRIS
        </h1>

        <div class="mb-6">

            <h3 class="font-semibold mb-2">
                Scan QRIS Berikut
            </h3>

            <img
                src="{{ $media_url($umkm->foto_qris) }}"
                class="w-80 mx-auto">

            <div class="flex justify-center mt-3">
                <a href="{{ $media_url($umkm->foto_qris) }}"
                   download="QRIS-{{ $umkm->nama_umkm }}.jpg"
                   class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download QRIS
                </a>
            </div>

        </div>

        <form
            action="{{ route('payment.upload',$order->id) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <label class="block mb-2">
                Upload Bukti Transfer
            </label>

            <input
                type="file"
                name="bukti_bayar"
                required
                class="w-full border rounded-xl p-3">

            <button
                class="mt-6 w-full bg-yellow-500 text-white py-3 rounded-xl">

                Kirim Bukti Pembayaran

            </button>

        </form>

    </div>

</div>

@endsection