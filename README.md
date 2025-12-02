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
# 📊 ERD (Entity Relationship Diagram) - Visual
# Sistem Absensi PKL Polres Garut

## 🎯 Overview Diagram

```
╔═════════════════════════════════════════════════════════════════════════════╗
║                   SISTEM ABSENSI PKL - POLRES GARUT                         ║
║                          Database Relational                                ║
╚═════════════════════════════════════════════════════════════════════════════╝

                              ┌──────────────────┐
                              │      USERS       │
                              ├──────────────────┤
                              │ PK: id           │
                              │ name             │
                              │ email (UNIQUE)   │
                              │ password         │
                              │ role (ENUM)      │ ◄── Enum: admin, user
                              │ created_at       │
                              │ updated_at       │
                              └──────────┬───────┘
                                         │
                                         │ 1:1 Relationship
                                         │ (role = 'user')
                                         │
                              ┌──────────▼───────────┐
                              │    SISWA_PKL         │
                              ├──────────────────────┤
                              │ PK: id               │
                              │ FK: user_id          │
                              │ nama                 │
                              │ nim_nis (UNIQUE)     │
                              │ jurusan              │
                              │ sekolah              │
                              │ foto                 │
                              │ created_at           │
                              │ updated_at           │
                              └──────────┬───────────┘
                                         │
                                         │ 1:M Relationship
                                         │ (1 siswa banyak absensi)
                                         │
                              ┌──────────▼───────────┐
                              │     ABSENSI          │
                              ├──────────────────────┤
                              │ PK: id               │
                              │ FK: siswa_pkl_id     │
                              │ tanggal              │
                              │ jam_masuk            │
                              │ jam_pulang           │
                              │ foto_masuk           │
                              │ foto_pulang          │
                              │ status (ENUM)        │ ◄── Enum: hadir, izin, sakit, alpha
                              │ keterangan           │
                              │ created_at           │
                              │ updated_at           │
                              └──────────────────────┘
```

---

## 📐 Relasi Detail Diagram

### Relasi 1: Users ↔ Siswa_PKL (One-to-One)

```
╔═════════════════╗                           ╔════════════════╗
║     USERS       ║                           ║   SISWA_PKL    ║
║                 ║                           ║                ║
║ id (PK)    ✓    ║──────── 1 ──────┐        ║ id (PK)    ✓   ║
║ name            ║                  │ 1:1    ║ user_id (FK)◄──┼─ REFERENCES users.id
║ email           ║                  │        ║ nama           ║
║ password        ║                  ├───────►║ nim_nis        ║
║ role            ║                  │        ║ jurusan        ║
║ created_at      ║                  │        ║ sekolah        ║
║ updated_at      ║                  │        ║ foto           ║
║                 ║                  │        ║ created_at     ║
║ Constraint:     ║                  │        ║ updated_at     ║
║ role = 'user'   ║                  │        ║                ║
║                 ║◄─────── 1 ───────┘        ║                ║
╚═════════════════╝                           ╚════════════════╝

Type: One-to-One (1:1)
- Satu User (role='user') = Satu Siswa_PKL
- User dapat login, Siswa_PKL adalah profil detailnya
- Foreign Key: siswa_pkl.user_id → users.id
- On Delete: CASCADE
```

### Relasi 2: Siswa_PKL ↔ Absensi (One-to-Many)

```
╔════════════════╗                           ╔═════════════════╗
║   SISWA_PKL    ║                           ║    ABSENSI      ║
║                ║                           ║                 ║
║ id (PK)    ✓   ║──────── 1 ──────┐         ║ id (PK)     ✓   ║
║ user_id (FK)   ║                  │ 1:M    ║ siswa_pkl_id◄───┼─ REFERENCES siswa_pkl.id
║ nama           ║                  │        ║ tanggal         ║
║ nim_nis        ║                  │        ║ jam_masuk       ║
║ jurusan        ║                  │        ║ jam_pulang      ║
║ sekolah        ║                  ├───────►║ foto_masuk      ║
║ foto           ║                  │        ║ foto_pulang     ║
║ created_at     ║                  │        ║ status          ║
║ updated_at     ║                  │        ║ keterangan      ║
║                ║                  │        ║ created_at      ║
║                ║                  │        ║ updated_at      ║
║                ║◄─────── M ───────┘        ║                 ║
╚════════════════╝                           ║ Unique:         ║
                                             ║ (siswa_pkl_id,  ║
                                             ║  tanggal)       ║
                                             ╚═════════════════╝

Type: One-to-Many (1:M)
- Satu Siswa_PKL = Banyak Absensi (per hari)
- Satu siswa bisa absen berkali-kali (history)
- Foreign Key: absensi.siswa_pkl_id → siswa_pkl.id
- On Delete: CASCADE
```

