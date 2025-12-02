# Diagram Sistem Absensi PKL

## 📊 Entity Relationship Diagram (ERD)

Sistem ini terdiri dari tiga entitas utama dengan relasi berikut:

### Siswa Entity
Menyimpan data profil siswa PKL dengan atribut:
- Absensi Masuk/Pulang - Waktu check-in dan check-out
- Jurusan - Program studi siswa
- Riwayat - History absensi lengkap
- Lapor Sakit - Laporan ketidakhadiran karena sakit
- Lapor Izin - Laporan cuti/izin
- NIM/NIS - Nomor identitas siswa
- Dashboard - Akses ke dashboard personal
- Email - Email siswa
- Sekolah - Asal sekolah
- Password - Kredensial login

### Riwayat Siswa PKL
Entitas yang merekam semua aktivitas absensi:
- Nama Lengkap - Identitas siswa
- Riwayat - Catatan absensi
- Laporan - Generate laporan absensi

### Admin Entity
Entitas dengan role administratif yang dapat:
- Manajemen Siswa PKL - Kelola data siswa (CRUD)
- Absensi - Input/verifikasi absensi siswa
- Kelonik Siswa - Kelola profil siswa
- Laporan Absensi - Generate dan lihat laporan
- Data Siswa PKL - Akses database siswa
- Riwayat Absensi - Lihat history semua siswa
- Dashboard - Admin panel utama
- Status - Verifikasi status absensi

---

## 🔄 Use Case Diagram

### Siswa (User) Role
1. **Absensi Masuk/Pulang**: Siswa dapat mencatat waktu masuk dan keluar
2. **Lapor Sakit**: Siswa dapat melaporkan ketidakhadiran karena alasan kesehatan
3. **Lapor Izin**: Siswa dapat mengajukan izin dengan keterangan
4. **Dashboard**: Akses dashboard personal dengan statistik kehadiran
5. **Riwayat**: Melihat history absensi pribadi dengan detail lengkap
6. **Laporan**: Generate laporan bulanan/tahunan kehadiran pribadi

### Admin Role
1. **Manajemen Siswa PKL**: CRUD operasi untuk data siswa
   - Tambah siswa baru
   - Edit profil siswa
   - Hapus data siswa
   - Lihat daftar siswa

2. **Absensi**: Input/verifikasi absensi siswa
   - Absen masuk untuk siswa
   - Absen pulang untuk siswa
   - Catat izin siswa
   - Catat sakit siswa
   - Catat alpa siswa

3. **Laporan Absensi**: Generate laporan comprehensive
   - Laporan bulanan per siswa
   - Laporan tahunan per siswa
   - Statistik kehadiran (hadir/izin/sakit/alpa)
   - Export data

4. **Dashboard Admin**: Panel kontrol utama
   - Statistik harian (total siswa, hadir hari ini, belum absen)
   - Quick access ke semua fitur
   - Monitoring real-time

---

## 📋 Data Flow

### Proses Absensi Siswa:
```
Siswa Login → Dashboard Personal → Pilih Status Absensi → Input Data
↓
Sistem Catat Timestamp & Status → Update Database
↓
Tampil Konfirmasi & Update Dashboard
```

### Proses Laporan Admin:
```
Admin Login → Dashboard → Pilih Menu Laporan
↓
Pilih Bulan & Tahun → Filter Siswa (optional)
↓
Sistem Query Data dari Tabel Absensi → Calculate Statistics
↓
Generate & Display Laporan dengan Chart
```

---

## 🔐 Relasi Database

### Users → Siswa_PKL (1:1)
- Satu user terhubung dengan satu profil siswa PKL
- Foreign Key: `siswa_pkl.user_id` → `users.id`

### Siswa_PKL → Absensi (1:M)
- Satu siswa dapat memiliki banyak record absensi
- Foreign Key: `absensi.siswa_pkl_id` → `siswa_pkl.id`

---

## 📚 Tabel Relasional

| Tabel | Field | Type | Relasi |
|-------|-------|------|--------|
| users | id | INT PK | - |
| users | role | ENUM | admin/user |
| siswa_pkl | user_id | INT FK | users.id |
| absensi | siswa_pkl_id | INT FK | siswa_pkl.id |
| absensi | status | ENUM | hadir/izin/sakit/alpha |

---

## 🎯 Use Case Summary

```
┌─────────────────────────────────────────────────────┐
│           Sistem Absensi PKL Polres Garut          │
└─────────────────────────────────────────────────────┘

┌──────────────────────┐        ┌──────────────────────┐
│   Siswa PKL (User)   │        │      Admin           │
├──────────────────────┤        ├──────────────────────┤
│ • Absen Masuk/Pulang │        │ • Kelola Siswa       │
│ • Lapor Izin/Sakit   │        │ • Input Absensi      │
│ • Lihat Riwayat      │        │ • Generate Laporan   │
│ • View Dashboard     │        │ • Dashboard Admin    │
│ • View Laporan       │        │ • Verifikasi Status  │
└──────────────────────┘        └──────────────────────┘
         │                                  │
         └──────────────┬──────────────────┘
                        │
                   ┌────▼─────┐
                   │ Database  │
                   │  (MySQL)  │
                   └───────────┘
```

---

## 📖 Catatan Penting

1. **Enum Values**:
   - Role: `admin`, `user`
   - Status Absensi: `hadir`, `izin`, `sakit`, `alpha`

2. **Access Control**:
   - Siswa hanya bisa akses data pribadi mereka
   - Admin bisa akses semua data
   - Middleware role-based pada setiap route

3. **Timezone**:
   - Semua timestamp menggunakan Asia/Jakarta (WIB)
   - Consistent across semua operasi database

4. **Validasi**:
   - Siswa tidak bisa absen lebih dari 1x per hari per status
   - Admin bisa override dengan input manual
   - Keterangan wajib untuk izin/sakit
