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

        $request->validate([
            'bukti_bayar' =>
            'required|image|max:2048'
        ]);

        $url = null;
        if ($request->hasFile('bukti_bayar')) {
            $cloudinary = app(CloudinaryService::class);
            $url = $cloudinary->upload($request->file('bukti_bayar'), 'payments');
        }

        Payment::create([
            'order_id' => $order->id,
            'bukti_bayar' => $url,
            'status' => 'menunggu'
        ]);

        $order->update([
            'status' => 'dibayar'
        ]);

        return redirect()
            ->route('orders.index')
            ->with(
                'success',
                'Bukti pembayaran berhasil dikirim'
            );
    }
}