@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header untuk Admin -->
    @if(auth()->user()->role === 'admin')
    <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-2xl shadow-xl p-8 text-white">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-user-tie text-3xl"></i>
            </div>
            <div>
                <p class="text-red-100 text-sm">Selamat Datang,</p>
                <h1 class="text-3xl font-bold">Admin {{ auth()->user()->name }}</h1>
                <p class="text-red-100">Manajemen Absensi PKL Polres Garut</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Header untuk Siswa (User) -->
    @if(auth()->user()->role === 'user' && auth()->user()->siswaPkl)
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl p-8 text-white">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-user-graduate text-3xl"></i>
            </div>
            <div>
                <p class="text-blue-100 text-sm">Selamat Datang,</p>
                <h1 class="text-3xl font-bold">{{ auth()->user()->siswaPkl->nama }}</h1>
                <p class="text-blue-100">NIM/NIS: {{ auth()->user()->siswaPkl->nim_nis }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    @if(auth()->user()->role === 'admin')
    <!-- ADMIN DASHBOARD -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-red-600 to-red-700 rounded-2xl p-6 text-white shadow-xl hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-200 text-sm font-medium">Total Siswa PKL</p>
                    <p class="text-5xl font-bold mt-2">{{ $totalSiswa }}</p>
                </div>
                <i class="fas fa-users text-6xl text-red-300 opacity-50"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl p-6 text-white shadow-xl hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Hadir Hari Ini</p>
                    <p class="text-5xl font-bold mt-2">{{ $hadirHariIni }}</p>
                </div>
                <i class="fas fa-check-circle text-6xl text-yellow-200 opacity-50"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-yellow-500 rounded-2xl p-6 text-white shadow-xl hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Belum Absen</p>
                    <p class="text-5xl font-bold mt-2">{{ $belumAbsen }}</p>
                </div>
                <i class="fas fa-exclamation-triangle text-6xl text-yellow-100 opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Daftar Siswa untuk Absensi (Admin) -->
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-clipboard-check text-red-600 mr-3"></i>
            Absensi Hari Ini
        </h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($siswa as $s)
            <div class="border-2 border-gray-200 rounded-xl p-6 hover:shadow-lg transition-shadow {{ $s->absensiHariIni ? 'bg-green-50 border-green-300' : 'bg-red-50 border-red-300' }}">
                <div class="flex items-center mb-4">
                    @if($s->foto)
                    <img src="{{ Storage::url($s->foto) }}" alt="{{ $s->nama }}" class="w-16 h-16 rounded-full object-cover mr-4 border-4 border-white shadow">
                    @else
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-red-500 to-yellow-500 flex items-center justify-center text-white font-bold text-2xl mr-4">
                        {{ substr($s->nama, 0, 1) }}
                    </div>
                    @endif
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $s->nama }}</h3>
                        <p class="text-sm text-gray-600">{{ $s->nim_nis }}</p>
                    </div>
                </div>

                <div class="space-y-2 mb-4">
                    <p class="text-sm text-gray-600"><i class="fas fa-graduation-cap mr-2"></i>{{ $s->jurusan }}</p>
                    <p class="text-sm text-gray-600"><i class="fas fa-school mr-2"></i>{{ $s->sekolah }}</p>
                </div>

                @if($s->absensiHariIni)
                <div class="space-y-2">
                    @if($s->absensiHariIni->jam_masuk)
                    <div class="flex items-center text-green-700 bg-green-100 px-3 py-2 rounded-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        <span class="text-sm">Masuk: {{ \Carbon\Carbon::parse($s->absensiHariIni->jam_masuk)->format('H:i') }}</span>
                    </div>
                    @endif
                    
                    @if($s->absensiHariIni->jam_pulang)
                    <div class="flex items-center text-blue-700 bg-blue-100 px-3 py-2 rounded-lg">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        <span class="text-sm">Pulang: {{ \Carbon\Carbon::parse($s->absensiHariIni->jam_pulang)->format('H:i') }}</span>
                    </div>
                    @else
                    <button onclick="absenPulang({{ $s->id }})" class="w-full gradient-red-yellow text-white px-4 py-2 rounded-lg font-semibold hover:shadow-lg transition-all">
                        <i class="fas fa-sign-out-alt mr-2"></i>Absen Pulang
                    </button>
                    @endif
                </div>
                @else
                <div class="space-y-2">
                    <button onclick="absenMasuk({{ $s->id }})" class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-4 py-2 rounded-lg font-semibold hover:shadow-lg transition-all">
                        <i class="fas fa-sign-in-alt mr-2"></i>Absen Masuk
                    </button>
                    <div class="grid grid-cols-3 gap-2">
                        <button onclick="showIzinModal({{ $s->id }})" class="bg-blue-500 text-white px-2 py-2 rounded-lg text-sm font-semibold hover:shadow-lg transition-all">
                            <i class="fas fa-clipboard-list mr-1"></i>Izin
                        </button>
                        <button onclick="showSakitModal({{ $s->id }})" class="bg-orange-500 text-white px-2 py-2 rounded-lg text-sm font-semibold hover:shadow-lg transition-all">
                            <i class="fas fa-heartbeat mr-1"></i>Sakit
                        </button>
                        <button onclick="absenAlpa({{ $s->id }})" class="bg-red-500 text-white px-2 py-2 rounded-lg text-sm font-semibold hover:shadow-lg transition-all">
                            <i class="fas fa-ban mr-1"></i>Alpa
                        </button>
                    </div>
                </div>
                @endif
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <i class="fas fa-users text-6xl mb-4 text-gray-300"></i>
                <p class="text-lg">Belum ada data siswa PKL</p>
                <a href="{{ route('siswa.create') }}" class="inline-block mt-4 gradient-red-yellow text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Tambah Siswa
                </a>
            </div>
            @endforelse
        </div>
    </div>

    @else
    <!-- USER/SISWA DASHBOARD -->
    @if(auth()->user()->siswaPkl)
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-2xl p-6 text-white shadow-xl hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-200 text-sm font-medium">Absen Masuk</p>
                    <p class="text-5xl font-bold mt-2">{{ $hadirHariIni ? '✓' : '✗' }}</p>
                </div>
                <i class="fas fa-check-circle text-6xl text-green-300 opacity-50"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl p-6 text-white shadow-xl hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Absen Pulang</p>
                    <p class="text-5xl font-bold mt-2">{{ auth()->user()->siswaPkl->absensiHariIni?->jam_pulang ? '✓' : '✗' }}</p>
                </div>
                <i class="fas fa-sign-out-alt text-6xl text-yellow-200 opacity-50"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 text-white shadow-xl hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-200 text-sm font-medium">Jurusan</p>
                    <p class="text-2xl font-bold mt-2">{{ auth()->user()->siswaPkl->jurusan }}</p>
                </div>
                <i class="fas fa-graduation-cap text-6xl text-blue-300 opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Data Absensi Siswa -->
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-clipboard-check text-red-600 mr-3"></i>
            Data Absensi Anda Hari Ini
        </h2>

        @if(auth()->user()->siswaPkl->absensiHariIni)
        <div class="border-2 border-green-300 bg-green-50 rounded-xl p-6">
            <div class="space-y-4">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Jam Masuk</p>
                    <p class="text-3xl font-bold text-green-700">
                        <i class="fas fa-sign-in-alt mr-2"></i>{{ \Carbon\Carbon::parse(auth()->user()->siswaPkl->absensiHariIni->jam_masuk)->format('H:i') }}
                    </p>
                </div>

                @if(auth()->user()->siswaPkl->absensiHariIni->jam_pulang)
                <div>
                    <p class="text-gray-600 text-sm mb-1">Jam Pulang</p>
                    <p class="text-3xl font-bold text-blue-700">
                        <i class="fas fa-sign-out-alt mr-2"></i>{{ \Carbon\Carbon::parse(auth()->user()->siswaPkl->absensiHariIni->jam_pulang)->format('H:i') }}
                    </p>
                </div>
                @else
                <button onclick="absenPulang({{ auth()->user()->siswaPkl->id }})" class="w-full gradient-red-yellow text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition-all text-lg">
                    <i class="fas fa-sign-out-alt mr-2"></i>Absen Pulang
                </button>
                @endif
            </div>
        </div>
        @else
        <div class="border-2 border-red-300 bg-red-50 rounded-xl p-8">
            <p class="text-gray-700 text-lg mb-6 text-center">Pilih Status Kehadiran Anda</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <button onclick="absenMasuk({{ auth()->user()->siswaPkl->id }})" class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-6 py-4 rounded-lg font-semibold hover:shadow-lg transition-all">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                </button>
                <button onclick="showIzinModal({{ auth()->user()->siswaPkl->id }})" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-4 rounded-lg font-semibold hover:shadow-lg transition-all">
                    <i class="fas fa-clipboard-list mr-2"></i>Izin
                </button>
                <button onclick="showSakitModal({{ auth()->user()->siswaPkl->id }})" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-4 rounded-lg font-semibold hover:shadow-lg transition-all">
                    <i class="fas fa-heartbeat mr-2"></i>Sakit
                </button>
                <button onclick="absenAlpa({{ auth()->user()->siswaPkl->id }})" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-lg font-semibold hover:shadow-lg transition-all">
                    <i class="fas fa-ban mr-2"></i>Alpa
                </button>
            </div>
        </div>
        @endif
    </div>

    @else
    <!-- User tidak punya profile siswa -->
    <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-8">
        <p class="text-yellow-900 text-lg">
            <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
            <strong>Informasi:</strong> Data profil siswa Anda belum ada di sistem. Silakan hubungi admin untuk verifikasi data Anda.
        </p>
    </div>
    @endif
    @endif
