@extends('layouts.umkm')

@section('content')

<div class="max-w-7xl mx-auto p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Produk UMKM</h2>

        <a href="{{ route('umkm.products.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded">
            + Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Foto</th>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Harga</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($umkm->makanans as $makanan)
                <tr class="border-b">
                    <td class="p-3">
                        @if($makanan->gambar_url)
                          <img src="{{ asset('storage/' . $makanan->gambar_url) }}"
                            class="w-32 h-32 object-cover rounded">
                        @else
                            -
                        @endif
                    </td>

                    <td class="p-3">{{ $makanan->nama_makanan }}</td>

                    <td class="p-3">
                        Rp {{ number_format($makanan->harga) }}
                    </td>

                    <td class="p-3 text-center">
                        <a href="{{ route('umkm.products.edit',$makanan->id) }}"
                           class="bg-blue-500 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        <form action="{{ route('umkm.products.destroy',$makanan->id) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Hapus produk ini?')">

                            @csrf
                            @method('DELETE')

                            <button class="bg-red-500 text-white px-3 py-1 rounded">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @if($products->count() == 0)
                <tr>
                    <td colspan="5" class="text-center p-5 text-gray-500">
                        Produk belum ada
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>

@endsection
