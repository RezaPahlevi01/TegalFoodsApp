<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AdminReportExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\AdminReportService;
use Maatwebsite\Excel\Facades\Excel;

class AdminReportController extends Controller
{
    protected $reportService;

    private const SUCCESSFUL_STATUSES = [
        'paid',
        'processing',
        'ready',
        'delivering',
        'completed',
    ];

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
            'omzetPerUmkm' => $this->reportService->omzetPerUmkm($tipe, $hari, $bulan, $tahun),
            'produkTerlaris' => $this->reportService->produkTerlaris($tipe, $hari, $bulan, $tahun),
            'transaksiTerbaru' => $this->reportService->transaksiTerbaru()
        ]);
    }

    public function export(Request $request)
    {
        $request->validate([
            'exports'   => ['required', 'array', 'min:1'],
            'exports.*' => ['in:monthly,yearly,menus'],
            'year'      => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'month'     => ['nullable', 'integer', 'min:1', 'max:12'],
        ]);

        $exports = $request->exports;
        $year = $request->integer('year', (int) now()->year);
        $month = $request->integer('month', (int) now()->month);

        if (in_array('monthly', $exports)) {
            $request->validate([
                'year'  => ['required', 'integer', 'min:2000', 'max:2100'],
                'month' => ['required', 'integer', 'min:1', 'max:12'],
            ]);
        }

        if (in_array('yearly', $exports)) {
            $request->validate([
                'year' => ['required', 'integer', 'min:2000', 'max:2100'],
            ]);
        }

        $monthlyData = null;
        $yearlyData = null;
        $menuData = null;

        if (in_array('monthly', $exports)) {
            $monthlyData = $this->getReportData($year, $month);
        }

        if (in_array('yearly', $exports)) {
            $yearlyData = $this->getReportData($year);
        }

        if (in_array('menus', $exports)) {
            $menuData = $this->getMenuData();
        }

        $filename = 'laporan-tegalfood-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(
            new AdminReportExport($exports, $year, $month, $monthlyData, $yearlyData, $menuData),
            $filename
        );
    }

    private function getReportData(int $year, ?int $month = null): array
    {
        $successfulStatuses = self::SUCCESSFUL_STATUSES;

        $orderQuery = Order::query()
            ->select(
                'umkm_id',
                DB::raw('COUNT(id) as total_order'),
                DB::raw('SUM(subtotal) as total_omzet')
            )
            ->whereIn('status', $successfulStatuses)
            ->whereYear('created_at', $year)
            ->groupBy('umkm_id');

        if ($month) {
            $orderQuery->whereMonth('created_at', $month);
        }

        $orderData = $orderQuery->get();

        $produkData = OrderItem::query()
            ->select(
                'orders.umkm_id',
                DB::raw('SUM(order_items.qty) as produk_terjual')
            )
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereIn('orders.status', $successfulStatuses)
            ->whereYear('orders.created_at', $year)
            ->when($month, function ($q) use ($month) {
                $q->whereMonth('orders.created_at', $month);
            })
            ->groupBy('orders.umkm_id')
            ->get()
            ->keyBy('umkm_id');

        $umkmList = Umkm::all();

        $report = [];
        $no = 1;
        foreach ($orderData as $item) {
            $umkm = $umkmList->firstWhere('id', $item->umkm_id);
            if (!$umkm) continue;

            $report[] = [
                'no'             => $no++,
                'nama_umkm'      => $umkm->nama_umkm,
                'total_order'    => (int) $item->total_order,
                'produk_terjual' => (int) ($produkData->get($item->umkm_id)->produk_terjual ?? 0),
                'total_omzet'    => (int) $item->total_omzet,
            ];
        }

        usort($report, fn($a, $b) => $b['total_omzet'] <=> $a['total_omzet']);

        return $report;
    }

    private function getMenuData(): array
    {
        $umkms = Umkm::with(['makanans' => function ($q) {
            $q->orderBy('nama_makanan');
        }])->orderBy('nama_umkm')
          ->get();

        $rows = [];
        $no = 1;

        foreach ($umkms as $umkm) {
            if ($umkm->makanans->isEmpty()) {
                continue;
            }

            $first = true;
            foreach ($umkm->makanans as $makanan) {
                $rows[] = [
                    'no'        => $first ? $no : '',
                    'nama_umkm' => $first ? $umkm->nama_umkm : '',
                    'menu'      => $makanan->nama_makanan,
                    'harga'     => (int) $makanan->harga,
                ];
                $first = false;
            }
            $no++;
        }

        return $rows;
    }
}