### Relasi Lengkap: Users → Siswa_PKL → Absensi

```
                        ┌─────────────────────────────────────┐
                        │      USERS TABLE                    │
                        │                                     │
                        │ id: 1, name: Admin, role: admin    │
                        │ id: 2, name: Budi, role: user      │
                        │ id: 3, name: Siti, role: user      │
                        │                                     │
                        └──────────────┬──────────────────────┘
                                       │
                    ┌──────────────────┼──────────────────────┐
                    │                  │                      │
             ┌──────▼────────────┐ ┌──▼───────────────┐  ┌───▼──────────────┐
             │ SISWA_PKL         │ │ SISWA_PKL        │  │ SISWA_PKL        │
             │                   │ │                  │  │                  │
             │ id: 1             │ │ id: 2            │  │ id: 3            │
             │ user_id: 2        │ │ user_id: 3       │  │ user_id: 4       │
             │ nama: Budi        │ │ nama: Siti       │  │ nama: Ahmad      │
             │ nim_nis: 201001   │ │ nim_nis: 201002  │  │ nim_nis: 201003  │
             │                   │ │                  │  │                  │
             └──────┬────────────┘ └──┬───────────────┘  └───┬──────────────┘
                    │                  │                      │
        ┌───────────┼──────────┐    ┌──┴──────┐        ┌─────┴──────┐
        │           │          │    │         │        │            │
        ▼           ▼          ▼    ▼         ▼        ▼            ▼
    ┌────────┐ ┌────────┐ ┌────────┐ ┌─────────┐ ┌────────┐ ┌────────┐
    │ABSENSI │ │ABSENSI │ │ABSENSI │ │ABSENSI  │ │ABSENSI │ │ABSENSI │
    │        │ │        │ │        │ │         │ │        │ │        │
    │01-12   │ │02-12   │ │03-12   │ │01-12    │ │02-12   │ │01-12   │
    │hadir   │ │izin    │ │sakit   │ │hadir    │ │sakit   │ │hadir   │
    └────────┘ └────────┘ └────────┘ └─────────┘ └────────┘ └────────┘

 Legend:
 ═════════════════════
 ─ User
 User→ Siswa_PKL (1:1)
 Siswa_PKL→ Absensi (1:M)
```

---

## 📋 Cardinality (Multiplicity)

```
Notation: (Min, Max)

USERS                    SISWA_PKL                   ABSENSI
┌────────────────┐       ┌──────────────┐           ┌─────────────┐
│                │       │              │           │             │
│  (1,1)─────(1,1)  :(1,1)─────(1,M)  :
│                │       │              │           │             │
└────────────────┘       └──────────────┘           └─────────────┘

Penjelasan:
- Users (1,1) : Setiap user minimal 1 dan maksimal 1
- Siswa_PKL (1,1) : Setiap siswa minimal 1 dan maksimal 1
- Absensi (1,M) : Setiap siswa bisa 1 atau banyak absensi

Contoh:
- User ID 1 (Admin) = 1:0 (tidak ada di Siswa_PKL)
- User ID 2 (Budi) = 1:1 Siswa_PKL ID 1
- Siswa_PKL ID 1 = 1:M Absensi (bisa punya 5 record absensi)
```

---

## 🗂️ Enum Values

### Role Enum (Users.role)
```
┌─────────┬──────────────────────────────────────────┐
│ Value   │ Keterangan                               │
├─────────┼──────────────────────────────────────────┤
│ admin   │ Administrator/Kepala Absensi             │
│         │ - Bisa lihat semua siswa                 │
│         │ - Bisa input absensi siswa               │
│         │ - Bisa generate laporan                  │
│         │ - Bisa kelola data siswa                 │
├─────────┼──────────────────────────────────────────┤
│ user    │ Siswa PKL                                │
│         │ - Hanya bisa input absensi sendiri       │
│         │ - Hanya bisa lihat data pribadi          │
│         │ - Hanya bisa lihat laporan pribadi       │
└─────────┴──────────────────────────────────────────┘
```

