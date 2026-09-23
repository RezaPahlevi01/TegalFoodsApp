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
        $tipe = $request->tipe ?? 'bulan';
        $tanggal = $request->tanggal ?? now()->format('Y-m-d');
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $user = Auth::guard('umkm')->user();

        $umkm = Umkm::where('user_id',$user->id)->firstOrFail();

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

        $totalProducts = $this->reportService->totalProducts($umkm->id, $bulan, $tahun, $tipe, $tanggal);

        $bestSeller = $this->reportService->bestSeller($report);

        $pdf = Pdf::loadView(
            'mitra.report.pdf',
            compact(
                'report',
                'bulan',
                'tahun',
                'tipe',
                'tanggal',
                'totalIncome',
                'totalOrders',
                'totalProducts',
                'bestSeller',
                'umkm'
            )
        );

        return $pdf->download(
            "laporan-$umkm->nama_umkm-$tipe-$bulan-$tahun.pdf"
        );
    }
}
