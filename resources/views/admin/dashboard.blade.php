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
        <h3 class="text-sm text-gray-500">Admin Aktif</h3>
        <p class="text-3xl font-bold mt-2">
            {{ $totalAdmin ?? 1 }}
        </p>
    </div>

</div>

@endsection
