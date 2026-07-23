<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Umkm;
use Illuminate\Support\Facades\DB;

class AdminReportService
{
    /*
    |--------------------------------------------------------------------------
    | FILTER UTAMA (FIX CORE)
    |--------------------------------------------------------------------------
    */
    private function applyFilter($query, $tipe, $hari, $bulan, $tahun)
    {
        return $query
            ->where('status', 'selesai')
            ->when($tipe == 'hari', function ($q) use ($hari, $bulan, $tahun) {
                $q->whereDay('created_at', $hari)
                  ->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
            })
            ->when($tipe == 'bulan', function ($q) use ($bulan, $tahun) {
                $q->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
            })
            ->when($tipe == 'tahun', function ($q) use ($tahun) {
                $q->whereYear('created_at', $tahun);
            });
    }

    /*
    |--------------------------------------------------------------------------
    | SUMMARY
    |--------------------------------------------------------------------------
    */
    public function summary($tipe, $hari, $bulan, $tahun)
    {
        $orderQuery = Order::query();

        $orderQuery = $this->applyFilter($orderQuery, $tipe, $hari, $bulan, $tahun);

        return [
            'totalOmzet' => (clone $orderQuery)->sum('subtotal'),

            'totalOrder' => (clone $orderQuery)->count(),

            'totalProduk' => OrderItem::whereHas('order', function ($q) use ($tipe, $hari, $bulan, $tahun) {
                $this->applyFilter($q, $tipe, $hari, $bulan, $tahun);
            })->sum('qty'),

            'totalUmkm' => Umkm::count(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | OMZET PER UMKM
    |--------------------------------------------------------------------------
    */
    public function omzetPerUmkm($tipe, $hari, $bulan, $tahun)
    {
        $query = Order::select(
                'umkm_id',
                DB::raw('COUNT(id) as total_order'),
                DB::raw('SUM(subtotal) as total_omzet')
            )
            ->with('umkm')
            ->groupBy('umkm_id');

        $query = $this->applyFilter($query, $tipe, $hari, $bulan, $tahun);

        return $query->get()->map(function ($item) use ($tipe, $hari, $bulan, $tahun) {

            $item->total_produk = OrderItem::whereHas('order', function ($q) use ($item, $tipe, $hari, $bulan, $tahun) {
                $q->where('umkm_id', $item->umkm_id);
                $this->applyFilter($q, $tipe, $hari, $bulan, $tahun);
            })->sum('qty');

            return $item;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | PRODUK TERLARIS
    |--------------------------------------------------------------------------
    */
    public function produkTerlaris($tipe, $hari, $bulan, $tahun)
    {
        $query = OrderItem::select(
                'makanan_id',
                DB::raw('SUM(qty) as total_terjual'),
                DB::raw('SUM(subtotal) as total_pendapatan')
            )
            ->with('makanan.umkm')
            ->groupBy('makanan_id')
            ->orderByDesc('total_terjual');

        $query->whereHas('order', function ($q) use ($tipe, $hari, $bulan, $tahun) {
            $this->applyFilter($q, $tipe, $hari, $bulan, $tahun);
        });

        return $query->take(10)->get();
    }

    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI TERBARU (TIDAK DIFILTER)
    |--------------------------------------------------------------------------
    */
    public function transaksiTerbaru()
    {
        return Order::with(['user', 'umkm'])
            ->latest()
            ->take(10)
            ->get();
    }
}