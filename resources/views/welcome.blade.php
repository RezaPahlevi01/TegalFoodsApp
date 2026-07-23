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

    .swiper-slide {
        transform: scale(1.05);
        transition: transform 1s ease;
    }

    .swiper-slide-active {
        transform: scale(1);
    }

    .reveal {
        opacity: 0;
        transform: translateY(60px);
        transition:
            opacity 0.6s ease,
            transform 0.6s ease;
        will-change: opacity, transform;
    }

    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    .chatbot-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .chatbot-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(146, 64, 14, 0.35);
        border-radius: 9999px;
    }

    .chatbot-glow {
        box-shadow:
            0 22px 60px rgba(120, 53, 15, 0.28),
            0 10px 22px rgba(245, 158, 11, 0.18);
    }

    .chatbot-fab {
        box-shadow:
            0 18px 40px rgba(234, 88, 12, 0.35),
            0 8px 18px rgba(251, 191, 36, 0.25);
    }
</style>
@endpush

@section('content')

<section id="hero" class="relative h-screen overflow-hidden text-white">
    <div class="swiper mySwiper h-full">
        <div class="swiper-wrapper h-full">
            @forelse ($sliderFood as $slider)
                <div class="swiper-slide bg-cover bg-center"
                     style="background-image: url('{{ asset('storage/' . $slider->gambar) }}')">
                </div>
            @empty
                <div class="swiper-slide bg-cover bg-center"
                     style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836')">
                </div>
            @endforelse
        </div>
    </div>

    <div class="absolute inset-0 bg-black/50 z-10"></div>

    <div id="hero-content"
         class="absolute inset-0 z-20 flex flex-col justify-center items-center text-center transition-all duration-300">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6">
            Citarasa Asli Makanan Khas Tegal
        </h1>

        <p class="text-lg md:text-xl max-w-3xl mb-10">
            Dukung UMKM lokal dengan memesan kuliner tradisional favorit Anda
            langsung dari ahlinya.
        </p>

        <a href="{{ auth()->check() && auth()->user()->role === 'user' ? '/mitra-umkm' : '/login-user' }}"
        class="px-10 py-3 rounded-lg bg-white/80 text-black font-semibold hover:bg-yellow-400">
            Pesan Sekarang
        </a>
    </div>
</section>

<section id="slider" class="bg-gradient-to-b from-yellow-100 to-white py-16 reveal">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-24">
            Kuliner Khas Kota Tegal
        </h2>

        <div class="relative">
            <div class="flex gap-12 overflow-x-auto snap-x snap-mandatory px-12 pt-24 pb-12 scrollbar-hide">
                @foreach ($sliderFood as $slider)
                    <div class="snap-center shrink-0 w-[260px]">
                        <div class="relative bg-[#FDEEC8] rounded-2xl pt-28 pb-8 px-4 text-center shadow-lg transition-all duration-300 hover:-translate-y-3 hover:shadow-2xl">
                            <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-40 h-40 rounded-full bg-white shadow-xl flex items-center justify-center">
                                <img src="{{ asset('storage/' . $slider->gambar) }}"
                                     alt="{{ $slider->title }}"
                                     class="w-36 h-36 rounded-full object-cover">
                            </div>

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

<section id="makanan" class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="container mx-auto px-4 mb-16 reveal">
            <h2 class="text-3xl font-bold text-center mb-4">
                Artikel Tentang Makanan Khas Tegal
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            @forelse ($blogs as $index => $blog)
                <article class="group overflow-hidden rounded-2xl bg-white shadow-sm transition-all duration-500 hover:-translate-y-1 hover:shadow-xl reveal"
                         style="transition-delay: {{ min($index * 100, 400) }}ms">
                    <div class="relative h-40 overflow-hidden">
                        <img src="{{ $blog->image ? (\Illuminate\Support\Str::startsWith($blog->image, ['http://', 'https://']) ? $blog->image : asset('storage/' . $blog->image)) : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80' }}"
                             alt="{{ $blog->title }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>

                        <span class="absolute top-3 left-3 bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                            Kuliner Tegal
                        </span>
                    </div>

                    <div class="p-4">
                        <h3 class="text-base font-bold text-gray-800 group-hover:text-yellow-600 transition line-clamp-2">
                            {{ $blog->title }}
                        </h3>

                        <p class="mt-2 text-gray-600 text-sm leading-relaxed line-clamp-2">
                            {{ $blog->content }}
                        </p>

                        <div class="mt-4 flex items-center justify-between">
                            <a href="{{ route('blog.show', $blog->slug) }}"
                               class="inline-flex items-center gap-2 text-yellow-600 font-semibold text-sm hover:text-yellow-700 transition">
                                Baca
                                <span aria-hidden="true">-></span>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-center col-span-3 text-gray-500">
                    Belum ada artikel makanan khas.
                </p>
            @endforelse
        </div>
    </div>
</section>

