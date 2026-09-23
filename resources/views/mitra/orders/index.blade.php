@extends('layouts.umkm')

@section('content')
<div class="container mx-auto p-6">

    <h2 class="text-2xl font-bold mb-4">Pesanan Masuk</h2>

    <table class="w-full border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Kode Order</th>
                <th class="p-2 border">Customer</th>
                <th class="p-2 border">Total</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($orders as $order)
            <tr>
                <td class="p-2 border font-semibold">{{ $order->kode_order }}</td>
                <td class="p-2 border">{{ $order->user->name }}</td>
                <td class="p-2 border">Rp {{ number_format($order->total) }}</td>
                <td class="p-2 border">
                    @switch($order->status)
                        @case('pending_confirmation')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Menunggu Konfirmasi
                            </span>
                        @break
                        @case('waiting_payment')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Menunggu Pembayaran
                            </span>
                        @break
                        @case('paid')
                            <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Dibayar
                            </span>
                        @break
                        @case('processing')
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Diproses
                            </span>
                        @break
                        @case('ready')
                            <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Siap
                            </span>
                        @break
                        @case('delivering')
                            <span class="bg-cyan-100 text-cyan-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Diantar
                            </span>
                        @break
                        @case('completed')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Selesai
                            </span>
                        @break
                        @case('rejected')
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Ditolak
                            </span>
                        @break
                        @case('cancelled')
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Dibatalkan
                            </span>
                        @break
                    @endswitch
                </td>
                <td class="p-2 border">
                    <a href="{{ route('umkm.manage-orders.show', $order->id) }}"
                       class="bg-blue-500 text-white px-3 py-1 rounded">
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center p-4">Tidak ada pesanan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
