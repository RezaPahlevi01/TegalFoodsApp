@extends('layouts.user')

@section('title', 'Keranjang Saya')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold mb-8">
        Keranjang Belanja
    </h1>

    @forelse($cartsByUmkm as $group)
    <div class="mb-8 bg-white rounded-2xl shadow-lg overflow-hidden">

        <div class="bg-gradient-to-r from-orange-500 to-yellow-500 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-2 rounded-full">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-white font-bold text-lg">{{ $group['umkm']->nama_umkm }}</h2>
                    <p class="text-white/80 text-sm">{{ $group['items']->count() }} item</p>
                </div>
            </div>
            <a href="{{ route('checkout.index', ['umkm_id' => $group['umkm']->id]) }}"
               class="bg-white text-orange-600 hover:bg-orange-50 px-5 py-2.5 rounded-xl font-bold text-sm transition shadow-md flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                </svg>
                Checkout Toko Ini
            </a>
        </div>

        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-4 text-left text-sm font-semibold text-gray-600">Menu</th>
                    <th class="p-4 text-center text-sm font-semibold text-gray-600">Harga</th>
                    <th class="p-4 text-center text-sm font-semibold text-gray-600">Qty</th>
                    <th class="p-4 text-center text-sm font-semibold text-gray-600">Subtotal</th>
                    <th class="p-4 text-center text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($group['items'] as $cart)
                <tr class="border-b last:border-b-0 hover:bg-gray-50 transition">
                    <td class="p-4 flex items-center gap-4">
                        <img src="{{ $media_url($cart->makanan->gambar_url) }}"
                             class="w-16 h-16 rounded-lg object-cover">
                        <div>
                            <h3 class="font-semibold text-gray-800">
                                {{ $cart->makanan->nama_makanan }}
                            </h3>
                        </div>
                    </td>
                    <td class="text-center text-gray-600">
                        Rp {{ number_format($cart->harga,0,',','.') }}
                    </td>
                    <td class="text-center text-gray-600">
                        {{ $cart->qty }}
                    </td>
                    <td class="text-center font-semibold text-orange-600">
                        Rp {{ number_format($cart->harga * $cart->qty,0,',','.') }}
                    </td>
                    <td class="text-center">
                        <form action="{{ route('cart.delete',$cart->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="bg-gray-50 px-6 py-3 flex justify-end">
            <span class="text-sm text-gray-500">Subtotal toko:</span>
            <span class="ml-2 font-bold text-orange-600">Rp {{ number_format($group['total'],0,',','.') }}</span>
        </div>
    </div>
    @empty

    <div class="bg-white rounded-2xl shadow-lg p-10 text-center">
        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
        </svg>
        <p class="text-gray-500 text-lg">Keranjang masih kosong</p>
        <a href="{{ route('dashboard') }}" class="inline-block mt-4 text-orange-500 hover:text-orange-600 font-semibold">
            Mulai Belanja →
        </a>
    </div>

    @endforelse

    @if($cartsByUmkm->count() > 1)
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mt-4 flex items-start gap-3">
        <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div class="text-sm text-blue-700">
            <p class="font-semibold">Checkout per toko</p>
            <p class="mt-1">Keranjang berisi item dari {{ $cartsByUmkm->count() }} toko berbeda. Silakan checkout satu per satu sesuai toko yang dipilih.</p>
        </div>
    </div>
    @endif

</div>

@endsection