</div>

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

    .modal {
        display: none;
        position: fixed;
        z-index: 50;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: white;
        padding: 2rem;
        border-radius: 1rem;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
    }
</style>

@push('scripts')
<script>
    let currentSiswaId = null;

    function showIzinModal(siswaId) {
        currentSiswaId = siswaId;
        document.getElementById('izinModal').classList.add('active');
    }

    function closeIzinModal() {
        document.getElementById('izinModal').classList.remove('active');
    }

    function showSakitModal(siswaId) {
        currentSiswaId = siswaId;
        document.getElementById('sakitModal').classList.add('active');
    }

    function closeSakitModal() {
        document.getElementById('sakitModal').classList.remove('active');
    }

    function submitIzin() {
        const keterangan = document.getElementById('izinKeterangan').value;
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("absensi.izin") }}';
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        
        const siswa = document.createElement('input');
        siswa.type = 'hidden';
        siswa.name = 'siswa_pkl_id';
        siswa.value = currentSiswaId;

        const ket = document.createElement('input');
        ket.type = 'hidden';
        ket.name = 'keterangan';
        ket.value = keterangan;
        
        form.appendChild(csrf);
        form.appendChild(siswa);
        form.appendChild(ket);
        document.body.appendChild(form);
        form.submit();
    }

    function submitSakit() {
        const keterangan = document.getElementById('sakitKeterangan').value;
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("absensi.sakit") }}';
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        
        const siswa = document.createElement('input');
        siswa.type = 'hidden';
        siswa.name = 'siswa_pkl_id';
        siswa.value = currentSiswaId;

        const ket = document.createElement('input');
        ket.type = 'hidden';
        ket.name = 'keterangan';
        ket.value = keterangan;
        
        form.appendChild(csrf);
        form.appendChild(siswa);
        form.appendChild(ket);
        document.body.appendChild(form);
        form.submit();
    }

    function absenMasuk(siswaId) {
        if (confirm('Konfirmasi absen masuk?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("absensi.masuk") }}';
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            
            const siswa = document.createElement('input');
            siswa.type = 'hidden';
            siswa.name = 'siswa_pkl_id';
            siswa.value = siswaId;
            
            form.appendChild(csrf);
            form.appendChild(siswa);
            document.body.appendChild(form);
            form.submit();
        }
    }

    function absenPulang(siswaId) {
        if (confirm('Konfirmasi absen pulang?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("absensi.pulang") }}';
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            
            const siswa = document.createElement('input');
            siswa.type = 'hidden';
            siswa.name = 'siswa_pkl_id';
            siswa.value = siswaId;
            
            form.appendChild(csrf);
            form.appendChild(siswa);
            document.body.appendChild(form);
            form.submit();
        }
    }

    function absenAlpa(siswaId) {
        if (confirm('Konfirmasi status alpa?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("absensi.alpa") }}';
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            
            const siswa = document.createElement('input');
            siswa.type = 'hidden';
            siswa.name = 'siswa_pkl_id';
            siswa.value = siswaId;
            
            form.appendChild(csrf);
            form.appendChild(siswa);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Close modal ketika klik di luar modal
    window.onclick = function(event) {
        const izinModal = document.getElementById('izinModal');
        const sakitModal = document.getElementById('sakitModal');
        if (event.target == izinModal) {
            izinModal.classList.remove('active');
        }
        if (event.target == sakitModal) {
            sakitModal.classList.remove('active');
        }
    }
</script>
@endpush

<!-- Modal untuk Izin -->
<div id="izinModal" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-clipboard-list text-blue-500 mr-2"></i>Lapor Izin
            </h2>
            <button onclick="closeIzinModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan (Opsional)</label>
            <textarea id="izinKeterangan" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500" rows="4" placeholder="Masukkan keterangan izin..."></textarea>
        </div>
        <div class="flex gap-3">
            <button onclick="closeIzinModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg">
                Batal
            </button>
            <button onclick="submitIzin()" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
                Kirim
            </button>
        </div>
    </div>
</div>

<!-- Modal untuk Sakit -->
<div id="sakitModal" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-heartbeat text-orange-500 mr-2"></i>Lapor Sakit
            </h2>
            <button onclick="closeSakitModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan Sakit</label>
            <textarea id="sakitKeterangan" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-orange-500" rows="4" placeholder="Masukkan keterangan sakit..."></textarea>
        </div>
        <div class="flex gap-3">
            <button onclick="closeSakitModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg">
                Batal
            </button>
            <button onclick="submitSakit()" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg">
                Kirim
            </button>
        </div>
    </div>
</div>
@endsection
