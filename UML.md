# UML Class Diagram & Architecture

## Class Diagram

```
┌──────────────────────────────────────────────────────┐
│                      User                            │
├──────────────────────────────────────────────────────┤
│ - id: BigInt                                         │
│ - name: String                                       │
│ - email: String                                      │
│ - password: String                                   │
│ - role: Enum(admin|user)                            │
├──────────────────────────────────────────────────────┤
│ + siswaPkl(): HasOne                                 │
│ + login(): void                                      │
│ + register(): void                                   │
│ + logout(): void                                     │
└──────────────────────────────────────────────────────┘
           △
           │ authenticable
           │
┌──────────┴──────────┬──────────────────────────────┐
│                     │                              │
│                     ▼                              │
│    ┌───────────────────────────────┐              │
│    │       Admin User              │              │
│    ├───────────────────────────────┤              │
│    │ + manageSiswa()               │              │
│    │ + viewAllAbsensi()            │              │
│    │ + generateReport()            │              │
│    │ + manualAbsenEntry()          │              │
│    └───────────────────────────────┘              │
│                                                    │
│    ┌───────────────────────────────┐              │
│    │    Siswa PKL User             │              │
│    ├───────────────────────────────┤              │
│    │ + absenMasuk()                │              │
│    │ + absenPulang()               │              │
│    │ + reportIzin()                │              │
│    │ + reportSakit()               │              │
│    │ + viewOwnAbsensi()            │              │
│    └───────────────────────────────┘              │
│                                                    │
└──────────────────────────────────────────────────┘


┌──────────────────────────────────────────────────────┐
│                   SiswaPkl                           │
├──────────────────────────────────────────────────────┤
│ - id: BigInt                                         │
│ - user_id: BigInt                                    │
│ - nama: String                                       │
│ - nim_nis: String (unique)                          │
│ - jurusan: String                                    │
│ - sekolah: String                                    │
│ - foto: String (nullable)                           │
├──────────────────────────────────────────────────────┤
│ + user(): BelongsTo                                  │
│ + absensi(): HasMany                                │
│ + absensiHariIni(): HasOne                          │
│ + getInitialName(): String                          │
└──────────────────────────────────────────────────────┘
           △                           △
           │ 1                         │
           │                           │
        owns                        has many
           │                           │
           │ 1                         │ Many
           │                           │
   ┌───────┴─────────────┐   ┌────────┴────────────────┐
   │                     │   │                        │
   ▼                     │   ▼                        │
┌──────────────────┐     │ ┌──────────────────────────┐
│    User          │     │ │      Absensi            │
├──────────────────┤     │ ├──────────────────────────┤
│ + role='user'    │     │ │ - id: BigInt            │
│                  │     │ │ - siswa_pkl_id: BigInt  │
└──────────────────┘     │ │ - tanggal: Date         │
                         │ │ - jam_masuk: Time       │
                         │ │ - jam_pulang: Time      │
                         │ │ - foto_masuk: String    │
                         │ │ - foto_pulang: String   │
                         │ │ - status: Enum          │
                         │ │ - keterangan: Text      │
                         │ ├──────────────────────────┤
                         │ │ + siswaPkl(): BelongsTo  │
                         │ │ + getDuration(): Time    │
                         │ │ + isPresent(): Boolean   │
                         │ └──────────────────────────┘
```

---

## Controller Architecture

```
┌─────────────────────────────────────────────────────┐
│            AbsensiController                        │
├─────────────────────────────────────────────────────┤
│ Methods:                                            │
│ + index(): View                                     │
│   - Show dashboard (role-specific)                  │
│                                                     │
│ + absenMasuk(Request): RedirectResponse             │
│   - Record check-in time                            │
│   - Validate siswa ownership (user role)            │
│                                                     │
│ + absenPulang(Request): RedirectResponse            │
│   - Record check-out time                           │
│   - Validate siswa ownership (user role)            │
│                                                     │
│ + absenIzin(Request): RedirectResponse              │
│   - Record leave status with reason                 │
│   - Validate siswa ownership (user role)            │
│                                                     │
│ + absenSakit(Request): RedirectResponse             │
│   - Record sick status with reason                  │
│   - Validate siswa ownership (user role)            │
│                                                     │
│ + absenAlpa(Request): RedirectResponse              │
│   - Record absent status                            │
│   - Validate siswa ownership (user role)            │
│                                                     │
│ + riwayat(): View                                   │
│   - Show attendance history (filtered by role)      │
│                                                     │
│ + laporan(Request): View                            │
│   - Generate monthly/yearly report (filtered)       │
└─────────────────────────────────────────────────────┘
           △
           │ uses
           │
   ┌───────┴───────────┬──────────────┐
   │                   │              │
   ▼                   ▼              ▼
┌─────────┐    ┌───────────┐   ┌────────────┐
│ Absensi │    │ SiswaPkl  │   │   User     │
│ Model   │    │  Model    │   │   Model    │
└─────────┘    └───────────┘   └────────────┘


┌─────────────────────────────────────────────────────┐
│            AuthController                           │
├─────────────────────────────────────────────────────┤
│ Methods:                                            │
│ + showLogin(): View                                 │
│ + login(Request): RedirectResponse                  │
│ + showRegister(): View                              │
│ + register(Request): RedirectResponse               │
│   - Create User with role='user'                    │
│   - Create SiswaPkl profile                         │
│ + logout(): RedirectResponse                        │
└─────────────────────────────────────────────────────┘


┌─────────────────────────────────────────────────────┐
│         SiswaPklController (Admin Only)              │
├─────────────────────────────────────────────────────┤
│ Methods:                                            │
│ + index(): View        - List all siswa             │
│ + create(): View       - Create form                │
│ + store(Request): Redirect  - Store siswa           │
│ + edit(id): View       - Edit form                  │
│ + update(Request): Redirect - Update siswa          │
│ + destroy(id): Redirect - Delete siswa              │
└─────────────────────────────────────────────────────┘
```

