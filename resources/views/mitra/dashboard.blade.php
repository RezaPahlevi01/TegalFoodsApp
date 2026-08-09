@extends('layouts.umkm')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">
        Dashboard UMKM
    </h1>
</div>

<div class="bg-white shadow rounded-2xl p-6 border border-gray-100 mb-6">
    <div class="flex items-center gap-6 mb-6">
        <div>
            @if($umkm->logo_url)
                <img src="{{ $media_url($umkm->logo_url) }}"
                     class="w-24 h-24 rounded-full object-cover border">
            @else
                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500 text-sm">No Logo</span>
                </div>
            @endif
        </div>

        <div>
            <h2 class="text-xl font-semibold">{{ $umkm->nama_umkm }}</h2>
            <p class="text-gray-600">Pemilik: {{ $umkm->nama_pemilik }}</p>
            <p class="text-gray-600">WhatsApp: {{ $umkm->nomor_whatsapp }}</p>
        </div>
    </div>

    <hr class="mb-4">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <p class="font-semibold mb-1">Alamat</p>
            <p class="text-gray-700">{{ $umkm->alamat }}</p>
        </div>

        <div>
            <p class="font-semibold mb-1">Deskripsi Toko</p>
            <p class="text-gray-700">{{ $umkm->deskripsi ?? '-' }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white shadow rounded-2xl p-6 border border-gray-100">
        <p class="text-sm text-gray-500">Pengunjung Toko</p>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalVisitors ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-2">Total kunjungan halaman toko</p>
    </div>

    <div class="bg-white shadow rounded-2xl p-6 border border-gray-100">
        <p class="text-sm text-gray-500">View Menu</p>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalMenuViews ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-2">Interaksi saat pengunjung membuka detail menu</p>
    </div>

    <div class="bg-white shadow rounded-2xl p-6 border border-gray-100">
        <p class="text-sm text-gray-500">Jumlah Menu</p>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalMenus ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-2">Menu aktif yang tampil di toko Anda</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <div class="bg-white shadow rounded-2xl p-6 border border-gray-100 xl:col-span-2">
        <div class="mb-5">
            <h3 class="text-lg font-semibold text-gray-900">Tren Pengunjung 7 Hari Terakhir</h3>
            <p class="text-sm text-gray-500">Pantau perkembangan kunjungan ke halaman toko Anda</p>
        </div>
        <canvas id="visitorChart" class="w-full h-72"></canvas>
    </div>

    <div class="bg-white shadow rounded-2xl p-6 border border-gray-100">
        <div class="mb-5">
            <h3 class="text-lg font-semibold text-gray-900">Menu Paling Populer</h3>
            <p class="text-sm text-gray-500">Berdasarkan menu yang paling sering dibuka pengunjung</p>
        </div>
        <canvas id="menuChart" class="w-full h-72"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
window.addEventListener('DOMContentLoaded', () => {
    const visitorCtx = document.getElementById('visitorChart').getContext('2d');
    const menuCtx = document.getElementById('menuChart').getContext('2d');

    new Chart(visitorCtx, {
        type: 'line',
        data: {
            labels: @json($visitorChartLabels),
            datasets: [{
                label: 'Pengunjung Toko',
                data: @json($visitorChartData),
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245, 158, 11, 0.18)',
                tension: 0.35,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    new Chart(menuCtx, {
        type: 'bar',
        data: {
            labels: @json($popularMenusLabels),
            datasets: [{
                label: 'View Menu',
                data: @json($popularMenusData),
                backgroundColor: ['#f59e0b', '#fbbf24', '#fb923c', '#f97316', '#ea580c'],
                borderRadius: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

@endsection
