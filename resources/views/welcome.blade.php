@extends('layouts.app')

@section('title', 'TegalFood - Kuliner Khas Kota Tegal')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .swiper-pagination-bullet-active {
        background: #FFC107 !important;
    }

        #navbar {
        background-color: transparent;
    }
</style>
@endpush

@section('content')

{{-- ================= HERO ================= --}}
<section id="hero"
         class="relative h-screen overflow-hidden text-white">

    <div class="swiper mySwiper h-full">
        <div class="swiper-wrapper h-full">
            @forelse ($sliderFood as $slider)
                <div
                    class="swiper-slide bg-cover bg-center"
                    style="background-image: url('{{ asset('storage/' . $slider->gambar) }}')"
                >
                </div>
            @empty
                <div
                    class="swiper-slide bg-cover bg-center"
                    style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836')"
                >
                </div>
            @endforelse
        </div>
    </div>

    <div class="absolute inset-0 bg-black/50 z-10"></div>

    <div id="hero-content"
         class="absolute inset-0 z-20 flex flex-col
                justify-center items-center text-center
                transition-all duration-300">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6">
            Citarasa Asli Makanan Khas Tegal
        </h1>

        <p class="text-lg md:text-xl max-w-3xl mb-10">
            Dukung UMKM lokal dengan memesan kuliner tradisional favorit Anda
            langsung dari ahlinya.
        </p>

        <a href="/mitra-umkm"
           class="px-10 py-3 rounded-lg bg-white/80 text-black font-semibold hover:bg-yellow-400">
            Pesan Sekarang
        </a>
    </div>
</section>

{{-- ================= SLIDER PROMOSI ================= --}}
<section id="slider" class="bg-gradient-to-b from-yellow-100 to-white py-16">
    <div class="container mx-auto px-4">

        <h2 class="text-3xl font-bold text-center mb-24">
            Kuliner Khas Kota Tegal
        </h2>

        <div class="relative">
            <div
                class="flex gap-12 overflow-x-auto snap-x snap-mandatory
                       px-12 pt-24 pb-12
                       scrollbar-hide"
            >

                @foreach ($sliderFood as $slider)
                    <div class="snap-center shrink-0 w-[260px]">
                        <div
                            class="relative bg-[#FDEEC8] rounded-2xl
                                   pt-28 pb-8 px-4 text-center
                                   shadow-lg transition-all duration-300
                                   hover:-translate-y-3 hover:shadow-2xl"
                        >

                            {{-- Floating Image --}}
                            <div
                                class="absolute -top-20 left-1/2 -translate-x-1/2
                                       w-40 h-40 rounded-full
                                       bg-white shadow-xl
                                       flex items-center justify-center"
                            >
                                <img
                                    src="{{ asset('storage/' . $slider->gambar) }}"
                                    alt="{{ $slider->title }}"
                                    class="w-36 h-36 rounded-full object-cover"
                                >
                            </div>

                            {{-- Title --}}
                            <h3 class="text-lg font-bold">
                                {{ $slider->judul }}
                            </h3>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </div>
</section>



