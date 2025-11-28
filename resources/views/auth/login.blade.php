@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <!-- Logo / Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <span class="text-white font-bold text-3xl">P</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Login</h1>
            <p class="text-gray-600 mt-2">Sistem Absensi PKL Polres</p>
        </div>

        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6">
                @foreach ($errors->all() as $error)
                    <p class="text-red-800 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-6">
                <p class="text-green-800 text-sm"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-red-600 mr-2"></i>Email
                    </label>
                    <input 
                        type="email" 
                        id="email"
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="Masukkan email Anda"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:bg-red-50 transition-all @error('email') border-red-500 @enderror"
                        required autofocus>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-red-600 mr-2"></i>Password
                    </label>
                    <input 
                        type="password" 
                        id="password"
                        name="password" 
                        placeholder="Masukkan password Anda"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:bg-red-50 transition-all @error('password') border-red-500 @enderror"
                        required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember"
                        class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="ml-3 text-sm font-medium text-gray-700">
                        Ingat saya
                    </label>
                </div>

                <!-- Login Button -->
                <button 
                    type="submit"
                    class="w-full gradient-red-yellow text-white py-3 rounded-lg font-semibold hover:shadow-lg transition-all transform hover:scale-105">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </button>

                <!-- Register Link -->
                <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-gray-700">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-red-600 font-semibold hover:text-red-700 transition-colors">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Demo Info -->
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
            <p class="text-blue-900 text-sm">
                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                <strong>Demo Account:</strong><br>
                👨‍💼 <strong>Admin:</strong> admin@example.com | password<br>
                👤 <strong>Siswa PKL:</strong> siswa@example.com | password
            </p>
        </div>
    </div>
</div>

<style>
    .gradient-red-yellow {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #eab308 100%);
    }
</style>
@endsection
