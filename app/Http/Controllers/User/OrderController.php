<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where(
            'user_id',
            Auth::id()
        )
        ->latest()
        ->get();

        return view(
            'user.orders',
            compact('orders')
        );
    }

    public function show($id)
    {
        $order = Order::with('items.makanan')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.orders.show', compact('order'));
    }
}