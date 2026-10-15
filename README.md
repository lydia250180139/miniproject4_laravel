# Galeri Laptop Inventory Management System (Laravel 12 — Pertemuan 5)

Project migrasi dan implementasi **Inventory Management System (P4 PHP Native ke Laravel 12 P5)** sesuai capaian pembelajaran dan rubrik penilaian slide perkuliahan *Pertemuan 5: Laravel Fundamental*.

---

## 🎯 Capaian Pembelajaran & Fitur yang Diimplementasikan
1. **Laravel Environment**:
   - PHP 8.2 (ZTS x64) terintegrasi.
   - Composer dependency management.
   - Konfigurasi `.env` (Database `galeri_laptop`, `APP_KEY` ter-generate).
   - Penggunaan Artisan CLI untuk migration, seeder, tinker, dan test.
2. **Arsitektur MVC (Request → Response)**:
   - Request → Route → Controller → Model & Eloquent → MySQL Database → Blade View / Redirect Response.
3. **Routing**:
   - Resource route: `Route::resource('products', ProductController::class)`.
   - Route grouping dengan middleware `guest` dan `auth`.
   - Named routes untuk redirection dan form action yang aman.
4. **Controller & Validation**:
   - Pola 7 method resource: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`.
   - Server-side request validation dengan custom error message dan old input value.
5. **Blade Template Engine**:
   - Base layout di `resources/views/layouts/app.blade.php`.
   - Reusable layout partial `layouts.navigation`.
   - Reusable Blade component: `<x-alert>` di `resources/views/components/alert.blade.php`.
   - Directive Blade: `@csrf`, `@method('PUT' / 'DELETE')`, `@error`, `@forelse`, `@empty`, `@selected`.
6. **Database, Migration, Factory & Seeder**:
   - Database migrations untuk tabel `users`, `categories`, `suppliers`, `products`, `stock_movements`.
   - Factory dummy generator: `CategoryFactory` dan `ProductFactory`.
   - Seeder siap pakai via `DatabaseSeeder` (`php artisan migrate:fresh --seed`).
7. **Eloquent ORM & Business Rules**:
   - Relationship `Category hasMany Product` dan `Product belongsTo Category`.
   - Relationship `Product hasMany StockMovement`.
   - Fitur katalog: **Pencarian (Search)**, **Filter Kategori**, **Sorting multi-kolom**, dan **Pagination** dengan query string terjaga (`withQueryString()`).
   - Aturan bisnis stok P4: Mutasi masuk (`IN`) dan keluar (`OUT`), validasi stok keluar tidak boleh melebihi stok yang tersedia.

---

## 🔑 Portal Login Terpisah & Akun Demo

Aplikasi memiliki **dua portal login berbeda** dengan pembatasan hak akses (Role-Based Access Control) dan halaman larangan akses (HTTP 403 Forbidden):

| Portal | URL Route | Akun Demo | Hak Akses Utama |
| :--- | :--- | :--- | :--- |
| **Portal Administrator** | `http://127.0.0.1:8000/login/admin` | Username: `admin`<br>Password: `admin123` | Akses penuh (Dashboard, CRUD Produk + Hapus, CRUD Kategori, CRUD Supplier, Transaksi Stok). |
| **Portal Staff Gudang** | `http://127.0.0.1:8000/login/staff` | Username: `staff`<br>Password: `staff123` | Akses operasional (Dashboard, Lihat Katalog Produk, Catat Transaksi Stok Barang Masuk/Keluar). |

### 🚫 Akses Terlarang (403 Forbidden) yang Diterapkan:
1. **Pencegahan Silang Login**:
   - Jika akun `staff` mencoba masuk melalui Portal Admin → Sistem menolak dengan pesan: *"Akses Terlarang! Akun ini bertipe Staff. Anda dilarang masuk melalui Portal Admin."*
   - Jika akun `admin` mencoba masuk melalui Portal Staff → Sistem menolak dengan pesan: *"Akses Terlarang! Akun ini adalah Administrator. Silakan gunakan Portal Administrator."*
2. **Pembatasan Halaman & Aksi (Middleware `role:admin`)**:
   - Staff **DILARANG** membuka menu Tambah Produk (`GET /products/create`) dan Simpan Produk (`POST /products`).
   - Staff **DILARANG** mengedit atau menghapus produk (`PUT/DELETE /products/{id}`).
   - Staff **DILARANG** mengelola Kategori (`/categories/*`) dan Supplier (`/suppliers/*`).
   - Jika Staff mencoba mengakses URL tersebut langsung dari browser, sistem akan memicu respons **HTTP 403 Forbidden** dan menampilkan halaman khusus **403 Akses Terlarang**.

---

## ⚙️ Petunjuk Menjalankan Project

### 1. Prasyarat
- XAMPP berjalan (Apache & MySQL aktif).
- PHP 8.2 (sudah dihubungkan ke `C:\xampp_Old1\php`).

### 2. Jalankan Perintah Artisan
Buka terminal PowerShell pada direktori project:
```powershell
cd c:\xampp_Old1\htdocs\galeri-laptop-laravel-p5-lengkap

# 1. Pastikan Application Key sudah aktif
php artisan key:generate

# 2. Buat tabel dan isi data awal (seeder)
php artisan migrate:fresh --seed

# 3. Jalankan pengujian otomatis (Feature Test)
php artisan test

# 4. Jalankan development server
php artisan serve
```

