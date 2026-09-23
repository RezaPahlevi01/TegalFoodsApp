<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login UMKM - TegalFood</title>
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
    <div class="hidden md:flex w-1/2 bg-yellow-500 items-center justify-center p-10 relative">

        <div class="text-center text-white">
            <h2 class="text-3xl font-bold mb-4">
                Selamat Datang Kembali
            </h2>

            <p class="text-yellow-100 mb-8 max-w-sm mx-auto">
                Login untuk mengelola toko dan produk UMKM Anda di TegalFood.
            </p>

            <img src="{{ asset('images/login-umkm.svg') }}"
                 alt="Login Illustration"
                 class="w-80 mx-auto drop-shadow-2xl float">
        </div>

        <div class="absolute bottom-6 text-xs text-yellow-100">
            &copy; 2026 TegalFood
        </div>
    </div>

    {{-- RIGHT SIDE --}}
    <div class="flex w-full md:w-1/2 items-center justify-center bg-gradient-to-br from-yellow-50 to-white p-6">

        <form method="POST" action="{{ route('umkm.login.process') }}"
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
                Login UMKM
            </h1>

            <p class="text-gray-500 mb-8 text-sm">
                Masukkan NIB dan password Anda
            </p>

            <div class="mb-5">
                <label class="block text-sm font-medium mb-2 text-gray-700">
                    NIB (Nomor Induk Berusaha)
                </label>
                <input type="text" name="nib" value="{{ old('nib') }}"
                       class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                       placeholder="Masukkan NIB"
                       required autofocus>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2 text-gray-700">
                    Password
                </label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                       required>
            </div>

            <button type="submit"
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg font-semibold transition duration-300">
                Login
            </button>

            <p class="text-sm text-center text-gray-500 mt-6">
                Lupa password?
                <a href="{{ route('password.request') }}"
                   class="text-yellow-500 font-semibold hover:underline">
                    Reset password
                </a>
            </p>

            <p class="text-xs text-center text-gray-400 mt-4">
                Akun UMKM dibuat oleh admin. Hubungi admin jika belum memiliki akun.
            </p>

        </form>
    </div>

</div>

</body>
</html>
