<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingSetting;
use App\Services\ShippingService;
use Illuminate\Http\Request;

class AdminShippingController extends Controller
{
    public function index()
    {
        $settings = ShippingSetting::instance();

        return view('admin.shipping.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'base_fare'    => 'required|numeric|min:0',
            'price_per_km' => 'required|numeric|min:0',
            'minimum_fare' => 'required|numeric|min:0',
            'maximum_fare' => 'required|numeric|min:0',
            'rounding'     => 'required|integer|min:0',
        ]);

        $settings = ShippingSetting::instance();

        $settings->update([
            'base_fare'    => $request->base_fare,
            'price_per_km' => $request->price_per_km,
            'minimum_fare' => $request->minimum_fare,
            'maximum_fare' => $request->maximum_fare,
            'rounding'     => $request->rounding,
        ]);

        return back()->with('success', 'Pengiriman berhasil diperbarui.');
    }

    public function preview(Request $request)
    {
        $request->validate([
            'distance' => 'required|numeric|min:0',
        ]);

        $shipping = app(ShippingService::class);
        $ongkir = $shipping->calculateFromDistance((float) $request->distance);

        return response()->json([
            'distance_km' => $request->distance,
            'ongkir'      => $ongkir,
            'formatted'   => 'Rp ' . number_format($ongkir, 0, ',', '.'),
        ]);
    }
}
