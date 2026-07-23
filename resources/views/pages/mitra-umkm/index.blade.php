<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mitra UMKM - TegalFood</title>
   <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style type="text/tailwindcss">
        @layer theme {
            extend {
                colors: {
                    'brand-primary': '#800000', // Maroon
                    'brand-secondary': '#F5F5DC', // Beige
                    'brand-accent': '#FFC107', // Kuning Emas
                    'brand-text': '#333333',
                }
            }
        }
    </style>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <a href="/" class="flex items-center text-2xl font-bold text-brand-primary">
                <img src="{{ asset('images/logo.png') }}" alt="TegalFood Logo" class="h-55 w-55 mr-2 object-contain">
            </a>
            <div>
                <a href="\welcome" class="text-brand-primary font-semibold hover:underline">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </nav>
    </header>
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