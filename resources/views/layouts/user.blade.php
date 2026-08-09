<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','TegalFood')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    {{-- Leaflet CSS --}}
    <link rel="stylesheet"
          href="https://unpkg.com/leaflet/dist/leaflet.css">

    {{-- Tempat untuk css tambahan --}}
    @stack('styles')

    {{-- PROFILE MODAL --}}
<div
    id="profileModal"
    class="fixed inset-0 z-50 flex items-center justify-center
    bg-black/40 backdrop-blur-sm
    opacity-0 invisible
    transition-all duration-300 ease-out">

    <div
        id="profileCard"
        class="
        bg-white
        rounded-3xl
        shadow-2xl

        w-[92%]
        md:w-[650px]

        max-h-[85vh]
        overflow-y-auto

        scale-90
        translate-y-10
        opacity-0

        transition-all
        duration-300
        ease-[cubic-bezier(.22,1,.36,1)]
    ">

        {{-- Header --}}
        <div class="flex justify-between items-center p-6 border-b">

            <h2 class="text-xl font-bold">
                Edit Profile
            </h2>

            <button
                id="closeProfile"
                class="text-2xl">

                ×

            </button>

        </div>

        {{-- Body --}}
        <form
            action="{{ route('profile.update') }}"
            method="POST"
            class="p-6 space-y-5">

            @csrf
            @method('PUT')

            <div class="flex justify-center">

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=120"
                    class="w-24 h-24 rounded-full">

            </div>

            <div>

                <label class="font-semibold">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ Auth::user()->name }}"
                    class="w-full mt-2 border rounded-xl p-3">

            </div>

            <div>

                <label class="font-semibold">
                    Email
                </label>

                <input
                    type="email"
                    value="{{ Auth::user()->email }}"
                    disabled
                    class="w-full mt-2 border rounded-xl p-3 bg-gray-100">

            </div>

            <div>

                <label class="font-semibold">
                    Nomor Telepon
                </label>

                <input
                    type="tel"
                    name="nomor_telepon"
                    value="{{ old('nomor_telepon', optional(Auth::user()->profile)->nomor_telepon) }}"
                    inputmode="numeric"
                    maxlength="15"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    placeholder="Nomor telepon"
                    class="w-full mt-2 border rounded-xl p-3"
                    required>

            </div>

            <div>

                <label class="font-semibold">
                    Alamat
                </label>

                <textarea
                    name="alamat"
                    rows="3"
                    class="w-full mt-2 border rounded-xl p-3">{{ optional(Auth::user()->profile)->alamat }}</textarea>

            </div>

            <div>

                <input type="hidden"
                    id="latitude"
                    name="latitude"
                    value="{{ old('latitude', optional(Auth::user()->profile)->latitude) }}">

                <input type="hidden"
                    id="longitude"
                    name="longitude"
                    value="{{ old('longitude', optional(Auth::user()->profile)->longitude) }}">

                <label class="font-semibold">
                    Lokasi (klik peta untuk memilih lokasi)
                </label>

                <div id="map" class="w-full h-64 mt-2 rounded-xl"></div>

            </div>

            <button
                class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl">

                Simpan Perubahan

            </button>

        </form>
    </div>

</div>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-50">

{{-- MOBILE OVERLAY --}}
<div
    id="sidebarOverlay"
    class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden">
</div>

{{-- SIDEBAR --}}
<aside
    id="sidebar"
    class="fixed top-0 left-0 h-screen w-64 bg-white shadow-lg z-50
           transform -translate-x-full lg:translate-x-0 transition duration-300">

    <div class="p-6 border-b">

        <h1 class="text-2xl font-bold text-orange-500">
            TegalFood
        </h1>

    </div>

    <nav class="p-4">

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 p-3 rounded-lg hover:bg-orange-100 mb-2">

            🏠 Dashboard

        </a>

        <a href="{{ route('mitra.umkm') }}"
           class="flex items-center gap-3 p-3 rounded-lg hover:bg-orange-100 mb-2">

            🏪 UMKM

        </a>

        <a href="{{ route('cart.index') }}"
           class="flex items-center gap-3 p-3 rounded-lg hover:bg-orange-100 mb-2">

            🛒 Keranjang

        </a>

        <a href="{{ route('orders.index') }}"
           class="flex items-center gap-3 p-3 rounded-lg hover:bg-orange-100 mb-2">

            📦 Pesanan Saya

        </a>

        <a href="{{ route('blog.index') }}"
           class="flex items-center gap-3 p-3 rounded-lg hover:bg-orange-100">

            📰 Artikel

        </a>

    </nav>

