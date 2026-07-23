@extends('layouts.umkm')

@section('content')

{{-- HEADER --}}
<div class="mb-4">
    <h1 class="text-2xl font-bold">Laporan Penjualan UMKM</h1>
    <p class="text-gray-500 mt-1">
        Statistik penjualan berdasarkan hari / bulan / tahun
    </p>
</div>

{{-- FILTER --}}
<form method="GET" class="grid md:grid-cols-4 gap-4 bg-white p-5 rounded-2xl shadow">

    {{-- TIPE FILTER --}}
    <div>
        <label class="block mb-2 font-semibold">Tipe</label>

        <select name="tipe" class="w-full border rounded-xl p-3">
            <option value="hari" {{ $tipe=='hari'?'selected':'' }}>Harian</option>
            <option value="bulan" {{ $tipe=='bulan'?'selected':'' }}>Bulanan</option>
            <option value="tahun" {{ $tipe=='tahun'?'selected':'' }}>Tahunan</option>
        </select>
    </div>

    {{-- TANGGAL (HARIAN) --}}
    <div>
        <label class="block mb-2 font-semibold">Tanggal</label>
        <input type="date"
               name="tanggal"
               value="{{ $tanggal ?? now()->format('Y-m-d') }}"
               class="w-full border rounded-xl p-3">
    </div>

    {{-- BULAN --}}
    <div>
        <label class="block mb-2 font-semibold">Bulan</label>

        <select name="bulan" class="w-full border rounded-xl p-3">
            @for($i=1;$i<=12;$i++)
                <option value="{{ $i }}" {{ $bulan==$i?'selected':'' }}>
                    {{ DateTime::createFromFormat('!m',$i)->format('F') }}
                </option>
            @endfor
        </select>
    </div>

    {{-- TAHUN --}}
    <div>
        <label class="block mb-2 font-semibold">Tahun</label>

        <select name="tahun" class="w-full border rounded-xl p-3">
            @for($i=date('Y');$i>=2024;$i--)
                <option value="{{ $i }}" {{ $tahun==$i?'selected':'' }}>
                    {{ $i }}
                </option>
            @endfor
        </select>
    </div>

    {{-- BUTTON --}}
    <div class="md:col-span-4 flex justify-end">
        <button type="submit"
            class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl">
            Tampilkan
        </button>
    </div>

</form>

{{-- PDF --}}
<div class="mt-4">
    <button
        onclick="window.location.href='{{ route('umkm.report.pdf',[
            'tipe'=>$tipe,
            'tanggal'=>$tanggal ?? null,
            'bulan'=>$bulan,
            'tahun'=>$tahun
        ]) }}'"
        class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-xl">

        Export PDF
    </button>
</div>

{{-- CARD --}}
<div class="grid md:grid-cols-4 gap-4 mt-6">

    <div class="bg-white rounded-2xl shadow p-6">
        <p>Total Pendapatan</p>
        <h2 class="text-2xl font-bold text-green-600">
            Rp {{ number_format($totalIncome ?? 0,0,',','.') }}
        </h2>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <p>Total Pesanan</p>
        <h2 class="text-2xl font-bold text-blue-600">
            {{ $totalOrders ?? 0 }}
        </h2>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <p>Produk Terjual</p>
        <h2 class="text-2xl font-bold text-orange-600">
            {{ $totalProducts ?? 0 }}
        </h2>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <p>Produk Terlaris</p>

        @if($bestSeller)
            <h2 class="text-lg font-bold text-purple-600">
                {{ $bestSeller?->makanan?->nama_makanan ?? '-' }}
            </h2>

            <p class="text-gray-500">
                {{ $bestSeller->total_terjual ?? 0 }} terjual
            </p>
        @else
            <h2 class="text-gray-400">-</h2>
        @endif
    </div>

</div>

{{-- TABLE --}}
<div class="bg-white rounded-2xl shadow mt-6">

    <div class="p-5 border-b">
        <h2 class="text-xl font-bold">Detail Produk Terjual</h2>
    </div>

    <table class="w-full">

        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-4 text-left">No</th>
                <th class="px-6 py-4 text-left">Produk</th>
                <th class="px-6 py-4 text-center">Qty</th>
                <th class="px-6 py-4 text-right">Pendapatan</th>
            </tr>
        </thead>

        <tbody>

        @forelse($report as $item)

            <tr class="border-t hover:bg-orange-50">

                <td class="px-6 py-4">
                    {{ $loop->iteration }}
                </td>

                <td class="px-6 py-4 font-semibold">
                    {{ $item?->makanan?->nama_makanan ?? '-' }}
                </td>

                <td class="px-6 py-4 text-center">
                    {{ $item->total_terjual ?? 0 }}
                </td>

                <td class="px-6 py-4 text-right font-bold text-green-600">
                    Rp {{ number_format($item->total_pendapatan ?? 0,0,',','.') }}
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="4" class="text-center py-10 text-gray-500">
                    Belum ada data
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection