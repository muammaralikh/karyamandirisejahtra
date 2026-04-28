# 📋 PROJECT91 - DEPLOYMENT GUIDE

## ✅ FIXES YANG SUDAH DILAKUKAN

### 1. ✔️ MIGRATION FILES (KRITIS)
- `2026_02_01_100000_create_kategoris_table.php` - Kategori table structure
- `2026_02_01_100001_create_produk_table.php` - Produk table structure dengan foreign key
- `2026_02_01_100002_create_order_items_table.php` - OrderItem table untuk relasi

### 2. ✔️ MODEL FIXES
- **Produk.php** - Berubah dari `extends Authenticatable` → `extends Model` (PENTING!)
- **Kategori.php** - Berubah dari `extends Authenticatable` → `extends Model` (PENTING!)

### 3. ✔️ FILE STORAGE REFACTORING
- **ProdukController.php** - Gunakan `Storage::disk('public')` bukan `public_path()`
- **KategoriController.php** - Gunakan `Storage::disk('public')` bukan `public_path()`
- Validasi gambar ditambah: `'gambar' => 'nullable|image|max:2048'`
- File path terstruktur: `produk/` dan `kategori/` subdirectories

### 4. ✔️ SECURITY - MIDDLEWARE PROTECTION
- Route `/produk/*` → Protected dengan `['auth', 'role:admin']`
- Route `/kategori/*` → Protected dengan `['auth', 'role:admin']`
- Route `/pesanan/*` → Protected dengan `['auth', 'role:admin']`
- Route `/daftar-user/*` → Protected dengan `['auth', 'role:admin']`

---

## 🚀 SEBELUM HOSTING - LOCAL TESTING

### LANGKAH 1: Run Migrations
```bash
php artisan migrate
```
✅ Ini akan buat table: `kategoris`, `produk`, `order_items`

### LANGKAH 2: Create Symbolic Link untuk Storage
```bash
php artisan storage:link
```
✅ Ini menciptakan symlink: `public/storage` → `storage/app/public`

### LANGKAH 3: Test Fitur Produk & Kategori

#### A. Buat Kategori
1. Login sebagai admin
2. Ke menu Kategori
3. Tambah kategori baru dengan nama & gambar
4. Verifikasi:
   - ✅ Kategori muncul di list
   - ✅ Gambar tersimpan di `storage/app/public/kategori/`
   - ✅ Gambar bisa dilihat melalui `public/storage/kategori/xxx.jpg`

#### B. Buat Produk
1. Login sebagai admin
2. Ke menu Produk
3. Tambah produk dengan:
   - Nama, harga, stok, deskripsi
   - Pilih kategori yang sudah dibuat
   - Upload gambar
4. Verifikasi:
   - ✅ Produk muncul di list dengan kategori yang benar
   - ✅ Gambar tersimpan di `storage/app/public/produk/`
   - ✅ Gambar bisa dilihat

#### C. Edit & Delete
1. Edit produk (ganti gambar atau data lain)
   - ✅ Gambar lama terhapus
   - ✅ Gambar baru tersimpan
2. Delete produk
   - ✅ Produk hilang dari list
   - ✅ File gambar terhapus

#### D. Test Public Features
1. Halaman `/produk-showall` - Tampilkan semua produk ✅
2. Halaman `/kategori` - Tampilkan semua kategori ✅
3. Rute `/produk/kategori/{id}` - Tampilkan produk per kategori ✅

#### E. Test Security (PENTING!)
1. Logout
2. Coba akses `/produk` (admin page)
   - ❌ Harus redirect ke login (JANGAN bisa akses)
3. Login sebagai user (bukan admin)
4. Coba akses `/produk` (admin page)
   - ❌ Harus dapat error 403 Forbidden (JANGAN bisa akses)

---

## 🌐 SAAT HOSTING

### LANGKAH 1: Deploy Code
```bash
# Upload semua files ke server, termasuk migrations yang baru
git push origin main  # atau deploy method yang Anda gunakan
```

### LANGKAH 2: Install Dependencies (di Server)
```bash
composer install --optimize-autoloader --no-dev
```

