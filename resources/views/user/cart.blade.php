@extends('layouts.user')

@section('title', 'Keranjang Saya')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold mb-8">
        Keranjang Belanja
    </h1>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <table class="w-full">

            <thead class="bg-yellow-500 text-white">

                <tr>
                    <th class="p-4 text-left">Makanan</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4">Qty</th>
                    <th class="p-4">Subtotal</th>
                    <th class="p-4">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($carts as $cart)

                <tr class="border-b">

                    <td class="p-4 flex items-center gap-4">

                        <img src="{{ $media_url($cart->makanan->gambar_url) }}"
                             class="w-20 h-20 rounded-lg object-cover">

                        <div>
                            <h3 class="font-semibold">
                                {{ $cart->makanan->nama_makanan }}
                            </h3>
                        </div>

                    </td>

                    <td class="text-center">
                        Rp {{ number_format($cart->harga,0,',','.') }}
                    </td>

                    <td class="text-center">
                        {{ $cart->qty }}
                    </td>

                    <td class="text-center font-semibold">
                        Rp {{ number_format($cart->harga * $cart->qty,0,',','.') }}
                    </td>

                    <td class="text-center">

                        <form action="{{ route('cart.delete',$cart->id) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                class="bg-red-500 text-white px-3 py-2 rounded-lg">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center py-10">
                        Keranjang masih kosong
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-6 flex justify-end">

        <div class="bg-white shadow-lg rounded-xl p-6 w-96">

            <h3 class="font-bold text-xl mb-4">
                Ringkasan Belanja
            </h3>

            <div class="flex justify-between mb-3">
                <span>Total</span>
                <span class="font-bold">
                    Rp {{ number_format($total,0,',','.') }}
                </span>
            </div>

            <a href="{{ route('checkout.index') }}"
               class="block text-center bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-xl font-semibold">
                Checkout
            </a>

        </div>

    </div>

</div>

@endsection