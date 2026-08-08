<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class UmkmOrderController extends Controller
{
    // 🔹 LIST ORDER MILIK UMKM
    public function index()
    {
        $umkmId = auth()->user()->umkm->id;

        $orders = Order::whereHas('items.makanan', function ($q) use ($umkmId) {
                $q->where('umkm_id', $umkmId);
            })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mitra.orders.index', compact('orders'));
    }

    // 🔹 DETAIL ORDER
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

    // 🔹 UPDATE STATUS ORDER
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $umkmId = auth()->user()->umkm->id;

        $order = Order::whereHas('items.makanan', function ($q) use ($umkmId) {
                $q->where('umkm_id', $umkmId);
            })
            ->findOrFail($id);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status order berhasil diperbarui');
    }
}