<div id="tegal-chatbot"
     class="fixed bottom-5 right-5 z-[120] w-[calc(100vw-2rem)] max-w-sm">
    <div id="chatbot-panel"
         class="hidden overflow-hidden rounded-[28px] border border-amber-200/70 bg-white/95 backdrop-blur chatbot-glow">
        <div class="bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.45),_transparent_40%),linear-gradient(135deg,#f59e0b,#ea580c)] px-5 py-4 text-white">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-[11px] uppercase tracking-[0.35em] text-white/75">TegalFood AI</p>
                    <h3 class="mt-1 text-lg font-bold">TegalBot</h3>
                    <p class="mt-1 text-sm text-white/90">
                        Tanya kuliner, wisata, dan info khas Tegal.
                    </p>
                </div>
                <button id="chatbot-close"
                        type="button"
                        class="rounded-full bg-white/15 px-3 py-1 text-sm font-semibold hover:bg-white/25">
                    Tutup
                </button>
            </div>
        </div>

        <div id="chat-box" class="chatbot-scrollbar h-80 overflow-y-auto bg-gradient-to-b from-amber-50 via-white to-orange-50/40 px-4 py-4 text-sm">
            <div class="mb-3 flex justify-start">
                <div class="max-w-[85%] rounded-2xl rounded-tl-md bg-white px-4 py-3 text-gray-700 shadow-sm ring-1 ring-amber-100">
                    Halo, saya siap bantu info tentang kuliner khas Tegal, wisata, oleh-oleh, dan suasana Kota Tegal.
                </div>
            </div>
        </div>

        <div class="border-t border-amber-100 bg-white px-4 py-4">
            <div class="mb-3 flex flex-wrap gap-2">
                <button type="button" class="chatbot-suggestion rounded-full bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-900 hover:bg-amber-200">
                    Makanan khas Tegal
                </button>
                <button type="button" class="chatbot-suggestion rounded-full bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-900 hover:bg-amber-200">
                    Wisata di Tegal
                </button>
                <button type="button" class="chatbot-suggestion rounded-full bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-900 hover:bg-amber-200">
                    Oleh-oleh Tegal
                </button>
            </div>

            <form id="chatbot-form" class="flex items-end gap-2">
                <textarea id="message"
                          rows="1"
                          class="max-h-28 min-h-[48px] flex-1 resize-none rounded-2xl border border-amber-200 px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200"
                          placeholder="Ketik pertanyaan tentang Tegal..."></textarea>

                <button id="chatbot-send"
                        type="submit"
                        class="rounded-2xl bg-amber-500 px-4 py-3 text-sm font-semibold text-white shadow hover:bg-amber-600">
                    Kirim
                </button>
            </form>
        </div>
    </div>

    <div id="chatbot-fab-wrapper" class="mt-3 flex justify-end">
        <button id="chatbot-toggle"
                type="button"
                class="chatbot-fab inline-flex items-center gap-3 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 px-5 py-4 text-white transition hover:-translate-y-1">
            <span class="flex h-11 w-11 items-center justify-center rounded-full bg-white/20 text-xl">AI</span>
            <span class="text-left">
                <span class="block text-sm font-bold leading-tight">Chat TegalBot</span>
                <span class="block text-xs text-white/85">Asisten kuliner & kota Tegal</span>
            </span>
        </button>
    </div>
</div>

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

            heroContent.style.opacity = 1 - progress;
            heroContent.style.transform = `translateY(${progress * 40}px)`;

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

<script>
    const reveals = document.querySelectorAll('.reveal');

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                } else {
                    entry.target.classList.remove('active');
                }
            });
        },
        {
            threshold: 0.2,
        }
    );

    reveals.forEach(el => observer.observe(el));
</script>

<script>
    const chatbotPanel = document.getElementById('chatbot-panel');
    const chatbotToggle = document.getElementById('chatbot-toggle');
    const chatbotClose = document.getElementById('chatbot-close');
    const chatBox = document.getElementById('chat-box');
    const chatbotForm = document.getElementById('chatbot-form');
    const chatbotInput = document.getElementById('message');
    const chatbotSend = document.getElementById('chatbot-send');

    const appendMessage = (message, sender = 'bot') => {
        const wrapper = document.createElement('div');
        wrapper.className = sender === 'user' ? 'mb-3 flex justify-end' : 'mb-3 flex justify-start';

        const bubble = document.createElement('div');
        bubble.className = sender === 'user'
            ? 'max-w-[85%] rounded-2xl rounded-br-md bg-gradient-to-r from-amber-500 to-orange-500 px-4 py-3 text-white shadow-sm'
            : 'max-w-[85%] rounded-2xl rounded-tl-md bg-white px-4 py-3 text-gray-700 shadow-sm ring-1 ring-amber-100';
        bubble.textContent = message;

        wrapper.appendChild(bubble);
        chatBox.appendChild(wrapper);
        chatBox.scrollTop = chatBox.scrollHeight;
    };

    const toggleChatbot = (open) => {
        chatbotPanel.classList.toggle('hidden', !open);
        document.getElementById('chatbot-fab-wrapper').classList.toggle('hidden', open);

        if (open) {
            chatbotInput.focus();
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    };

    const setLoading = (loading) => {
        chatbotSend.disabled = loading;
        chatbotSend.textContent = loading ? 'Mengirim...' : 'Kirim';
    };

    chatbotToggle?.addEventListener('click', () => toggleChatbot(true));
    chatbotClose?.addEventListener('click', () => toggleChatbot(false));

    document.querySelectorAll('.chatbot-suggestion').forEach((button) => {
        button.addEventListener('click', () => {
            chatbotInput.value = button.textContent.trim();
            chatbotForm.requestSubmit();
        });
    });

    chatbotInput?.addEventListener('input', () => {
        chatbotInput.style.height = 'auto';
        chatbotInput.style.height = `${Math.min(chatbotInput.scrollHeight, 112)}px`;
    });

    chatbotForm?.addEventListener('submit', async (event) => {
        event.preventDefault();

        const msg = chatbotInput.value.trim();
        if (!msg) {
            return;
        }

        appendMessage(msg, 'user');
        chatbotInput.value = '';
        chatbotInput.style.height = 'auto';
        setLoading(true);

        try {
            const res = await fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: msg })
            });

            const data = await res.json();
            appendMessage(data.reply ?? 'Maaf, jawaban chatbot belum tersedia.', 'bot');
        } catch (error) {
            appendMessage('Maaf, chatbot sedang bermasalah. Coba lagi sebentar ya.', 'bot');
        } finally {
            setLoading(false);
        }
    });
</script>
@endpush
