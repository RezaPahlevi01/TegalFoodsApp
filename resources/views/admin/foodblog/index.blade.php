@extends('layouts.admin')

@section('title', 'Admin - Food Blog')

@section('content')
<div class="container mx-auto px-6 py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Food Blog</h1>

        <a href="{{ route('admin.foodblog.create') }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
            + Tambah Artikel
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full bg-white shadow rounded overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-4 text-left">Judul</th>
                <th class="p-4 text-center">Status</th>
                <th class="p-4 text-center">Tanggal</th>
                <th class="p-4 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @forelse($blogs as $blog)
            <tr class="border-t hover:bg-gray-50">
            <td class="p-4 font-semibold">
                {{ $blog->title }}
            </td>
            <td class="p-4 text-center">
                {{-- TOGGLE --}}
                <label class="relative inline-flex items-center cursor-pointer">
                    <input
                        type="checkbox"
                        class="sr-only peer toggle-status"
                        data-id="{{ $blog->id }}"
                        {{ $blog->status === 'published' ? 'checked' : '' }}
                    >
                    <div class="w-11 h-6 bg-gray-300 rounded-full peer
                        peer-checked:bg-green-600
                        after:content-['']
                        after:absolute after:top-0.5 after:left-[2px]
                        after:bg-white after:rounded-full after:h-5 after:w-5
                        after:transition-all
                        peer-checked:after:translate-x-full">
                    </div>
                </label>
            </td>
                <td class="p-4 text-center text-sm text-gray-600">
                    {{ $blog->created_at->format('d M Y') }}
                </td>

                <td class="p-4 text-center flex justify-center gap-3">

                    <a href="{{ route('admin.foodblog.edit', $blog) }}"
                       class="text-blue-600 hover:underline">
                        Edit
                    </a>

                    <form method="POST"
                        action="{{ route('admin.foodblog.destroy', $blog) }}"
                        onsubmit="return confirm('Hapus artikel ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="p-6 text-center text-gray-500">
                    Belum ada artikel
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-6">
        {{ $blogs->links() }}
    </div>

</div>
<script>
document.querySelectorAll('.toggle-status').forEach(toggle => {
    toggle.addEventListener('change', function () {

        const checkbox = this;
        const blogId = checkbox.dataset.id;

        const url = checkbox.checked
            ? `/admin/foodblog/published/${blogId}`
            : `/admin/foodblog/draft/${blogId}`;

        fetch(url, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error('Request failed');
            return res.json();
        })
        .then(data => {
            checkbox.checked = data.status === 'published';
        })
        .catch(() => {
            alert('Gagal mengubah status');
            checkbox.checked = !checkbox.checked;
        });
    });
});
</script>
@endsection