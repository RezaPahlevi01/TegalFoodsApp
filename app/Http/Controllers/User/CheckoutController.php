<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Umkm;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $umkmId = $request->query('umkm_id');

        if (!$umkmId) {
            return redirect()->route('cart.index')
                ->with('error', 'Pilih toko terlebih dahulu untuk checkout.');
        }

        $umkm = Umkm::find($umkmId);
        if (!$umkm) {
            return redirect()->route('cart.index')
                ->with('error', 'Toko tidak ditemukan.');
        }

        $carts = Cart::with('makanan')
            ->where('user_id', Auth::id())
            ->whereHas('makanan', function ($q) use ($umkmId) {
                $q->where('umkm_id', $umkmId);
            })
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Tidak ada item dari toko ini di keranjang.');
        }

        $total = $carts->sum(function ($item) {
            return $item->qty * $item->harga;
        });

        $profile = Auth::user()->profile;

        if (!$profile || !$profile->latitude || !$profile->longitude) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda belum mengatur lokasi. Silakan lengkapi profil lokasi terlebih dahulu.');
        }

        if (!$umkm->latitude || !$umkm->longitude) {
            return redirect()->route('cart.index')
                ->with('error', 'Toko "' . $umkm->nama_umkm . '" belum mengatur lokasi. Silakan pilih toko lain.');
        }

        $shipping = app(ShippingService::class);
        $result = $shipping->calculate(
            (float) $profile->latitude,
            (float) $profile->longitude,
            (float) $umkm->latitude,
            (float) $umkm->longitude
        );

        return view('user.checkout', [
            'carts'            => $carts,
            'total'            => $total,
            'profile'          => $profile,
            'ongkir'           => $result['ongkir'],
            'umkm'             => $umkm,
            'distance_km'      => $result['distance_km'],
            'duration_minutes' => $result['duration_minutes'],
            'shipping_error'   => $result['error'],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat_pengiriman'  => 'required',
            'metode_pengiriman'  => 'required|in:delivery,pickup',
            'umkm_id'            => 'required|exists:umkms,id',
        ]);

        $umkmId = $request->umkm_id;
        $metode = $request->metode_pengiriman;

        $carts = Cart::with('makanan')
            ->where('user_id', Auth::id())
            ->whereHas('makanan', function ($q) use ($umkmId) {
                $q->where('umkm_id', $umkmId);
            })
            ->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Tidak ada item dari toko ini di keranjang.');
        }

        $subtotal = $carts->sum(function ($item) {
            return $item->qty * $item->harga;
        });

        $user    = Auth::user();
        $profile = $user->profile;

        if (!$profile || !$profile->latitude || !$profile->longitude) {
            return back()->with('error', 'Lengkapi profil lokasi Anda terlebih dahulu di halaman profil.');
        }

        $umkm = Umkm::find($umkmId);

        if ($metode === 'pickup') {
            $ongkir = 0;
            $distanceKm      = 0;
            $durationMinutes = 0;
        } else {
            if (!$umkm->latitude || !$umkm->longitude) {
                return back()->with('error', 'Toko "' . $umkm->nama_umkm . '" belum mengatur lokasi. Silakan pilih metode Pick Up.');
            }

            $shipping = app(ShippingService::class);
            $result = $shipping->calculate(
                (float) $profile->latitude,
                (float) $profile->longitude,
                (float) $umkm->latitude,
                (float) $umkm->longitude
            );

            if ($result['error']) {
                return back()->with('error', $result['error']);
            }

            $ongkir          = $result['ongkir'];
            $distanceKm      = $result['distance_km'];
            $durationMinutes = $result['duration_minutes'];
        }

        $profile->update([
            'alamat' => $request->alamat_pengiriman,
        ]);

        $order = DB::transaction(function () use (
            $user, $umkmId, $profile, $request, $metode,
            $subtotal, $ongkir, $carts
        ) {
            $order = Order::create([
                'user_id'           => $user->id,
                'umkm_id'           => $umkmId,
                'kode_order'        => 'TGF-' . strtoupper(Str::random(8)),
                'nama_penerima'     => $profile->nama_lengkap,
                'nomor_telepon'     => $profile->nomor_telepon,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'metode_pengiriman' => $metode,
                'subtotal'          => $subtotal,
                'ongkir'            => $ongkir,
                'total'             => $subtotal + $ongkir,
                'status'            => 'pending_confirmation',
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'makanan_id' => $cart->makanan_id,
                    'qty'        => $cart->qty,
                    'harga'      => $cart->harga,
                    'subtotal'   => $cart->qty * $cart->harga,
                ]);
            }

            Cart::where('user_id', $user->id)
                ->whereHas('makanan', function ($q) use ($umkmId) {
                    $q->where('umkm_id', $umkmId);
                })
                ->delete();

            return $order;
        });

        return redirect()
            ->route('orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat. Silakan tunggu konfirmasi dari UMKM.');
    }
}
