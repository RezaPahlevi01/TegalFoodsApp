<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class UmkmOrderController extends Controller
{
    public function index()
    {
        $umkmId = auth()->user()->umkm->id;

        $orders = Order::whereHas('items.makanan', function ($q) use ($umkmId) {
                $q->where('umkm_id', $umkmId);
            })
            ->with(['user', 'payment'])
            ->orderByRaw("CASE status
                WHEN 'pending_confirmation' THEN 0
                WHEN 'waiting_payment' THEN 1
                WHEN 'paid' THEN 2
                WHEN 'processing' THEN 3
                WHEN 'ready' THEN 4
                WHEN 'delivering' THEN 5
                WHEN 'completed' THEN 6
                WHEN 'rejected' THEN 7
                WHEN 'cancelled' THEN 8
                ELSE 9 END")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mitra.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $umkmId = auth()->user()->umkm->id;

        $order = Order::with(['user', 'items.makanan', 'payment'])
            ->whereHas('items.makanan', function ($q) use ($umkmId) {
                $q->where('umkm_id', $umkmId);
            })
            ->where('id', $id)
            ->firstOrFail();

        return view('mitra.orders.show', compact('order', 'umkmId'));
    }

    public function confirm(Request $request, $id)
    {
        $umkmId = auth()->user()->umkm->id;

        $order = Order::whereHas('items.makanan', function ($q) use ($umkmId) {
                $q->where('umkm_id', $umkmId);
            })
            ->where('id', $id)
            ->firstOrFail();

        if ($order->status !== 'pending_confirmation') {
            return back()->with('error', 'Pesanan sudah tidak menunggu konfirmasi.');
        }

        $order->transitionTo('waiting_payment');

        return redirect()->back()->with('success', 'Pesanan telah dikonfirmasi. Pelanggan sekarang dapat melakukan pembayaran.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:500',
        ]);

        $umkmId = auth()->user()->umkm->id;

        $order = Order::whereHas('items.makanan', function ($q) use ($umkmId) {
                $q->where('umkm_id', $umkmId);
            })
            ->where('id', $id)
            ->firstOrFail();

        if ($order->status !== 'pending_confirmation') {
            return back()->with('error', 'Pesanan sudah tidak dapat ditolak.');
        }

        $order->update([
            'status' => 'rejected',
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil ditolak.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:processing,ready,delivering,completed',
        ]);

        $umkmId = auth()->user()->umkm->id;

        $order = Order::whereHas('items.makanan', function ($q) use ($umkmId) {
                $q->where('umkm_id', $umkmId);
            })
            ->where('id', $id)
            ->firstOrFail();

        if (!$order->canTransitionTo($request->status)) {
            return back()->with('error', 'Perubahan status tidak diizinkan.');
        }

        $order->transitionTo($request->status);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