<!-- {{-- ================= UMKM GRID (TIDAK DIHAPUS) ================= --}}
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-6">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800">
                    🍽️ Makanan Khas Tegal
                </h2>
                <p class="text-gray-500 mt-2">
                    Pilihan kuliner favorit yang wajib kamu coba
                </p>
            </div>

            <a href="{{ route('mitra.umkm') }}"
               class="mt-4 md:mt-0 inline-flex items-center gap-2
                      bg-yellow-500 hover:bg-yellow-600
                      text-white px-5 py-3 rounded-full font-semibold transition">
                Lihat Semua
                <span>→</span>
            </a>
        </div>

        {{-- GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($menuPopuler as $menu)
            <div class="group bg-white rounded-2xl shadow-md overflow-hidden
                        hover:shadow-xl transition duration-300">

                {{-- IMAGE --}}
                <div class="relative overflow-hidden">
                    <img src="{{ asset('storage/'.$menu->gambar) }}"
                         alt="{{ $menu->nama }}"
                         class="w-full h-48 object-cover
                                group-hover:scale-110 transition duration-500">

                    {{-- BADGE --}}
                    <span class="absolute top-3 left-3
                                 bg-red-500 text-white text-xs font-bold
                                 px-3 py-1 rounded-full shadow">
                        🔥 Populer
                    </span>
                </div>

                {{-- CONTENT --}}
                <div class="p-5">

                    <h3 class="text-lg font-bold text-gray-800 mb-1">
                        {{ $menu->nama }}
                    </h3>

                    <p class="text-sm text-gray-500 mb-3">
                        {{ $menu->umkm->nama_umkm ?? 'UMKM Lokal' }}
                    </p>

                    <div class="flex items-center justify-between">
                        <span class="text-yellow-600 font-extrabold text-lg">
                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                        </span>

                        <a href="{{ route('umkm.show', $menu->umkm_id) }}"
                           class="text-sm font-semibold text-white
                                  bg-green-600 hover:bg-green-700
                                  px-4 py-2 rounded-full transition">
                            Pesan
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section> -->

{{-- ================= MAKANAN KHAS ================= --}}
<section id="makanan"
    <div class="max-w-7xl mx-auto px-6">

        {{-- HEADER --}}
        <div class="container mx-auto px-4 mb-16">
            <h2 class="text-3xl font-bold text-center mb-4">
                Artikel Tentang Makanan Khas Tegal
            </h2>
        </div>

        {{-- GRID BLOG --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            @forelse ($blogs as $blog)
                <div class="group bg-white rounded-2xl overflow-hidden shadow-md
                            hover:shadow-xl transition duration-300">

                    {{-- IMAGE --}}
                    <div class="relative h-56 overflow-hidden">
                        <img
                            src="{{ asset('storage/' . $blog->image) }}"
                            alt="{{ $blog->title }}"
                            class="w-full h-full object-cover
                                   group-hover:scale-110 transition duration-500"
                        >

                        {{-- OVERLAY --}}
                        <div class="absolute inset-0 bg-gradient-to-t
                                    from-black/60 via-black/30 to-transparent">
                        </div>

                        {{-- TAG --}}
                        <span class="absolute top-4 left-4
                                     bg-yellow-500 text-white text-xs font-bold
                                     px-3 py-1 rounded-full shadow">
                            Kuliner Tegal
                        </span>
                    </div>

                    {{-- CONTENT --}}
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-3
                                   group-hover:text-yellow-600 transition">
                            {{ $blog->title }}
                        </h3>

                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-3 mb-5">
                            {{ $blog->content }}
                        </p>

                        <a href="{{ url('/blog/' . $blog->slug) }}"
                           class="inline-flex items-center gap-2
                                  text-yellow-600 font-semibold text-sm
                                  hover:text-yellow-700 transition">
                            Baca selengkapnya
                            <span>→</span>
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-center col-span-3 text-gray-500">
                    Belum ada artikel makanan khas.
                </p>
            @endforelse

        </div>

    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    new Swiper(".mySwiper", {
        loop: true,
        effect: "fade",
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
    });

    new Swiper(".umkmSwiper", {
        slidesPerView: 1.3,
        spaceBetween: 40,
        centeredSlides: true,
        grabCursor: true,

        breakpoints: {
            640: { slidesPerView: 2.2 },
            1024: { slidesPerView: 3 },
        },
    });
</script>
<script>
    const hero = document.getElementById('hero');
    const heroContent = document.getElementById('hero-content');
    const navbar = document.getElementById('navbar');

    if (hero && navbar) {
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            const heroHeight = hero.offsetHeight;

            const progress = Math.min(scrollY / heroHeight, 1);

            // Hero fade + move
            heroContent.style.opacity = 1 - progress;
            heroContent.style.transform = `translateY(${progress * 40}px)`;

            // Navbar change
            if (scrollY > heroHeight - 120) {
                navbar.classList.add('bg-white', 'shadow-md');
                navbar.classList.remove('bg-transparent');
            } else {
                navbar.classList.add('bg-transparent');
                navbar.classList.remove('bg-white', 'shadow-md');
            }
        });
    }
</script>
@endpush