</aside>

{{-- CONTENT --}}
<div class="lg:ml-64">

    {{-- TOPBAR --}}
    <header
        class="bg-white shadow-sm h-16 md:h-20 px-4 md:px-8 flex justify-between items-center sticky top-0 z-30">

        <div class="flex items-center gap-3">

            {{-- HAMBURGER MOBILE --}}
            <button
                id="menuBtn"
                class="lg:hidden p-2 rounded-lg hover:bg-gray-100">

                ☰

            </button>

            <h2 class="text-lg md:text-xl font-bold">
                @yield('page-title')
            </h2>

        </div>

        <div class="flex items-center gap-3">

            <div class="hidden sm:block text-right">

                <p class="font-semibold text-sm md:text-base">
                    {{ Auth::user()->name }}
                </p>

                <p class="text-gray-500 text-xs md:text-sm">
                    {{ Auth::user()->email }}

            </div>

            <button id="profileBtn">

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                    class="w-10 h-10 rounded-full border-2 border-orange-400 hover:scale-105 transition">

            </button>

            <form
                action="{{ route('user.logout') }}"
                method="POST">

                @csrf

                <button
                    class="bg-red-500 hover:bg-red-600 text-white px-3 md:px-4 py-2 rounded-lg text-sm">

                    Logout

                </button>

            </form>

        </div>

    </header>

    {{-- PAGE --}}
    <main class="p-4 md:p-8">

        @if(session('success'))

            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">

                {{ session('success') }}

            </div>

        @endif

        @if(session('error'))
            <script>
                alert('{{ session('error') }}');
            </script>
        @endif

        @yield('content')

    </main>

</div>

{{-- BOTTOM NAV MOBILE --}}
<div
    class="fixed bottom-0 left-0 right-0 bg-white border-t lg:hidden z-30">

    <div class="grid grid-cols-5">

        <a href="{{ route('dashboard') }}"
           class="py-3 text-center text-sm">

            🏠
        </a>

        <a href="{{ route('mitra.umkm') }}"
           class="py-3 text-center text-sm">

            🏪
        </a>

        <a href="{{ route('cart.index') }}"
           class="py-3 text-center text-sm">

            🛒
        </a>

        <a href="{{ route('orders.index') }}"
           class="py-3 text-center text-sm">

            📦
        </a>

        <a href="{{ route('blog.index') }}"
           class="py-3 text-center text-sm">

            📰
        </a>

    </div>

</div>

<script>

const menuBtn = document.getElementById('menuBtn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');

menuBtn?.addEventListener('click', () => {

    sidebar.classList.remove('-translate-x-full');
    overlay.classList.remove('hidden');

});

overlay?.addEventListener('click', () => {

    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');

});

</script>

<script>
const profileBtn = document.getElementById("profileBtn");
const profileModal = document.getElementById("profileModal");
const profileCard = document.getElementById("profileCard");
const closeProfile = document.getElementById("closeProfile");

function openProfile() {

    profileModal.classList.remove("opacity-0","invisible");

    profileCard.classList.remove(
        "opacity-0",
        "scale-90",
        "translate-y-10"
    );

}

function closeProfileModal() {

    profileModal.classList.add("opacity-0");

    profileCard.classList.add(
        "opacity-0",
        "scale-90",
        "translate-y-10"
    );

    setTimeout(() => {

        profileModal.classList.add("invisible");

    },300);

}

profileBtn.addEventListener("click", openProfile);

closeProfile.addEventListener("click", closeProfileModal);

profileModal.addEventListener("click",(e)=>{

    if(e.target===profileModal){

        closeProfileModal();

    }

});
</script>
{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@stack('scripts')

<script>
    const map = L.map('map').setView([-6.869, 109.140], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    let marker;

    map.on('click', function(e) {

        const { lat, lng } = e.latlng;

        if(marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng]).addTo(map);
        }

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

    });
    
    const lat = document.getElementById('latitude').value;
    const lng = document.getElementById('longitude').value;

    if(lat && lng){

        map.setView([lat,lng],16);

        marker = L.marker([lat,lng]).addTo(map);

    }
</script>
</body>
</html>