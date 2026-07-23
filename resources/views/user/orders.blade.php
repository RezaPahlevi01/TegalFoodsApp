@extends('layouts.user')

@section('title','Pesanan Saya')

@section('content')

<h1 class="text-3xl font-bold mb-8">
    📦 Pesanan Saya
</h1>

@if($orders->isEmpty())

<div class="bg-white rounded-2xl shadow-lg p-12 text-center">

    <div class="text-6xl mb-5">
        🛍️
    </div>

    <h2 class="text-2xl font-bold mb-2">
        Belum ada pesanan
    </h2>

    <p class="text-gray-500 mb-6">
        Yuk mulai pesan makanan khas Tegal favoritmu.
    </p>

    <a href="{{ route('mitra.umkm') }}"
        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-xl">

        Cari Makanan

    </a>

</div>

@else

<div class="bg-white rounded-2xl shadow-lg overflow-hidden">

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-yellow-500 text-white">

                <tr>

                    <th class="py-4 px-5">Kode</th>
                    <th class="py-4 px-5">Tanggal</th>
                    <th class="py-4 px-5">Pengiriman</th>
                    <th class="py-4 px-5">Total</th>
                    <th class="py-4 px-5">Status</th>
                    <th class="py-4 px-5">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @foreach($orders as $order)

                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="text-center py-5 font-semibold">
                        {{ $order->kode_order }}
                    </td>

                    <td class="text-center">
                        {{ $order->created_at->format('d M Y') }}
                    </td>

                    <td class="text-center">

                        @if($order->metode_pengiriman == 'delivery')

                            <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                                🚚 Delivery
                            </span>

                        @else

                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                🏪 Pick Up
                            </span>

                        @endif

                    </td>

                    <td class="text-center font-semibold text-orange-600">
                        Rp {{ number_format($order->total,0,',','.') }}
                    </td>

                    <td class="text-center">

                        @switch($order->status)

                            @case('pending')
                                <span class="bg-yellow-100 text-yellow-700 px-4 py-1 rounded-full">
                                    ⏳ Pending
                                </span>
                            @break

                            @case('dibayar')
                                <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full">
                                    💳 Dibayar
                                </span>
                            @break

                            @case('diproses')
                                <span class="bg-indigo-100 text-indigo-700 px-4 py-1 rounded-full">
                                    👨‍🍳 Diproses
                                </span>
                            @break

                            @case('dikirim')
                                <span class="bg-purple-100 text-purple-700 px-4 py-1 rounded-full">
                                    🚚 Dikirim
                                </span>
                            @break

                            @case('selesai')
                                <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full">
                                    ✅ Selesai
                                </span>
                            @break

                            @case('dibatalkan')
                                <span class="bg-red-100 text-red-700 px-4 py-1 rounded-full">
                                    ❌ Dibatalkan
                                </span>
                            @break

                        @endswitch

                    </td>

                    <td class="text-center">

                        <a href="{{ route('orders.show',$order->id) }}"
                            class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-xl transition">

                            Detail

                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endif

@endsection