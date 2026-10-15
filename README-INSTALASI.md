# Panduan Cepat Menjalankan Project

## Langkah Praktis:
1. Pastikan Apache dan MySQL di XAMPP sudah berjalan (Status: hijau / Running).
2. Buka terminal PowerShell di folder ini (`c:\xampp_Old1\htdocs\galeri-laptop-laravel-p5-lengkap`).
3. Jalankan perintah migrasi dan pengisian data:
   ```powershell
   php artisan migrate:fresh --seed
   ```
4. Jalankan server Laravel:
   ```powershell
   php artisan serve
   ```
5. Buka browser (Google Chrome / Edge) di alamat:
   👉 **http://127.0.0.1:8000**

## Akun Login & Portal Terpisah:
1. **Portal Administrator**: `http://127.0.0.1:8000/login/admin`
   - Username: `admin` | Password: `admin123`
   - Hak: Akses penuh CRUD, Kategori, Supplier, Produk, Transaksi Stok.

2. **Portal Staff Gudang**: `http://127.0.0.1:8000/login/staff`
   - Username: `staff` | Password: `staff123`
   - Hak: Transaksi Stok & Lihat Katalog. Dilarang (403 Forbidden) menambah/edit/hapus produk, kategori, dan supplier.

## Demo Fitur Utama Sesuai PPT Pertemuan 5:
- **Dashboard**: Ringkasan persediaan & riwayat transaksi terbaru.
- **Produk**: Tambah, edit, hapus, detail, pencarian (search), filter kategori, sorting (terbaru, harga, stok, nama), pagination.
- **Kategori**: Manajemen kategori (Laptop, iPad, Aksesoris).
- **Supplier**: Data pemasok barang.
- **Transaksi Stok**: Pencatatan barang masuk (IN) dan barang keluar (OUT) dengan pencegahan barang keluar melebihi stok tersedia.
