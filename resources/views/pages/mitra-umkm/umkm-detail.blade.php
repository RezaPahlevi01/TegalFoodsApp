<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $umkm->nama_umkm }} - TegalFood</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style type="text/tailwindcss">
        @layer theme {
            extend {
                colors: {
                    'brand-primary': '#800000',
                    'brand-secondary': '#F5F5DC',
                    'brand-accent': '#FFC107',
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
        <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg flex flex-col md:flex-row justify-between items-center gap-8">
            
            <div class="flex flex-col md:flex-row items-center gap-8 flex-1 w-full md:w-auto">
                <img src="{{ $media_url($umkm->logo_url) }}" alt="{{ $umkm->nama_umkm }}" class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover shadow-md flex-shrink-0">
                
                <div class="text-center md:text-left">
                    <h1 class="text-4xl font-bold text-brand-primary">{{ $umkm->nama_umkm }}</h1>
                    <p class="text-lg text-gray-700 mt-2">{{ $umkm->deskripsi }}</p>

                    <div class="mt-4 flex flex-wrap items-center justify-center gap-3 md:justify-start">
                        <span class="inline-flex rounded-full px-4 py-2 text-sm font-semibold {{ $umkm->isOpenNow() ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                            {{ $umkm->isOpenNow() ? 'Toko Sedang Buka' : 'Toko Sedang Tutup' }}
                        </span>

                        @if($umkm->jam_buka && $umkm->jam_tutup)
                            <span class="text-sm text-gray-600">
                                Jam operasional: {{ \Carbon\Carbon::parse($umkm->jam_buka)->format('H:i') }} - {{ \Carbon\Carbon::parse($umkm->jam_tutup)->format('H:i') }}
                            </span>
                        @endif
                    </div>

                    <div class="mt-4 space-y-2 text-gray-600">
                        <div class="flex items-center justify-center md:justify-start gap-2">
                            <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>Pemilik: {{ $umkm->nama_pemilik }}</span>
                        </div>
                        <div class="flex items-center justify-center md:justify-start gap-2">
                            <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Alamat: {{ $umkm->alamat }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="flex-shrink-0 mt-6 md:mt-0 w-full md:w-auto flex justify-center md:justify-end">
                <a href="https://wa.me/{{ $umkm->no_whatsapp }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#128C7E] text-white px-6 py-3 rounded-xl font-semibold shadow-md transition-colors w-full md:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.49.652.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                    </svg>
                    Hubungi Penjual
                </a>
            </div> -->

        </div>
    </section>

    <section class="container mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-20">
        <h2 class="text-3xl font-bold text-brand-primary mb-8">Daftar Menu</h2>

        @if(!$umkm->isOpenNow())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                Toko ini sedang tutup. Menu tetap bisa dilihat, tetapi pemesanan sebaiknya dilakukan saat jam operasional.
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach ($umkm->makanans as $makanan)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col h-full" x-data="{ open: false }">
                <img src="{{ $media_url($makanan->gambar_url) }}" alt="{{ $makanan->nama_makanan }}" class="w-full h-56 object-cover">

                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex-grow">
                        <h3 class="text-2xl font-bold text-brand-text">{{ $makanan->nama_makanan }}</h3>
                        <span class="text-xl font-semibold text-brand-primary">
                            Rp {{ number_format($makanan->harga, 0, ',', '.') }}
                        </span>

                        <button
                            @click="
                                open = !open;
                                if (open) {
                                    window.trackMenuView({{ $makanan->id }});
                                }
                            "
                            class="text-sm text-brand-primary font-semibold hover:underline mt-2 flex items-center gap-1">
                            <span>Lihat Deskripsi</span>
                            <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" x-transition class="mt-4 text-sm text-gray-600">
                            <p>{{ $makanan->deskripsi }}</p>
                        </div>
                    </div>

                    <div class="flex gap-3">

                        @guest

                            <a href="{{ route('user.login') }}"
                            class="w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-xl transition">

                                + Keranjang

                            </a>

                        @else

                            @if(Auth::user()->role == 'user')

                                <form action="{{ route('cart.add',$makanan->id) }}"
                                    method="POST"
                                    class="w-full">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-xl transition">

                                        + Keranjang

                                    </button>

                                </form>

                            @else

                                <button
                                    onclick="alert('Hanya akun User yang dapat menambahkan menu ke keranjang.')"
                                    class="w-full bg-gray-400 text-white px-6 py-3 rounded-xl cursor-not-allowed">

                                    + Keranjang

                                </button>

                            @endif

                        @endguest

                    </div>
                </div>
            </div>
            @endforeach

            @if($umkm->makanans->isEmpty())
                <div class="col-span-full rounded-2xl bg-white p-8 text-center text-gray-500 shadow">
                    Belum ada menu aktif yang ditampilkan oleh toko ini.
                </div>
            @endif
        </div>
    </section>

    <footer class="bg-brand-primary text-white py-8 mt-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 TegalFood. Dibuat untuk Digitalisasi UMKM Tegal.</p>
        </div>
    </footer>

    <script>
        const trackedMenus = new Set();
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        window.trackMenuView = function (menuId) {
            if (!menuId || trackedMenus.has(menuId)) {
                return;
            }

            trackedMenus.add(menuId);

            fetch(`/menu/${menuId}/view`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({})
            }).catch(() => {
                trackedMenus.delete(menuId);
            });
        };
    </script>
</body>
</html>