---

## Middleware Flow

```
HTTP Request
    │
    ▼
┌──────────────────────┐
│   Auth Middleware    │
│ (Cek login)          │
└──────────┬───────────┘
           │
        YES│  NO
           │  │
           ▼  ▼
       ┌─────────┐
       │ Proceed │ Redirect to login
       └────┬────┘
            │
            ▼
    ┌───────────────────┐
    │  Role Middleware  │
    │ (for admin routes)│
    └───────┬───────────┘
            │
         YES│  NO
            │  │
            ▼  ▼
        ┌─────────┐
        │ Proceed │ 403 Forbidden
        └────┬────┘
             │
             ▼
        ┌────────────────┐
        │  Route Handler │
        │   (Controller) │
        └────┬───────────┘
             │
             ▼
         Response
```

---

## Database Transaction Flow

### Absen Masuk Flow
```
1. User submit form POST /absensi/masuk
2. Controller validate siswa_pkl_id
3. IF user role='user':
     - Check if siswa_pkl_id matches user->siswaPkl
     - Return error if mismatch
4. Find or create Absensi record:
   - WHERE siswa_pkl_id = X AND tanggal = today
5. Set jam_masuk = current_time
6. IF file uploaded:
   - Store foto_masuk in storage
7. Save record
8. Redirect with success message
```

### Generate Laporan Flow
```
1. User navigate to GET /absensi/laporan
2. Controller get month & year from request
3. Query Absensi:
   - WHERE tanggal BETWEEN month start/end AND year
   - IF user role='user': AND siswa_pkl_id = user->siswaPkl->id
   - IF role='admin': get all siswa
4. Group and count by status (hadir/izin/sakit/alpha)
5. Calculate statistics per siswa
6. Render view with report data
```

---

## Security & Validation

| Fitur | Validasi | Authorization |
|-------|----------|----------------|
| Absen Masuk/Pulang | siswa_pkl_id exists | User hanya bisa untuk diri sendiri; Admin untuk siapa saja |
| Lapor Izin/Sakit | siswa_pkl_id exists, keterangan <= 255 chars | User hanya untuk diri sendiri |
| View Riwayat | - | User hanya lihat punya diri sendiri; Admin lihat semua |
| Generate Laporan | Valid month/year | User hanya lihat diri sendiri; Admin lihat semua |
| Manage Siswa | - | Admin only (CheckRole middleware) |

---

## Sequence Diagram: Login & Register

### Login Sequence
```
User          Browser       Auth Controller    User Model
 │               │                │               │
 ├──Show form───>│                │               │
 │               │                │               │
 │<──Display────┤                │               │
 │ login page   │                │               │
 │               │                │               │
 ├─Submit───────>│                │               │
 │ email/pwd    │                │               │
 │               ├──POST /login─>│               │
 │               │                ├──Query──────>│
 │               │                │ find by email│
 │               │                │<──Return────┤
 │               │                │ user record │
 │               │                │               │
 │               │                ├──Verify pwd──│
 │               │                │ with hash    │
 │               │                │               │
 │               │<──Login ok────┤               │
 │               │(set session)  │               │
 │               │                │               │
 │<──Redirect───┤                │               │
 │ to dashboard│                │               │
```

### Register Sequence (Siswa)
```
User          Browser       Auth Controller    User Model   SiswaPkl Model
 │               │                │               │               │
 ├──Show form───>│                │               │               │
 │               │<──Display────┤                │               │
 │ register      │ form          │               │               │
 │               │                │               │               │
 ├─Submit───────>│                │               │               │
 │ name/email    │                │               │               │
 │ nim/password  │                │               │               │
 │               ├─POST /register│               │               │
 │               │───────────────>│               │               │
 │               │                ├──Create──────>│               │
 │               │                │ user with    │               │
 │               │                │ role='user'  │               │
 │               │                │<─return id─┤               │
 │               │                │               │               │
 │               │                ├──────Create────────────────>│
 │               │                │ siswaPkl with user_id       │
 │               │                │<──return id─────────────────┤
 │               │                │               │               │
 │               │<──Success────┤                │               │
 │               │ message      │               │               │
 │               │ + login link │               │               │
 │               │                │               │               │
 │<──Redirect───┤                │               │               │
 │ to login     │                │               │               │
```
