<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\MenuView;
use App\Models\UmkmView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    // ===============================
    // DASHBOARD UMKM
    // ===============================
    public function index()
    {
        $user = Auth::guard('umkm')->user();
        $umkm = $user->umkm()->with('makanans')->first();

        // Jika belum buat profil
        if (!$umkm) {
            return redirect()->route('umkm.profile.edit');
        }

        $startDate = now()->subDays(6)->toDateString();
        $endDate = now()->toDateString();

        $dailyVisitors = UmkmView::select(
                'view_date',
                DB::raw('COUNT(DISTINCT session_id) as total')
            )
            ->where('umkm_id', $umkm->id)
            ->whereBetween('view_date', [$startDate, $endDate])
            ->groupBy('view_date')
            ->orderBy('view_date')
            ->pluck('total', 'view_date');

        $visitorChartLabels = [];
        $visitorChartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $visitorChartLabels[] = Carbon::parse($date)->translatedFormat('d M');
            $visitorChartData[] = $dailyVisitors->get($date) ?? 0;
        }

        $popularMenus = $umkm->makanans()
            ->leftJoin('menu_views', 'makanans.id', '=', 'menu_views.makanan_id')
            ->select(
                'makanans.id',
                'makanans.nama_makanan',
                DB::raw('COUNT(menu_views.id) as total_views')
            )
            ->groupBy('makanans.id', 'makanans.nama_makanan')
            ->orderByDesc('total_views')
            ->limit(5)
            ->get();

        return view('mitra.dashboard', [
            'umkm' => $umkm,
            'totalVisitors' => UmkmView::where('umkm_id', $umkm->id)->count(),
            'totalMenuViews' => MenuView::where('umkm_id', $umkm->id)->count(),
            'totalMenus' => $umkm->makanans->count(),
            'visitorChartLabels' => $visitorChartLabels,
            'visitorChartData' => $visitorChartData,
            'popularMenusLabels' => $popularMenus->pluck('nama_makanan')->map(
                fn ($name) => str($name)->limit(24)->toString()
            )->all(),
            'popularMenusData' => $popularMenus->pluck('total_views')->all(),
        ]);
    }

    // ===============================
    // FORM EDIT PROFILE
    // ===============================
    public function editProfile()
    {
        $user = Auth::guard('umkm')->user();
        $umkm = $user->umkm;

        return view('mitra.profile.edit', compact('umkm'));
    }

    // ===============================
    // UPDATE PROFILE UMKM
    // ===============================
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('umkm')->user();
        $umkm = $user->umkm;

        $request->validate([
            'nama_umkm' => 'required',
            'nama_pemilik' => 'required',
            'nomor_whatsapp' => 'required|numeric|digits_between:10,15',
            'alamat' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'deskripsi' => 'nullable',
            'jam_buka' => 'nullable|date_format:H:i',
            'jam_tutup' => 'nullable|date_format:H:i',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'foto_qris' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $cloudinary = app(\App\Services\CloudinaryService::class);

        // ===============================
        // UPLOAD LOGO
        // ===============================
        if ($request->hasFile('logo')) {
            $logoUrl = $cloudinary->upload($request->file('logo'), 'umkm/logo');
            if ($logoUrl) {
                $umkm->logo_url = $logoUrl;
            }
        }

        // ===============================
        // UPLOAD QRIS
        // ===============================
        if ($request->hasFile('foto_qris')) {
            $qrisUrl = $cloudinary->upload($request->file('foto_qris'), 'umkm/qris');
            if ($qrisUrl) {
                $umkm->foto_qris = $qrisUrl;
            }
        }

        // ===============================
        // UPDATE DATA UMKM
        // ===============================
        $umkm->update([
            'nama_umkm' => $request->nama_umkm,
            'nama_pemilik' => $request->nama_pemilik,
            'nomor_whatsapp' => $request->nomor_whatsapp,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'deskripsi' => $request->deskripsi,
            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
        ]);

        return redirect()
            ->route('umkm.dashboard')
            ->with('success', 'Profil UMKM berhasil diperbarui');
    }
}
