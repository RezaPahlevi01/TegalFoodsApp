@extends('layouts.admin')

@section('title', 'Tambah Food Blog')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 shadow rounded">

    <h1 class="text-2xl font-bold mb-6">Tambah Artikel</h1>

    <form method="POST"
          enctype="multipart/form-data"
          action="{{ route('admin.foodblog.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-2">Judul</label>
            <input type="text" name="title"
                   class="w-full border p-3 rounded"
                   required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Konten</label>
            <textarea name="content" rows="7"
                      class="w-full border p-3 rounded"
                      required></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Gambar</label>
            <input type="file" name="image"
                   class="w-full border p-2 rounded">
        </div>

        <div class="mb-6">
            <label class="block font-semibold mb-2">Status</label>
            <select name="status"
                    class="w-full border p-3 rounded">
                <option value="draft">Draft</option>
                <option value="published">Publish</option>
            </select>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.foodblog.index') }}"
               class="px-4 py-2 border rounded">
                Batal
            </a>

            <button class="bg-green-600 text-white px-6 py-2 rounded">
                Simpan
            </button>
        </div>

    </form>
</div>
@endsection
