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
        $carts = Cart::with('makanan.umkm')
            ->where('user_id', Auth::id())
            ->get();

        $cartsByUmkm = $carts->groupBy(function ($cart) {
            return $cart->makanan->umkm_id;
        })->map(function ($items, $umkmId) {
            $umkm = $items->first()->makanan->umkm;
            $total = $items->sum(function ($item) {
                return $item->qty * $item->harga;
            });
            return [
                'umkm' => $umkm,
                'items' => $items,
                'total' => $total,
            ];
        })->values();

        $total = $carts->sum(function ($item) {
            return $item->qty * $item->harga;
        });

        return view(
            'user.cart',
            compact('carts', 'total', 'cartsByUmkm')
        );
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return back();
    }

    public function apiData()
    {
        if (!Auth::check()) {
            return response()->json(['items' => [], 'count' => 0, 'total' => 0, 'groups' => []]);
        }

        $carts = Cart::with('makanan.umkm')
            ->where('user_id', Auth::id())
            ->get();

        $total = $carts->sum(function ($item) {
            return $item->qty * $item->harga;
        });

        $items = $carts->map(function ($cart) {
            $gambar = $cart->makanan->gambar_url ?? '';
            if ($gambar && !str_starts_with($gambar, 'http')) {
                $gambar = asset('storage/' . $gambar);
            }
            return [
                'id' => $cart->id,
                'makanan_id' => $cart->makanan_id,
                'nama' => $cart->makanan->nama_makanan ?? '-',
                'gambar' => $gambar,
                'harga' => $cart->harga,
                'qty' => $cart->qty,
                'subtotal' => $cart->qty * $cart->harga,
                'umkm' => $cart->makanan->umkm->nama_umkm ?? '-',
                'umkm_id' => $cart->makanan->umkm_id,
            ];
        });

        $groups = $carts->groupBy(function ($cart) {
            return $cart->makanan->umkm_id;
        })->map(function ($groupItems, $umkmId) {
            $umkm = $groupItems->first()->makanan->umkm;
            $groupTotal = $groupItems->sum(function ($item) {
                return $item->qty * $item->harga;
            });
            $mappedItems = $groupItems->map(function ($cart) {
                $gambar = $cart->makanan->gambar_url ?? '';
                if ($gambar && !str_starts_with($gambar, 'http')) {
                    $gambar = asset('storage/' . $gambar);
                }
                return [
                    'id' => $cart->id,
                    'makanan_id' => $cart->makanan_id,
                    'nama' => $cart->makanan->nama_makanan ?? '-',
                    'gambar' => $gambar,
                    'harga' => $cart->harga,
                    'qty' => $cart->qty,
                    'subtotal' => $cart->qty * $cart->harga,
                ];
            });
            return [
                'umkm_id' => $umkmId,
                'umkm_nama' => $umkm->nama_umkm ?? '-',
                'items' => $mappedItems->values(),
                'total' => $groupTotal,
                'count' => $groupItems->sum('qty'),
            ];
        })->values();

        return response()->json([
            'items' => $items,
            'count' => $carts->sum('qty'),
            'total' => $total,
            'groups' => $groups,
        ]);
    }

    public function apiAdd(Makanan $makanan)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Silakan login terlebih dahulu.'], 401);
        }

        if (Auth::user()->role != 'user') {
            return response()->json(['error' => 'Hanya user yang dapat menambahkan menu ke keranjang.'], 403);
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

        return response()->json(['success' => true, 'message' => 'Produk berhasil ditambahkan ke keranjang']);
    }

    public function apiRemove(Cart $cart)
    {
        if (!Auth::check() || $cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cart->delete();

        return response()->json(['success' => true, 'message' => 'Item berhasil dihapus dari keranjang']);
    }
}