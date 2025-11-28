@extends('layouts.app')

@section('title', 'Laporan Absensi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">
            <i class="fas fa-file-alt text-red-600 mr-3"></i>Laporan Absensi
        </h1>
        <p class="text-gray-600">Laporan absensi siswa PKL per bulan/tahun</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6">
        <form method="GET" class="flex gap-4 flex-wrap items-end">
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                <select name="bulan" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500">
                    @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create(null, $i, 1)->format('F') }}
                    </option>
                    @endfor
                </select>
            </div>

            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                <select name="tahun" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500">
                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="gradient-red-yellow text-white px-6 py-2 rounded-lg font-semibold hover:shadow-lg transition-all">
                <i class="fas fa-search mr-2"></i>Tampilkan
            </button>

            <button type="button" onclick="printReport()" class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 transition-all">
                <i class="fas fa-print mr-2"></i>Cetak
            </button>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-xl">
            <p class="text-green-100 text-sm font-medium">Total Hadir</p>
            <p class="text-4xl font-bold mt-2">
                {{ $absensi->where('status', 'hadir')->count() }}
            </p>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
            <p class="text-blue-100 text-sm font-medium">Izin</p>
            <p class="text-4xl font-bold mt-2">
                {{ $absensi->where('status', 'izin')->count() }}
            </p>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl p-6 text-white shadow-xl">
            <p class="text-yellow-100 text-sm font-medium">Sakit</p>
            <p class="text-4xl font-bold mt-2">
                {{ $absensi->where('status', 'sakit')->count() }}
            </p>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-xl">
            <p class="text-red-100 text-sm font-medium">Alpha</p>
            <p class="text-4xl font-bold mt-2">
                {{ $absensi->where('status', 'alpha')->count() }}
            </p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="gradient-red-yellow text-white">
                        <th class="px-6 py-4 text-left text-sm font-semibold">Nama Siswa</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">NIM / NIS</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Jurusan</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Hadir</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Izin</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Sakit</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Alpha</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($siswa as $s)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                @if($s->foto)
                                    <img src="{{ Storage::url($s->foto) }}" alt="{{ $s->nama }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-500 to-yellow-500 flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($s->nama, 0, 1) }}
                                    </div>
                                @endif
                                <span class="font-medium text-gray-800">{{ $s->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $s->nim_nis }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $s->jurusan }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $absensi->where('siswa_pkl_id', $s->id)->where('status', 'hadir')->count() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $absensi->where('siswa_pkl_id', $s->id)->where('status', 'izin')->count() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $absensi->where('siswa_pkl_id', $s->id)->where('status', 'sakit')->count() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $absensi->where('siswa_pkl_id', $s->id)->where('status', 'alpha')->count() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center font-semibold text-gray-800">
                            {{ $absensi->where('siswa_pkl_id', $s->id)->count() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-inbox text-6xl mb-4 text-gray-300"></i>
                                <p class="text-lg font-medium">Belum ada data siswa</p>
                                <p class="text-sm">Tambahkan siswa terlebih dahulu untuk melihat laporan absensi.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Print Info -->
    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6">
        <p class="text-blue-900">
            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
            <strong>Info:</strong> Laporan absensi untuk bulan <strong>{{ \Carbon\Carbon::create(null, $bulan, 1)->format('F') }} {{ $tahun }}</strong>.
            Klik tombol "Cetak" untuk mencetak laporan ini.
        </p>
    </div>
</div>

<style>
    .gradient-red-yellow {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #eab308 100%);
    }

    @media print {
        .bg-white, .rounded-2xl, .shadow-xl, .grid, .flex {
            page-break-inside: avoid;
        }
        button, .bg-blue-50, .gradient-red-yellow {
            display: none;
        }
    }
</style>

<script>
    function printReport() {
        window.print();
    }
</script>
@endsection
