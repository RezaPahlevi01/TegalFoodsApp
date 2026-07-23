<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Umkm;
use Illuminate\Support\Facades\Auth;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;

class UmkmReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }


    public function index(Request $request)
    {
        $tipe = $request->tipe ?? 'bulan';
        $tanggal = $request->tanggal ?? now()->format('Y-m-d');
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $user = Auth::guard('umkm')->user();
        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();

        $report = $this->reportService->monthlyReport(
            $umkm->id,
            $bulan,
            $tahun,
            $tipe,
            $tanggal
        );

        $totalIncome = $this->reportService->totalIncome(
            $umkm->id,
            $bulan,
            $tahun,
            $tipe,
            $tanggal
        );

        $totalOrders = $this->reportService->totalOrders(
            $umkm->id,
            $bulan,
            $tahun,
            $tipe,
            $tanggal
        );

        $totalProducts = $this->reportService->totalProducts(
            $umkm->id,
            $bulan,
            $tahun,
            $tipe,
            $tanggal
        );

        $bestSeller = $this->reportService->bestSeller($report);

        return view('mitra.report.index', compact(
            'report',
            'bulan',
            'tahun',
            'tanggal',
            'tipe',
            'totalIncome',
            'totalOrders',
            'totalProducts',
            'bestSeller'
        ));
    }

 public function exportPdf(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $user = Auth::guard('umkm')->user();

        $umkm = Umkm::where('user_id',$user->id)->firstOrFail();

        $report = $this->reportService->monthlyReport(
            $umkm->id,
            $bulan,
            $tahun
        );

        $totalIncome = $this->reportService->totalIncome(
            $umkm->id,
            $bulan,
            $tahun
        );

        $totalOrders = $this->reportService->totalOrders(
            $umkm->id,
            $bulan,
            $tahun
        );

        $totalProducts = $this->reportService->totalProducts($report);

        $bestSeller = $this->reportService->bestSeller($report);

        $pdf = Pdf::loadView(
            'mitra.report.pdf',
            compact(
                'report',
                'bulan',
                'tahun',
                'totalIncome',
                'totalOrders',
                'totalProducts',
                'bestSeller',
                'umkm'
            )
        );

        return $pdf->download(
            "laporan-$bulan-$tahun.pdf"
        );
    }

    private function filterOrder($query, $tipe, $tanggal, $bulan, $tahun)
    {
        if ($tipe == 'hari') {
            return $query->whereDate('created_at', $tanggal);
        }

        if ($tipe == 'bulan') {
            return $query->whereMonth('created_at', $bulan)
                        ->whereYear('created_at', $tahun);
        }

        if ($tipe == 'tahun') {
            return $query->whereYear('created_at', $tahun);
        }

        return $query;
    }

    public function totalIncome($umkmId, $bulan, $tahun, $tipe, $tanggal)
    {
        return Order::where('umkm_id', $umkmId)
            ->whereIn('status', ['dibayar','selesai'])
            ->when(true, function ($q) use ($tipe, $tanggal, $bulan, $tahun) {
                if ($tipe == 'hari') {
                    $q->whereDate('created_at', $tanggal);
                } elseif ($tipe == 'bulan') {
                    $q->whereMonth('created_at', $bulan)
                    ->whereYear('created_at', $tahun);
                } elseif ($tipe == 'tahun') {
                    $q->whereYear('created_at', $tahun);
                }
            })
            ->sum('total');
    }

    public function totalOrders($umkmId, $bulan, $tahun, $tipe, $tanggal)
{
    return Order::where('umkm_id', $umkmId)
        ->whereIn('status', ['dibayar','selesai'])
        ->when(true, function ($q) use ($tipe, $tanggal, $bulan, $tahun) {
            if ($tipe == 'hari') {
                $q->whereDate('created_at', $tanggal);
            } elseif ($tipe == 'bulan') {
                $q->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
            } elseif ($tipe == 'tahun') {
                $q->whereYear('created_at', $tahun);
            }
        })
        ->count();
}

public function totalProducts($umkmId, $bulan, $tahun, $tipe, $tanggal)
{
    return OrderItem::whereHas('order', function ($q) use ($umkmId, $bulan, $tahun, $tipe, $tanggal) {

        $q->where('umkm_id', $umkmId)
          ->whereIn('status', ['dibayar','selesai'])
          ->when(true, function ($q) use ($tipe, $tanggal, $bulan, $tahun) {
              if ($tipe == 'hari') {
                  $q->whereDate('created_at', $tanggal);
              } elseif ($tipe == 'bulan') {
                  $q->whereMonth('created_at', $bulan)
                    ->whereYear('created_at', $tahun);
              } elseif ($tipe == 'tahun') {
                  $q->whereYear('created_at', $tahun);
              }
          });

    })->sum('qty');
}
}
