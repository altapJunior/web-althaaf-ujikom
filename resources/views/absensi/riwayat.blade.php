@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">
            <i class="fas fa-history text-red-600 mr-3"></i>Riwayat Absensi
        </h1>
        <p class="text-gray-600">Lihat historis absensi seluruh siswa PKL</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6">
        <form method="GET" class="flex gap-4 flex-wrap">
            <div class="flex-1 min-w-[200px]">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari nama atau NIM siswa..."
                    value="{{ request('search') }}"
                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500">
            </div>
            <div class="flex-1 min-w-[150px]">
                <input 
                    type="date" 
                    name="date" 
                    value="{{ request('date') }}"
                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500">
            </div>
            <button type="submit" class="gradient-red-yellow text-white px-6 py-2 rounded-lg font-semibold hover:shadow-lg transition-all">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
            <a href="{{ route('absensi.riwayat') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg font-semibold hover:bg-gray-300 transition-all">
                <i class="fas fa-redo mr-2"></i>Reset
            </a>
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="gradient-red-yellow text-white">
                        <th class="px-6 py-4 text-left text-sm font-semibold">Nama Siswa</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">NIM / NIS</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Masuk</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Pulang</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($absensi as $a)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                @if($a->siswaPkl->foto)
                                    <img src="{{ Storage::url($a->siswaPkl->foto) }}" alt="{{ $a->siswaPkl->nama }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-500 to-yellow-500 flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($a->siswaPkl->nama, 0, 1) }}
                                    </div>
                                @endif
                                <span class="font-medium text-gray-800">{{ $a->siswaPkl->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $a->siswaPkl->nim_nis }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            <i class="fas fa-calendar text-red-600 mr-2"></i>{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($a->jam_masuk)
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-sign-in-alt mr-1"></i>{{ \Carbon\Carbon::parse($a->jam_masuk)->format('H:i') }}
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($a->jam_pulang)
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-sign-out-alt mr-1"></i>{{ \Carbon\Carbon::parse($a->jam_pulang)->format('H:i') }}
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">Belum</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($a->status === 'hadir')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>Hadir
                                </span>
                            @elseif($a->status === 'izin')
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-file-alt mr-1"></i>Izin
                                </span>
                            @elseif($a->status === 'sakit')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-heartbeat mr-1"></i>Sakit
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-times-circle mr-1"></i>Alpha
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button onclick="showDetails({{ json_encode($a) }})" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-inbox text-6xl mb-4 text-gray-300"></i>
                                <p class="text-lg font-medium">Belum ada data absensi</p>
                                <p class="text-sm">Data absensi akan muncul di sini setelah siswa melakukan absensi.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $absensi->links() }}
        </div>
    </div>
</div>

<!-- Modal Detail Absensi -->
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-screen overflow-y-auto">
        <!-- Modal Header -->
        <div class="gradient-red-yellow text-white p-6 sticky top-0">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div id="modalAvatar" class="w-12 h-12 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                        <i class="fas fa-user text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 id="modalNama" class="text-xl font-bold">Loading...</h2>
                        <p id="modalNim" class="text-red-100 text-sm">-</p>
                    </div>
                </div>
                <button onclick="closeModal()" class="text-white hover:bg-black hover:bg-opacity-20 rounded-full p-2 transition-all">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="p-6 space-y-4">
            <!-- Informasi Siswa -->
            <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                <h3 class="font-semibold text-gray-800 mb-3"><i class="fas fa-user-graduate text-red-600 mr-2"></i>Data Siswa</h3>
                <div>
                    <p class="text-gray-600 text-sm">Jurusan</p>
                    <p id="modalJurusan" class="font-semibold text-gray-800">-</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Sekolah</p>
                    <p id="modalSekolah" class="font-semibold text-gray-800">-</p>
                </div>
            </div>

            <!-- Informasi Absensi -->
            <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                <h3 class="font-semibold text-gray-800 mb-3"><i class="fas fa-calendar-alt text-red-600 mr-2"></i>Data Absensi</h3>
                <div>
                    <p class="text-gray-600 text-sm">Tanggal</p>
                    <p id="modalTanggal" class="font-semibold text-gray-800">-</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 text-sm">Jam Masuk</p>
                        <p id="modalJamMasuk" class="font-semibold text-green-700 text-lg">-</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Jam Pulang</p>
                        <p id="modalJamPulang" class="font-semibold text-blue-700 text-lg">-</p>
                    </div>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Status</p>
                    <p id="modalStatus" class="font-semibold text-gray-800 text-sm">-</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Keterangan</p>
                    <p id="modalKeterangan" class="font-medium text-gray-700 italic">-</p>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="border-t border-gray-200 p-6 flex gap-3">
            <button onclick="closeModal()" class="flex-1 bg-gray-200 text-gray-800 px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition-all">
                <i class="fas fa-times mr-2"></i>Tutup
            </button>
        </div>
    </div>
</div>

<style>
    .gradient-red-yellow {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #eab308 100%);
    }
</style>

<script>
    function showDetails(absensi) {
        // Set data ke modal
        document.getElementById('modalNama').textContent = absensi.siswa_pkl.nama;
        document.getElementById('modalNim').textContent = 'NIM/NIS: ' + absensi.siswa_pkl.nim_nis;
        document.getElementById('modalJurusan').textContent = absensi.siswa_pkl.jurusan;
        document.getElementById('modalSekolah').textContent = absensi.siswa_pkl.sekolah;
        
        // Format tanggal
        const tanggalObj = new Date(absensi.tanggal);
        const tanggalFormatted = new Intl.DateTimeFormat('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(tanggalObj);
        document.getElementById('modalTanggal').textContent = tanggalFormatted;
        
        // Set jam
        document.getElementById('modalJamMasuk').textContent = absensi.jam_masuk ? absensi.jam_masuk.slice(0, 5) : '-';
        document.getElementById('modalJamPulang').textContent = absensi.jam_pulang ? absensi.jam_pulang.slice(0, 5) : '-';
        
        // Set status dengan badge
        const statusBadges = {
            'hadir': '<span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold"><i class="fas fa-check-circle mr-1"></i>Hadir</span>',
            'izin': '<span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold"><i class="fas fa-file-alt mr-1"></i>Izin</span>',
            'sakit': '<span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold"><i class="fas fa-heartbeat mr-1"></i>Sakit</span>',
            'alpha': '<span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold"><i class="fas fa-times-circle mr-1"></i>Alpha</span>'
        };
        document.getElementById('modalStatus').innerHTML = statusBadges[absensi.status] || '-';
        
        document.getElementById('modalKeterangan').textContent = absensi.keterangan || 'Tidak ada keterangan';
        
        // Tampilkan modal dengan animasi
        const modal = document.getElementById('detailModal');
        modal.classList.remove('hidden');
        modal.classList.add('fade-in');
    }

    function closeModal() {
        const modal = document.getElementById('detailModal');
        modal.classList.add('hidden');
        modal.classList.remove('fade-in');
    }

    // Close modal ketika klik di luar modal
    document.getElementById('detailModal')?.addEventListener('click', function(event) {
        if (event.target === this) {
            closeModal();
        }
    });

    // Close modal dengan tombol ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });

    // Tambahkan CSS untuk animasi fade
    const style = document.createElement('style');
    style.textContent = `
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection
