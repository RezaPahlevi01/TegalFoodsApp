<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel - TegalFood')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-gray-200">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-gray-800 text-gray-200 hidden md:flex flex-col shadow-xl">

        <div class="p-6 text-xl font-bold text-yellow-400 border-b border-gray-700">
            Admin Panel
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 text-sm">

            <a href="{{ route('admin.dashboard') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                Dashboard
            </a>

            <a href="{{ route('admin.umkm.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                Mitra UMKM
            </a>

            <a href="{{ route('admin.slider.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                Slider / Hero
            </a>

            <a href="{{ route('admin.foodblog.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                Food Blog
            </a>

        </nav>

        <div class="p-4 border-t border-gray-700">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="w-full text-left text-sm text-red-400 hover:underline">
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- CONTENT AREA --}}
    <div class="flex-1 flex flex-col">

        {{-- TOPBAR --}}
        <header class="bg-gray-800 border-b border-gray-700 px-6 py-4">
            <h1 class="text-lg font-semibold text-gray-100">
                @yield('header')
            </h1>
        </header>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-8">

            <div class="bg-white text-gray-800 rounded-2xl shadow-2xl p-8 min-h-[300px]">
                @yield('content')
            </div>

        </main>

    </div>

</div>

</body>
</html>