### Status Enum (Absensi.status)
```
┌─────────┬──────────────────────────────────────────────────────┐
│ Value   │ Keterangan                                           │
├─────────┼──────────────────────────────────────────────────────┤
│ hadir   │ Siswa hadir (ada jam_masuk dan jam_pulang)           │
│         │ - Wajib ada waktu masuk dan pulang                  │
│         │ - Keterangan NULLABLE (boleh kosong)                │
├─────────┼──────────────────────────────────────────────────────┤
│ izin    │ Siswa tidak hadir dengan alasan izin               │
│         │ - jam_masuk dan jam_pulang NULL                     │
│         │ - Keterangan REQUIRED (harus ada)                   │
├─────────┼──────────────────────────────────────────────────────┤
│ sakit   │ Siswa tidak hadir karena sakit                      │
│         │ - jam_masuk dan jam_pulang NULL                     │
│         │ - Keterangan REQUIRED (harus ada)                   │
├─────────┼──────────────────────────────────────────────────────┤
│ alpha   │ Siswa tidak hadir tanpa alasan (Absen Tanpa Izin)   │
│         │ - jam_masuk dan jam_pulang NULL                     │
│         │ - Keterangan NULLABLE (boleh kosong)                │
└─────────┴──────────────────────────────────────────────────────┘
```

---

## 📊 Data Model

### Entity Users
```
┌─────────────────────────────────────────────────────────────┐
│ USERS                                                       │
├─────────────────────────────────────────────────────────────┤
│ Field        │ Type         │ Constraint                    │
├──────────────┼──────────────┼───────────────────────────────┤
│ id           │ INT          │ PK, AUTO_INCREMENT            │
│ name         │ VARCHAR(255) │ NOT NULL                      │
│ email        │ VARCHAR(255) │ UNIQUE, NOT NULL             │
│ password     │ VARCHAR(255) │ NOT NULL (Bcrypt hashed)     │
│ role         │ ENUM         │ NOT NULL, DEFAULT 'user'     │
│              │              │ Values: admin, user          │
│ created_at   │ TIMESTAMP    │ DEFAULT CURRENT_TIMESTAMP    │
│ updated_at   │ TIMESTAMP    │ DEFAULT CURRENT_TIMESTAMP    │
└─────────────────────────────────────────────────────────────┘
```

### Entity Siswa_PKL
```
┌──────────────────────────────────────────────────────────────┐
│ SISWA_PKL                                                    │
├──────────────────────────────────────────────────────────────┤
│ Field        │ Type         │ Constraint                    │
├──────────────┼──────────────┼────────────────────────────────┤
│ id           │ INT          │ PK, AUTO_INCREMENT            │
│ user_id      │ INT          │ FK, UNIQUE, NOT NULL         │
│              │              │ References: users(id)        │
│ nama         │ VARCHAR(255) │ NOT NULL                      │
│ nim_nis      │ VARCHAR(20)  │ UNIQUE, NOT NULL             │
│ jurusan      │ VARCHAR(100) │ NOT NULL                      │
│ sekolah      │ VARCHAR(255) │ NOT NULL                      │
│ foto         │ VARCHAR(255) │ NULLABLE (path ke storage)   │
│ created_at   │ TIMESTAMP    │ DEFAULT CURRENT_TIMESTAMP    │
│ updated_at   │ TIMESTAMP    │ DEFAULT CURRENT_TIMESTAMP    │
└──────────────────────────────────────────────────────────────┘
```

### Entity Absensi
```
┌──────────────────────────────────────────────────────────────┐
│ ABSENSI                                                      │
├──────────────────────────────────────────────────────────────┤
│ Field        │ Type         │ Constraint                    │
├──────────────┼──────────────┼────────────────────────────────┤
│ id           │ INT          │ PK, AUTO_INCREMENT            │
│ siswa_pkl_id │ INT          │ FK, NOT NULL                 │
│              │              │ References: siswa_pkl(id)    │
│ tanggal      │ DATE         │ NOT NULL                      │
│ jam_masuk    │ TIME         │ NULLABLE                      │
│ jam_pulang   │ TIME         │ NULLABLE                      │
│ foto_masuk   │ VARCHAR(255) │ NULLABLE (path ke storage)   │
│ foto_pulang  │ VARCHAR(255) │ NULLABLE (path ke storage)   │
│ status       │ ENUM         │ NOT NULL                      │
│              │              │ Values: hadir, izin,         │
│              │              │         sakit, alpha         │
│ keterangan   │ TEXT         │ NULLABLE                      │
│ created_at   │ TIMESTAMP    │ DEFAULT CURRENT_TIMESTAMP    │
│ updated_at   │ TIMESTAMP    │ DEFAULT CURRENT_TIMESTAMP    │
│ UNIQUE       │              │ (siswa_pkl_id, tanggal)      │
└──────────────────────────────────────────────────────────────┘
```

