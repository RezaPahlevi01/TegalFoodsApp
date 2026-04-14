<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - TegalFood</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 flex items-center justify-center min-h-screen">

    <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl">

        {{-- TITLE --}}
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                Admin Panel
            </h1>
            <p class="text-sm text-gray-500 mt-2">
                Login untuk mengakses dashboard administrator
            </p>
        </div>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- FORM --}}
        <form method="POST" action="{{ route('admin.login.process') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>
                <input type="email" name="email"
                       class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800"
                       required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800"
                       required>
            </div>

            <button type="submit"
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg font-semibold transition">
                Login
            </button>
        </form>

        <div class="text-center text-xs text-gray-400 mt-6">
            © 2026 TegalFood Admin System
        </div>

    </div>

</body>
</html>