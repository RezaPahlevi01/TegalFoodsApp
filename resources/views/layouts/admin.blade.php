<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel - TegalFood')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">

        <div class="p-6 text-xl font-bold text-yellow-600 border-b border-gray-200">
            Admin TegalFood
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 text-sm">

            <a href="{{ route('admin.dashboard') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                Dashboard
            </a>

            <a href="{{ route('admin.umkm.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                Mitra UMKM
            </a>

            <a href="{{ route('admin.slider.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                Slider / Hero
            </a>

            <a href="{{ route('admin.foodblog.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                Food Blog
            </a>

        </nav>

        <div class="p-4 border-t border-gray-200">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="w-full text-left text-sm text-red-600 hover:underline">
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- CONTENT --}}
    <div class="flex-1 flex flex-col">

        {{-- TOPBAR --}}
        <header class="bg-white border-b border-gray-200 px-6 py-4">
            <h1 class="text-lg font-semibold text-gray-700">
                @yield('header')
            </h1>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                @yield('content')
            </div>
        </main>

    </div>

</div>

</body>
</html>