---

## 🔑 Primary Key & Foreign Key

```
PRIMARY KEYS:
═════════════════════════════════════════════════════════════
│ Tabel        │ Primary Key │ Type     │ Keterangan      │
├──────────────┼─────────────┼──────────┼─────────────────┤
│ USERS        │ id          │ INT      │ Auto increment  │
│ SISWA_PKL    │ id          │ INT      │ Auto increment  │
│ ABSENSI      │ id          │ INT      │ Auto increment  │
└──────────────┴─────────────┴──────────┴─────────────────┘

FOREIGN KEYS:
═════════════════════════════════════════════════════════════
│ Tabel     │ FK Column      │ References        │ On Delete │
├───────────┼────────────────┼───────────────────┼───────────┤
│ SISWA_PKL │ user_id        │ users(id)         │ CASCADE   │
│ ABSENSI   │ siswa_pkl_id   │ siswa_pkl(id)     │ CASCADE   │
└───────────┴────────────────┴───────────────────┴───────────┘

UNIQUE CONSTRAINTS:
═════════════════════════════════════════════════════════════
│ Tabel        │ Unique Column(s)      │ Reason             │
├──────────────┼───────────────────────┼────────────────────┤
│ USERS        │ email                 │ No duplicate email │
│ SISWA_PKL    │ user_id               │ 1:1 relationship   │
│ SISWA_PKL    │ nim_nis               │ No duplicate NIM   │
│ ABSENSI      │ siswa_pkl_id, tanggal │ 1 absen/hari/siswa │
└──────────────┴───────────────────────┴────────────────────┘
```

---

## 📈 Sample ERD Data

```
USERS TABLE:
┌────┬──────────────────┬─────────────────────┬──────────┐
│ id │ name             │ email               │ role     │
├────┼──────────────────┼─────────────────────┼──────────┤
│ 1  │ Admin User       │ admin@polres.id     │ admin    │
│ 2  │ Budi Santoso     │ budi@example.com    │ user     │
│ 3  │ Siti Nurdin      │ siti@example.com    │ user     │
│ 4  │ Ahmad Maulana    │ ahmad@example.com   │ user     │
└────┴──────────────────┴─────────────────────┴──────────┘

SISWA_PKL TABLE:
┌────┬─────────┬──────────────────┬─────────┬──────────────────┬──────────────┐
│ id │ user_id │ nama             │ nim_nis │ jurusan          │ sekolah      │
├────┼─────────┼──────────────────┼─────────┼──────────────────┼──────────────┤
│ 1  │ 2       │ Budi Santoso     │ 201001  │ Teknik Informatika│ SMK Negeri 1 │
│ 2  │ 3       │ Siti Nurdin      │ 201002  │ Akuntansi        │ SMK Negeri 2 │
│ 3  │ 4       │ Ahmad Maulana    │ 201003  │ Teknik Mesin     │ SMK Negeri 1 │
└────┴─────────┴──────────────────┴─────────┴──────────────────┴──────────────┘

ABSENSI TABLE:
┌────┬──────────────┬────────────┬────────────┬────────────┬──────────┐
│ id │ siswa_pkl_id │ tanggal    │ jam_masuk  │ jam_pulang │ status   │
├────┼──────────────┼────────────┼────────────┼────────────┼──────────┤
│ 1  │ 1            │ 2025-12-01 │ 07:30:00   │ 16:00:00   │ hadir    │
│ 2  │ 1            │ 2025-12-02 │ NULL       │ NULL       │ izin     │
│ 3  │ 1            │ 2025-12-03 │ NULL       │ NULL       │ sakit    │
│ 4  │ 2            │ 2025-12-01 │ 07:45:00   │ 16:15:00   │ hadir    │
│ 5  │ 2            │ 2025-12-02 │ 07:30:00   │ 16:00:00   │ hadir    │
│ 6  │ 2            │ 2025-12-03 │ NULL       │ NULL       │ alpha    │
│ 7  │ 3            │ 2025-12-01 │ 07:20:00   │ 16:30:00   │ hadir    │
└────┴──────────────┴────────────┴────────────┴────────────┴──────────┘
```

