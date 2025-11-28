# Sistem Absensi PKL - Dokumentasi

## Deskripsi
Sistem Absensi PKL adalah aplikasi web berbasis Laravel untuk mengelola absensi siswa Praktik Kerja Lapangan (PKL) di Polres. Sistem ini memiliki dua jenis pengguna: Admin dan Siswa PKL.

## Role & Akses

### 1. Admin
- Email: `admin@example.com`
- Password: `password`
- Akses:
  - Dashboard (melihat semua siswa)
  - Kelola Siswa (tambah, edit, hapus siswa)
  - Absen Masuk/Pulang untuk siswa (manual)
  - Riwayat Absensi
  - Laporan Absensi

### 2. User (Siswa PKL)
- Email: `siswa@example.com`
- Password: `password`
- Akses:
  - Dashboard (hanya data diri sendiri)
  - Absen Masuk/Pulang secara mandiri
  - Riwayat Absensi (hanya milik mereka)
  - Laporan Absensi (hanya milik mereka)
  - **TIDAK bisa**: Kelola Siswa

## Instalasi & Setup

### 1. Clone/Copy Project
```bash
cd c:\xampp\htdocs
# Project sudah ada di LaravelAlthaafUjikom
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=LaravelAlthaafUjikom
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi & Seeder
```bash
php artisan migrate:fresh --seed
```

Ini akan membuat:
- Tabel database
- User Admin & User Siswa
- Data siswa contoh (Budi, Siti, dsb)

### 6. Jalankan Aplikasi
```bash
php artisan serve
```

Akses: `http://localhost:8000`

## Fitur Utama

### Dashboard
- **Admin**: Melihat statistik semua siswa (total, hadir hari ini, belum absen)
- **Siswa**: Melihat status absensi pribadi

### Kelola Siswa (Admin Only)
- Tambah siswa baru
- Edit data siswa
- Hapus siswa
- Upload foto profil

### Absensi
- **Absen Masuk**: Mencatat jam masuk siswa
- **Absen Pulang**: Mencatat jam pulang siswa
- **Modal Detail**: Lihat detail absensi dengan tampilan cantik

### Riwayat Absensi
- Tabel lengkap absensi semua siswa (Admin) / pribadi (Siswa)
- Filter berdasarkan nama, NIM, atau tanggal
- Pagination
- Modal detail dengan informasi lengkap

### Laporan Absensi
- Laporan per bulan/tahun
- Statistik: Hadir, Izin, Sakit, Alpha
- Rekapitulasi per siswa
- Tombol cetak

## Teknologi

- **Framework**: Laravel 9
- **Frontend**: Tailwind CSS
- **Database**: MySQL
- **Timezone**: Asia/Jakarta (Waktu Indonesia)

## Struktur File Penting

```
LaravelAlthaafUjikom/
├── app/
│   ├── Models/
│   │   ├── User.php           # Model User (Admin & Siswa)
│   │   ├── SiswaPkl.php       # Model Siswa PKL
│   │   └── Absensi.php        # Model Absensi
│   └── Http/
│       ├── Controllers/
│       │   ├── AuthController.php
│       │   ├── AbsensiController.php
│       │   └── SiswaPklController.php
│       └── Middleware/
│           └── CheckRole.php   # Middleware untuk cek role
├── database/
│   ├── migrations/
│   └── seeders/
│       └── UserSeeder.php     # Demo data
├── resources/views/
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── absensi/
│   │   ├── index.blade.php    # Dashboard
│   │   ├── riwayat.blade.php
│   │   └── laporan.blade.php
│   ├── siswa/
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── index.blade.php
│   └── layouts/
│       └── app.blade.php      # Layout utama
└── routes/
    └── web.php                # Routes dengan role protection
```

## Fitur Keamanan

- **Authentication**: Login/Register dengan validasi
- **Authorization**: Role-based access control
- **CSRF Protection**: Token CSRF di setiap form
- **Password Hashing**: Bcrypt untuk password
- **Middleware**: CheckRole untuk proteksi route

## Catatan Penting

### Registrasi Siswa PKL
Ketika siswa mendaftar via register, sistem otomatis membuat:
1. Account user dengan role `user`
2. Profile siswa_pkl yang terhubung dengan user

### Timezone
Semua waktu menggunakan zona waktu **Asia/Jakarta** (WIB) untuk akurasi absensi.

### Modal Detail
- Klik tombol "Detail" di riwayat absensi untuk melihat detail dengan modal cantik
- Close dengan tombol X, Tutup, atau tekan ESC

## Troubleshooting

### Error: Foreign Key Constraint
Jika ada error foreign key, jalankan:
```bash
php artisan migrate:fresh --seed
```

### Timezone Salah
Jika waktu tidak sesuai Indonesia, pastikan di `config/app.php`:
```php
'timezone' => 'Asia/Jakarta',
```

### Database Error
```bash
# Check database connection
php artisan tinker
# Test: DB::connection()->getPdo()
```

## Contact & Support
Jika ada pertanyaan atau bug, silakan hubungi admin sistem.

---
**Last Updated**: November 25, 2025
**Version**: 1.0
