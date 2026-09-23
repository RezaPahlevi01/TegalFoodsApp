@extends('layouts.admin')

@section('title', 'Admin - Mitra UMKM')

@section('content')
<div class="container mx-auto px-6 py-10">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Akun Mitra UMKM</h1>

        <a href="{{ route('admin.umkm.create') }}"
           class="px-4 py-2 bg-yellow-500 text-white rounded">
            + Tambah UMKM
        </a>
    </div>

    <form method="GET" action="{{ route('admin.umkm.index') }}" class="mb-6">
        <div class="flex gap-2">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari nama, NIB, atau nama UMKM..."
                class="flex-1 max-w-md px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            <button
                type="submit"
                class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">
                Cari
            </button>
            @if($search)
                <a href="{{ route('admin.umkm.index') }}"
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Reset
                </a>
            @endif
        </div>
    </form>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Nama UMKM</th>
                    <th class="p-3 text-left">NIB</th>
                    <th class="p-3 text-left">Pemilik</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @foreach($umkms as $umkm)
            <tr class="border-t">
                <td class="p-3">
                    {{ $umkm->umkm->nama_umkm ?? '-' }}
                </td>

                <td class="p-3 font-mono text-sm">
                    {{ $umkm->umkm->nib ?? '-' }}
                </td>

                <td class="p-3">
                    {{ $umkm->name }}
                </td>

                <td class="p-3 text-center">
                    <span
                        id="status-text-{{ $umkm->id }}"
                        class="px-3 py-1 rounded-full text-sm
                        {{ $umkm->status === 'active'
                            ? 'bg-green-200 text-green-800'
                            : ($umkm->status === 'non-active'
                                ? 'bg-red-200 text-red-800'
                                : 'bg-yellow-200 text-yellow-800')
                        }}">
                        {{ ucfirst($umkm->status) }}
                    </span>
                </td>

                <td class="p-3 text-center">
                    <div class="flex justify-center items-center gap-2">

                        {{-- DETAIL --}}
                        <a href="{{ route('admin.umkm.show', $umkm->id) }}"
                           class="p-2 rounded hover:bg-blue-100 text-blue-600 hover:text-blue-800 transition"
                           title="Detail">
                            👁️
                        </a>

                        {{-- EDIT --}}
                        <a href="{{ route('admin.umkm.edit', $umkm->id) }}"
                           class="p-2 rounded hover:bg-yellow-100 text-yellow-600 hover:text-yellow-800 transition"
                           title="Edit">
                            ✏️
                        </a>

                        {{-- TOGGLE --}}
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                class="sr-only peer toggle-umkm"
                                data-id="{{ $umkm->id }}"
                                {{ $umkm->status === 'active' ? 'checked' : '' }}
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

                        {{-- DELETE ICON --}}
                        <form action="{{ route('admin.umkm.destroy', $umkm->id) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus UMKM ini? Semua data terkait akan ikut terhapus.')">
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="p-2 rounded hover:bg-red-100 text-red-600 hover:text-red-800 transition"
                                title="Hapus UMKM">
                                🗑️
                            </button>
                        </form>

                    </div>
                </td>

            </tr>
            @endforeach
            </tbody>

        </table>
    </div>

    <div class="mt-6">
        {{ $umkms->links() }}
    </div>

</div>

<script>
document.querySelectorAll('.toggle-umkm').forEach(toggle => {
    toggle.addEventListener('change', function () {

        const userId = this.dataset.id;
        const isActive = this.checked;

        const statusText = document.getElementById(`status-text-${userId}`);

        const url = isActive
            ? `/admin/umkm/activate/${userId}`
            : `/admin/umkm/deactivate/${userId}`;

        fetch(url, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {

            statusText.textContent = data.status === 'active'
                ? 'Active'
                : 'Non-active';

            statusText.className = data.status === 'active'
                ? 'px-3 py-1 bg-green-200 text-green-800 rounded-full text-sm'
                : 'px-3 py-1 bg-red-200 text-red-800 rounded-full text-sm';

        })
        .catch(() => {
            alert('Gagal mengubah status');
            this.checked = !isActive;
        });

    });
});
</script>
@endsection
