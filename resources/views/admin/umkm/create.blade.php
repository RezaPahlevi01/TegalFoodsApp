@extends('layouts.admin')

@section('title', 'Tambah UMKM')

@section('content')
<div class="container mx-auto px-6 py-10 max-w-2xl">

    <h1 class="text-2xl font-bold mb-6">Tambah Mitra UMKM</h1>

    <form action="{{ route('admin.umkm.store') }}" method="POST" class="space-y-4">
        @csrf

        <input name="name" placeholder="Nama akun" class="w-full border p-3 rounded">
        <input name="email" type="email" placeholder="Email" class="w-full border p-3 rounded">
        <input name="role" type="hidden" value="umkm" class="w-full border p-3 rounded">
        <input name="password" type="password" placeholder="Password" class="w-full border p-3 rounded">
        <input name="password_confirmation" type="password" placeholder="Konfirmasi Password" class="w-full border p-3 rounded">
        <input name="status" type="hidden" value="non-active" class="w-full border p-3 rounded">
        <button class="px-6 py-3 bg-yellow-500 text-white rounded">
            Simpan
        </button>
    </form>

</div>
@endsection
