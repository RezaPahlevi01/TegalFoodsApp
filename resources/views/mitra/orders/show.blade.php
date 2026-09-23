@extends('layouts.umkm')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Detail Pesanan</h2>
            <p class="text-sm text-gray-500 mt-1">Kode: <span class="font-mono font-bold text-emerald-600">{{ $order->kode_order }}</span></p>
        </div>
        <a href="{{ route('umkm.manage-orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    {{-- STATUS BADGE --}}
    @php
        $statusColors = [
            'pending_confirmation' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
            'waiting_payment'      => 'bg-blue-100 text-blue-700 border-blue-200',
            'paid'                 => 'bg-indigo-100 text-indigo-700 border-indigo-200',
            'processing'           => 'bg-purple-100 text-purple-700 border-purple-200',
            'ready'                => 'bg-teal-100 text-teal-700 border-teal-200',
            'delivering'           => 'bg-cyan-100 text-cyan-700 border-cyan-200',
            'completed'            => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            'rejected'             => 'bg-red-100 text-red-700 border-red-200',
            'cancelled'            => 'bg-gray-100 text-gray-700 border-gray-200',
        ];
        $statusLabels = [
            'pending_confirmation' => 'Menunggu Konfirmasi',
            'waiting_payment'      => 'Menunggu Pembayaran',
            'paid'                 => 'Dibayar',
            'processing'           => 'Diproses',
            'ready'                => 'Siap',
            'delivering'           => 'Diantar',
            'completed'            => 'Selesai',
            'rejected'             => 'Ditolak',
            'cancelled'            => 'Dibatalkan',
        ];
        $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
        $label = $statusLabels[$order->status] ?? ucfirst($order->status);
    @endphp
    <div class="flex items-center gap-3 flex-wrap">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-bold border {{ $color }}">
            {{ $label }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- KIRI: INFO PELANGGAN --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- PELANGGAN --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-5 py-3 flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-full">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="font-bold text-white">Informasi Pelanggan</h3>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Nama</p>
                            <p class="font-semibold text-gray-800">{{ $order->nama_penerima }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Telepon</p>
                            <p class="font-semibold text-gray-800">{{ $order->nomor_telepon }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Alamat</p>
                            <p class="font-semibold text-gray-800">{{ $order->alamat_pengiriman }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ITEM PESANAN --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-5 py-3 flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-full">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h3 class="font-bold text-white">Item Pesanan</h3>
                </div>
                <div class="p-5">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs text-gray-400 uppercase tracking-wide border-b border-gray-100">
                                <th class="pb-3 font-semibold">Menu</th>
                                <th class="pb-3 font-semibold text-center">Qty</th>
                                <th class="pb-3 font-semibold text-right">Harga</th>
                                <th class="pb-3 font-semibold text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                @if($item->makanan->umkm_id == $umkmId)
                                <tr class="border-b border-gray-50 last:border-0">
                                    <td class="py-3 font-medium text-gray-800">{{ $item->makanan->nama_makanan }}</td>
                                    <td class="py-3 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-700 text-sm font-bold">{{ $item->qty }}</span>
                                    </td>
                                    <td class="py-3 text-right text-gray-600">Rp {{ number_format($item->harga) }}</td>
                                    <td class="py-3 text-right font-semibold text-gray-800">Rp {{ number_format($item->subtotal) }}</td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- KANAN: RINGKASAN + BUKTI + STATUS --}}
        <div class="space-y-6">

            {{-- RINGKASAN --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-5 py-3 flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-full">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-white">Ringkasan</h3>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50">
                        <span class="text-gray-500 text-sm">Metode</span>
                        <span class="ml-auto font-semibold text-gray-800 flex items-center gap-1.5">
                            @if($order->metode_pengiriman === 'delivery')
                                Delivery
                            @else
                                Pick Up
                            @endif
                        </span>
                    </div>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($order->subtotal) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Ongkir</span>
                            <span class="font-medium">Rp {{ number_format($order->ongkir) }}</span>
                        </div>
                        <hr class="border-gray-100">
                        <div class="flex justify-between text-lg font-bold text-emerald-600">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->total) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BUKTI PEMBAYARAN --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-5 py-3 flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-full">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-white">Bukti Pembayaran</h3>
                </div>
                <div class="p-5">
                    @if($order->payment && $order->payment->bukti_bayar)
                        <a href="{{ $media_url($order->payment->bukti_bayar) }}" target="_blank" class="block group">
                            <img src="{{ $media_url($order->payment->bukti_bayar) }}" class="w-full rounded-xl border border-gray-200 group-hover:shadow-md transition-shadow">
                        </a>
                    @else
                        <div class="text-center py-6">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-gray-400 text-sm">Belum ada bukti pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ACTIONS --}}
            @if($order->status === 'pending_confirmation')
            {{-- KONFIRMASI / TOLAK --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-5 py-3 flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-full">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-white">Konfirmasi Pesanan</h3>
                </div>
                <div class="p-5 space-y-3">
                    <form method="POST" action="{{ route('umkm.manage-orders.confirm', $order->id) }}">
                        @csrf
                        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Konfirmasi Pesanan
                        </button>
                    </form>

                    <button type="button" onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-xl transition-colors duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Tolak Pesanan
                    </button>
                </div>
            </div>
            @endif

            @if($order->status === 'paid')
            {{-- MULAI PROSES --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-5 py-3 flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-full">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="font-bold text-white">Proses Pesanan</h3>
                </div>
                <div class="p-5">
                    <form method="POST" action="{{ route('umkm.manage-orders.updateStatus', $order->id) }}">
                        @csrf
                        <input type="hidden" name="status" value="processing">
                        <button type="submit" class="w-full bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 rounded-xl transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Mulai Proses
                        </button>
                    </form>
                </div>
            </div>
            @endif

            @if($order->status === 'processing')
            {{-- TANDAI SIAP --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-5 py-3 flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-full">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-white">Tandai Siap</h3>
                </div>
                <div class="p-5">
                    <form method="POST" action="{{ route('umkm.manage-orders.updateStatus', $order->id) }}">
                        @csrf
                        <input type="hidden" name="status" value="ready">
                        <button type="submit" class="w-full bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 rounded-xl transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Tandai Siap
                        </button>
                    </form>
                </div>
            </div>
            @endif

            @if($order->status === 'ready')
            {{-- SIAP --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 px-5 py-3 flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-full">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="font-bold text-white">
                        @if($order->metode_pengiriman === 'pickup')
                            Tandai Selesai
                        @else
                            Tandai Sedang Diantar
                        @endif
                    </h3>
                </div>
                <div class="p-5">
                    <form method="POST" action="{{ route('umkm.manage-orders.updateStatus', $order->id) }}">
                        @csrf
                        <input type="hidden" name="status" value="{{ $order->metode_pengiriman === 'pickup' ? 'completed' : 'delivering' }}">
                        <button type="submit" class="w-full {{ $order->metode_pengiriman === 'pickup' ? 'bg-green-500 hover:bg-green-600' : 'bg-cyan-500 hover:bg-cyan-600' }} text-white font-bold py-3 rounded-xl transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @if($order->metode_pengiriman === 'pickup')
                                Tandai Selesai
                            @else
                                Tandai Sedang Diantar
                            @endif
                        </button>
                    </form>
                </div>
            </div>
            @endif

            @if($order->status === 'delivering')
            {{-- TANDAI SELESAI --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-5 py-3 flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-full">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="font-bold text-white">Tandai Selesai</h3>
                </div>
                <div class="p-5">
                    <form method="POST" action="{{ route('umkm.manage-orders.updateStatus', $order->id) }}">
                        @csrf
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Tandai Selesai
                        </button>
                    </form>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

{{-- REJECT MODAL --}}
@if($order->status === 'pending_confirmation')
<div id="rejectModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-2">Tolak Pesanan</h3>
        <p class="text-gray-500 text-sm mb-4">Masukkan alasan penolakan pesanan ini.</p>
        <form method="POST" action="{{ route('umkm.manage-orders.reject', $order->id) }}" class="space-y-4">
            @csrf
            <textarea name="alasan_penolakan" rows="3" required maxlength="500"
                class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-red-400 focus:outline-none"
                placeholder="Contoh: Stok makanan habis..."></textarea>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')"
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2.5 rounded-xl transition">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-2.5 rounded-xl transition">
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@endsection
