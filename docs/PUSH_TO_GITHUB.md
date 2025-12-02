# 📤 Panduan Push File ke GitHub

## Langkah-Langkah Push Foto/File ke GitHub

### 1. **Verifikasi Git Configuration**
```bash
git config --global user.name
git config --global user.email
```

Pastikan nama dan email sudah benar.

---

### 2. **Add File ke Staging Area**

#### A. Add semua file yang berubah:
```bash
git add .
```

#### B. Add file spesifik:
```bash
git add docs/DIAGRAMS.md
git add "path/ke/foto.png"
```

#### C. Check status:
```bash
git status
```

---

### 3. **Commit dengan Pesan Jelas**

```bash
git commit -m "docs: tambah diagram ERD dan use case untuk sistem absensi"
```

**Format pesan commit yang baik:**
- `docs:` - Dokumentasi
- `feat:` - Feature baru
- `fix:` - Bug fix
- `style:` - Formatting
- `refactor:` - Refactoring kode

---

### 4. **Push ke Remote Repository**

```bash
git push origin main
```

Jika ditanya login, gunakan:
- **Username/Email**: altapJunior (atau user yang punya akses)
- **Password**: Token GitHub atau password (lebih baik gunakan token)

---

## ⚠️ Jika Terjadi Error "Permission Denied"

### Opsi 1: Gunakan Personal Access Token
```bash
# Di browser, buka: https://github.com/settings/tokens
# Buat token dengan scope: repo

# Kemudian push dengan:
git push https://<TOKEN>@github.com/altapJunior/web-althaaf-ujikom.git main
```

### Opsi 2: Setup SSH Key
```bash
# Generate SSH key (jika belum ada)
ssh-keygen -t rsa -b 4096 -f ~/.ssh/id_rsa

# Copy key ke GitHub: https://github.com/settings/keys
# Add remote SSH:
git remote set-url origin git@github.com:altapJunior/web-althaaf-ujikom.git

# Push:
git push origin main
```

### Opsi 3: Fork & Pull Request (Recommended)
```bash
# 1. Fork di GitHub UI
# 2. Clone fork Anda:
git clone https://github.com/FahmiFebriano/web-althaaf-ujikom.git

# 3. Add upstream untuk sync:
git remote add upstream https://github.com/altapJunior/web-althaaf-ujikom.git

# 4. Push ke fork Anda:
git push origin main

# 5. Buat Pull Request di GitHub UI
```

---

## 📂 Struktur Folder untuk Dokumentasi

```
project/
├── docs/
│   ├── DIAGRAMS.md          # Dokumentasi diagram
│   ├── SETUP.md             # Panduan setup
│   ├── API.md               # Dokumentasi API
│   └── images/              # Folder untuk foto/screenshot
│       ├── erd-diagram.png
│       ├── use-case-diagram.png
│       └── screenshot-*.png
├── ERD.md
├── UML.md
├── README.md
└── ...
```

---

## 🖼️ Menambahkan Foto/Screenshot

### 1. **Simpan foto di folder `docs/images/`**
```bash
mkdir docs/images
# Kemudian copy/paste foto ke folder ini
```

### 2. **Reference foto di Markdown**
```markdown
![Diagram ERD](docs/images/erd-diagram.png)

![Use Case Siswa](docs/images/usecase-siswa.png)
```

### 3. **Add & Commit**
```bash
git add docs/images/
git commit -m "docs: tambah diagram screenshots"
git push origin main
```

---

## ✅ Checklist Push ke GitHub

- [ ] Foto/file sudah disimpan di folder yang tepat
- [ ] Git config sudah benar (`git config --global user.name`)
- [ ] `git status` menunjukkan file yang ingin di-push
- [ ] `git add .` atau `git add <file>`
- [ ] `git commit -m "pesan yang jelas"`
- [ ] `git push origin main` tanpa error
- [ ] Verifikasi di GitHub website bahwa file sudah terupload

---

## 🔍 Verifikasi Push Berhasil

```bash
# Lihat commit history
git log --oneline -5

# Check remote
git remote -v

# Fetch latest from remote
git fetch origin

# Pull untuk memastikan up-to-date
git pull origin main
```

---

## 💡 Tips & Trik

### Push dengan force (⚠️ hati-hati!):
```bash
git push -f origin main
```

### Lihat diff sebelum commit:
```bash
git diff
git diff --staged
```

### Undo last commit (belum push):
```bash
git reset --soft HEAD~1
```

### Lihat siapa yang push:
```bash
git log --author="FahmiFebriano"
```

---

## 📞 Common Issues & Solutions

### Error: "fatal: could not read Username"
**Solusi**: Gunakan Personal Access Token atau SSH key

### Error: "origin does not appear to be a 'git' repository"
**Solusi**: `git remote -v` untuk check, atau `git remote add origin <url>`

### Error: "Your branch is ahead of 'origin/main'"
**Solusi**: `git push origin main` untuk push changes

### Error: "Please make sure you have the correct access rights"
**Solusi**: Check SSH key atau gunakan HTTPS dengan token

---

## 🎯 Ringkasan Perintah Cepat

```bash
# Setup
git config --global user.name "altapJunior"
git config --global user.email "email@example.com"

# Push changes
git status                    # Check status
git add .                     # Stage semua file
git commit -m "pesan"         # Commit dengan pesan
git push origin main          # Push ke GitHub

# Check hasil
git log --oneline -5          # Lihat commit terbaru
```

---

Siap untuk push! 🚀
