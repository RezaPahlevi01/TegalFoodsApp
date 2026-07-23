<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AdminReportService;

class AdminReportController extends Controller
{
    protected $reportService;

    public function __construct(AdminReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index(Request $request)
    {
        $tipe = $request->tipe ?? 'hari';
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        $hari = $request->hari ?? now()->day;

$summary = $this->reportService->summary($tipe, $hari, $bulan, $tahun);

        return view('admin.report.index', [

            'tipe' => $tipe,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'hari' => $hari,

            'totalOmzet'  => $summary['totalOmzet'],
            'totalOrder'  => $summary['totalOrder'],
            'totalProduk' => $summary['totalProduk'],
            'totalUmkm' => User::where('role', 'umkm')->count(),

            'omzetPerUmkm' => $this->reportService->omzetPerUmkm($tipe,$hari,$bulan,$tahun),
            'produkTerlaris' => $this->reportService->produkTerlaris($tipe,$hari,$bulan,$tahun),

            'transaksiTerbaru' => $this->reportService->transaksiTerbaru()

        ]);
    }
}