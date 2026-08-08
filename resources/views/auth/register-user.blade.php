<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar User - TegalFood</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0px); }
        }

        .float {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex">

    {{-- LEFT SIDE --}}
    <div class="hidden md:flex w-1/2 bg-gradient-to-br from-orange-500 to-yellow-500 items-center justify-center p-10 relative">

        <div class="text-center text-white">

            <h2 class="text-4xl font-bold mb-4">
                Jelajahi Kuliner Tegal 🍜
            </h2>

            <p class="text-orange-100 mb-8 max-w-md mx-auto">
                Temukan makanan khas, oleh-oleh, dan UMKM terbaik di Kota Tegal dalam satu aplikasi.
            </p>
        </div>

        <div class="absolute bottom-6 text-xs text-orange-100">
            © 2026 TegalFood
        </div>

    </div>

    {{-- RIGHT SIDE --}}
    <div class="flex w-full md:w-1/2 items-center justify-center bg-gradient-to-br from-orange-50 to-white p-6">

        <form method="POST"
              action="{{ route('user.register.store') }}"
              class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-md">

            @csrf

            @if(session('success'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <h1 class="text-3xl font-bold mb-2 text-gray-800">
                Daftar User
            </h1>

            <p class="text-gray-500 mb-8 text-sm">
                Daftar untuk mulai memesan makanan favorit Anda.
            </p>

            <div class="mb-5">
                <label class="block text-sm font-medium mb-2 text-gray-700">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                    required>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium mb-2 text-gray-700">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                    required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2 text-gray-700">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                    required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2 text-gray-700">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                    required>
            </div>

            <div class="mb-5">

                <label class="block text-sm font-medium mb-2">

                    Nomor Telepon

                </label>

                <input
                    type="tel"
                    name="nomor_telepon"
                    value="{{ old('nomor_telepon') }}"
                    inputmode="numeric"
                    maxlength="15"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="w-full border border-gray-300 p-3 rounded-lg"
                    placeholder="Nomor Telepon"
                    required>

            </div>

            <button
                type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-semibold transition duration-300">

                Daftar

            </button>

            {{-- GOOGLE LOGIN --}}
            <div class="mt-6 text-center">

                <p class="text-sm text-gray-500 mb-3">
                    Atau daftar dengan Google
                </p>

                <a href="{{ route('user.google.redirect') }}"
                class="inline-flex items-center justify-center w-12 h-12 rounded-full border border-gray-300 bg-white shadow-sm hover:shadow-md hover:bg-gray-100 transition duration-300">

                    <svg class="w-6 h-6" viewBox="0 0 48 48">
                        <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.9 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.1 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-3.5z"/>
                        <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 16 18.9 12 24 12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.1 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
                        <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.6-5.3l-6.3-5.2C29.3 35.9 26.8 37 24 37c-5.2 0-9.6-3.5-11.2-8.3l-6.5 5C9.5 39.6 16.2 44 24 44z"/>
                        <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-1.1 3-3.4 5.4-6.3 6.7l6.3 5.2C39.8 36.2 44 30.7 44 24c0-1.3-.1-2.7-.4-3.5z"/>
                    </svg>

                </a>

            </div>

            <p class="text-sm text-center text-gray-500 mt-6">
                Sudah punya akun?

                <a href="{{ route('user.login') }}"
                class="text-orange-500 font-semibold hover:underline">
                    Login sekarang
                </a>
            </p>

        </form>

    </div>

</div>

</body>
</html>