@extends('layouts.admin')

@section('header')
Laporan Platform
@endsection

@section('content')

<div class="space-y-8">

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form method="GET" class="flex flex-wrap items-end gap-4">

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Tipe
                </label>

                <select name="tipe"
                        class="border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-orange-400">

                    <option value="hari" {{ $tipe=='hari'?'selected':'' }}>
                        Harian
                    </option>

                    <option value="bulan" {{ $tipe=='bulan'?'selected':'' }}>
                        Bulanan
                    </option>

                    <option value="tahun" {{ $tipe=='tahun'?'selected':'' }}>
                        Tahunan
                    </option>

                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Tanggal
                </label>

                <input type="date"
                       name="tanggal"
                       value="{{ $tanggal ?? now()->format('Y-m-d') }}"
                       class="border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-orange-400"> 
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Bulan
                </label>

                <select name="bulan"
                        class="border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-orange-400">

                    @for($i=1;$i<=12;$i++)
                        <option value="{{ $i }}"
                            {{ $bulan==$i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m',$i)->format('F') }}
                        </option>
                    @endfor

                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Tahun
                </label>

                <select name="tahun"
                        class="border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-orange-400">

                    @for($y=2025;$y<=date('Y');$y++)
                        <option value="{{ $y }}"
                            {{ $tahun==$y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor

                </select>
            </div>

            <button
                class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-xl transition">
                Filter
            </button>

        </form>
    </div>

    {{-- EXPORT EXCEL --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Export Laporan</h3>

        <form method="POST" action="{{ route('admin.report.export') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Jenis Data</label>
                <div class="flex flex-wrap gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="exports[]" value="monthly"
                               class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-400"
                               onchange="toggleMonthYear()">
                        <span class="text-sm text-gray-700">Laporan Bulanan</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="exports[]" value="yearly"
                               class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-400"
                               onchange="toggleMonthYear()">
                        <span class="text-sm text-gray-700">Laporan Tahunan</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="exports[]" value="menus"
                               class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-400">
                        <span class="text-sm text-gray-700">Menu UMKM</span>
                    </label>
                </div>
            </div>

            <div class="flex flex-wrap gap-4" id="filterPeriode">
                <div id="bulanField">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Bulan</label>
                    <select name="month"
                            class="border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-orange-400">
                        @for($i=1;$i<=12;$i++)
                            <option value="{{ $i }}" {{ $bulan==$i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m',$i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div id="tahunField">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Tahun</label>
                    <select name="year"
                            class="border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-orange-400">
                        @for($y=2025;$y<=date('Y');$y++)
                            <option value="{{ $y }}" {{ $tahun==$y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            @error('exports')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-xl transition">
                Export Excel
            </button>
        </form>
    </div>

    {{-- CARD --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <p class="text-gray-500 text-sm">
                Total Omzet
            </p>

            <h2 class="text-3xl font-bold text-green-600 mt-3">
                Rp {{ number_format($totalOmzet,0,',','.') }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <p class="text-gray-500 text-sm">
                Total Order
            </p>

            <h2 class="text-3xl font-bold text-blue-600 mt-3">
                {{ $totalOrder }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <p class="text-gray-500 text-sm">
                Produk Terjual
            </p>

            <h2 class="text-3xl font-bold text-orange-500 mt-3">
                {{ $totalProduk }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <p class="text-gray-500 text-sm">
                Total UMKM
            </p>

            <h2 class="text-3xl font-bold text-purple-600 mt-3">
                {{ $totalUmkm }}
            </h2>
        </div>

    </div>

    {{-- OMZET SEMUA UMKM --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="flex items-center justify-between px-6 py-5 border-b">

            <div>

                <h2 class="text-xl font-bold text-gray-800">
                    Omzet Semua UMKM
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Rekap omzet seluruh UMKM berdasarkan transaksi selesai.
                </p>

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-orange-50">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold">
                        No
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold">
                        Nama UMKM
                    </th>

                    <th class="px-6 py-4 text-center text-sm font-semibold">
                        Total Order
                    </th>

                    <th class="px-6 py-4 text-center text-sm font-semibold">
                        Produk Terjual
                    </th>

                    <th class="px-6 py-4 text-right text-sm font-semibold">
                        Total Omzet
                    </th>

                </tr>

                </thead>

                <tbody>

                @forelse($omzetPerUmkm as $index=>$item)

                    <tr class="border-b hover:bg-orange-50 transition">

                        <td class="px-6 py-4">
                            {{ $index+1 }}
                        </td>

                        <td class="px-6 py-4 font-semibold">
                            {{ optional($item->umkm)->nama_umkm }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $item->total_order }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ $item->total_produk }}
                        </td>

                        <td class="px-6 py-4 text-right font-bold text-green-600">
                            Rp {{ number_format($item->total_omzet,0,',','.') }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="py-10 text-center text-gray-500">

                            Belum ada data transaksi.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>
function toggleMonthYear() {
    const monthly = document.querySelector('input[value="monthly"]');
    const yearly = document.querySelector('input[value="yearly"]');
    const bulanField = document.getElementById('bulanField');
    const tahunField = document.getElementById('tahunField');

    const showBulan = monthly.checked;
    const showTahun = monthly.checked || yearly.checked;

    bulanField.style.display = showBulan ? 'block' : 'none';
    tahunField.style.display = showTahun ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', toggleMonthYear);
</script>

@endsection