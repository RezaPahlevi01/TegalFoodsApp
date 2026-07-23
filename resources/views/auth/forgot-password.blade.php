<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="min-h-screen w-full bg-gradient-to-br from-orange-50 via-white to-yellow-50 flex items-center justify-center relative overflow-hidden">

    <!-- dekorasi background blur -->
    <div class="absolute -top-20 -left-20 w-72 h-72 bg-orange-300 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-yellow-300 rounded-full blur-3xl opacity-30"></div>

    <!-- card utama -->
    <div class="bg-white/90 backdrop-blur-md shadow-xl rounded-2xl p-8 w-full max-w-md z-10">

        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Lupa Password
            </h1>

            <p class="text-gray-500 text-sm mt-2">
                Masukkan email kamu untuk menerima link reset password
            </p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm text-gray-600">Email</label>
                <input type="email"
                       name="email"
                       required
                       class="w-full mt-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-orange-400 outline-none"
                       placeholder="contoh@email.com">
            </div>

            <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl font-semibold transition shadow-md">
                Kirim Link Reset
            </button>
        </form>

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