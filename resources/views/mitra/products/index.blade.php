@extends('layouts.umkm')

@section('content')

<div class="max-w-7xl mx-auto p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Produk UMKM</h2>

    <a href="{{ route('umkm.products.create') }}"
    class="inline-flex items-center gap-2
            bg-green-500 hover:bg-green-600
            text-white text-sm font-semibold
            px-4 py-2 rounded-lg shadow-sm
            transition">
        + Tambah Produk
    </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded-xl">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="p-4 text-left font-semibold">Foto</th>
                    <th class="p-4 text-left font-semibold">Nama</th>
                    <th class="p-4 text-left font-semibold">Harga</th>
                    <th class="p-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>

        <tbody class="divide-y">
                @foreach($umkm->makanans as $makanan)
                <tr class="border-b">
                    <td class="p-3">
                        @if($makanan->gambar_url)
                        <img src="{{ asset('storage/' . $makanan->gambar_url) }}"
                            class="w-16 h-16 object-cover rounded-lg border">
                        @else
                            -
                        @endif
                    </td>

                    <td class="p-3">{{ $makanan->nama_makanan }}</td>

                    <td class="p-3">
                        Rp {{ number_format($makanan->harga) }}
                    </td>

                    <td class="p-3 text-center">
                    <div class="flex justify-center gap-2">

                        <a href="{{ route('umkm.products.edit',$makanan->id) }}"
                        class="px-3 py-1 text-xs font-semibold
                                bg-blue-100 text-blue-600
                                rounded-md hover:bg-blue-200 transition">
                            Edit
                        </a>

                        <form action="{{ route('umkm.products.destroy',$makanan->id) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')

                            <button
                                class="px-3 py-1 text-xs font-semibold
                                    bg-red-100 text-red-600
                                    rounded-md hover:bg-red-200 transition">
                                Hapus
                            </button>
                        </form>

                    </div>
                    </td>
                </tr>
                @endforeach

                @if($products->count() == 0)
                <tr>
                <td colspan="4" class="p-10 text-center text-gray-500">
                    <p class="mb-2">📦 Belum ada produk</p>
                    <p class="text-sm">Klik <strong>Tambah Produk</strong> untuk mulai jualan</p>
                </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>

@endsection
