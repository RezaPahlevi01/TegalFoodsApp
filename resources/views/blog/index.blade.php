<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Blog Kuliner Tegal - TegalFood</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">

<section class="py-20">
    <div class="max-w-7xl mx-auto px-6">

        {{-- BACK BUTTON --}}
        <a href="{{ url('/') }}"
           class="inline-flex items-center gap-2 mb-10
                  text-yellow-600 font-semibold
                  hover:text-yellow-700 transition">
            ← Kembali ke Beranda
        </a>

        {{-- TITLE --}}
        <h1 class="text-4xl font-bold text-center mb-16">
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