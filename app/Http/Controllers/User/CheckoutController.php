<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Services\DistanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::with('makanan')
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        $total = $carts->sum(function ($item) {
            return $item->qty * $item->harga;
        });

        $profile = Auth::user()->profile;

        if (!$profile || !$profile->latitude || !$profile->longitude) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda belum mengatur lokasi. Silakan lengkapi profil lokasi terlebih dahulu.');
        }

        $umkm = $carts->first()->makanan->umkm;

        if ($umkm->latitude && $umkm->longitude) {
            $distance = DistanceService::haversine(
                $profile->latitude,
                $profile->longitude,
                $umkm->latitude,
                $umkm->longitude
            );

            if ($distance <= 2) {
                $ongkir = 5000;
            } elseif ($distance <= 5) {
                $ongkir = 10000;
            } elseif ($distance <= 10) {
                $ongkir = 15000;
            } else {
                $ongkir = 20000;
            }
        } else {
            $ongkir = 10000;
        }

        return view(
            'user.checkout',
            compact(
                'carts',
                'total',
                'profile',
                'ongkir'
            )
        );
    }

    public function store(Request $request)
{
    $request->validate([
        'alamat_pengiriman' => 'required',
        'metode_pengiriman' => 'required|in:delivery,pickup',
    ]);

    $carts = Cart::where(
        'user_id',
        Auth::id()
    )->get();

    if ($carts->isEmpty()) {

        return back()->with(
            'error',
            'Keranjang kosong'
        );
    }

    $subtotal = $carts->sum(function ($item) {
        return $item->qty * $item->harga;
    });

    // ambil profile user
    $user = Auth::user();
    $profile = Auth::user()->profile;

    if (!$profile->latitude || !$profile->longitude) {
        return back()->with('error', 'Lengkapi profil lokasi Anda terlebih dahulu di halaman profil.');
    }
// Ambil UMKM dari produk pertama di keranjang
$umkm = $carts->first()->makanan->umkm;

// Hitung jarak user ke UMKM
$distance = DistanceService::haversine(
    $profile->latitude,
    $profile->longitude,
    $umkm->latitude,
    $umkm->longitude
);

if ($request->metode_pengiriman == 'pickup') {

    $ongkir = 0;

} else {

    if ($distance <= 2) {

        $ongkir = 5000;

    } elseif ($distance <= 5) {

        $ongkir = 10000;

    } elseif ($distance <= 10) {

        $ongkir = 15000;

    } else {

        $ongkir = 20000;

    }

}
$profile->update([
    'alamat' => $request->alamat_pengiriman
]);

$order = Order::create([
    'user_id' => $user->id,
    'umkm_id' => $carts->first()->makanan->umkm_id,

    'kode_order' => 'TGF-' . strtoupper(Str::random(8)),

    // Snapshot penerima
    'nama_penerima' => $profile->nama_lengkap,
    'nomor_telepon' => $profile->nomor_telepon,

    'alamat_pengiriman' => $request->alamat_pengiriman,
    'metode_pengiriman' => $request->metode_pengiriman,

    'subtotal' => $subtotal,
    'ongkir' => $ongkir,
    'total' => $subtotal + $ongkir,
    'status' => 'pending',
]);

    foreach ($carts as $cart) {

        OrderItem::create([

            'order_id' => $order->id,

            'makanan_id' => $cart->makanan_id,

            'qty' => $cart->qty,

            'harga' => $cart->harga,

            'subtotal' => $cart->qty * $cart->harga

        ]);
    }

    Cart::where(
        'user_id',
        Auth::id()
    )->delete();

    return redirect()
        ->route(
            'payment.show',
            $order->id
        );
}
}