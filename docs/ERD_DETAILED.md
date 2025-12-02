# Entity Relationship Diagram (ERD)
# Sistem Absensi PKL - Polres Garut

## 📊 Database Schema Overview

Sistem ini menggunakan 3 tabel utama dengan relasi many-to-one dan one-to-many:

```
┌─────────────────────┐
│      USERS          │
├─────────────────────┤
│ id (PK)             │
│ name                │
│ email (UNIQUE)      │
│ password            │
│ role (ENUM)         │◄─────┐
│ created_at          │      │ 1:1
│ updated_at          │      │
└─────────────────────┘      │
                             │
                      ┌──────┴────────┐
                      │               │
                ┌─────▼──────────────┐
                │   SISWA_PKL        │
                ├────────────────────┤
                │ id (PK)            │
                │ user_id (FK)       │◄─────┐
                │ nama               │      │
                │ nim_nis            │      │ 1:M
                │ jurusan            │      │
                │ sekolah            │      │
                │ foto               │      │
                │ created_at         │      │
                │ updated_at         │      │
                └────────────────────┘      │
                         │                  │
                         │ 1:M              │
                         │                  │
                ┌────────▼──────────────┐   │
                │     ABSENSI           │   │
                ├───────────────────────┤   │
                │ id (PK)               │   │
                │ siswa_pkl_id (FK)     │───┘
                │ tanggal               │
                │ jam_masuk             │
                │ jam_pulang            │
                │ foto_masuk            │
                │ foto_pulang           │
                │ status (ENUM)         │
                │ keterangan            │
                │ created_at            │
                │ updated_at            │
                └───────────────────────┘
```

---

## 📋 Tabel Detail

### 1️⃣ **USERS Table**
Menyimpan akun login untuk Admin dan Siswa PKL

| Column | Type | Constraint | Keterangan |
|--------|------|-----------|-----------|
| **id** | INT | PK, AUTO_INCREMENT | Primary key |
| **name** | VARCHAR(255) | NOT NULL | Nama user (admin atau siswa) |
| **email** | VARCHAR(255) | UNIQUE, NOT NULL | Email untuk login |
| **password** | VARCHAR(255) | NOT NULL | Password ter-hash (Bcrypt) |
| **role** | ENUM('admin', 'user') | NOT NULL, DEFAULT 'user' | Role: admin atau user (siswa) |
| **created_at** | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu dibuat |
| **updated_at** | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu diupdate |

**Relationships:**
- ✅ One-to-One dengan `siswa_pkl` (jika role = 'user')
- ✅ One-to-Many dengan `absensi` (via siswa_pkl)

**Enum Values:**
- `admin` - Administrator/Kepala Absensi
- `user` - Siswa PKL (User biasa)

---

### 2️⃣ **SISWA_PKL Table**
Menyimpan profil detail siswa PKL yang terhubung dengan User

| Column | Type | Constraint | Keterangan |
|--------|------|-----------|-----------|
| **id** | INT | PK, AUTO_INCREMENT | Primary key |
| **user_id** | INT | FK, UNIQUE, NOT NULL | Foreign key ke users.id |
| **nama** | VARCHAR(255) | NOT NULL | Nama lengkap siswa |
| **nim_nis** | VARCHAR(20) | UNIQUE, NOT NULL | Nomor Induk Siswa/NIM |
| **jurusan** | VARCHAR(100) | NOT NULL | Program studi/jurusan |
| **sekolah** | VARCHAR(255) | NOT NULL | Asal sekolah |
| **foto** | VARCHAR(255) | NULLABLE | Path foto siswa di storage |
| **created_at** | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu dibuat |
| **updated_at** | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu diupdate |

**Relationships:**
- ✅ Many-to-One dengan `users` (foreign key: user_id)
- ✅ One-to-Many dengan `absensi`

**Foreign Key Constraint:**
```sql
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
```

---

### 3️⃣ **ABSENSI Table**
Menyimpan record absensi harian siswa PKL

