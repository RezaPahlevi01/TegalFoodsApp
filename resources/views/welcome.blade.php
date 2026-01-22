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

        <a href="#umkm"
           class="px-10 py-3 rounded-lg bg-white/80 text-black font-semibold hover:bg-yellow-400">
            Pesan Sekarang
        </a>
    </div>
</section>

{{-- ================= SLIDER PROMOSI ================= --}}
<section id="slider" class="py-28 bg-white">
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
<section id="umkm" class="py-16 bg-white">
    <div class="container mx-auto px-4">

        <h2 class="text-3xl font-bold text-center mb-12">
            Mitra UMKM Unggulan
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($listUmkm as $umkm)
                <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition overflow-hidden">

                    <img src="{{ $umkm->logo_url }}"
                         alt="{{ $umkm->nama_umkm }}"
                         class="w-full h-48 object-cover transition group-hover:scale-105">

                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">
                            {{ $umkm->nama_umkm }}
                        </h3>

                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                            {{ $umkm->deskripsi }}
                        </p>

                        <a href="{{ route('umkm.show', $umkm->id) }}"
                           class="text-yellow-600 font-semibold hover:underline">
                            Lihat Menu →
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section> -->

{{-- ================= MAKANAN KHAS ================= --}}
<section id="makanan" class="py-20 bg-white">
    <div class="container mx-auto px-4">

        <h2 class="text-3xl font-bold text-center mb-16">
            Makanan Khas Tegal
        </h2>

        <div class="flex flex-col md:flex-row items-center gap-16 justify-center">

            <div class="bg-white border rounded-xl p-8 max-w-xl shadow">
                <h3 class="text-2xl font-bold mb-4">
                    {{ $menuPopuler->first()->nama_makanan ?? 'Tahu Aci' }}
                </h3>

                <p class="text-gray-600 leading-relaxed">
                    {{ $menuPopuler->first()->deskripsi ?? 'Salah satu jajanan legendaris dari Tegal.' }}
                </p>
            </div>

            <img src="{{ $menuPopuler->first()->gambar_url ?? 'https://images.unsplash.com/photo-1604908554161-89f56f2cdd5a' }}"
                 class="w-[350px] rounded-xl shadow-lg">
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
