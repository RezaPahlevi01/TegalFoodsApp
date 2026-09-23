@extends('layouts.user')

@section('title','Detail Pesanan')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="flex items-center justify-between mb-8">

        <a href="{{ route('orders.index') }}"
            class="flex items-center gap-2 text-orange-500 hover:text-orange-600 font-semibold">

            <- Kembali

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
                    {{ $order->created_at->format('d F Y - H:i') }}
                </p>

            </div>

            <div class="mt-5 md:mt-0">

                @switch($order->status)

                    @case('pending_confirmation')
                        <span class="px-5 py-2 rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                            Menunggu Konfirmasi
                        </span>
                    @break

                    @case('waiting_payment')
                        <span class="px-5 py-2 rounded-full bg-blue-100 text-blue-700 font-semibold">
                            Menunggu Pembayaran
                        </span>
                    @break

                    @case('paid')
                        <span class="px-5 py-2 rounded-full bg-indigo-100 text-indigo-700 font-semibold">
                            Dibayar
                        </span>
                    @break

                    @case('processing')
                        <span class="px-5 py-2 rounded-full bg-purple-100 text-purple-700 font-semibold">
                            Diproses
                        </span>
                    @break

                    @case('ready')
                        <span class="px-5 py-2 rounded-full bg-teal-100 text-teal-700 font-semibold">
                            Siap
                        </span>
                    @break

                    @case('delivering')
                        <span class="px-5 py-2 rounded-full bg-cyan-100 text-cyan-700 font-semibold">
                            Diantar
                        </span>
                    @break

                    @case('completed')
                        <span class="px-5 py-2 rounded-full bg-green-100 text-green-700 font-semibold">
                            Selesai
                        </span>
                    @break

                    @case('rejected')
                        <span class="px-5 py-2 rounded-full bg-red-100 text-red-700 font-semibold">
                            Ditolak
                        </span>
                    @break

                    @case('cancelled')
                        <span class="px-5 py-2 rounded-full bg-gray-100 text-gray-700 font-semibold">
                            Dibatalkan
                        </span>
                    @break

                @endswitch

            </div>

        </div>

    </div>

    {{-- STATUS INFO CARDS --}}
    @if($order->status === 'pending_confirmation')
    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <h3 class="font-bold text-yellow-800">Pesanan Menunggu Konfirmasi</h3>
                <p class="text-yellow-700 mt-1">UMKM sedang memeriksa ketersediaan makanan. Anda belum dapat melakukan pembayaran.</p>
            </div>
        </div>
    </div>
    @endif

    @if($order->status === 'waiting_payment')
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <div class="flex-1">
                <h3 class="font-bold text-blue-800">Pesanan Telah Dikonfirmasi</h3>
                <p class="text-blue-700 mt-1">Silakan lakukan pembayaran untuk melanjutkan pesanan.</p>
                <a href="{{ route('payment.show', $order->id) }}"
                   class="inline-flex items-center gap-2 mt-3 bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Bayar Sekarang
                </a>
            </div>
        </div>
    </div>
    @endif

    @if($order->status === 'paid')
    <div class="bg-indigo-50 border border-indigo-200 rounded-2xl p-6 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-indigo-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <h3 class="font-bold text-indigo-800">Pembayaran Diterima</h3>
                <p class="text-indigo-700 mt-1">Pesanan akan segera diproses oleh UMKM.</p>
            </div>
        </div>
    </div>
    @endif

    @if($order->status === 'processing')
    <div class="bg-purple-50 border border-purple-200 rounded-2xl p-6 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <div>
                <h3 class="font-bold text-purple-800">Pesanan Sedang Diproses</h3>
                <p class="text-purple-700 mt-1">UMKM sedang menyiapkan pesanan Anda.</p>
            </div>
        </div>
    </div>
    @endif

    @if($order->status === 'ready')
    <div class="bg-teal-50 border border-teal-200 rounded-2xl p-6 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-teal-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <h3 class="font-bold text-teal-800">Pesanan Siap</h3>
                <p class="text-teal-700 mt-1">
                    @if($order->metode_pengiriman === 'pickup')
                        Pesanan siap diambil di toko.
                    @else
                        Pesanan siap diantar ke alamat Anda.
                    @endif
                </p>
            </div>
        </div>
    </div>
    @endif

    @if($order->status === 'delivering')
    <div class="bg-cyan-50 border border-cyan-200 rounded-2xl p-6 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-cyan-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
            <div>
                <h3 class="font-bold text-cyan-800">Pesanan Sedang Diantar</h3>
                <p class="text-cyan-700 mt-1">Pesanan sedang dalam perjalanan ke alamat Anda.</p>
            </div>
        </div>
    </div>
    @endif

    @if($order->status === 'completed')
    <div class="bg-green-50 border border-green-200 rounded-2xl p-6 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <h3 class="font-bold text-green-800">Pesanan Selesai</h3>
                <p class="text-green-700 mt-1">Terima kasih telah memesan di TegalFood.</p>
            </div>
        </div>
    </div>
    @endif

    @if($order->status === 'rejected')
    <div class="bg-red-50 border border-red-200 rounded-2xl p-6 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <h3 class="font-bold text-red-800">Pesanan Ditolak</h3>
                <p class="text-red-700 mt-1">Pesanan ditolak oleh UMKM.</p>
                @if($order->alasan_penolakan)
                <div class="mt-2 p-3 bg-red-100 rounded-lg">
                    <p class="text-sm font-semibold text-red-800">Alasan penolakan:</p>
                    <p class="text-red-700">{{ $order->alasan_penolakan }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    @if($order->status === 'cancelled')
    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-gray-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <h3 class="font-bold text-gray-800">Pesanan Dibatalkan</h3>
                <p class="text-gray-700 mt-1">Pesanan telah dibatalkan.</p>
            </div>
        </div>
    </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- INFORMASI PENERIMA --}}
        <div class="bg-white rounded-2xl shadow-lg p-6">

            <h3 class="text-lg font-bold mb-5">
                Informasi Penerima
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

                            Delivery

                        @else

                            Pick Up

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

                Item Pesanan

            </h3>

            @foreach($order->items as $item)

            <div class="flex justify-between items-center border-b py-5">

                <div>

                    <h4 class="font-semibold text-lg">
                        {{ $item->makanan->nama_makanan }}
                    </h4>

                    <p class="text-gray-500">

                        {{ $item->qty }} x
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

    {{-- BUKTI PEMBAYARAN --}}
    @if($order->payment)
    <div class="bg-white rounded-2xl shadow-lg p-6 mt-6">

        <h3 class="text-lg font-bold mb-5">
            Bukti Pembayaran
        </h3>

        @if($order->payment->bukti_bayar)
            <a href="{{ $media_url($order->payment->bukti_bayar) }}" target="_blank" class="block group">
                <img src="{{ $media_url($order->payment->bukti_bayar) }}" class="w-full max-w-md rounded-xl border border-gray-200 group-hover:shadow-md transition-shadow">
            </a>
        @else
            <div class="text-center py-6 bg-gray-50 rounded-xl">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-gray-400 text-sm">Belum ada bukti pembayaran</p>
            </div>
        @endif

    </div>
    @endif

</div>

@endsection
