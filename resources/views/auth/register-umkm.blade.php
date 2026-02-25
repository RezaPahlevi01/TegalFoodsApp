<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar UMKM - TegalFood</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg p-8">

        <!-- HEADER -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Daftar UMKM TegalFood
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Buat akun UMKM dan mulai jual produk kamu
            </p>
        </div>

        <!-- ERROR -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded mb-4">
                <ul class="text-sm">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('umkm.register.store') }}" method="POST">
            @csrf

            <!-- DATA AKUN -->
            <h3 class="font-semibold text-gray-700 mb-3">
                Data Akun
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="text-sm">Nama Pemilik</label>
                    <input type="text" name="name"
                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-yellow-400 outline-none"
                        placeholder="Nama lengkap"
                        required>
                </div>

                <div>
                    <label class="text-sm">Email</label>
                    <input type="email" name="email"
                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-yellow-400 outline-none"
                        placeholder="example@gmail.com"
                        required>
                </div>

                <div>
                    <label class="text-sm">Password</label>
                    <input type="password" name="password"
                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-yellow-400 outline-none"
                        required>
                </div>

                <div>
                    <label class="text-sm">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-yellow-400 outline-none"
                        required>
                </div>

            </div>

            <!-- UMKM -->
            <hr class="my-6">

            <h3 class="font-semibold text-gray-700 mb-3">
                Data UMKM
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="text-sm">Nama UMKM</label>
                    <input type="text" name="nama_umkm"
                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-yellow-400 outline-none"
                        placeholder="Nama usaha"
                        required>
                </div>

                <div>
                    <label class="text-sm">Nama Pemilik</label>
                    <input type="text" name="nama_pemilik"
                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-yellow-400 outline-none"
                        placeholder="Nama pemilik usaha"
                        required>
                </div>

                <div>
                    <label class="text-sm">Nomor WhatsApp</label>
                    <input type="text" name="nomor_whatsapp"
                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-yellow-400 outline-none"
                        placeholder="08xxxxxxxx"
                        required>
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm">Alamat UMKM</label>
                    <textarea name="alamat" rows="3"
                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-yellow-400 outline-none"
                        placeholder="Alamat lengkap UMKM"
                        required></textarea>
                </div>

            </div>

            <!-- BUTTON -->
            <button type="submit"
                class="mt-6 w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg font-semibold transition">

                Daftar UMKM

            </button>

            <!-- LINK LOGIN -->
            <p class="text-center text-sm text-gray-500 mt-4">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-yellow-600 font-semibold hover:underline">
                    Login
                </a>
            </p>

        </form>

    </div>

</div>

</body>
</html>
