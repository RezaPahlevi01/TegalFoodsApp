<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Blog Kuliner Tegal - TegalFood</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind CDN --}}
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
                    <a href="/" class="text-brand-primary font-semibold hover:underline">
                        &larr; Kembali ke Beranda
                    </a>
                </div>
            </nav>
        </header>
    <div class="max-w-7xl mx-auto px-6">
        {{-- TITLE --}}
        <h1 class="text-4xl font-bold text-center mb-16 mt-16">
            Filosofi di Balik Citarasa Khas Tegal
        </h1>

        {{-- BLOG GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            @foreach ($blogs as $blog)
                <div class="bg-white rounded-2xl shadow-md
                            hover:shadow-xl transition overflow-hidden">

                    <img src="{{ asset('storage/' . $blog->image) }}"
                         alt="{{ $blog->title }}"
                         class="w-full h-56 object-cover">

                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3">
                            {{ $blog->title }}
                        </h3>

                        <p class="text-gray-600 text-sm line-clamp-3 mb-5">
                            {{ $blog->content }}
                        </p>

                        <a href="{{ route('blog.show', $blog->slug) }}"
                           class="text-yellow-600 font-semibold
                                  hover:text-yellow-700 transition">
                            Baca selengkapnya →
                        </a>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- PAGINATION --}}
        <div class="mt-16">
            {{ $blogs->links() }}
        </div>

    </div>
</section>

</body>
</html>