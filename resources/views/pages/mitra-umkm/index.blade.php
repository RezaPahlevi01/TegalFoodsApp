<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mitra UMKM - TegalFood</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
       <a href="{{ url('/') }}"
           class="inline-flex items-center gap-2 mb-5
                  text-yellow-600 font-semibold
                  hover:text-yellow-700 transition">
            ← Kembali ke Beranda
        </a>
<section class="py-20 bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4">

         {{-- ================= JUDUL ================= --}}
        <h1 class="text-4xl font-extrabold text-center mb-6">
            Mitra UMKM TegalFood
        </h1>

        <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
            Temukan berbagai mitra UMKM makanan khas Kota Tegal yang telah
            bekerja sama dengan TegalFood.
        </p>

        {{-- ================= SEARCH INPUT ================= --}}
        <div class="flex justify-center">
            <input
                type="text"
                id="search"
                placeholder="Cari nama UMKM..."
                class="w-full max-w-md
                       px-5 py-3 rounded-xl border border-gray-300
                       focus:ring-2 focus:ring-yellow-400
                       focus:outline-none transition shadow-sm"
            >
        </div>

        {{-- ================= HASIL UMKM ================= --}}
        <div id="umkm-list" class="mt-14">
            @include('partials.list', ['mitra' => $mitra])
        </div>

    </div>
</section>

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
        }, 300);
    });
</script>

</body>
</html>