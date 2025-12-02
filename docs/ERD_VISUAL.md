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
