# 🚀 QUICK START - BEFORE HOSTING

## ⚡ LOCAL TESTING (HARUS DIKERJAKAN SEKARANG)

### 1️⃣ Run Migrations Baru
```bash
php artisan migrate
```

### 2️⃣ Create Storage Link
```bash
php artisan storage:link
```

### 3️⃣ Test Admin Login
- Pastikan punya akun admin
- Login ke `/login`
- Menu `/produk` harus accessible

### 4️⃣ Test Kategori (Cek 5 menit)
```
✅ Masuk menu Kategori
✅ Tambah kategori baru dengan gambar
✅ Gambar terlihat
✅ Edit kategori
✅ Delete kategori
```

### 5️⃣ Test Produk (Cek 10 menit)
```
✅ Masuk menu Produk  
✅ Tambah produk baru (pilih kategori!)
✅ Upload gambar produk
✅ Gambar terlihat
✅ Edit produk
✅ Delete produk
```

### 6️⃣ Test Security (SANGAT PENTING!)
```bash
# Logout dulu
# Coba akses: http://localhost:8000/produk
❌ HARUS redirect ke login (BUKAN boleh akses)

# Login sebagai user biasa (bukan admin)
# Coba akses: http://localhost:8000/produk
❌ HARUS dapat error 403 (BUKAN boleh akses)
```

---

## 🌐 SAAT DI-HOSTING (PRIORITY ORDER)

### 1️⃣ Upload Semua Files (prioritas utama)
```
Files baru yang WAJIB:
- database/migrations/2026_02_01_100000_create_kategoris_table.php
- database/migrations/2026_02_01_100001_create_produk_table.php
- database/migrations/2026_02_01_100002_create_order_items_table.php
- DEPLOYMENT_GUIDE.md (dokumentasi)
```

### 2️⃣ SSH ke Hosting (atau cPanel Terminal)
```bash
cd /path/to/project
```

### 3️⃣ Install & Setup
```bash
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan storage:link
php artisan config:cache
```

### 4️⃣ Verify Upload Works
- Login admin
- Upload kategori dengan gambar
- Upload produk dengan kategori
- Cek gambar muncul di browser

### 5️⃣ Done! ✅

---

## 📋 JIKA FORGOT STEPS, BACA:
```
📖 DEPLOYMENT_GUIDE.md (file lengkap di project root)
```

---

## 🆘 TROUBLESHOOT QUICK FIXES

| Masalah | Solusi |
|---------|--------|
| "The disk [public] does not exist" | `php artisan storage:link` |
| Gambar tidak muncul | Check: `php artisan storage:link` + `chmod -R 755 storage` |
| Migration error | Check: database connection di `.env` |
| Can't login admin | Check: admin user role di database = "admin" |
| "Akses ditolak" saat upload | Check: user role di database harus "admin" |

---

## ✨ YANG SUDAH DIFIX:

✅ **Models** - Produk & Kategori sekarang proper Model
✅ **Migrations** - Ada 3 migration files baru untuk tables
✅ **File Upload** - Gunakan Storage facade (aman untuk hosting)
✅ **Security** - Admin routes protected dengan middleware auth + role:admin
✅ **Foreign Keys** - Produk -> Kategori relationship proper

**SEMUA SIAP UNTUK HOSTING! 🎉**
