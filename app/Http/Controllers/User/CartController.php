<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Makanan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Makanan $makanan)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()
                ->route('user.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah yang login adalah user
        if (Auth::user()->role != 'user') {
            abort(403, 'Hanya user yang dapat menambahkan menu ke keranjang.');
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('makanan_id', $makanan->id)
            ->first();

        if ($cart) {

            $cart->increment('qty');

        } else {

            Cart::create([
                'user_id' => Auth::id(),
                'makanan_id' => $makanan->id,
                'qty' => 1,
                'harga' => $makanan->harga
            ]);
        }

        return back()->with(
            'success',
            'Produk berhasil ditambahkan ke keranjang'
        );
    }
    
    public function index()
    {
        $carts = Cart::with('makanan')
            ->where('user_id', Auth::id())
            ->get();

        $total = $carts->sum(function ($item) {
            return $item->qty * $item->harga;
        });

        return view(
            'user.cart',
            compact('carts', 'total')
        );
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return back();
    }
}