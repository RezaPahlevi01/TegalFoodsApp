<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;

class ReportService
{
    /*
    |--------------------------------------------------------------------------
    | REPORT PRODUK PER UMKM
    |--------------------------------------------------------------------------
    */

    public function monthlyReport($umkmId, $bulan, $tahun)
    {
        return OrderItem::select(
                'makanan_id',
                \DB::raw('SUM(qty) as total_terjual'),
                \DB::raw('SUM(subtotal) as total_pendapatan')
            )
            ->whereHas('order', function ($q) use ($umkmId, $bulan, $tahun) {
                $q->where('umkm_id', $umkmId)
                  ->where('status', 'selesai')
                  ->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
            })
            ->with('makanan')
            ->groupBy('makanan_id')
            ->orderByDesc('total_terjual')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | TOTAL OMZET (FIX: pakai orders.subtotal)
    |--------------------------------------------------------------------------
    */

    public function totalIncome($umkmId, $bulan, $tahun)
    {
        return Order::where('umkm_id', $umkmId)
            ->where('status', 'selesai')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->sum('subtotal'); // ✅ FIX: pakai subtotal order
    }

    /*
    |--------------------------------------------------------------------------
    | TOTAL ORDER
    |--------------------------------------------------------------------------
    */

    public function totalOrders($umkmId, $bulan, $tahun)
    {
        return Order::where('umkm_id', $umkmId)
            ->where('status', 'selesai')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count();
    }

    /*
    |--------------------------------------------------------------------------
    | TOTAL PRODUK TERJUAL
    |--------------------------------------------------------------------------
    */

    public function totalProducts($umkmId, $bulan, $tahun)
    {
        return OrderItem::whereHas('order', function ($q) use ($umkmId, $bulan, $tahun) {
            $q->where('umkm_id', $umkmId)
              ->where('status', 'selesai')
              ->whereMonth('created_at', $bulan)
              ->whereYear('created_at', $tahun);
        })->sum('qty');
    }

    /*
    |--------------------------------------------------------------------------
    | BEST SELLER
    |--------------------------------------------------------------------------
    */

    public function bestSeller($report)
    {
        return $report->first();
    }
}