---

## 🔄 Relationship Flow

```
FLOW 1: User Login & Absen
═════════════════════════════════════════════════════════════════
User (id=2) Login
    ↓
Query: SELECT * FROM users WHERE id = 2
    ↓
Result: Budi Santoso (role=user)
    ↓
Authorized → Navigate to Dashboard
    ↓
Query: SELECT * FROM siswa_pkl WHERE user_id = 2
    ↓
Result: Siswa_PKL (id=1, nama=Budi Santoso, nim_nis=201001)
    ↓
User Input: Absen Masuk jam 07:30
    ↓
Insert to Absensi:
  siswa_pkl_id = 1
  tanggal = 2025-12-01
  jam_masuk = 07:30:00
  status = hadir
    ↓
Success → Display di Dashboard


FLOW 2: Admin View All Attendance
═════════════════════════════════════════════════════════════════
Admin (id=1) Login
    ↓
Authorized (role=admin)
    ↓
Query: SELECT siswa, absensi FROM siswa_pkl 
       JOIN absensi ON siswa_pkl.id = absensi.siswa_pkl_id
       WHERE DATE(absensi.tanggal) = TODAY()
    ↓
Result: List semua absensi hari ini dari semua siswa
    ↓
Display di Dashboard Admin


FLOW 3: Generate Laporan Bulanan
═════════════════════════════════════════════════════════════════
User/Admin pilih: Bulan = Desember, Tahun = 2025
    ↓
Query:
  SELECT siswa_pkl.nama, 
         COUNT(CASE WHEN status='hadir' THEN 1 END) as hadir,
         COUNT(CASE WHEN status='izin' THEN 1 END) as izin,
         COUNT(CASE WHEN status='sakit' THEN 1 END) as sakit,
         COUNT(CASE WHEN status='alpha' THEN 1 END) as alpha
  FROM absensi
  JOIN siswa_pkl ON absensi.siswa_pkl_id = siswa_pkl.id
  WHERE MONTH(tanggal)=12 AND YEAR(tanggal)=2025
  GROUP BY siswa_pkl.id
    ↓
Result: Statistik per siswa (hadir, izin, sakit, alpha)
    ↓
Display Laporan
```

---

## ✅ Validasi & Constraint

```
BUSINESS RULES:
═════════════════════════════════════════════════════════════════

1. USERS TABLE
   ✓ Email harus unique (tidak ada duplikasi)
   ✓ Password harus ter-hash (Bcrypt)
   ✓ Role hanya boleh 'admin' atau 'user'
   ✓ Setiap user harus punya email dan password

2. SISWA_PKL TABLE
   ✓ user_id harus unique (1 user = 1 siswa_pkl)
   ✓ NIM/NIS harus unique (tidak ada duplikasi)
   ✓ Nama, jurusan, sekolah wajib diisi
   ✓ Foto boleh kosong (optional)

3. ABSENSI TABLE
   ✓ Status hanya: hadir, izin, sakit, atau alpha
   ✓ Jika status=hadir, jam_masuk dan jam_pulang REQUIRED
   ✓ Jika status=izin atau sakit, keterangan REQUIRED
   ✓ Jika status=alpha, keterangan NULLABLE
   ✓ (siswa_pkl_id, tanggal) harus unique
     → Satu siswa hanya bisa absen 1x per hari

4. FOREIGN KEY
   ✓ siswa_pkl.user_id harus exist di users.id
   ✓ absensi.siswa_pkl_id harus exist di siswa_pkl.id
   ✓ Saat delete, gunakan CASCADE
```

---

## 🎨 Color Legend (untuk diagram visual)

```
┌──────────────────────────────────────────────────────────┐
│ PRIMARY KEY        : 🔑 (Yellow/Gold)                   │
│ FOREIGN KEY        : 🔗 (Blue)                          │
│ UNIQUE CONSTRAINT  : ✓ (Green)                         │
│ NOT NULL           : ● (Red)                           │
│ NULLABLE           : ○ (Gray)                          │
│ ENUM VALUE         : 🏷️  (Purple)                       │
└──────────────────────────────────────────────────────────┘
```

