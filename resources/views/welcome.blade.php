<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Sistem Absensi PKL - Polres Garut</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="bg-gradient-to-br from-red-50 via-yellow-50 to-red-100">
        <!-- Header -->
        <header class="bg-gradient-to-r from-red-600 to-red-700 text-white shadow-xl">
            <div class="container mx-auto px-6 py-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('Lambang_Polda_Jabar.png') }}" alt="Logo Polda Jabar" class="w-16 h-16 shadow-lg hover:shadow-xl transition-shadow object-contain">
                        <div>
                            <h1 class="text-3xl font-bold">POLRES GARUT</h1>
                            <p class="text-sm text-red-100">Kepolisian Resor Garut</p>
                        </div>
                    </div>
                    <div>
                        @auth
                        <a href="{{ route('home') }}" class="px-6 py-2 bg-yellow-400 text-red-700 rounded-lg font-bold hover:bg-yellow-300 transition-all">
                            <i class="fas fa-arrow-right mr-2"></i>Ke Dashboard
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-white text-red-600 rounded-lg font-bold hover:bg-gray-100 transition-all">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-16">
            <!-- Hero Section -->
            <section class="grid md:grid-cols-2 gap-12 items-center mb-20">
                <div>
                    <h2 class="text-5xl font-bold text-gray-800 mb-4">
                        Sistem Absensi PKL
                    </h2>
                    <p class="text-xl text-gray-600 mb-6">
                        Platform manajemen kehadiran untuk Program Kerja Lapangan (PKL) di <strong>Kepolisian Resor Garut</strong>
                    </p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-red-600 mr-3"></i>
                            Pencatatan absensi real-time
                        </li>
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-red-600 mr-3"></i>
                            Laporan kehadiran komprehensif
                        </li>
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-red-600 mr-3"></i>
                            Manajemen siswa PKL terpusat
                        </li>
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-red-600 mr-3"></i>
                            Status izin, sakit, dan alpa
                        </li>
                    </ul>
                    @guest
                    <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg font-bold hover:shadow-lg transition-all">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sebagai Siswa
                    </a>
                    @endguest
                </div>
                <div class="flex justify-center">
                    <img src="{{ asset('Lambang_Polda_Jabar.png') }}" alt="Logo Polda Jabar" class="w-80 h-80 shadow-2xl object-contain hover:shadow-lg transition-shadow">
                </div>
            </section>

            <!-- Features Section -->
            <section class="mb-20">
                <h3 class="text-4xl font-bold text-gray-800 mb-12 text-center">Fitur Utama</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-clock text-red-600 text-2xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-800 mb-3">Absensi Real-time</h4>
                        <p class="text-gray-600">Pencatatan masuk dan pulang dengan timestamp otomatis, memastikan akurasi kehadiran siswa PKL.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all">
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-chart-bar text-yellow-600 text-2xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-800 mb-3">Laporan Terukur</h4>
                        <p class="text-gray-600">Laporan kehadiran bulanan dan tahunan dengan statistik lengkap untuk evaluasi performa siswa.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-user-check text-blue-600 text-2xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-800 mb-3">Manajemen Siswa</h4>
                        <p class="text-gray-600">Kelola profil siswa PKL, termasuk izin, sakit, dan alpa dengan catatan yang terstruktur.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-lock text-green-600 text-2xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-800 mb-3">Akses Terkontrol</h4>
                        <p class="text-gray-600">Sistem role-based dengan pembedaan akses admin dan siswa untuk keamanan data maksimal.</p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-history text-purple-600 text-2xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-800 mb-3">Riwayat Lengkap</h4>
                        <p class="text-gray-600">Akses riwayat absensi lengkap dengan filter berdasarkan tanggal dan siswa untuk tracking detail.</p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all">
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-mobile-alt text-orange-600 text-2xl"></i>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-800 mb-3">Responsive Design</h4>
                        <p class="text-gray-600">Antarmuka yang responsif dan user-friendly dapat diakses dari berbagai perangkat dengan mudah.</p>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="bg-gradient-to-r from-red-600 to-red-700 rounded-2xl shadow-2xl p-12 text-white text-center mb-20">
                <h3 class="text-4xl font-bold mb-4">Siap Menggunakan Sistem?</h3>
                <p class="text-xl mb-8 text-red-100">Bergabunglah dengan ribuan siswa PKL di Polres Garut yang telah menggunakan platform kami.</p>
                <div class="flex gap-4 justify-center flex-wrap">
                    @guest
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-yellow-400 text-red-700 rounded-lg font-bold hover:bg-yellow-300 transition-all">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-white text-red-600 rounded-lg font-bold hover:bg-gray-100 transition-all">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                    @else
                    <a href="{{ route('home') }}" class="px-8 py-3 bg-yellow-400 text-red-700 rounded-lg font-bold hover:bg-yellow-300 transition-all">
                        <i class="fas fa-arrow-right mr-2"></i>Ke Dashboard
                    </a>
                    @endguest
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-8">
            <div class="container mx-auto px-6">
                <div class="grid md:grid-cols-3 gap-8 mb-8">
                    <div>
                        <h4 class="text-xl font-bold mb-4">Tentang Kami</h4>
                        <p class="text-gray-400">Sistem Absensi PKL Polres Garut adalah platform modern untuk manajemen kehadiran siswa Program Kerja Lapangan.</p>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold mb-4">Navigasi</h4>
                        <ul class="space-y-2 text-gray-400">
                            @auth
                            <li><a href="{{ route('home') }}" class="hover:text-white transition">Dashboard</a></li>
                            <li><a href="{{ route('absensi.riwayat') }}" class="hover:text-white transition">Riwayat</a></li>
                            <li><a href="{{ route('absensi.laporan') }}" class="hover:text-white transition">Laporan</a></li>
                            @else
                            <li><a href="{{ route('login') }}" class="hover:text-white transition">Login</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-white transition">Daftar</a></li>
                            @endauth
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold mb-4">Kontak</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><i class="fas fa-map-marker-alt mr-2"></i>Polres Garut, Jawa Barat</li>
                            <li><i class="fas fa-phone mr-2"></i>(+62) XXX-XXXX-XXXX</li>
                            <li><i class="fas fa-envelope mr-2"></i>info@polresgarut.id</li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-700 pt-8 text-center text-gray-400">
                    <p>&copy; 2024 Polres Garut. Semua hak dilindungi. | Sistem Absensi PKL</p>
                </div>
            </div>
        </footer>
    </body>
</html>
