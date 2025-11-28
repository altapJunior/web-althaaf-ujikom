# Sistem Absensi PKL - Polres Garut

![Polres Garut](https://img.shields.io/badge/Polres-Garut-red)
![Laravel](https://img.shields.io/badge/Laravel-9-red)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue)
![Database](https://img.shields.io/badge/Database-MySQL-orange)

Platform manajemen kehadiran digital untuk Program Kerja Lapangan (PKL) di Kepolisian Resor Garut dengan fitur absensi real-time, laporan komprehensif, dan manajemen siswa terpusat.

## 📋 Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Teknologi Stack](#teknologi-stack)
- [Requirements](#requirements)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Penggunaan](#penggunaan)
- [Struktur Project](#struktur-project)
- [Dokumentasi Teknis](#dokumentasi-teknis)
- [Kontribusi](#kontribusi)
- [License](#license)

---

## 🎯 Fitur Utama

### Untuk Admin
- ✅ **Dashboard Komprehensif**: Melihat statistik absensi harian siswa
- ✅ **Manajemen Siswa PKL**: Tambah, edit, hapus profil siswa
- ✅ **Absensi Manual**: Input absensi siswa untuk keperluan tertentu
- ✅ **Riwayat Lengkap**: Lihat history absensi semua siswa dengan filter
- ✅ **Laporan Bulanan/Tahunan**: Generate laporan kehadiran dengan statistik detail
- ✅ **Status Flexibility**: Catat izin, sakit, dan alpa dengan keterangan

### Untuk Siswa PKL
- ✅ **Absen Masuk/Pulang**: Pencatatan waktu masuk dan pulang real-time
- ✅ **Lapor Izin**: Kirim laporan izin dengan keterangan
- ✅ **Lapor Sakit**: Kirim laporan sakit dengan keterangan
- ✅ **Status Alpa**: Catat ketidakhadiran tanpa izin
- ✅ **Lihat Riwayat Pribadi**: Akses history absensi sendiri
- ✅ **Laporan Pribadi**: Lihat statistik absensi bulanan/tahunan diri sendiri
- ✅ **Dashboard Personal**: Status kehadiran hari ini dengan display intuitif

---

## 🛠️ Teknologi Stack

| Component | Technology | Version |
|-----------|-----------|---------|
| Framework | Laravel | 9.x |
| Language | PHP | 8.1+ |
| Database | MySQL | 5.7+ |
| Frontend | Blade Templating | - |
| CSS Framework | Tailwind CSS | 3.x |
| Icons | Font Awesome | 6.4.0 |
| Authentication | Laravel Auth | Built-in |

---

## 📦 Requirements

### Server Requirements
- PHP >= 8.1
- MySQL >= 5.7
- Apache/Nginx web server
- Composer (PHP package manager)
- OpenSSL extension
- PDO extension
- Tokenizer extension
- XML extension

### Browser Support
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

---

## 🚀 Instalasi

### 1. Clone Repository
```bash
cd c:\xampp\htdocs
git clone <repository-url> LaravelAlthaafUjikom
cd LaravelAlthaafUjikom
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Environment File
```bash
cp .env.example .env
```

Edit `.env` dan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_althaaf
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Jalankan Database Migration
```bash
php artisan migrate
```

### 6. Seed Demo Data (Optional)
```bash
php artisan migrate:fresh --seed
```

Ini akan membuat akun demo:
- **Admin**: `admin@example.com` / password: `password`
- **Siswa**: `siswa@example.com` / password: `password`

### 7. Start Development Server
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

---

## ⚙️ Konfigurasi

### Timezone
Edit `config/app.php`:
```php
'timezone' => 'Asia/Jakarta',
```

### Storage (untuk foto absensi)
```bash
php artisan storage:link
```

### Mail Configuration (opsional)
Edit `.env` untuk konfigurasi email:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

---

## 📖 Penggunaan

### Login Awal
1. Buka `http://localhost:8000/login`
2. Gunakan akun demo yang sudah dibuat
3. Anda akan diarahkan ke dashboard sesuai role

### Workflow Admin

#### A. Kelola Siswa
1. Navigasi ke **Kelola Siswa** di menu
2. Klik **Tambah Siswa** untuk menambah data baru
3. Isi form dengan data siswa (nama, NIM, jurusan, sekolah)
4. Upload foto siswa (opsional)
5. Klik **Simpan**

#### B. Input Absensi Manual
1. Di dashboard, lihat card siswa yang belum absen
2. Klik tombol **Masuk**, **Izin**, **Sakit**, atau **Alpa** sesuai kebutuhan
3. Jika izin/sakit, masukkan keterangan di modal
4. Sistem akan mencatat waktu otomatis

#### C. Lihat Riwayat
1. Navigasi ke **Riwayat** di menu
2. Lihat daftar lengkap absensi semua siswa
3. Klik **Detail** untuk melihat informasi selengkapnya di modal

#### D. Generate Laporan
1. Navigasi ke **Laporan**
2. Pilih bulan dan tahun
3. Sistem akan menampilkan:
   - Statistik hadir/izin/sakit/alpha per siswa
   - Total ketidakhadiran
   - Presentase kehadiran

### Workflow Siswa

#### A. Dashboard Personal
1. Setelah login, lihat card status hari ini
2. Jika belum absen, pilih status:
   - **Masuk** - Absen masuk normal
   - **Izin** - Laporkan izin (harus ada keterangan)
   - **Sakit** - Laporkan sakit (harus ada keterangan)
   - **Alpa** - Catat tidak hadir tanpa izin

#### B. Lihat Riwayat Pribadi
1. Navigasi ke **Riwayat** di menu
2. Lihat history absensi pribadi dengan pagination

#### C. Lihat Laporan Pribadi
1. Navigasi ke **Laporan**
2. Pilih bulan dan tahun
3. Lihat statistik personal absensi

---

## 📁 Struktur Project

```
LaravelAlthaafUjikom/
├── app/
│   ├── Console/
│   │   └── Kernel.php
│   ├── Exceptions/
│   │   └── Handler.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AbsensiController.php      # Main controller
│   │   │   ├── AuthController.php         # Auth logic
│   │   │   ├── SiswaPklController.php     # Siswa management
│   │   │   └── Kernel.php                 # HTTP Kernel
│   │   └── Middleware/
│   │       └── CheckRole.php              # Role authorization
│   ├── Models/
│   │   ├── User.php                       # User model
│   │   ├── Absensi.php                    # Attendance model
│   │   └── Siswapkl.php                   # Student profile model
│   └── Providers/
│       ├── AppServiceProvider.php
│       └── RouteServiceProvider.php
├── bootstrap/
│   └── app.php
├── config/
│   ├── app.php                            # App config
│   ├── database.php                       # DB config
│   └── ...
├── database/
│   ├── migrations/                        # Database migrations
│   │   ├── 2025_11_24_013152_create_users_table.php
│   │   ├── 2025_11_25_000000_add_role_to_users_table.php
│   │   └── 2025_11_25_000001_add_user_id_to_siswa_pkl_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       └── SiswaSeeder.php
├── public/
│   ├── index.php
│   ├── Lambang_Polda_Jabar.png            # Official logo
│   └── logo-polres.svg
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php              # Master layout
│   │   ├── absensi/
│   │   │   ├── index.blade.php            # Dashboard
│   │   │   ├── riwayat.blade.php          # History view
│   │   │   └── laporan.blade.php          # Report view
│   │   ├── siswa/
│   │   │   ├── create.blade.php           # Add siswa form
│   │   │   ├── edit.blade.php             # Edit siswa form
│   │   │   └── index.blade.php            # List siswa
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   └── register.blade.php
│   │   └── welcome.blade.php              # Landing page
│   └── css/
│       └── app.css
├── routes/
│   ├── web.php                            # Web routes
│   ├── api.php
│   └── ...
├── storage/
│   ├── app/
│   │   ├── public/                        # Public storage (photos)
│   │   └── ...
│   ├── logs/
│   │   └── laravel.log
│   └── ...
├── tests/
├── .env.example
├── .gitignore
├── artisan                                # Artisan CLI
├── composer.json
├── composer.lock
├── package.json
├── webpack.mix.js
├── ERD.md                                 # Entity Relationship Diagram
├── UML.md                                 # UML & Architecture docs
├── README.md                              # This file
└── README_SISTEM.md                       # System documentation

```

---

## 🏗️ Dokumentasi Teknis

### Entity Relationship Diagram
Lihat file [ERD.md](ERD.md) untuk dokumentasi lengkap schema database, termasuk:
- Definisi tabel dan kolom
- Foreign key relationships
- Enum values
- Constraint dan indexes

### UML & Architecture
Lihat file [UML.md](UML.md) untuk:
- Class diagram dan relationships
- Controller architecture
- Middleware flow
- Database transaction flow
- Security & validation rules
- Sequence diagrams

---

## 🔐 Security

### Authentication
- Menggunakan Laravel's built-in authentication
- Password di-hash menggunakan Bcrypt
- CSRF protection pada semua form

### Authorization
- Role-based access control (RBAC)
- Admin middleware untuk rute admin-only
- Siswa hanya bisa akses data pribadi mereka

### Validation
- Input validation di controller
- Siswa tidak bisa absen untuk siswa lain
- File upload validation (gambar max 2MB)

---

## 🐛 Troubleshooting

### Problem: Migrate error "SQLSTATE[01000]"
**Solution**: Pastikan enum value di controller sesuai migration (`alpha` bukan `alpa`)

### Problem: Logo tidak tampil
**Solution**: Jalankan `php artisan storage:link` untuk symlink ke storage

### Problem: Database connection error
**Solution**: Cek `.env` configuration, pastikan MySQL running di port 3306

### Problem: "Class not found" errors
**Solution**: Jalankan `composer dump-autoload`

---

## 📞 API Endpoints

### Authentication
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/login` | Show login form |
| POST | `/login` | Process login |
| GET | `/register` | Show register form |
| POST | `/register` | Process registration |
| POST | `/logout` | Logout user |

### Dashboard & Core
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/` | Show dashboard |
| POST | `/absensi/masuk` | Check-in attendance |
| POST | `/absensi/pulang` | Check-out attendance |
| POST | `/absensi/izin` | Report leave |
| POST | `/absensi/sakit` | Report sick |
| POST | `/absensi/alpa` | Report absence |
| GET | `/absensi/riwayat` | View attendance history |
| GET | `/absensi/laporan` | View attendance report |

### Siswa Management (Admin Only)
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/siswa` | List all students |
| GET | `/siswa/create` | Show create form |
| POST | `/siswa` | Create student |
| GET | `/siswa/{id}/edit` | Show edit form |
| PUT | `/siswa/{id}` | Update student |
| DELETE | `/siswa/{id}` | Delete student |

---

## 📊 Database Schema Summary

### Users Table
- Menyimpan akun admin dan siswa
- Fields: id, name, email, password, role, timestamps
- Role enum: 'admin' atau 'user'

### Siswa_PKL Table
- Profil detail siswa PKL
- Linked ke User table via user_id
- Fields: id, user_id, nama, nim_nis, jurusan, sekolah, foto, timestamps

### Absensi Table
- Data absensi harian
- Linked ke Siswa_PKL via siswa_pkl_id
- Fields: id, siswa_pkl_id, tanggal, jam_masuk, jam_pulang, foto_masuk, foto_pulang, status, keterangan, timestamps
- Status enum: 'hadir', 'izin', 'sakit', 'alpha'

---

## 🎨 UI/UX Features

- **Responsive Design**: Optimized untuk desktop dan mobile
- **Color Scheme**: Red & Yellow gradient (Polres brand colors)
- **Icons**: Font Awesome 6.4.0 untuk visual consistency
- **Dashboard**: Role-specific views dengan personalized greetings
- **Modal**: Detail view dengan modal popup
- **Form Validation**: Real-time dan server-side validation
- **Notifications**: Toast messages untuk success/error feedback

---

## 🚀 Deployment

### Production Checklist
- [ ] Set `APP_DEBUG=false` di `.env`
- [ ] Jalankan `php artisan config:cache`
- [ ] Jalankan `php artisan route:cache`
- [ ] Jalankan `php artisan view:cache`
- [ ] Setup HTTPS certificate
- [ ] Configure web server (Apache/Nginx)
- [ ] Setup database backups
- [ ] Monitor logs di `storage/logs/`

### Deploy Commands
```bash
# Production build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clearing cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 📝 Changelog

### v1.0.0 (Current)
- ✅ Complete authentication system
- ✅ Role-based access control (Admin & Siswa)
- ✅ Real-time attendance recording
- ✅ Leave/Sick/Absence reporting
- ✅ Comprehensive attendance reports
- ✅ Student management (CRUD)
- ✅ Attendance history with pagination
- ✅ Responsive UI with Tailwind CSS
- ✅ Database seeding with demo data

---

## 👥 Kontribusi

Kontribusi sangat diterima! Silakan:

1. Fork repository ini
2. Buat branch feature (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📧 Support & Contact

Untuk pertanyaan atau support:
- Email: support@polresgarut.id
- Documentation: Lihat folder `docs/`
- Issues: Report di GitHub issues

---

## 🙏 Terima Kasih

Terima kasih kepada:
- Laravel Team untuk framework yang luar biasa
- Tailwind CSS untuk styling framework
- Font Awesome untuk icons
- Polres Garut untuk trust dan support

---

## 📄 License

Project ini dilisensikan di bawah MIT License - lihat file [LICENSE](LICENSE) untuk detail.

---

**Dibuat dengan ❤️ untuk Kepolisian Resor Garut**

Last Updated: November 28, 2025
