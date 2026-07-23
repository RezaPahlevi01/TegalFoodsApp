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
                src="{{ asset('storage/'.$umkm->foto_qris) }}"
                class="w-80 mx-auto">

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