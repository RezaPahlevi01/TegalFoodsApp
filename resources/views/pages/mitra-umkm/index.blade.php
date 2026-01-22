@extends('layouts.app')

@section('title', 'Mitra UMKM - TegalFood')

@section('content')
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">

        {{-- ================= JUDUL ================= --}}
        <h1 class="text-4xl font-extrabold text-center mb-6">
            Mitra UMKM TegalFood
        </h1>

        <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
            Temukan berbagai mitra UMKM makanan khas Kota Tegal yang telah
            bekerja sama dengan TegalFood.
        </p>

        {{-- ================= SEARCH INPUT ================= --}}
        <input
            type="text"
            id="search"
            placeholder="Cari nama UMKM..."
            class="w-full max-w-md mx-auto mb-14 block
                   px-5 py-3 rounded-xl border border-gray-300
                   focus:ring-2 focus:ring-yellow-400
                   focus:outline-none transition"
        >

        {{-- ================= HASIL UMKM ================= --}}
        <div id="umkm-list">
            {{-- render awal --}}
            @include('partials.list', ['mitra' => $mitra])
        </div>

    </div>
</section>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('search');
    const umkmList = document.getElementById('umkm-list');

    let timeout = null;

    searchInput.addEventListener('keyup', function () {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            fetch(`{{ route('mitra.umkm.search') }}?q=${this.value}`)
                .then(response => response.text())
                .then(html => {
                    umkmList.innerHTML = html;
                })
                .catch(error => {
                    console.error('Search error:', error);
                });
        }, 300); // debounce
    });
</script>
@endpush
