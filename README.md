# Admin Akademik Modular

Aplikasi administrasi akademik PHP + MySQL/MariaDB dengan arsitektur modular/feature-based.

## Modul saat ini
- Dashboard
- Dosen
- Mahasiswa
- Import / Export
  - Import Excel/CSV dengan SheetJS preview
  - Import ke database melalui endpoint PHP
  - Export CSV
  - Download template CSV

## Teknologi
- PHP 8+
- PDO
- MySQL/MariaDB
- Bootstrap 5
- Bootstrap Icons
- SheetJS
- Session authentication
- CSRF token untuk form utama

## Struktur

app/
  config/
  core/
  helpers/
  modules/
    dashboard/
    dosen/
    mahasiswa/
    import_export/
  views/
    layouts/

database/
  database.sql

public/
  index.php
  login.php
  logout.php
  assets/
  modules/
    dashboard/
    dosen/
    mahasiswa/
    import_export/

storage/
  exports/
  logs/
  uploads/

## Instalasi

1. Buat database, misalnya `admin_akademik`.
2. Import `database/database.sql`.
3. Atur koneksi di `app/config/config.php`.
4. Arahkan document root web server ke folder `public/`.
5. Pastikan PHP memiliki PDO MySQL.
6. Pastikan folder `storage` dapat ditulis oleh web server jika memakai upload/export.

Contoh:
- Apache: VirtualHost DocumentRoot ke `/path/admin-akademik-modular/public`
- Nginx: root `/path/admin-akademik-modular/public`

## Login demo

Email: admin@localhost
Password: password

Jika database sudah pernah diisi, jalankan ulang bagian seed user pada database.sql atau ubah password melalui database.

## Catatan arsitektur

Setiap fitur diletakkan di:
`app/modules/<nama_fitur>/`

Sebuah modul idealnya memiliki:
- Controller.php
- Model.php
- routes.php
- views/

Entry point publik hanya meneruskan request ke controller modul. Dengan pola ini fitur baru dapat ditambahkan tanpa membuat satu file `index.php` menjadi sangat besar.

## Pengembangan berikutnya

Arsitektur ini siap diperluas dengan:
- Program Studi
- Mata Kuliah
- Kelas
- Jadwal
- User & Role
- Activity Log
- Laporan
- Tracer Study
- REST API

## Perilaku Import Data

Import menggunakan **update parsial** untuk data yang sudah ada:
- Dosen dicocokkan berdasarkan NIDN.
- Mahasiswa dicocokkan berdasarkan NIM.
- Jika record sudah ada, kolom yang kosong pada file **tidak mengubah data lama**.
- Kolom yang berisi nilai baru akan diperbarui.
- Jika record belum ada, data baru dibuat seperti biasa.

Contoh:
`NIM=123, Nama=andi, Angkatan=2025` di database lalu file `NIM=123, Nama=Andi, Angkatan=` akan menghasilkan `NIM=123, Nama=Andi, Angkatan=2025`.

## Struktur Data Dosen

Data Dosen menggunakan kolom:
- NIDN
- Nama
- NIP
- Email
- Jabatan
- Pangkat

`NIDN` adalah identifier unik untuk pencocokan saat import.

## Struktur Data Dosen

Database Dosen mengikuti data pada template `template_dsn.xlsx`:
- NIP
- NIDN
- Gelar Depan
- Nama
- Gelar Belakang
- Jabatan Akademik
- Pendidikan Terakhir
- Golongan (ditampilkan sebagai Pangkat)
- Status
- Homebase
- Email

Pada tabel halaman Dosen, kolom yang ditampilkan adalah:
`NIDN`, `NAMA`, `NIP`, `EMAIL`, `JABATAN`, dan `PANGKAT`.

Untuk import, `NIDN` menjadi identifier unik. `GOLONGAN` dari template dipetakan ke field database `pangkat`.


## DataTables

Tabel Dosen dan Mahasiswa menggunakan DataTables:
- 25 data per halaman secara default
- pilihan 10, 25, 50, atau 100 data
- pencarian
- sorting
- informasi jumlah data
- scroll horizontal pada layar kecil

Saat ini seluruh data masih diambil dari database lalu dipaginasi di browser. Ini cocok untuk ratusan hingga beberapa ribu data. Jika nanti jumlah data menjadi sangat besar, gunakan server-side processing.
