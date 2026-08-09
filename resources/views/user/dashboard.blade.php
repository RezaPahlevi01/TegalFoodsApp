@extends('layouts.user')

@section('page-title','Dashboard')

@section('content')

<div class="bg-gradient-to-r from-orange-500 to-yellow-500 rounded-2xl p-5 md:p-8 text-white mb-8">

    <h1 class="text-2xl md:text-4xl font-bold">
        Halo, {{ Auth::user()->name }}
    </h1>

    <p class="mt-2 text-sm md:text-lg">
        Selamat datang di TegalFood.
        Temukan kuliner khas Tegal dari UMKM terbaik.
    </p>

</div>

    </section>

    {{-- SEARCH --}}
    <section class="container mx-auto px-4 md:px-6 py-6">

        <form action="{{ route('mitra.umkm.search') }}">
            <input
                type="text"
                name="search"
                placeholder="Cari makanan atau UMKM..."
                class="w-full rounded-xl border border-gray-200 p-3 md:p-4 shadow-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none">
        </form>

    </section>

    {{-- UMKM --}}
    <section class="container mx-auto px-6 py-10">

        <h2 class="text-3xl font-bold mb-8">
            UMKM Tegal
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($umkms as $umkm)

            <a href="{{ route('umkm.show',$umkm->id) }}"
            class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden">

                @if($umkm->logo_url)

                    <img
                        src="{{ $media_url($umkm->logo_url) }}"
                        class="w-full h-44 object-cover">

                @endif

                <div class="p-4">

                    <h3 class="font-bold text-lg">
                        {{ $umkm->nama_umkm }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        {{ $umkm->alamat }}
                    </p>

                </div>

            </a>

            @endforeach

        </div>

    </section>

    {{-- MAKANAN TERBARU --}}
    <section class="container mx-auto px-6 py-10">

        <h2 class="text-3xl font-bold mb-8">
            Menu Terbaru
        </h2>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            @foreach($makanans as $makanan)

            <div class="bg-white rounded-2xl shadow overflow-hidden">

                <img
                    src="{{ $media_url($makanan->gambar_url) }}"
                    class="w-full h-32 md:h-48 object-cover">

                <div class="p-3 md:p-4">

                    <h3 class="font-bold text-sm md:text-base line-clamp-2">
                        {{ $makanan->nama_makanan }}
                    </h3>

                    <p class="text-xs md:text-sm text-gray-500">
                        {{ $makanan->umkm->nama_umkm }}
                    </p>

                    <p class="font-bold text-orange-600 mt-2 text-sm md:text-lg">
                        Rp {{ number_format($makanan->harga) }}
                    </p>

                    <form action="{{ route('cart.add',$makanan->id) }}" method="POST">
                        @csrf

                        <button
                            class="w-full mt-3 bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg text-sm">

                            Tambah

                        </button>
                    </form>

                </div>

            </div>

            @endforeach

        </div>

    </section>

    {{-- PESANAN TERAKHIR --}}
    <div class="space-y-4">

        @forelse($lastOrders as $order)

            <div class="bg-white rounded-xl shadow p-4">

                <div class="flex justify-between">

                    <div>
                        <p class="font-semibold">
                            {{ $order->kode_order }}
                        </p>

                        <p class="text-sm text-gray-500">
                            Rp {{ number_format($order->total) }}
                        </p>
                    </div>

                    <span
                        class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($order->status=='pending') bg-yellow-100 text-yellow-700
                        @elseif($order->status=='selesai') bg-green-100 text-green-700
                        @elseif($order->status=='dibatalkan') bg-red-100 text-red-700
                        @else bg-blue-100 text-blue-700
                        @endif">

                        {{ ucfirst($order->status) }}

                    </span>

                </div>

                <a
                    href="{{ route('orders.show',$order->id) }}"
                    class="inline-block mt-3 text-orange-500 font-semibold">

                    Lihat Detail →

                </a>

            </div>

        @empty

            <div class="bg-white rounded-xl shadow p-5 text-center text-gray-500">
                Belum ada pesanan
            </div>

        @endforelse

    </div>

    {{-- BLOG --}}
    <section class="container mx-auto px-6 py-10">

        <h2 class="text-3xl font-bold mb-8">
            Artikel Kuliner
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($blogs as $blog)

            <div class="bg-white rounded-2xl shadow overflow-hidden hover:shadow-xl transition">

                <img
                    src="{{ $media_url($blog->image) }}"
                    class="w-full h-48 md:h-56 object-cover">

                <div class="p-4">

                    <h3 class="font-bold line-clamp-2">
                        {{ $blog->title }}
                    </h3>

                    <a
                        href="{{ route('blog.show',$blog->slug) }}"
                        class="inline-block mt-3 text-yellow-600 font-semibold">

                        Baca Selengkapnya →

                    </a>

                </div>

            </div>

            @endforeach

        </div>

    </section>

</div>

@endsection