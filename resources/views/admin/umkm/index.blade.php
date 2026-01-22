@extends('layouts.admin')

@section('title', 'Admin - Mitra UMKM')

@section('content')
<div class="container mx-auto px-6 py-10">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Data Mitra UMKM</h1>

        <a href="{{ route('admin.umkm.create') }}"
           class="px-4 py-2 bg-yellow-500 text-white rounded">
            + Tambah UMKM
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Nama UMKM</th>
                <th class="p-3">Pemilik</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @foreach($umkms as $umkm)
            <tr class="border-t">
                <td class="p-3">{{ $umkm->nama_umkm }}</td>
                <td class="p-3 text-center">{{ $umkm->nama_pemilik }}</td>
                <td class="p-3 text-center flex justify-center gap-2">

                    <a href="{{ route('admin.umkm.edit', $umkm) }}"
                       class="px-3 py-1 bg-blue-500 text-white rounded">
                        Edit
                    </a>

                    <form action="{{ route('admin.umkm.destroy', $umkm) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus UMKM ini?')">
                        @csrf
                        @method('DELETE')

                        <button class="px-3 py-1 bg-red-500 text-white rounded">
                            Hapus
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        {{ $umkms->links() }}
    </div>

</div>
@endsection