### 3. Buka Aplikasi di Browser
Akses link berikut:
👉 **http://127.0.0.1:8000** (otomatis diarahkan ke halaman login)

---

## 🧪 Demonstrasi Satu Alur Lengkap Sesuai Permintaan PPT
Berikut adalah alur lengkap **Membuka Form → Validasi Gagal & Berhasil → Simpan ke Database → Redirect → Tampilkan Data**:

1. **Login**: Buka `http://127.0.0.1:8000`, masukkan username `admin` dan password `password`.
2. **Buka Form Tambah Produk**:
   - Klik menu **Produk** di sidebar.
   - Klik tombol **+ Tambah Produk** (mengarah ke route `products.create` / URL `/products/create`).
3. **Uji Validasi Error**:
   - Kosongkan isian atau ketikkan input yang tidak valid, lalu tekan tombol **Simpan Produk**.
   - Sistem akan memicu validasi form dan menampilkan pesan error merah di bawah setiap input (`@error`) dan pesan alert `<x-alert type="error">`.
4. **Simpan Data Valid**:
   - Isi form dengan data contoh:
     - SKU: `LPT-009`
     - Nama Produk: `ASUS ROG Zephyrus G14`
     - Kategori: `Laptop`
     - Harga: `24500000`
     - Stok: `5`
     - Minimum Stok: `2`
     - Deskripsi: `Laptop gaming premium ultra-portable`
   - Klik tombol **Simpan Produk**.
5. **Redirect & Tampilkan Data**:
   - Controller menyimpan data produk baru ke tabel database `products` dan mencatat stok awal ke `stock_movements`.
   - Controller melakukan redirect ke `route('products.index')` disertai session flash message.
   - Halaman menampilkan notifikasi sukses hijau: *"Produk berhasil ditambahkan."*
   - Produk yang baru ditambahkan langsung muncul pada tabel daftar produk.

---

## 🏗️ Penjelasan Arsitektur MVC Pertemuan 5
Alur kerja data dalam aplikasi ini mengikuti standar arsitektur MVC Laravel:

```
[Browser / Klien]
       │  (HTTP Request: e.g. POST /products)
       ▼
 [routes/web.php] ──▶ Mengarahkan request ke ProductController@store
       │
       ▼
[ProductController] ──▶ Validasi input Request ($request->validate([...]))
       │
       ▼
 [App\Models\Product] ──▶ Eloquent ORM berinteraksi dengan tabel 'products'
       │
       ▼
[Database MySQL] ──▶ Query INSERT dieksekusi secara aman (Prepared Statement)
       │
       ▼
[ProductController] ──▶ Menerima hasil penyimpanan & membuat Response Redirect
       │
       ▼
[resources/views] ──▶ Template Blade (index.blade.php + layout app) me-render HTML
       │
       ▼
[Browser / Klien] ──▶ Menerima Response 200 OK dengan tampilan produk baru
```

---

## 🛠️ Riwayat Perbaikan Masalah (Troubleshooting Log)
Bagi referensi jika sebelumnya project mengalami error:
1. **Penyebab Utama "Gak Bisa-bisa"**:
   - Environment Windows sebelumnya mengarah ke `C:\xampp\php\php.exe` (PHP versi 8.0.30).
   - Laravel 12 membutuhkan minimal PHP 8.2 (menggunakan fitur PHP 8.2 seperti *readonly classes*).
   - Akibatnya Artisan selalu crash dengan pesan: `PHP Parse error: syntax error, unexpected identifier "readonly"`.
   - **Solusi**: Dibuat NTFS Directory Junction dari `C:\xampp\php` menuju `C:\xampp_Old1\php` (PHP 8.2.12), sehingga perintah `php` dan `composer` di terminal manapun langsung menjalankan PHP 8.2 secara konsisten.
2. **Kunci Enkripsi (`APP_KEY`)**:
   - Nilai `APP_KEY` pada file `.env` awalnya kosong, sekarang sudah di-generate dengan `php artisan key:generate`.
3. **Base Controller**:
   - File `app/Http/Controllers/Controller.php` awalnya tidak ada, menyebabkan error `Class "App\Http\Controllers\Controller" not found`. Telah dibuat kelas abstrak base controller.
4. **Fitur Pertemuan 5 Dilengkapi**:
   - Ditambahkan factory `CategoryFactory` dan `ProductFactory`.
   - Ditambahkan komponen Blade `<x-alert>` dan partial layout `navigation`.
   - Ditambahkan sorting multi-opsi (Nama, Harga, Stok, Terbaru) yang mempertahankan query string pagination.
   - Ditambahkan automated test `tests/Feature/ProductFlowTest.php` untuk verifikasi alur kerja.

---

## Unggah Project ke GitHub (Windows)

1. Buat repository baru yang kosong di GitHub, tanpa README, license, atau `.gitignore`.
2. Jalankan PowerShell di folder project dan eksekusi:

   ```powershell
   powershell -ExecutionPolicy Bypass -File .\push-to-github.ps1
   ```

3. Saat diminta, masukkan URL repository GitHub. Skrip akan membuat commit lalu push ke branch aktif. Autentikasi dilakukan melalui Git Credential Manager atau kunci SSH yang sudah dikonfigurasi.

File `.env`, `vendor`, dan cache PHPUnit tidak disertakan. Skrip tidak memakai force-push; bila repository remote memiliki riwayat yang berbeda, push akan gagal dan riwayat perlu diselaraskan terlebih dahulu.
