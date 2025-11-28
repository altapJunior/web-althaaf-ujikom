<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Absensi PKL Polres</title>
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
    </style>
</head>
<body class="bg-gradient-to-br from-red-50 via-yellow-50 to-red-100 min-h-screen">
    
    <!-- Header -->
    <header class="gradient-red-yellow text-white shadow-2xl sticky top-0 z-50">
        <div class="container mx-auto px-6 py-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <span class="text-red-800 font-bold text-2xl">P</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">POLRES</h1>
                        <p class="text-yellow-100 text-sm">Sistem Absensi PKL</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold" id="clock"></div>
                    <div class="text-yellow-100 text-sm">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="bg-white shadow-md border-b-4 border-red-600 sticky top-20 z-40">
        <div class="container mx-auto px-6">
            <div class="flex space-x-1">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 px-6 py-4 font-semibold transition-all {{ request()->routeIs('home') ? 'gradient-red-yellow text-white border-b-4 border-red-900' : 'text-gray-700 hover:bg-red-50' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('siswa.index') }}" class="flex items-center space-x-2 px-6 py-4 font-semibold transition-all {{ request()->routeIs('siswa.*') ? 'gradient-red-yellow text-white border-b-4 border-red-900' : 'text-gray-700 hover:bg-red-50' }}">
                    <i class="fas fa-users"></i>
                    <span>Data Siswa</span>
                </a>
                <a href="{{ route('absensi.riwayat') }}" class="flex items-center space-x-2 px-6 py-4 font-semibold transition-all {{ request()->routeIs('absensi.riwayat') ? 'gradient-red-yellow text-white border-b-4 border-red-900' : 'text-gray-700 hover:bg-red-50' }}">
                    <i class="fas fa-history"></i>
                    <span>Riwayat</span>
                </a>
                <a href="{{ route('absensi.laporan') }}" class="flex items-center space-x-2 px-6 py-4 font-semibold transition-all {{ request()->routeIs('absensi.laporan') ? 'gradient-red-yellow text-white border-b-4 border-red-900' : 'text-gray-700 hover:bg-red-50' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="container mx-auto px-6 mt-4">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container mx-auto px-6 mt-4">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="gradient-red-yellow text-white mt-12 py-6">
        <div class="container mx-auto px-6 text-center">
            <p class="font-semibold">© {{ date('Y') }} Kepolisian Resort - Sistem Absensi PKL</p>
            <p class="text-yellow-200 text-sm mt-2">Melayani dengan Sepenuh Hati</p>
        </div>
    </footer>

    <script>
        // Real-time clock
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        }
        updateClock();
        setInterval(updateClock, 1000);

        // Auto hide alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000);
    </script>
    @stack('scripts')
</body>
</html>