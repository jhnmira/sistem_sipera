<img width="914" height="436" alt="1 halaman utama" src="https://github.com/user-attachments/assets/35fa5c67-9576-4d9a-9022-b7ecddbe9d1c" /># SIPERA - Sistem Pencatatan Peralatan Elektronik

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

<img width="914" height="436" alt="1 halaman utama" src="https://github.com/user-attachments/assets/876be000-6408-45e1-9e40-040a42cecce8" />
<img width="956" height="434" alt="2 halaman login" src="https://github.com/user-attachments/assets/4502e90d-9e9f-49ce-83e7-c06d2ad8f749" />
<img width="956" height="438" alt="5 form tambah barang" src="https://github.com/user-attachments/assets/3f76a15b-9607-4fa9-a95f-837264757f41" />
<img width="949" height="437" alt="6 halaman tambah riwayat perawatan per alat elektronik" src="https://github.com/user-attachments/assets/db498de1-65a1-4fab-b34e-c89c03863336" />

