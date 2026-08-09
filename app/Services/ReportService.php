<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;

class ReportService
{
    private function applyFilter($query, $tipe, $tanggal, $bulan, $tahun)
    {
        if ($tipe === 'hari') {
            $query->whereDate('created_at', $tanggal);
        } elseif ($tipe === 'tahun') {
            $query->whereYear('created_at', $tahun);
        } else {
            $query->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
        }
        return $query;
    }

    public function monthlyReport($umkmId, $bulan, $tahun, $tipe = 'bulan', $tanggal = null)
    {
        return OrderItem::select(
                'makanan_id',
                \DB::raw('SUM(qty) as total_terjual'),
                \DB::raw('SUM(subtotal) as total_pendapatan')
            )
            ->whereHas('order', function ($q) use ($umkmId, $bulan, $tahun, $tipe, $tanggal) {
                $q->where('umkm_id', $umkmId)
                  ->where('status', 'selesai');
                $this->applyFilter($q, $tipe, $tanggal, $bulan, $tahun);
            })
            ->with('makanan')
            ->groupBy('makanan_id')
            ->orderByDesc('total_terjual')
            ->get();
    }

    public function totalIncome($umkmId, $bulan, $tahun, $tipe = 'bulan', $tanggal = null)
    {
        $query = Order::where('umkm_id', $umkmId)
            ->where('status', 'selesai');
        $this->applyFilter($query, $tipe, $tanggal, $bulan, $tahun);
        return $query->sum('subtotal');
    }

    public function totalOrders($umkmId, $bulan, $tahun, $tipe = 'bulan', $tanggal = null)
    {
        $query = Order::where('umkm_id', $umkmId)
            ->where('status', 'selesai');
        $this->applyFilter($query, $tipe, $tanggal, $bulan, $tahun);
        return $query->count();
    }

    public function totalProducts($umkmId, $bulan, $tahun, $tipe = 'bulan', $tanggal = null)
    {
        return OrderItem::whereHas('order', function ($q) use ($umkmId, $bulan, $tahun, $tipe, $tanggal) {
            $q->where('umkm_id', $umkmId)
              ->where('status', 'selesai');
            $this->applyFilter($q, $tipe, $tanggal, $bulan, $tahun);
        })->sum('qty');
    }

    public function bestSeller($report)
    {
        return $report->first();
    }
}