| Column | Type | Constraint | Keterangan |
|--------|------|-----------|-----------|
| **id** | INT | PK, AUTO_INCREMENT | Primary key |
| **siswa_pkl_id** | INT | FK, NOT NULL | Foreign key ke siswa_pkl.id |
| **tanggal** | DATE | NOT NULL | Tanggal absensi |
| **jam_masuk** | TIME | NULLABLE | Jam check-in (jika status hadir) |
| **jam_pulang** | TIME | NULLABLE | Jam check-out (jika status hadir) |
| **foto_masuk** | VARCHAR(255) | NULLABLE | Path foto saat masuk |
| **foto_pulang** | VARCHAR(255) | NULLABLE | Path foto saat pulang |
| **status** | ENUM | NOT NULL | Status kehadiran siswa |
| **keterangan** | TEXT | NULLABLE | Catatan/penjelasan absensi |
| **created_at** | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu dibuat |
| **updated_at** | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu diupdate |

**Relationships:**
- ✅ Many-to-One dengan `siswa_pkl` (foreign key: siswa_pkl_id)

**Foreign Key Constraint:**
```sql
FOREIGN KEY (siswa_pkl_id) REFERENCES siswa_pkl(id) ON DELETE CASCADE ON UPDATE CASCADE
```

**Enum Values (Status):**
- `hadir` - Siswa hadir dengan jam masuk dan jam pulang
- `izin` - Siswa tidak hadir dengan izin (ada keterangan)
- `sakit` - Siswa tidak hadir karena sakit (ada keterangan)
- `alpha` - Siswa tidak hadir tanpa izin (tidak ada keterangan)

---

## 🔄 Relasi Antar Tabel

### Relasi 1: Users ↔ Siswa_PKL (One-to-One)
- **Type**: One-to-One
- **Relationship**: 
  - 1 User (role='user') memiliki 1 Siswa_PKL
  - 1 Siswa_PKL milik 1 User
- **Foreign Key**: `siswa_pkl.user_id` → `users.id`
- **On Delete**: CASCADE (hapus user, hapus siswa_pkl)
- **Keterangan**: Setiap siswa PKL harus memiliki akun user untuk login

### Relasi 2: Siswa_PKL ↔ Absensi (One-to-Many)
- **Type**: One-to-Many
- **Relationship**:
  - 1 Siswa_PKL dapat memiliki banyak Absensi (harian)
  - Banyak Absensi milik 1 Siswa_PKL
- **Foreign Key**: `absensi.siswa_pkl_id` → `siswa_pkl.id`
- **On Delete**: CASCADE (hapus siswa, hapus semua absensinya)
- **Keterangan**: Setiap siswa memiliki history absensi per hari

### Relasi 3: Users ↔ Absensi (Indirect via Siswa_PKL)
- **Type**: One-to-Many (melalui Siswa_PKL)
- **Path**: Users → Siswa_PKL → Absensi
- **Keterangan**: Untuk query semua absensi milik satu user

---

## 📊 Cardinality Diagram

```
USERS (1) ─────────────────── (1) SISWA_PKL
   │                                │
   │ role='user'                    │ siswa_pkl_id
   │                                │
   └────────────────┬───────────────┘
                    │
            ┌───────▼────────┐
            │     (1:M)      │
            │                │
         (1) SISWA_PKL ─────────────── (M) ABSENSI
```

---

## 🗂️ Struktur Database SQL

### Create Users Table
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_role (role),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Create Siswa_PKL Table
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

