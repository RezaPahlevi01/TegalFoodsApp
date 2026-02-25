<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex">

    {{-- SIDEBAR --}}
    <div class="w-64 bg-white h-screen shadow p-6">

        <h2 class="font-bold text-xl mb-6">
            PANEL UMKM
        </h2>

        <ul class="space-y-4">

            <li>
                <a href="{{ route('umkm.dashboard') }}"
                   class="block hover:text-yellow-500">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('umkm.profile.edit') }}"
                    class="block hover:text-yellow-500">
                    Profil Toko
                </a>
            </li>

            <li>
                <a href="{{ route('umkm.products.index') }}" 
                    class="block hover:text-yellow-500">
                    Produk
                </a>
            </li>

            <li>
            <form action="{{ route('umkm.logout') }}" method="POST">
                @csrf
                <button class="text-red-500">
                    Logout
                </button>
            </form>
                </form>
            </li>

        </ul>

    </div>

    {{-- CONTENT --}}
    <div class="flex-1 p-8">
        @yield('content')
    </div>

</div>

</body>
</html>
