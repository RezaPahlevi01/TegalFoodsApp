<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<style>

body{

font-family: DejaVu Sans;

font-size:12px;

}

table{

width:100%;

border-collapse:collapse;

margin-top:20px;

}

th,td{

border:1px solid #000;

padding:8px;

}

th{

background:#f3f3f3;

}

</style>

</head>

<body>

<h2>Laporan Penjualan UMKM</h2>

<p>

<b>Nama UMKM :</b>

{{ $umkm->nama_umkm }}

</p>

<p>

Periode :

{{ $bulan }}/{{ $tahun }}

</p>

<hr>

<p>Total Pendapatan :

Rp {{ number_format($totalIncome,0,',','.') }}

</p>

<p>Total Pesanan :

{{ $totalOrders }}

</p>

<p>Total Produk Terjual :

{{ $totalProducts }}

</p>

<table>

<thead>

<tr>

<th>Produk</th>

<th>Qty</th>

<th>Pendapatan</th>

</tr>

</thead>

<tbody>

@foreach($report as $item)

<tr>

<td>

{{ optional($item->makanan)->nama_makanan }}

</td>

<td>

{{ $item->total_terjual }}

</td>

<td>

Rp {{ number_format($item->total_pendapatan,0,',','.') }}

</td>

</tr>

@endforeach

</tbody>

</table>

</body>
</html>