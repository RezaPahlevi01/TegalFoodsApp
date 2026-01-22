@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-xl">
    <h1 class="text-2xl font-bold mb-6">Tambah Slider</h1>

    <form method="POST"
          action="{{ route('admin.slider.store') }}"
          enctype="multipart/form-data"
          class="space-y-4">

        @csrf

        <input type="text"
               name="judul"
               placeholder="Judul (opsional)"
               class="w-full border rounded px-4 py-2">

        <input type="file"
               name="gambar"
               required
               class="w-full border rounded px-4 py-2">

        <button class="px-6 py-2 bg-yellow-500 text-white rounded">
            Simpan
        </button>
    </form>
</div>
@endsection
