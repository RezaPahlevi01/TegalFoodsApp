@extends('layouts.umkm')

@section('content')
<div class="container mx-auto p-6">

    <h2 class="text-2xl font-bold mb-4">Detail Pesanan</h2>

    {{-- INFO ORDER --}}
    <div class="mb-4">
        <p><b>Kode Order:</b> {{ $order->kode_order }}</p>
        <p><b>Customer:</b> {{ $order->user->name }}</p>
        <p><b>Nama Penerima:</b> {{ $order->nama_penerima }}</p>
        <p><b>No. Telepon:</b> {{ $order->nomor_telepon }}</p>
        <p><b>Alamat Pengiriman:</b> {{ $order->alamat_pengiriman }}</p>
        <p><b>Metode Pengiriman:</b> {{ $order->metode_pengiriman === 'delivery' ? 'Delivery' : 'Pick Up' }}</p>
        <p><b>Status:</b> {{ ucfirst($order->status) }}</p>
        <p><b>Subtotal:</b> Rp {{ number_format($order->subtotal) }}</p>
        <p><b>Ongkir:</b> Rp {{ number_format($order->ongkir) }}</p>
        <p><b>Total:</b> Rp {{ number_format($order->total) }}</p>
    </div>

    {{-- ITEM PESANAN --}}
    <h3 class="text-lg font-semibold mt-6 mb-2">Item Makanan</h3>

    <table class="w-full border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Nama Makanan</th>
                <th class="p-2 border">Qty</th>
                <th class="p-2 border">Harga</th>
                <th class="p-2 border">Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->items as $item)

                @if($item->makanan->umkm_id == $umkmId)

                <tr>
                    <td class="p-2 border">{{ $item->makanan->nama_makanan }}</td>
                    <td class="p-2 border">{{ $item->qty }}</td>
                    <td class="p-2 border">Rp {{ number_format($item->harga) }}</td>
                    <td class="p-2 border">Rp {{ number_format($item->subtotal) }}</td>
                </tr>

                @endif

            @endforeach
        </tbody>
    </table>

    {{-- BUKTI PEMBAYARAN --}}
    <h3 class="text-lg font-semibold mt-6">Bukti Pembayaran</h3>

    @if($order->payment && $order->payment->bukti_bayar)
        <a href="{{ $media_url($order->payment->bukti_bayar) }}" target="_blank">
            <img src="{{ $media_url($order->payment->bukti_bayar) }}"
                 class="w-64 mt-2 border rounded shadow">
        </a>
    @else
        <p class="text-red-500">Belum ada bukti pembayaran</p>
    @endif

    {{-- UPDATE STATUS --}}
    <h3 class="text-lg font-semibold mt-6">Update Status</h3>

    <form method="POST" action="{{ route('umkm.manage-orders.updateStatus', $order->id) }}">
        @csrf

        <select name="status" class="border p-2 mt-2">
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="dibayar" {{ $order->status == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
            <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
        </select>

        <button class="bg-green-500 text-white px-4 py-2 rounded mt-2">
            Update
        </button>
    </form>

</div>
@endsection