@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <!-- Selamat Datang Header -->
        <div class="text-center mb-8 bg-gradient-to-r from-blue-600 to-blue-500 rounded-2xl shadow-xl p-8 text-white">
            <h2 class="text-2xl font-bold mb-2">Selamat Datang</h2>
            <p class="text-blue-100">Daftar di Sistem Absensi PKL</p>
        </div>

        <!-- Logo / Header -->
        <div class="text-center mb-8">
            <img src="{{ asset('Lambang_Polda_Jabar.png') }}" alt="Logo Polda Jabar" class="w-24 h-24 mx-auto mb-4 shadow-lg object-contain hover:scale-110 transition-transform">
            <h1 class="text-3xl font-bold text-gray-800">POLRES GARUT</h1>
            <p class="text-gray-600 mt-2">Daftar Akun Baru</p>
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

        <!-- Register Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user text-red-600 mr-2"></i>Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        id="name"
                        name="name" 
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap Anda"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:bg-red-50 transition-all @error('name') border-red-500 @enderror"
                        required autofocus>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

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
                        required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIM/NIS -->
                <div>
                    <label for="nim_nis" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-id-card text-red-600 mr-2"></i>NIM / NIS
                    </label>
                    <input 
                        type="text" 
                        id="nim_nis"
                        name="nim_nis" 
                        value="{{ old('nim_nis') }}"
                        placeholder="Contoh: 001234"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:bg-red-50 transition-all @error('nim_nis') border-red-500 @enderror"
                        required>
                    @error('nim_nis')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jurusan -->
                <div>
                    <label for="jurusan" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-graduation-cap text-red-600 mr-2"></i>Jurusan
                    </label>
                    <input 
                        type="text" 
                        id="jurusan"
                        name="jurusan" 
                        value="{{ old('jurusan') }}"
                        placeholder="Contoh: Teknik Informatika"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:bg-red-50 transition-all @error('jurusan') border-red-500 @enderror"
                        required>
                    @error('jurusan')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sekolah -->
                <div>
                    <label for="sekolah" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-school text-red-600 mr-2"></i>Sekolah / Institusi
                    </label>
                    <input 
                        type="text" 
                        id="sekolah"
                        name="sekolah" 
                        value="{{ old('sekolah') }}"
                        placeholder="Contoh: SMK Negeri 1"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:bg-red-50 transition-all @error('sekolah') border-red-500 @enderror"
                        required>
                    @error('sekolah')
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
                        placeholder="Minimal 6 karakter"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:bg-red-50 transition-all @error('password') border-red-500 @enderror"
                        required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-red-600 mr-2"></i>Konfirmasi Password
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation"
                        name="password_confirmation" 
                        placeholder="Ulangi password Anda"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:bg-red-50 transition-all"
                        required>
                </div>

                <!-- Register Button -->
                <button 
                    type="submit"
                    class="w-full gradient-red-yellow text-white py-3 rounded-lg font-semibold hover:shadow-lg transition-all transform hover:scale-105">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sebagai Siswa PKL
                </button>

                <!-- Login Link -->
                <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-gray-700">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-red-600 font-semibold hover:text-red-700 transition-colors">
                            Login sekarang
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .gradient-red-yellow {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #eab308 100%);
    }
</style>
@endsection