### LANGKAH 3: Create Storage Symbolic Link (di Server)
```bash
php artisan storage:link
```
⚠️ **PENTING!** Ini harus dijalankan sekali saja di hosting untuk membuat symlink

### LANGKAH 4: Run Migrations (di Server)
```bash
php artisan migrate --force
```
✅ Ini akan membuat tabel di database production

### LANGKAH 5: Set Permissions (di Server)
```bash
# Untuk Linux/Unix hosting
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### LANGKAH 6: Clear Cache (di Server)
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## ✅ POST-HOSTING VERIFICATION

### Cek 1: Database Tables
```bash
# SSH ke server, jalankan:
php artisan tinker
# Kemudian:
>> \App\Models\Kategori::count()  // Harus ada data
>> \App\Models\Produk::count()     // Harus ada data
```

### Cek 2: File Upload Berfungsi
1. Login ke admin panel
2. Tambah kategori baru dengan gambar
3. Lihat file tersimpan:
   ```bash
   ls -la storage/app/public/kategori/
   ```
4. Akses gambar via browser: `https://yoursite.com/storage/kategori/xxx.jpg`

### Cek 3: Produk Upload + Kategori
1. Tambah produk baru dengan kategori
2. Verifikasi:
   - ✅ Produk muncul dengan kategori yang benar
   - ✅ Gambar muncul
   - ✅ Bisa di-edit & di-delete

### Cek 4: Security
1. Logout
2. Coba akses `/produk`
   - ❌ Harus redirect ke login
3. Coba akses dengan akun user biasa
   - ❌ Harus dapat 403 Forbidden

### Cek 5: Public Pages
1. `/produk-showall` - Tampilkan produk
2. `/kategori` - Tampilkan kategori
3. `/produk/kategori/{id}` - Tampilkan produk per kategori

---

## ⚠️ COMMON ISSUES & SOLUTIONS

### ISSUE 1: "The disk [public] does not exist"
**Solusi:**
```bash
php artisan storage:link
```

### ISSUE 2: Gambar tidak muncul di hosting
**Solusi:**
1. Pastikan symlink sudah dibuat: `php artisan storage:link`
2. Check permission folder: `chmod -R 755 storage`
3. Cek `.env`:
   ```
   FILESYSTEM_DISK=public
   ```

### ISSUE 3: Upload produk error "too large"
**Solusi:** Update `php.ini` di hosting:
```
upload_max_filesize = 10M
post_max_size = 10M
```

### ISSUE 4: "Kategori yang dipilih tidak valid"
**Solusi:**
1. Pastikan kategori sudah dibuat sebelum membuat produk
2. Pastikan migration kategori sudah dijalankan terlebih dahulu

### ISSUE 5: Middleware error "Akses ditolak"
**Solusi:**
1. Pastikan user memiliki role = 'admin' di database
2. Check: `SELECT role FROM users WHERE id = 1;`

---

## 📝 ENVIRONMENT VARIABLES (.env)

Pastikan di hosting `.env` ada:
```
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=your-hosting-db-host
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password
FILESYSTEM_DISK=public
```

---

## 🎯 CHECKLIST FINAL

Sebelum go-live, pastikan:

- [ ] Migrations sudah dijalankan di hosting
- [ ] Storage symlink sudah dibuat: `php artisan storage:link`
- [ ] Bisa login sebagai admin
- [ ] Bisa buat, edit, delete kategori dengan gambar
- [ ] Bisa buat, edit, delete produk dengan gambar + kategori
- [ ] User biasa TIDAK bisa akses menu admin
- [ ] Gambar terlihat di public pages
- [ ] Menu untuk user berfungsi normal
- [ ] Cart & checkout tetap berfungsi
- [ ] Upload gambar produk bekerja dengan baik
- [ ] Produk kategori terassosiasi dengan benar

---

## 🆘 JIKA ADA MASALAH

1. **Check error log:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **SSH ke hosting & jalankan:**
   ```bash
   php artisan migrate --force
   php artisan storage:link
   php artisan config:cache
   php artisan cache:clear
   ```

3. **Hubungi hosting provider jika:**
   - Tidak bisa akses SSH
   - Database tidak bisa diakses
   - File permissions tidak bisa diubah

---

**PENTING:** Jangan lupa backup database sebelum hosting! 🔒