---

## 📖 SQL DDL Statements

### Users Table
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Siswa_PKL Table
```sql
CREATE TABLE siswa_pkl (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE NOT NULL,
    nama VARCHAR(255) NOT NULL,
    nim_nis VARCHAR(20) UNIQUE NOT NULL,
    jurusan VARCHAR(100) NOT NULL,
    sekolah VARCHAR(255) NOT NULL,
    foto VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_nama (nama),
    INDEX idx_nim_nis (nim_nis)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Absensi Table
```sql
CREATE TABLE absensi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    siswa_pkl_id INT NOT NULL,
    tanggal DATE NOT NULL,
    jam_masuk TIME,
    jam_pulang TIME,
    foto_masuk VARCHAR(255),
    foto_pulang VARCHAR(255),
    status ENUM('hadir', 'izin', 'sakit', 'alpha') NOT NULL,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (siswa_pkl_id) REFERENCES siswa_pkl(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY uk_siswa_tanggal (siswa_pkl_id, tanggal),
    INDEX idx_tanggal (tanggal),
    INDEX idx_status (status),
    INDEX idx_siswa_tanggal (siswa_pkl_id, tanggal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

**Last Updated**: December 2, 2025  
**Format**: Visual ASCII Diagram + Database Schema  
**Database**: MySQL 5.7+  
**Timezone**: Asia/Jakarta (WIB)


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


AAS
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

### Diagram & Arsitektur

#### Entity Relationship Diagram (ERD)
Diagram menunjukkan relasi antar tabel dalam database:
- **Users Table**: Menyimpan data login admin dan siswa
- **Siswa_PKL Table**: Profil detail siswa yang terhubung ke Users
- **Absensi Table**: Record absensi harian yang terhubung ke Siswa_PKL

Untuk visualisasi lengkap, lihat [Dokumentasi Diagram](docs/DIAGRAMS.md)

#### Use Case Diagram
Menggambarkan interaksi antara:
- **Siswa PKL**: Dapat absen masuk/pulang, lapor izin/sakit, lihat riwayat
- **Admin**: Dapat mengelola siswa, input absensi, generate laporan

Untuk detail lengkap, lihat [Dokumentasi Diagram](docs/DIAGRAMS.md)

---

### File Dokumentasi Utama

| File | Deskripsi |
|------|-----------|
| [ERD.md](ERD.md) | Entity Relationship Diagram dengan schema database lengkap |
| [UML.md](UML.md) | UML Class Diagram dan System Architecture |
| [docs/DIAGRAMS.md](docs/DIAGRAMS.md) | Dokumentasi semua diagram sistem |
| [docs/PUSH_TO_GITHUB.md](docs/PUSH_TO_GITHUB.md) | Panduan push file ke GitHub |
| [README.md](README.md) | File ini - Dokumentasi project |

### Detail Dokumentasi

#### 1. **ERD (Entity Relationship Diagram)**
Schema database dengan 3 tabel utama:
- Users, Siswa_PKL, Absensi
- Foreign key relationships dengan CASCADE
- Enum values: role (admin/user), status (hadir/izin/sakit/alpha)

👉 Buka [ERD.md](ERD.md) untuk visualisasi lengkap

#### 2. **UML (Class Diagram & Architecture)**
Dokumentasi system architecture:
- Class diagrams untuk User, SiswaPkl, Absensi models
- Controller architecture dan Middleware flow
- Database transaction flows
- Sequence diagrams untuk Login & Register

👉 Buka [UML.md](UML.md) untuk detail lengkap

#### 3. **Diagram Use Case**
Interaksi user dengan system:
- Siswa PKL: Absen, Lapor Izin/Sakit, Lihat Riwayat
- Admin: Kelola Siswa, Input Absensi, Generate Laporan

👉 Buka [docs/DIAGRAMS.md](docs/DIAGRAMS.md) untuk visualisasi

#### 4. **Panduan GitHub**
Instruksi lengkap untuk:
- Push file ke repository
- Menangani error permission
- Setup SSH atau Personal Access Token

👉 Buka [docs/PUSH_TO_GITHUB.md](docs/PUSH_TO_GITHUB.md) untuk panduan

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