### Create Absensi Table
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
    UNIQUE KEY unique_absensi (siswa_pkl_id, tanggal),
    INDEX idx_tanggal (tanggal),
    INDEX idx_status (status),
    INDEX idx_siswa_tanggal (siswa_pkl_id, tanggal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 📈 Sample Data

### Users Table
```
id | name        | email               | role   | password
---|-------------|---------------------|--------|------------------
1  | Admin User  | admin@example.com   | admin  | hashed_password
2  | Budi Santoso| budi@example.com    | user   | hashed_password
3  | Siti Nurdin | siti@example.com    | user   | hashed_password
```

### Siswa_PKL Table
```
id | user_id | nama          | nim_nis | jurusan          | sekolah
---|---------|---------------|---------|------------------|------------------
1  | 2       | Budi Santoso  | 201001  | Teknik Informatika | SMK Negeri 1
2  | 3       | Siti Nurdin   | 201002  | Akuntansi        | SMK Negeri 2
```

### Absensi Table
```
id | siswa_pkl_id | tanggal    | jam_masuk | jam_pulang | status | keterangan
---|--------------|------------|-----------|------------|--------|------------------
1  | 1            | 2025-12-01 | 07:30:00  | 16:00:00   | hadir  | NULL
2  | 1            | 2025-12-02 | NULL      | NULL       | izin   | Sakit gigi
3  | 2            | 2025-12-01 | 07:45:00  | 16:15:00   | hadir  | NULL
4  | 2            | 2025-12-02 | NULL      | NULL       | sakit  | Demam tinggi
```

---

## 📝 Catatan Penting

### 1. **Constraints & Validation**
- ✅ Email UNIQUE → Tidak ada duplikasi user per email
- ✅ NIM/NIS UNIQUE → Tidak ada duplikasi siswa
- ✅ (siswa_pkl_id, tanggal) UNIQUE → Satu absensi per siswa per hari
- ✅ Role ENUM → Hanya 'admin' atau 'user'
- ✅ Status ENUM → Hanya 'hadir', 'izin', 'sakit', 'alpha'

### 2. **Cascade Operations**
- ON DELETE CASCADE → Menghapus user otomatis hapus siswa_pkl dan absensi
- ON UPDATE CASCADE → Update user id otomatis update di siswa_pkl dan absensi

### 3. **Timezone**
- Semua TIMESTAMP menggunakan Asia/Jakarta (WIB)
- Di aplikasi Laravel config set: `'timezone' => 'Asia/Jakarta'`

### 4. **Indexing**
- Email, NIM/NIS → Frequent search
- Tanggal, Status → Report generation queries
- siswa_pkl_id, tanggal → Composite index untuk performa

### 5. **Data Integrity**
- NULL constraints pada field yang wajib
- UNIQUE constraints pada identifiers
- Foreign keys untuk relasi integritas
- Enum untuk nilai terbatas (type safety)

---

## 🔍 Query Examples

### 1. Ambil semua absensi siswa per hari
```sql
SELECT s.nama, s.nim_nis, a.tanggal, a.jam_masuk, a.jam_pulang, a.status
FROM absensi a
JOIN siswa_pkl s ON a.siswa_pkl_id = s.id
WHERE a.tanggal = CURDATE()
ORDER BY a.created_at ASC;
```

### 2. Hitung statistik absensi per siswa per bulan
```sql
SELECT 
    s.nama,
    SUM(CASE WHEN a.status = 'hadir' THEN 1 ELSE 0 END) as hadir,
    SUM(CASE WHEN a.status = 'izin' THEN 1 ELSE 0 END) as izin,
    SUM(CASE WHEN a.status = 'sakit' THEN 1 ELSE 0 END) as sakit,
    SUM(CASE WHEN a.status = 'alpha' THEN 1 ELSE 0 END) as alpha
FROM absensi a
JOIN siswa_pkl s ON a.siswa_pkl_id = s.id
WHERE MONTH(a.tanggal) = MONTH(CURDATE()) AND YEAR(a.tanggal) = YEAR(CURDATE())
GROUP BY s.id
ORDER BY s.nama;
```

### 3. Ambil user dengan semua absensinya
```sql
SELECT u.id, u.name, u.email, s.nama, a.tanggal, a.status
FROM users u
LEFT JOIN siswa_pkl s ON u.id = s.user_id
LEFT JOIN absensi a ON s.id = a.siswa_pkl_id
WHERE u.role = 'user'
ORDER BY u.name, a.tanggal DESC;
```

---

## 📚 Referensi Dokumentasi

- **ERD File**: `ERD.md`
- **UML Diagram**: `UML.md`
- **Documentations**: `docs/DIAGRAMS.md`
- **GitHub Panduan**: `docs/PUSH_TO_GITHUB.md`

---

**Last Updated**: December 2, 2025  
**Created for**: Sistem Absensi PKL - Polres Garut
