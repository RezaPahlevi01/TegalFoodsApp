<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css','resources/js/app.js'])

    <title>Admin - TegalFood</title>
</head>

<body class="bg-gray-100">

<div class="flex">

    {{-- SIDEBAR --}}
    <aside
        class="fixed left-0 top-0
               w-72 h-screen
               bg-gradient-to-b
               from-yellow-500
               via-orange-500
               to-orange-600
               text-white
               flex flex-col
               shadow-2xl
               z-50">

        {{-- Logo --}}
        <div class="p-6 border-b border-white/20">

            <h2 class="text-2xl font-bold">
                🍴 TegalFood
            </h2>

            <p class="text-sm text-yellow-100">
                Admin Panel
            </p>

        </div>

        {{-- Menu --}}
        <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-2">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('admin.dashboard') ? 'bg-white text-orange-600 font-bold shadow' : 'hover:bg-white/20' }}">

                📊 Dashboard

            </a>

            <a href="{{ route('admin.umkm.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('admin.umkm.*') ? 'bg-white text-orange-600 font-bold shadow' : 'hover:bg-white/20' }}">

                🏪 Mitra UMKM

            </a>

            <a href="{{ route('admin.slider.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('admin.slider.*') ? 'bg-white text-orange-600 font-bold shadow' : 'hover:bg-white/20' }}">

                🖼 Slider / Hero

            </a>

            <a href="{{ route('admin.foodblog.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('admin.foodblog.*') ? 'bg-white text-orange-600 font-bold shadow' : 'hover:bg-white/20' }}">

                📰 Food Blog

            </a>

            <a href="{{ route('admin.report.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('admin.report.*') ? 'bg-white text-orange-600 font-bold shadow' : 'hover:bg-white/20' }}">

                📈 Laporan

            </a>

        </nav>

        {{-- Logout --}}
        <div class="p-5 border-t border-white/20">

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf

                <button
                    class="w-full bg-red-500 hover:bg-red-600 rounded-xl py-3 font-semibold transition">

                    Logout

                </button>

            </form>

        </div>

    </aside>

    {{-- CONTENT --}}
    <div class="flex-1 ml-72 min-h-screen">

        {{-- TOPBAR --}}
        <header
            class="sticky top-0 z-40
                   bg-white shadow-sm
                   px-8 py-5
                   flex justify-between items-center">

            <div>

                <h1 class="text-2xl font-bold text-gray-800">
                    @yield('header')
                </h1>

                <p class="text-sm text-gray-500">
                    Selamat datang di Admin Panel TegalFood
                </p>

            </div>

            <div class="flex items-center gap-3">

                <div class="text-right">

                    <p class="font-semibold">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="text-sm text-gray-500">
                        Administrator
                    </p>

                </div>

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                    class="w-11 h-11 rounded-full border">

            </div>

        </header>

        {{-- PAGE --}}
        <main class="p-8">

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>