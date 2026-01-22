@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">Slider Welcome Page</h1>
        <a href="{{ route('admin.slider.create') }}"
           class="px-4 py-2 bg-yellow-500 rounded text-white">
            Tambah Slider
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($sliders as $slider)
            <div class="bg-white rounded shadow overflow-hidden">
                <img src="{{ asset('storage/'.$slider->gambar) }}"
                     class="w-full h-48 object-cover">

                <div class="p-4 flex justify-between items-center">
                    <span>{{ $slider->judul }}</span>

                    <form method="POST"
                          action="{{ route('admin.slider.destroy', $slider) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
