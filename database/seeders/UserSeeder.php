<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SiswaPkl;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Polres Garut',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Regular User (Siswa PKL)
        $userSiswa = User::create([
            'name' => 'Althaaf Qathrunnada Kairun',
            'email' => 'siswa@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create Siswa PKL profile linked to user
        SiswaPkl::create([
            'user_id' => $userSiswa->id,
            'nama' => 'Althaaf Qathrunnada Kairun',
            'nim_nis' => '001',
            'jurusan' => 'Pengembangan Perangkat Lunak dan Gim',
            'sekolah' => 'SMKN 1 Garut',
        ]);

        
    }
}
