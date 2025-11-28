# Entity Relationship Diagram (ERD)

## Database Schema

### Tabel: `users`
Menyimpan informasi pengguna sistem (Admin dan Siswa PKL)

| Column | Type | Constraint | Description |
|--------|------|-----------|-------------|
| id | BIGINT | PRIMARY KEY | ID pengguna unik |
| name | VARCHAR(255) | NOT NULL | Nama pengguna |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email pengguna |
| password | VARCHAR(255) | NOT NULL | Password terenkripsi |
| role | ENUM | NOT NULL | Role: 'admin' atau 'user' |
| created_at | TIMESTAMP | | Waktu pembuatan |
| updated_at | TIMESTAMP | | Waktu update terakhir |

---

### Tabel: `siswa_pkl`
Menyimpan informasi profil siswa PKL

| Column | Type | Constraint | Description |
|--------|------|-----------|-------------|
| id | BIGINT | PRIMARY KEY | ID siswa unik |
| user_id | BIGINT | FOREIGN KEY, NULLABLE | Referensi ke tabel users |
| nama | VARCHAR(255) | NOT NULL | Nama lengkap siswa |
| nim_nis | VARCHAR(255) | UNIQUE, NOT NULL | NIM/NIS siswa |
| jurusan | VARCHAR(255) | NOT NULL | Jurusan/Program studi |
| sekolah | VARCHAR(255) | NOT NULL | Nama sekolah/institusi |
| foto | VARCHAR(255) | NULLABLE | Path foto profil siswa |
| created_at | TIMESTAMP | | Waktu pembuatan record |
| updated_at | TIMESTAMP | | Waktu update terakhir |

**Foreign Key:** `user_id` → `users(id)` ON DELETE CASCADE

---

### Tabel: `absensi`
Menyimpan data absensi siswa PKL

| Column | Type | Constraint | Description |
|--------|------|-----------|-------------|
| id | BIGINT | PRIMARY KEY | ID absensi unik |
| siswa_pkl_id | BIGINT | FOREIGN KEY, NOT NULL | Referensi ke siswa_pkl |
| tanggal | DATE | NOT NULL | Tanggal absensi |
| jam_masuk | TIME | NULLABLE | Jam absen masuk |
| jam_pulang | TIME | NULLABLE | Jam absen pulang |
| foto_masuk | VARCHAR(255) | NULLABLE | Path foto saat masuk |
| foto_pulang | VARCHAR(255) | NULLABLE | Path foto saat pulang |
| status | ENUM | NOT NULL | Status: 'hadir', 'izin', 'sakit', 'alpha' |
| keterangan | TEXT | NULLABLE | Keterangan/alasan absensi |
| created_at | TIMESTAMP | | Waktu pembuatan record |
| updated_at | TIMESTAMP | | Waktu update terakhir |

**Foreign Key:** `siswa_pkl_id` → `siswa_pkl(id)` ON DELETE CASCADE

---

## Relationship Diagram

```
┌─────────────────────┐
│      users          │
├─────────────────────┤
│ id (PK)             │
│ name                │
│ email (UNIQUE)      │
│ password            │
│ role (ENUM)         │
│ created_at          │
│ updated_at          │
└──────────┬──────────┘
           │
           │ 1:1 (role='user')
           │
           ▼
┌─────────────────────┐
│    siswa_pkl        │
├─────────────────────┤
│ id (PK)             │
│ user_id (FK)        │◄─────┐
│ nama                │      │
│ nim_nis (UNIQUE)    │      │
│ jurusan             │      │
│ sekolah             │      │
│ foto                │      │
│ created_at          │      │
│ updated_at          │      │
└──────────┬──────────┘      │
           │                 │
           │ 1:Many          │
           │                 │
           ▼                 │
┌─────────────────────┐      │
│      absensi        │      │
├─────────────────────┤      │
│ id (PK)             │      │
│ siswa_pkl_id (FK) ──┼──────┘
│ tanggal             │
│ jam_masuk           │
│ jam_pulang          │
│ foto_masuk          │
│ foto_pulang         │
│ status (ENUM)       │
│ keterangan          │
│ created_at          │
│ updated_at          │
└─────────────────────┘
```

---

## Relationship Summary

| Tabel 1 | Tabel 2 | Tipe | Deskripsi |
|---------|---------|------|-----------|
| users | siswa_pkl | 1:1 | Satu user dapat memiliki satu profil siswa (user role='user') |
| siswa_pkl | absensi | 1:Many | Satu siswa dapat memiliki banyak record absensi |
| users | absensi (indirect) | 1:Many | Satu user dapat memiliki banyak data absensi melalui siswa_pkl |

---

## Enum Values

### users.role
- `admin` - Administrator sistem
- `user` - Siswa PKL

### absensi.status
- `hadir` - Siswa hadir (absen masuk dan pulang)
- `izin` - Siswa izin
- `sakit` - Siswa sakit
- `alpha` - Siswa alpa/tidak hadir tanpa keterangan
