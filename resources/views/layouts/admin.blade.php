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
    <aside class="w-64 bg-white shadow-lg hidden md:block">
        <div class="p-6 text-xl font-bold text-yellow-600">
            Admin TegalFood
        </div>

        <nav class="px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
               class="block px-4 py-2 rounded hover:bg-yellow-100">
                Dashboard
            </a>

            <a href="{{ route('admin.umkm.index') }}"
               class="block px-4 py-2 rounded hover:bg-yellow-100">
                Mitra UMKM
            </a>

            <a href="{{ route('admin.slider.index') }}"
               class="block px-4 py-2 rounded hover:bg-yellow-100">
                Slider / Hero
            </a>
        </nav>
    </aside>

    {{-- CONTENT --}}
    <div class="flex-1 flex flex-col">

        {{-- TOPBAR --}}
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold">
                @yield('header', 'Dashboard')
            </h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-red-600 hover:underline">
                    Logout
                </button>
            </form>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>
