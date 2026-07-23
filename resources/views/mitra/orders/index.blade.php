@extends('layouts.umkm')

@section('content')
<div class="container mx-auto p-6">

    <h2 class="text-2xl font-bold mb-4">Pesanan Masuk</h2>

    <table class="w-full border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Kode Order</th>
                <th class="p-2 border">Customer</th>
                <th class="p-2 border">Subtotal</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($orders as $order)
            <tr>
                <td class="p-2 border">{{ $order->kode_order }}</td>
                <td class="p-2 border">{{ $order->user->name }}</td>
                <td class="p-2 border">Rp {{ number_format($order->subtotal) }}</td>
                <td class="p-2 border">{{ ucfirst($order->status) }}</td>
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