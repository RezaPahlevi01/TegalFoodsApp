@extends('layouts.user')

@section('title','Detail Pesanan')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="flex items-center justify-between mb-8">

        <a href="{{ route('orders.index') }}"
            class="flex items-center gap-2 text-orange-500 hover:text-orange-600 font-semibold">

            ← Kembali

        </a>

        <span class="text-gray-500">
            Order ID :
            <strong>{{ $order->kode_order }}</strong>
        </span>

    </div>

    {{-- HEADER --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">

        <div class="flex flex-col md:flex-row md:justify-between md:items-center">

            <div>

                <h1 class="text-3xl font-bold">
                    Detail Pesanan
                </h1>

                <p class="text-gray-500 mt-2">
                    {{ $order->created_at->format('d F Y • H:i') }}
                </p>

            </div>

            <div class="mt-5 md:mt-0">

                @switch($order->status)

                    @case('pending')
                        <span class="px-5 py-2 rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                            ⏳ Pending
                        </span>
                    @break

                    @case('dibayar')
                        <span class="px-5 py-2 rounded-full bg-blue-100 text-blue-700 font-semibold">
                            💳 Dibayar
                        </span>
                    @break

                    @case('diproses')
                        <span class="px-5 py-2 rounded-full bg-indigo-100 text-indigo-700 font-semibold">
                            👨‍🍳 Diproses
                        </span>
                    @break

                    @case('dikirim')
                        <span class="px-5 py-2 rounded-full bg-purple-100 text-purple-700 font-semibold">
                            🚚 Dikirim
                        </span>
                    @break

                    @case('selesai')
                        <span class="px-5 py-2 rounded-full bg-green-100 text-green-700 font-semibold">
                            ✅ Selesai
                        </span>
                    @break

                    @case('dibatalkan')
                        <span class="px-5 py-2 rounded-full bg-red-100 text-red-700 font-semibold">
                            ❌ Dibatalkan
                        </span>
                    @break

                @endswitch

            </div>

        </div>

    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- INFORMASI PENERIMA --}}
        <div class="bg-white rounded-2xl shadow-lg p-6">

            <h3 class="text-lg font-bold mb-5">
                👤 Informasi Penerima
            </h3>

            <div class="space-y-4">

                <div>
                    <p class="text-gray-500 text-sm">
                        Nama
                    </p>

                    <p class="font-semibold">
                        {{ $order->nama_penerima }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">
                        Nomor Telepon
                    </p>

                    <p class="font-semibold">
                        {{ $order->nomor_telepon }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500 text-sm">
                        Metode Pengiriman
                    </p>

                    <p class="font-semibold">

                        @if($order->metode_pengiriman=='delivery')

                            🚚 Delivery

                        @else

                            🏪 Pick Up

                        @endif

                    </p>
                </div>

                @if($order->metode_pengiriman=='delivery')

                <div>

                    <p class="text-gray-500 text-sm">
                        Alamat
                    </p>

                    <p class="font-semibold">
                        {{ $order->alamat_pengiriman }}
                    </p>

                </div>

                @endif

            </div>

        </div>

        {{-- ITEM PESANAN --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6">

            <h3 class="text-lg font-bold mb-6">

                🍜 Item Pesanan

            </h3>

            @foreach($order->items as $item)

            <div class="flex justify-between items-center border-b py-5">

                <div>

                    <h4 class="font-semibold text-lg">
                        {{ $item->makanan->nama_makanan }}
                    </h4>

                    <p class="text-gray-500">

                        {{ $item->qty }} ×
                        Rp {{ number_format($item->harga,0,',','.') }}

                    </p>

                </div>

                <div class="font-bold text-orange-500">

                    Rp {{ number_format($item->subtotal,0,',','.') }}

                </div>

            </div>

            @endforeach

            <div class="mt-8 border-t pt-6">

                <div class="flex justify-between mb-3">

                    <span>Subtotal</span>

                    <strong>
                        Rp {{ number_format($order->subtotal,0,',','.') }}
                    </strong>

                </div>

                <div class="flex justify-between mb-3">

                    <span>Ongkir</span>

                    <strong>
                        Rp {{ number_format($order->ongkir,0,',','.') }}
                    </strong>

                </div>

                <div class="flex justify-between text-2xl font-bold text-orange-500 border-t pt-4">

                    <span>Total</span>

                    <span>
                        Rp {{ number_format($order->total,0,',','.') }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection