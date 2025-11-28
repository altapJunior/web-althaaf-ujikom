@extends('layouts.app')

@section('title', 'Tambah Siswa PKL')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">
            <i class="fas fa-user-plus text-red-600 mr-3"></i>Tambah Siswa PKL
        </h1>
        <p class="text-gray-600">Masukkan data siswa PKL baru ke dalam sistem</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-red-600">
        <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama -->
            <div class="mb-6">
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-user text-red-600 mr-2"></i>Nama Lengkap
                </label>
                <input 
                    type="text" 
                    id="nama"
                    name="nama" 
                    placeholder="Masukkan nama lengkap siswa"
                    value="{{ old('nama') }}"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:bg-red-50 transition-all @error('nama') border-red-500 @enderror"
                    required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- NIM / NIS -->
            <div class="mb-6">
                <label for="nim_nis" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-id-card text-red-600 mr-2"></i>NIM / NIS
                </label>
                <input 
                    type="text" 
                    id="nim_nis"
                    name="nim_nis" 
                    placeholder="Contoh: 001234"
                    value="{{ old('nim_nis') }}"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:bg-red-50 transition-all @error('nim_nis') border-red-500 @enderror"
                    required>
                @error('nim_nis')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Jurusan -->
            <div class="mb-6">
                <label for="jurusan" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-graduation-cap text-red-600 mr-2"></i>Jurusan
                </label>
                <input 
                    type="text" 
                    id="jurusan"
                    name="jurusan" 
                    placeholder="Contoh: Teknik Informatika"
                    value="{{ old('jurusan') }}"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:bg-red-50 transition-all @error('jurusan') border-red-500 @enderror"
                    required>
                @error('jurusan')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Sekolah -->
            <div class="mb-6">
                <label for="sekolah" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-school text-red-600 mr-2"></i>Sekolah / Institusi
                </label>
                <input 
                    type="text" 
                    id="sekolah"
                    name="sekolah" 
                    placeholder="Contoh: SMK Negeri 1"
                    value="{{ old('sekolah') }}"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 focus:bg-red-50 transition-all @error('sekolah') border-red-500 @enderror"
                    required>
                @error('sekolah')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto -->
            <div class="mb-8">
                <label for="foto" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-image text-red-600 mr-2"></i>Foto Profil (Opsional)
                </label>
                <div class="relative">
                    <input 
                        type="file" 
                        id="foto"
                        name="foto" 
                        accept="image/*"
                        class="hidden"
                        onchange="previewImage(event)">
                    
                    <label for="foto" class="flex items-center justify-center w-full px-4 py-8 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-all">
                        <div class="text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-600 font-medium">Klik untuk memilih foto</p>
                            <p class="text-gray-400 text-sm">atau drag & drop (JPG, PNG, GIF - Max 2MB)</p>
                        </div>
                    </label>
                </div>
                
                <!-- Preview -->
                <div id="preview" class="mt-4 hidden">
                    <img id="previewImage" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border-2 border-gray-200">
                    <button type="button" onclick="clearPreview()" class="mt-2 text-red-600 text-sm hover:underline">
                        <i class="fas fa-times mr-1"></i>Hapus foto
                    </button>
                </div>

                @error('foto')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="flex-1 gradient-red-yellow text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition-all transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Simpan Data Siswa
                </button>
                <a 
                    href="{{ route('siswa.index') }}" 
                    class="flex-1 bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-all text-center">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Info Box -->
    <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6">
        <p class="text-blue-900">
            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
            <strong>Tips:</strong> Pastikan NIM/NIS unik untuk setiap siswa. Data ini tidak dapat diubah setelah dibuat.
        </p>
    </div>
</div>

<style>
    .gradient-red-yellow {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #eab308 100%);
    }
</style>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('preview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    function clearPreview() {
        document.getElementById('foto').value = '';
        document.getElementById('preview').classList.add('hidden');
    }
</script>
@endsection
