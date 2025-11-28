@extends('layouts.app')

@section('title', 'Data Siswa PKL')

@section('content')
<div class="bg-white rounded-2xl shadow-xl p-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-users text-red-600 mr-3"></i>
            Data Siswa PKL
        </h2>
        <a href="{{ route('siswa.create') }}" class="gradient-red-yellow text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition-all">
            <i class="fas fa-plus mr-2"></i>Tambah Siswa
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="gradient-red-yellow text-white">
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Foto</th>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">NIM/NIS</th>
                    <th class="px-6 py-4 text-left">Jurusan</th>
                    <th class="px-6 py-4 text-left">Sekolah</th>
                    <th class="px-6 py-4 text-left">Total Absensi</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa as $index => $s)
                <tr class="border-b hover:bg-red-50 transition-colors">
                    <td class="px-6 py-4">{{ $siswa->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        @if($s->foto)
                        <img src="{{ Storage::url($s->foto) }}" class="w-12 h-12 rounded-full object-cover">
                        @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-500 to-yellow-500 flex items-center justify-center text-white font-bold">
                            {{ substr($s->nama, 0, 1) }}
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-semibold">{{ $s->nama }}</td>
                    <td class="px-6 py-4">{{ $s->nim_nis }}</td>
                    <td class="px-6 py-4">{{ $s->jurusan }}</td>
                    <td class="px-6 py-4">{{ $s->sekolah }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $s->absensi_count }} hari
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('siswa.edit', $s) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteSiswa({{ $s->id }})" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-12 text-gray-500">
                        <i class="fas fa-inbox text-6xl mb-4 text-gray-300"></i>
                        <p>Belum ada data siswa</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $siswa->links() }}
    </div>
</div>

@push('scripts')
<script>
    function deleteSiswa(id) {
        if (confirm('Yakin ingin menghapus data siswa ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/siswa/' + id;
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            
            form.appendChild(csrf);
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush
@endsection