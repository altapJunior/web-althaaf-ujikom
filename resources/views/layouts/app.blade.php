<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Absensi PKL Polres Garut</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .gradient-red-yellow {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #eab308 100%);
        }

        .hover-scale {
            transition: transform 0.3s ease;
        } 
        .hover-scale:hover {
            transform: scale(1.05);
        }

        body {
            background-image: url('{{ asset('Lambang_Polda_Jabar.png') }}');
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: auto;
            background-color: #fef3c7;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.05) 0%, rgba(239, 68, 68, 0.05) 50%, rgba(234, 179, 8, 0.05) 100%);
            pointer-events: none;
            z-index: 0;
        }

        .main-content {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-red-50 via-yellow-50 to-red-100 min-h-screen">

    <!-- Header -->
    <header class="gradient-red-yellow text-white shadow-xl sticky top-0 z-50">
        <div class="container mx-auto px-6 py-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('Lambang_Polda_Jabar.png') }}" alt="Logo Polda Jabar" class="w-14 h-14 shadow-lg hover:shadow-xl transition-shadow object-contain">
                    <div>
                        <h1 class="text-2xl font-bold">POLRES GARUT</h1>
                        <p class="text-sm text-yellow-100">Kepolisian Resor Garut</p>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <h2 class="text-xl md:text-2xl font-semibold">Sistem Absensi PKL</h2>
                    
                    <!-- User Profile Dropdown -->
                    @if(auth()->check())
                    <div class="relative group">
                        <div class="flex items-center space-x-2 px-4 py-2 bg-white bg-opacity-20 rounded-lg cursor-pointer hover:bg-opacity-30 transition-all">
                            <i class="fas fa-user-circle text-2xl"></i>
                            <div class="text-sm">
                                <p class="font-semibold">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-yellow-100 uppercase">{{ auth()->user()->role }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-0 w-48 bg-white text-gray-800 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="px-4 py-3 border-b border-gray-200">
                                <p class="font-semibold">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-600">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="px-4 py-2">
                                <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ auth()->user()->role === 'admin' ? '👨‍💼 Admin' : '👤 User' }}
                                </span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-200">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 transition-all font-semibold">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="space-x-3">
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-white text-red-600 rounded-lg font-semibold hover:bg-yellow-100 transition-all">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        @if(auth()->check())
        <nav class="bg-black bg-opacity-20 border-t border-white border-opacity-20">
            <div class="container mx-auto px-6 flex flex-wrap items-center gap-2 md:gap-0 overflow-x-auto">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 px-6 py-4 font-semibold transition-all text-white hover:bg-black hover:bg-opacity-30 {{ request()->routeIs('home') ? 'border-b-4 border-yellow-300 bg-black bg-opacity-30' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>

                @if(auth()->user()->role === 'admin')
                <a href="{{ route('siswa.index') }}" class="flex items-center space-x-2 px-6 py-4 font-semibold transition-all text-white hover:bg-black hover:bg-opacity-30 {{ request()->routeIs('siswa.*') ? 'border-b-4 border-yellow-300 bg-black bg-opacity-30' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Kelola Siswa</span>
                </a>
                @endif

                <a href="{{ route('absensi.riwayat') }}" class="flex items-center space-x-2 px-6 py-4 font-semibold transition-all text-white hover:bg-black hover:bg-opacity-30 {{ request()->routeIs('absensi.riwayat') ? 'border-b-4 border-yellow-300 bg-black bg-opacity-30' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Riwayat</span>
                </a>

                <a href="{{ route('absensi.laporan') }}" class="flex items-center space-x-2 px-6 py-4 font-semibold transition-all text-white hover:bg-black hover:bg-opacity-30 {{ request()->routeIs('absensi.laporan') ? 'border-b-4 border-yellow-300 bg-black bg-opacity-30' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
            </div>
        </nav>
        @endif
    </header>

    <!-- Content -->
    <main class="main-content container mx-auto px-6 py-10">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
