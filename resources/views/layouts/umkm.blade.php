<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'UMKM Panel')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- TOPBAR (MOBILE) -->
<header class="md:hidden flex items-center justify-between bg-white shadow px-4 h-14">
    <button id="openSidebar" class="text-2xl">
        ☰
    </button>

    <span class="font-bold">
        UMKM Panel
    </span>
</header>

<!-- OVERLAY -->
<div id="overlay"
     class="fixed inset-0 bg-black/40 hidden z-40">
</div>

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside
        id="sidebar"
        class="fixed md:sticky top-0
            h-screen w-64
            bg-white shadow-lg
            transform -translate-x-full md:translate-x-0
            transition-transform duration-300
            z-50 p-6 overflow-y-auto">

        <!-- CLOSE (MOBILE) -->
        <div class="flex justify-between items-center mb-6 md:hidden">
            <h2 class="font-bold text-lg">PANEL UMKM</h2>
            <button id="closeSidebar" class="text-xl">✕</button>
        </div>

        <h2 class="font-bold text-xl mb-6 hidden md:block">
            PANEL UMKM
        </h2>

        <ul class="space-y-4">

            <li>
            <a href="{{ route('umkm.manage-orders.index') }}"
            class="block font-medium
                    {{ request()->routeIs('umkm.manage-orders.index') ? 'text-yellow-500' : '' }}">
                    Pesanan
                </a>
            </li>
            <li>
            <a href="{{ route('umkm.dashboard') }}"
            class="block font-medium
                    {{ request()->routeIs('umkm.dashboard') ? 'text-yellow-500' : '' }}">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('umkm.profile.edit') }}"
                   class="block font-medium {{ request()->routeIs('umkm.profile.edit') ? 'text-yellow-500' : '' }}">
                    Profil Toko
                </a>
            </li>

            <li>
                <a href="{{ route('umkm.products.index') }}"
                   class="block font-medium {{ request()->routeIs('umkm.products.index') ? 'text-yellow-500' : '' }}">
                    Produk
                </a>
            </li>

            <li>
                <a href="{{ route('umkm.report') }}"
                   class="block font-medium {{ request()->routeIs('umkm.report') ? 'text-yellow-500' : '' }}">
                    Laporan
                </a>
            </li>

            <li class="pt-4 border-t">
                <form action="{{ route('umkm.logout') }}" method="POST">
                    @csrf
                    <button class="text-red-500 font-semibold">
                        Logout
                    </button>
                </form>
            </li>

        </ul>
    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-4 sm:p-6 md:p-8 bg-gray-50">
        @yield('content')
    </main>

</div>

<!-- SCRIPT -->
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const openBtn = document.getElementById('openSidebar');
    const closeBtn = document.getElementById('closeSidebar');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }

    openBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);
</script>

</body>
</html>