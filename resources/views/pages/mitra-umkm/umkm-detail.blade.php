<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>{{ $umkm->nama_umkm }} - TegalFood</title>

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

</head>
<body class="antialiased bg-brand-secondary text-brand-text">

    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <a href="/" class="flex items-center text-2xl font-bold text-brand-primary">
                <img src="{{ asset('images/logo.png') }}" alt="TegalFood Logo" class="h-55 w-55 mr-2 object-contain">
            </a>
            <div>
                <a href="/mitra-umkm" class="text-brand-primary font-semibold hover:underline">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </nav>
    </header>

    <section class="container mx-auto px-4 sm:px-6 lg:px-8 mt-12">
        <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <img src="{{ asset('storage/' . $umkm->logo_url) }}" alt="{{ $umkm->nama_umkm }}" class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover shadow-md flex-shrink-0">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl font-bold text-brand-primary">{{ $umkm->nama_umkm }}</h1>
                    <p class="text-lg text-gray-700 mt-2">{{ $umkm->deskripsi }}</p>
                    
                    <div class="mt-4 space-y-2 text-gray-600">
                        <div class="flex items-center justify-center md:justify-start gap-2">
                            <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>Pemilik: {{ $umkm->nama_pemilik }}</span>
                        </div>
                        <div class="flex items-center justify-center md:justify-start gap-2">
                            <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Alamat: {{ $umkm->alamat }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-20">
        <h2 class="text-3xl font-bold text-brand-primary mb-8">Daftar Menu</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach ($umkm->makanans as $makanan)
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col h-full" x-data="{ open: false }">
                <img src="{{ asset('storage/' . $makanan->gambar_url) }}" alt="{{ $makanan->nama_makanan }}" class="w-full h-56 object-cover">
                
                <div class="p-6 flex flex-col flex-grow">
                    
                    <div class="flex-grow">
                        <h3 class="text-2xl font-bold text-brand-text">{{ $makanan->nama_makanan }}</h3>
                        <span class="text-xl font-semibold text-brand-primary">
                            Rp {{ number_format($makanan->harga, 0, ',', '.') }}
                        </span>
                        
                        <button @click="open = !open" class="text-sm text-brand-primary font-semibold hover:underline mt-2 flex items-center gap-1">
                            <span>Lihat Deskripsi</span>
                            <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" x-transition class="mt-4 text-sm text-gray-600">
                            <p>{{ $makanan->deskripsi }}</p>
                        </div>
                    </div>

                    <a  href="https://wa.me/{{ $umkm->nomor_whatsapp }}?text=Halo%2C%20saya%20mau%20pesan%20{{ urlencode($makanan->nama_makanan) }}"
                        target="_blank"
                        class="mt-6 w-full text-center block py-3 px-4 text-black rounded-lg font-semibold hover:bg-yellow-500 transition duration-300">
                        Pesan via WhatsApp
                    </a>
                </div>
            </div>
            @endforeach

        </div>
    </section>

    <footer class="bg-brand-primary text-white py-8 mt-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 TegalFood. Dibuat untuk Digitalisasi UMKM Tegal.</p>
        </div>
    </footer>

</body>
</html>`