<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="min-h-screen w-full bg-gradient-to-br from-orange-50 via-white to-yellow-50 flex items-center justify-center relative overflow-hidden">

    <!-- background blur dekorasi -->
    <div class="absolute -top-20 -left-20 w-72 h-72 bg-orange-300 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-yellow-300 rounded-full blur-3xl opacity-30"></div>

    <!-- card -->
    <div class="bg-white/90 backdrop-blur-md shadow-xl rounded-2xl p-8 w-full max-w-md z-10">

        <!-- header -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Reset Password
            </h1>

            <p class="text-gray-500 text-sm mt-2">
                Masukkan password baru kamu untuk mengamankan akun
            </p>
        </div>

        <!-- error -->
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- form -->
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <!-- email -->
            <div>
                <label class="text-sm text-gray-600">Email</label>
                <input type="email"
                       name="email"
                       value="{{ $email }}"
                       readonly
                       class="w-full mt-1 px-4 py-3 border rounded-xl bg-gray-100 text-gray-500">
            </div>

            <!-- password -->
            <div>
                <label class="text-sm text-gray-600">Password Baru</label>
                <input type="password"
                       name="password"
                       required
                       class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-orange-400 outline-none"
                       placeholder="Masukkan password baru">
            </div>

            <!-- confirm -->
            <div>
                <label class="text-sm text-gray-600">Konfirmasi Password</label>
                <input type="password"
                       name="password_confirmation"
                       required
                       class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-orange-400 outline-none"
                       placeholder="Ulangi password baru">
            </div>

            <!-- button -->
            <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl font-semibold transition shadow-md">
                Reset Password
            </button>
        </form>

        <!-- back -->
        <div class="text-center mt-5">
            <a href="{{ route('user.login') }}"
               class="text-sm text-orange-500 hover:underline">
                Kembali ke login
            </a>
        </div>

    </div>
</div>

</body>
</html>