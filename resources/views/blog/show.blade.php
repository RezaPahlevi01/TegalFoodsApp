<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $blog->title }} - TegalFood</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-800">

<section class="py-20">
    <div class="max-w-4xl mx-auto px-6">

        {{-- BACK BUTTON --}}
        <a href="{{ url('/blog') }}"
           class="inline-flex items-center gap-2 mb-8
                  text-yellow-600 font-semibold
                  hover:text-yellow-700 transition">
            ← Kembali ke Blog
        </a>

        <h1 class="text-4xl font-bold mb-6">
            {{ $blog->title }}
        </h1>

        <img src="{{ $media_url($blog->image) }}"
             alt="{{ $blog->title }}"
             class="w-full h-96 object-cover rounded-2xl mb-10">

        <article class="prose max-w-none prose-lg">
            {!! nl2br(e($blog->content)) !!}
        </article>

    </div>
</section>

</body>
</html>