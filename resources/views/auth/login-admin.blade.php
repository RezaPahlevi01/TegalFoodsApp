@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <form method="POST" action="{{ route('admin.login.process') }}"
          class="bg-white p-8 rounded shadow w-full max-w-md">

        @csrf

        <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>

        <input type="email" name="email" placeholder="Email"
               class="w-full border p-3 rounded mb-4" required>

        <input type="password" name="password" placeholder="Password"
               class="w-full border p-3 rounded mb-4" required>

        <button class="w-full bg-yellow-500 text-white py-3 rounded">
            Login
        </button>
    </form>
</div>
@endsection
