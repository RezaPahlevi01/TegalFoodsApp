@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('header', 'Dashboard Admin')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">
    <div class="bg-gradient-to-br from-yellow-50 to-white p-6 rounded-2xl border border-yellow-100 shadow-sm">
        <h3 class="text-sm text-gray-500">Pengunjung Web</h3>
        <p class="text-3xl font-bold mt-2 text-gray-900">{{ $totalWebVisitors ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-2">Total sesi pengunjung unik</p>
    </div>

    <div class="bg-gradient-to-br from-orange-50 to-white p-6 rounded-2xl border border-orange-100 shadow-sm">
        <h3 class="text-sm text-gray-500">Pembaca Artikel</h3>
        <p class="text-3xl font-bold mt-2 text-gray-900">{{ $totalArticleViews ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-2">Total view artikel yang tercatat</p>
    </div>

    <div class="bg-gradient-to-br from-emerald-50 to-white p-6 rounded-2xl border border-emerald-100 shadow-sm">
        <h3 class="text-sm text-gray-500">View Toko UMKM</h3>
        <p class="text-3xl font-bold mt-2 text-gray-900">{{ $totalStoreViews ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-2">Jumlah kunjungan ke halaman toko</p>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <h3 class="text-sm text-gray-500">Total Mitra UMKM</h3>
        <p class="text-3xl font-bold mt-2 text-gray-900">{{ $totalUmkm ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-2">Akun UMKM yang terdaftar</p>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <h3 class="text-sm text-gray-500">Konten Tersedia</h3>
        <p class="text-3xl font-bold mt-2 text-gray-900">{{ ($totalMenu ?? 0) + ($totalBlog ?? 0) }}</p>
        <p class="text-xs text-gray-500 mt-2">{{ $totalMenu ?? 0 }} menu dan {{ $totalBlog ?? 0 }} artikel</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-8">
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm xl:col-span-2">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Tren Pengunjung 7 Hari Terakhir</h3>
                <p class="text-sm text-gray-500">Perbandingan trafik web dan pembaca artikel</p>
            </div>
        </div>
        <canvas id="trafficChart" class="w-full h-72"></canvas>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="mb-5">
            <h3 class="text-lg font-semibold text-gray-900">Artikel Paling Banyak Dibaca</h3>
            <p class="text-sm text-gray-500">Top 5 artikel berdasarkan jumlah view</p>
        </div>
        <canvas id="articleChart" class="w-full h-72"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
window.addEventListener('DOMContentLoaded', () => {
    const trafficCtx = document.getElementById('trafficChart').getContext('2d');
    const articleCtx = document.getElementById('articleChart').getContext('2d');

    new Chart(trafficCtx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [
                {
                    label: 'Pengunjung Web',
                    data: @json($visitorChartData),
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.18)',
                    tension: 0.35,
                    fill: true
                },
                {
                    label: 'Pembaca Artikel',
                    data: @json($articleChartData),
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.08)',
                    tension: 0.35,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#374151'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    new Chart(articleCtx, {
        type: 'bar',
        data: {
            labels: @json($popularArticlesLabels),
            datasets: [{
                label: 'View Artikel',
                data: @json($popularArticlesData),
                backgroundColor: ['#f59e0b', '#fb923c', '#f97316', '#ef4444', '#dc2626'],
                borderRadius: 10
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

@endsection
