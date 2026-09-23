<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;

class ReportService
{
    /**
     * Satu-satunya definisi status order valid untuk laporan.
     * HARUS identik dengan AdminReportService::SUCCESSFUL_STATUSES
     * dan AdminReportController::SUCCESSFUL_STATUSES.
     */
    public const SUCCESSFUL_STATUSES = [
        'paid',
        'processing',
        'ready',
        'delivering',
        'completed',
    ];

    private function applyFilter($query, $tipe, $tanggal, $bulan, $tahun)
    {
        $query->whereIn('status', self::SUCCESSFUL_STATUSES);

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

    /**
     * Satu sumber logika rekap per UMKM dalam satu periode.
     * Dipakai UMKM Panel (index + export PDF) dan hasilnya identik
     * dengan baris UMKM yang sama pada AdminReportService::omzetPerUmkm().
     *
     * - Total Order   = COUNT(orders.id) milik umkm_id, status valid, periode sama
     * - Produk Terjual = SUM(order_items.qty) dari order valid tersebut
     * - Total Omzet   = SUM(orders.subtotal) (tanpa ongkir), tanpa JOIN ganda
     */
    public function getUmkmSummary($umkmId, $bulan, $tahun, $tipe = 'bulan', $tanggal = null): array
    {
        return [
            'total_order'    => $this->totalOrders($umkmId, $bulan, $tahun, $tipe, $tanggal),
            'total_produk'   => $this->totalProducts($umkmId, $bulan, $tahun, $tipe, $tanggal),
            'total_omzet'    => $this->totalIncome($umkmId, $bulan, $tahun, $tipe, $tanggal),
        ];
    }

    public function monthlyReport($umkmId, $bulan, $tahun, $tipe = 'bulan', $tanggal = null)
    {
        return OrderItem::select(
                'makanan_id',
                \DB::raw('SUM(qty) as total_terjual'),
                \DB::raw('SUM(subtotal) as total_pendapatan')
            )
            ->whereHas('order', function ($q) use ($umkmId, $bulan, $tahun, $tipe, $tanggal) {
                $q->where('umkm_id', $umkmId);
                $this->applyFilter($q, $tipe, $tanggal, $bulan, $tahun);
            })
            ->with('makanan')
            ->groupBy('makanan_id')
            ->orderByDesc('total_terjual')
            ->get();
    }

    public function totalIncome($umkmId, $bulan, $tahun, $tipe = 'bulan', $tanggal = null)
    {
        $query = Order::where('umkm_id', $umkmId);
        $this->applyFilter($query, $tipe, $tanggal, $bulan, $tahun);
        return $query->sum('subtotal');
    }

    public function totalOrders($umkmId, $bulan, $tahun, $tipe = 'bulan', $tanggal = null)
    {
        $query = Order::where('umkm_id', $umkmId);
        $this->applyFilter($query, $tipe, $tanggal, $bulan, $tahun);
        return $query->count();
    }

    public function totalProducts($umkmId, $bulan, $tahun, $tipe = 'bulan', $tanggal = null)
    {
        return OrderItem::whereHas('order', function ($q) use ($umkmId, $bulan, $tahun, $tipe, $tanggal) {
            $q->where('umkm_id', $umkmId);
            $this->applyFilter($q, $tipe, $tanggal, $bulan, $tahun);
        })->sum('qty');
    }

    public function bestSeller($report)
    {
        return $report->first();
    }
}
