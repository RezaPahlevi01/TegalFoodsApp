@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('header', 'Dashboard Admin')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- CARD --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-sm text-gray-500">Total Mitra UMKM</h3>
        <p class="text-3xl font-bold mt-2">
            {{ $totalUmkm ?? 0 }}
        </p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-sm text-gray-500">Total Menu</h3>
        <p class="text-3xl font-bold mt-2">
            {{ $totalMenu ?? 0 }}
        </p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-sm text-gray-500">Total Artikel</h3>
        <p class="text-3xl font-bold mt-2">
            {{ $totalBlog ?? 0 }}
        </p>
    </div>

    {{-- CHART --}}
    <div class="bg-white p-6 rounded-xl shadow mt-8 md:col-span-3">
        <h3 class="text-lg font-semibold mb-4">Pertumbuhan UMKM di Kota Tegal</h3>
        <canvas id="umkmChart" class="w-full h-64"></canvas>
    </div>

</div>

<!-- SCRIPT HARUS DI BAWAH -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
window.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('umkmChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Jumlah UMKM',
                data: @json($chartData),
                borderColor: '#facc15',
                backgroundColor: 'rgba(250, 204, 21, 0.2)',
                tension: 0.4,
                fill: true
            }]
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
});
</script>

@endsection