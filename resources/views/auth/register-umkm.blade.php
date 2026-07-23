<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Daftar UMKM - TegalFood</title>

    <!-- Tailwind CDN -->
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
<body class="bg-gradient-to-br from-yellow-50 via-white to-orange-50">

        <div class="min-h-screen flex items-center justify-center px-4 py-10">

            <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2">

                <!-- ================= LEFT ILLUSTRATION ================= -->
                <div class="hidden md:flex flex-col justify-center items-center bg-yellow-500 text-white p-10 relative">

            <h2 class="text-3xl font-bold mb-4 text-center">
                Gabung Jadi Mitra TegalFood
            </h2>

            <p class="text-center text-yellow-100 mb-8 max-w-sm">
                Perluas pasar UMKM kamu dan tingkatkan penjualan bersama TegalFood.
            </p>

            <img src="{{ asset('images/register-umkm.svg') }}"
                alt="Ilustrasi UMKM"
                class="w-80 drop-shadow-2xl float">

            <div class="absolute bottom-6 text-xs text-yellow-100">
                © 2026 TegalFood
            </div>
        </div>

        <!-- ================= FORM SECTION ================= -->
        <div class="p-8 sm:p-10">

            <div class="mb-6 text-center">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">
                    Daftar UMKM
                </h2>
                <p class="text-gray-500 text-sm mt-2">
                    Buat akun dan mulai jual produk kamu hari ini
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded mb-4 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('umkm.register.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h3 class="font-semibold text-gray-700 mb-3">Data Akun</h3>

                <div class="grid grid-cols-1 gap-4">

                    <input type="text" name="name"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-400 outline-none transition"
                        placeholder="Nama Pemilik"
                        required>

                    <input type="email" name="email"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-400 outline-none transition"
                        placeholder="Email"
                        required>

                    <input type="password" name="password"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-400 outline-none transition"
                        placeholder="Password"
                        required>

                    <input type="password" name="password_confirmation"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-400 outline-none transition"
                        placeholder="Konfirmasi Password"
                        required>
                </div>

                <hr class="my-6">

                <h3 class="font-semibold text-gray-700 mb-3">Data UMKM</h3>

                <div class="grid grid-cols-1 gap-4">

                    <input type="text" name="nama_umkm"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-400 outline-none transition"
                        placeholder="Nama UMKM"
                        required>

                    <input type="text" name="nama_pemilik"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-400 outline-none transition"
                        placeholder="Nama Pemilik Usaha"
                        required>

                    <input type="text" name="nomor_whatsapp"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-400 outline-none transition"
                        placeholder="Nomor WhatsApp"
                        required>

                    <textarea name="alamat" rows="3"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-400 outline-none transition"
                        placeholder="Alamat Lengkap UMKM"
                        required></textarea>
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload QRIS
                        </label>

                        <input
                            type="file"
                            name="foto_qris"
                            accept=".jpg,.jpeg,.png"
                            required
                            class="w-full border border-gray-300 rounded-xl px-4 py-3">

                        <p class="text-xs text-gray-500 mt-2">
                            Upload foto QRIS UMKM Anda (JPG/PNG maksimal 2 MB)
                        </p>

                    </div>
                </div>

                <button type="submit"
                    class="mt-6 w-full bg-yellow-500 hover:bg-yellow-600
                           text-white py-3 rounded-xl font-semibold
                           shadow-lg hover:shadow-xl transition duration-300">
                    Daftar Sekarang
                </button>

                <p class="text-center text-sm text-gray-500 mt-4">
                    Sudah punya akun?
                    <a href="{{ route('umkm.login') }}"
                       class="text-yellow-600 font-semibold hover:underline">
                        Login
                    </a>
                </p>

            </form>

        </div>

    </div>

</div>
</body>
</html>
