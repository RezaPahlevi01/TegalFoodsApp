@extends('layouts.admin')

@section('title', 'Edit Food Blog')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 shadow rounded">

    <h1 class="text-2xl font-bold mb-6">Edit Artikel</h1>

    <form method="POST"
          action="{{ route('admin.foodblog.update', $foodblog) }}">
        @csrf
        @method('PUT')

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
