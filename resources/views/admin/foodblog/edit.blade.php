@extends('layouts.admin')

@section('title', 'Edit Food Blog')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 shadow rounded">

    <h1 class="text-2xl font-bold mb-6">Edit Artikel</h1>

    <form method="POST"
        action="{{ route('admin.foodblog.update', $foodblog) }}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')


        <div class="mb-4">
            <label class="block font-semibold mb-2">Gambar</label>
            <input type="file" name="image"
                   class="w-full border p-3 rounded">

            @if ($foodblog->image)
                <img src="{{ asset('storage/' . $foodblog->image) }}"
                     alt="Gambar Artikel"
                     class="mt-4 w-32 h-32 object-cover rounded">
            @endif
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Judul</label>
            <input type="text" name="title"
                   value="{{ $foodblog->title }}"
                   class="w-full border p-3 rounded"
                   required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Konten</label>
            <textarea name="content" rows="7"
                      class="w-full border p-3 rounded"
                      required>{{ $foodblog->content }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block font-semibold mb-2">Status</label>
            <select name="status"
                    class="w-full border p-3 rounded">
                <option value="draft" {{ $foodblog->status === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ $foodblog->status === 'published' ? 'selected' : '' }}>Publish</option>
            </select>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.foodblog.index') }}"
               class="px-4 py-2 border rounded">
                Kembali
            </a>

            <button class="bg-blue-600 text-white px-6 py-2 rounded">
                Update
            </button>
        </div>

    </form>
</div>
@endsection
