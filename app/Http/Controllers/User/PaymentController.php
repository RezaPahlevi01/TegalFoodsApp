<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        if ((string) $order->user_id !== (string) auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'waiting_payment') {
            return redirect()
                ->route('orders.show', $order->id)
                ->with('error', 'Pesanan belum dapat dibayar.');
        }

        $order->load('items.makanan');

        $umkm = $order
            ->items
            ->first()
            ->makanan
            ->umkm;

        return view(
            'user.payment',
            compact(
                'order',
                'umkm'
            )
        );
    }

    public function upload(
        Request $request,
        Order $order
    ) {
        if ((string) $order->user_id !== (string) auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'waiting_payment') {
            return redirect()
                ->route('orders.show', $order->id)
                ->with('error', 'Pesanan belum dapat dibayar.');
        }

        $request->validate([
            'bukti_bayar' =>
            'required|image|max:2048'
        ]);

        $url = null;
        if ($request->hasFile('bukti_bayar')) {
            $cloudinary = app(CloudinaryService::class);
            $url = $cloudinary->upload($request->file('bukti_bayar'), 'payments');
        }

        if (!$url) {
            return back()->with('error', 'Gagal mengunggah bukti pembayaran. Silakan coba lagi.');
        }

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'bukti_bayar' => $url,
            ]
        );

        $order->transitionTo('paid');

        return redirect()
            ->route('orders.show', $order->id)
            ->with(
                'success',
                'Bukti pembayaran berhasil dikirim. Pesanan akan segera diproses.'
            );
    }
}
