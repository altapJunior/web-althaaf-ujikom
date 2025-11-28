@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header untuk User/Siswa -->
    @if(auth()->user()->role === 'user')
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl p-8 text-white">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-user-graduate text-3xl"></i>
            </div>
            <div>
                <p class="text-blue-100 text-sm">Selamat Datang,</p>
                <h1 class="text-3xl font-bold">{{ auth()->user()->siswaPkl->nama ?? auth()->user()->name }}</h1>
                <p class="text-blue-100">NIM/NIS: {{ auth()->user()->siswaPkl->nim_nis ?? '-' }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-red-600 to-red-700 rounded-2xl p-6 text-white shadow-xl hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-200 text-sm font-medium">{{ auth()->user()->role === 'admin' ? 'Total Siswa PKL' : 'Status Anda' }}</p>
                    <p class="text-5xl font-bold mt-2">{{ auth()->user()->role === 'admin' ? $totalSiswa : '1' }}</p>
                </div>
                <i class="fas fa-{{ auth()->user()->role === 'admin' ? 'users' : 'user' }} text-6xl text-red-300 opacity-50"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl p-6 text-white shadow-xl hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">{{ auth()->user()->role === 'admin' ? 'Hadir Hari Ini' : 'Absen Masuk' }}</p>
                    <p class="text-5xl font-bold mt-2">{{ $hadirHariIni }}</p>
                </div>
                <i class="fas fa-check-circle text-6xl text-yellow-200 opacity-50"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-yellow-500 rounded-2xl p-6 text-white shadow-xl hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">{{ auth()->user()->role === 'admin' ? 'Belum Absen' : 'Status Pulang' }}</p>
                    <p class="text-5xl font-bold mt-2">{{ auth()->user()->role === 'admin' ? $belumAbsen : (auth()->user()->siswaPkl->absensiHariIni?->jam_pulang ? '✓' : '✗') }}</p>
                </div>
                <i class="fas fa-{{ auth()->user()->role === 'admin' ? 'exclamation-triangle' : 'sign-out-alt' }} text-6xl text-yellow-100 opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Daftar Siswa untuk Absensi -->
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-clipboard-check text-red-600 mr-3"></i>
            {{ auth()->user()->role === 'admin' ? 'Absensi Hari Ini' : 'Data Absensi Anda' }}
        </h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-{{ auth()->user()->role === 'admin' ? '3' : '1' }} gap-6">
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
                <button onclick="absenMasuk({{ $s->id }})" class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-4 py-2 rounded-lg font-semibold hover:shadow-lg transition-all">
                    <i class="fas fa-sign-in-alt mr-2"></i>Absen Masuk
                </button>
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
</div>

@push('scripts')
<script>
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
</script>
@endpush
@endsection