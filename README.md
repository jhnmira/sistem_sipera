# SIPERA - Sistem Pencatatan Peralatan Elektronik

Sistem pencatatan dan monitoring peralatan elektronik untuk keperluan maintenance kantor. Dikembangkan selama program magang di BPS Kota Yogyakarta (semester 7).

## Fitur

- Login khusus admin
- Tambah, ubah, hapus, dan cari data aset elektronik
- Riwayat perawatan per aset
- Jadwal servis berikutnya dihitung otomatis dari tanggal servis terakhir dan interval servis
- Ekspor dan impor data ke Excel
- Dashboard ringkasan

## Teknologi

Laravel 11, PHP 8.2, MySQL, Tailwind CSS 3, Vite, Laravel Excel (Maatwebsite), Carbon

## Struktur Database

- `users`: akun admin
- `items`: data aset (nama, kode barang, NUP, merek, nomor seri, lokasi, kondisi, jadwal servis)
- `maintenance_records`: riwayat perawatan (relasi satu aset ke banyak riwayat)

## Cara Menjalankan

1. Clone repo, lalu masuk ke foldernya
2. Pasang dependensi:
   ```
   composer install
   npm install
   npm run build
   ```
3. Salin `.env.example` menjadi `.env`, lalu atur database MySQL (`DB_CONNECTION=mysql`, `DB_DATABASE`, dst.)
4. Buat kunci aplikasi dan tabel:
   ```
   php artisan key:generate
   php artisan migrate
   ```
5. Jalankan server:
   ```
   php artisan serve
   ```
6. Buka `http://127.0.0.1:8000`

Catatan: ekstensi PHP `gd` dan `zip` harus aktif (dibutuhkan fitur Excel).

## Tampilan

_Tambahkan screenshot halaman login, dashboard, daftar aset, dan riwayat perawatan di sini._
