# Dokumentasi Admin Akademik Modular

## 1. Pendahuluan

**Admin Akademik Modular** adalah aplikasi administrasi akademik berbasis:

- PHP
- MySQL / MariaDB
- PDO
- Bootstrap 5
- Bootstrap Icons
- JavaScript
- SheetJS untuk membaca file Excel di browser

Aplikasi saat ini memiliki beberapa bagian utama:

1. **Dashboard**
2. **Data Dosen**
3. **Data Mahasiswa**
4. **Import / Export**
5. **Login dan Logout**

Aplikasi dibuat dengan pendekatan **modular / feature-based**.

Artinya, setiap fitur utama dipisahkan ke dalam modul sendiri. Tujuannya agar aplikasi mudah dikembangkan.

Contohnya, jika suatu hari ingin menambahkan:

- Program Studi
- Mata Kuliah
- Kelas
- Jadwal
- Ruang
- User
- Role / Permission
- Tracer Study
- Surat
- Arsip
- Laporan

kita tidak perlu membuat ulang aplikasi dari awal. Kita cukup menambahkan modul baru dengan pola yang sama.

---

# 2. Konsep Sederhana Arsitektur Aplikasi

Untuk memahami aplikasi ini, bayangkan alurnya seperti berikut:

```text
Browser
   │
   ▼
public/
   │
   ▼
Controller
   │
   ├── Model ──────► Database
   │
   └── View ───────► Tampilan HTML
```

Contoh ketika pengguna membuka halaman mahasiswa:

```text
Browser
   │
   ▼
public/mahasiswa.php
   │
   ▼
MahasiswaController
   │
   ├── MahasiswaModel
   │       │
   │       ▼
   │    Database
   │
   └── View
        │
        ▼
     Tampilan mahasiswa
```

Jadi secara sederhana:

- **Public** = pintu masuk dari browser
- **Controller** = mengatur proses
- **Model** = berkomunikasi dengan database
- **View** = menampilkan halaman
- **Config** = pengaturan aplikasi dan database
- **Helpers** = fungsi bantuan yang dipakai banyak bagian
- **Storage** = tempat file/log
- **Database** = struktur dan data aplikasi

---

# 3. Struktur Folder

Struktur aplikasi saat ini:

```text
admin-akademik-modular/
│
├── README.md
│
├── app/
│   │
│   ├── config/
│   │   ├── config.php
│   │   └── database.php
│   │
│   ├── core/
│   │   └── bootstrap.php
│   │
│   ├── helpers/
│   │   ├── auth.php
│   │   ├── csrf.php
│   │   ├── response.php
│   │   └── view.php
│   │
│   ├── modules/
│   │   │
│   │   ├── dashboard/
│   │   │   ├── DashboardController.php
│   │   │   └── DashboardModel.php
│   │   │
│   │   ├── dosen/
│   │   │   ├── DosenController.php
│   │   │   ├── DosenModel.php
│   │   │   ├── routes.php
│   │   │   └── views/
│   │   │
│   │   ├── mahasiswa/
│   │   │   ├── MahasiswaController.php
│   │   │   ├── MahasiswaModel.php
│   │   │   ├── routes.php
│   │   │   └── views/
│   │   │
│   │   └── import_export/
│   │       ├── ImportExportController.php
│   │       ├── routes.php
│   │       └── views/
│   │
│   └── views/
│       ├── dashboard/
│       ├── dosen/
│       ├── mahasiswa/
│       ├── import_export/
│       └── layouts/
│
├── database/
│   └── database.sql
│
├── public/
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   │
│   ├── dosen.php
│   ├── dosen-form.php
│   ├── dosen-save.php
│   ├── dosen-delete.php
│   │
│   ├── mahasiswa.php
│   ├── mahasiswa-form.php
│   ├── mahasiswa-save.php
│   ├── mahasiswa-delete.php
│   │
│   ├── import-export.php
│   ├── import-process.php
│   ├── export.php
│   ├── template.php
│   │
│   └── assets/
│       ├── css/
│       │   └── app.css
│       │
│       └── js/
│           ├── app.js
│           └── excel-import.js
│
└── storage/
    ├── uploads/
    ├── exports/
    └── logs/
```

---

# 4. Folder `app/`

Folder `app` berisi **kode utama aplikasi**.

Folder ini sebaiknya tidak dapat diakses langsung oleh pengguna melalui browser.

Contohnya:

```text
app/
├── config/
├── core/
├── helpers/
└── modules/
```

---

# 5. Folder `app/config/`

Folder ini berisi konfigurasi aplikasi.

## 5.1 `config.php`

File:

```text
app/config/config.php
```

Berisi pengaturan seperti:

```php
define('APP_NAME', 'Admin Akademik');

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'admin_akademik');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### Fungsi

File ini digunakan untuk menentukan:

- nama aplikasi
- alamat database
- nama database
- username database
- password database
- lokasi storage
- mode aplikasi

### Jika pindah server

Biasanya file pertama yang perlu diperiksa adalah:

```text
app/config/config.php
```

Misalnya database server memiliki password:

```php
define('DB_USER', 'admin');
define('DB_PASS', 'password_database');
```

Jangan menyimpan password database di dalam file yang bisa diakses langsung melalui web.

---

## 5.2 `database.php`

File:

```text
app/config/database.php
```

Fungsinya membuat koneksi PDO ke MySQL/MariaDB.

Koneksi dibuat secara terpusat sehingga model tidak perlu membuat koneksi database sendiri-sendiri.

Contoh penggunaannya:

```php
$db = Database::connection();
```

### Kenapa dibuat terpusat?

Tanpa sistem seperti ini, setiap model mungkin akan membuat koneksi:

```php
new PDO(...);
```

berulang-ulang.

Dengan `Database::connection()`, semua model menggunakan mekanisme koneksi yang sama.

---

# 6. Folder `app/core/`

Saat ini berisi:

```text
app/core/bootstrap.php
```

## `bootstrap.php`

File ini adalah salah satu file penting.

File ini memanggil:

- konfigurasi
- database
- authentication helper
- CSRF helper
- view helper
- response helper
- session

Contoh:

```php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/auth.php';
```

Kemudian halaman public cukup menjalankan:

```php
require_once __DIR__ . '/../app/core/bootstrap.php';
```

### Tujuannya

Agar setiap halaman tidak perlu menulis semua `require_once` tersebut satu per satu.

---

# 7. Folder `app/helpers/`

Helper adalah kumpulan fungsi kecil yang digunakan oleh banyak bagian aplikasi.

Saat ini terdapat:

```text
app/helpers/
├── auth.php
├── csrf.php
├── response.php
└── view.php
```

---

## 7.1 `auth.php`

Mengatur autentikasi pengguna.

Fungsi utamanya:

```php
is_logged_in()
require_login()
login_user()
logout_user()
```

### Contoh

Untuk memastikan pengguna sudah login:

```php
require_login();
```

Jika belum login, pengguna akan diarahkan ke halaman login.

### Jangan membuat sistem login baru di setiap modul

Misalnya modul baru:

```text
Program Studi
```

tidak perlu membuat:

```text
prodi_login.php
```

Cukup:

```php
require_login();
```

---

# 8. `csrf.php`

CSRF adalah mekanisme keamanan untuk memastikan request POST berasal dari halaman aplikasi yang benar.

Contoh pada form:

```php
<?= csrf_field() ?>
```

Kemudian controller memeriksa:

```php
verify_csrf($_POST['_csrf'] ?? null)
```

Ini terutama penting untuk:

- tambah data
- edit data
- hapus data
- proses perubahan data

### Jangan menghilangkan CSRF

Jika membuat modul baru yang memiliki form POST, gunakan pola yang sama.

---

# 9. `response.php`

Berisi fungsi bantuan untuk response aplikasi.

Contohnya:

```php
redirect()
flash()
pull_flashes()
```

## Flash message

Flash message digunakan untuk menampilkan informasi seperti:

```text
Data berhasil disimpan.
Data berhasil dihapus.
Import berhasil.
Terjadi kesalahan.
```

Contoh:

```php
flash('success', 'Data berhasil disimpan.');
redirect('mahasiswa.php');
```

---

# 10. `view.php`

File ini membantu menampilkan View.

Fungsi:

```php
render()
```

Selain itu terdapat fungsi:

```php
e()
```

yang digunakan untuk melakukan escaping output HTML.

Contoh:

```php
<?= e($row['nama']) ?>
```

### Kenapa menggunakan `e()`?

Untuk membantu mencegah output HTML berbahaya dimasukkan langsung ke halaman.

Biasakan menggunakan:

```php
<?= e($data) ?>
```

daripada:

```php
<?= $data ?>
```

untuk data yang berasal dari database atau input pengguna.

---

# 11. Folder `app/modules/`

Ini adalah bagian terpenting dari arsitektur modular.

```text
app/modules/
├── dashboard/
├── dosen/
├── mahasiswa/
└── import_export/
```

Setiap folder mewakili **satu fitur/modul**.

Konsepnya:

```text
Satu folder = satu fitur
```

Contoh:

```text
app/modules/dosen/
```

berisi seluruh logika utama yang berhubungan dengan Dosen.

---

# 12. Modul Dashboard

Lokasi:

```text
app/modules/dashboard/
├── DashboardController.php
└── DashboardModel.php
```

## `DashboardController.php`

Controller mengatur halaman dashboard.

Tugasnya antara lain:

- memastikan user sudah login
- mengambil data statistik
- memanggil view dashboard

Contoh data:

```text
Total Dosen
Dosen Aktif
Total Mahasiswa
Mahasiswa Aktif
```

---

## `DashboardModel.php`

Model bertugas mengambil statistik dari database.

Misalnya:

```sql
SELECT COUNT(*) FROM dosen
```

atau:

```sql
SELECT COUNT(*) FROM mahasiswa
WHERE status = 'aktif'
```

### Jika dashboard ingin ditambah statistik

Misalnya ingin menampilkan:

```text
Total Program Studi
```

nanti kita dapat menambahkan:

```text
ProgramStudiModel
```

atau service statistik khusus.

Untuk aplikasi yang semakin besar, statistik dashboard sebaiknya dipisahkan ke service agar `DashboardModel` tidak menjadi terlalu besar.

---

# 13. Modul Dosen

Lokasi:

```text
app/modules/dosen/
├── DosenController.php
├── DosenModel.php
├── routes.php
└── views/
```

---

## 13.1 `DosenModel.php`

Model berkomunikasi dengan database tabel:

```text
dosen
```

Tugasnya:

- mengambil data
- mencari data
- mencari berdasarkan ID
- menyimpan data
- menghapus data

Contoh:

```php
$this->model->all(...)
```

untuk mengambil data dosen.

---

## 13.2 `DosenController.php`

Controller mengatur alur halaman Dosen.

Fungsi utama:

```text
index()
form()
save()
delete()
```

### `index()`

Menampilkan daftar dosen.

### `form()`

Menampilkan form tambah/edit.

### `save()`

Menyimpan data baru atau perubahan data.

### `delete()`

Menghapus data.

---

# 14. View Dosen

View digunakan untuk tampilan.

Lokasi utama:

```text
app/views/dosen/
├── index.php
└── form.php
```

## `index.php`

Menampilkan:

- tabel dosen
- pencarian
- filter status
- tombol tambah
- tombol edit
- tombol hapus

## `form.php`

Digunakan untuk:

- tambah dosen
- edit dosen

Form tersebut memiliki field seperti:

```text
NIDN
Nama
Email
NIP
Jabatan
No HP
Jenis Kelamin
Status
```

---

# 15. Modul Mahasiswa

Lokasi:

```text
app/modules/mahasiswa/
├── MahasiswaController.php
├── MahasiswaModel.php
├── routes.php
└── views/
```

Strukturnya hampir sama dengan modul Dosen.

---

## 15.1 `MahasiswaModel.php`

Berkomunikasi dengan tabel:

```text
mahasiswa
```

Fungsinya:

- mengambil data mahasiswa
- mencari mahasiswa
- mengambil berdasarkan ID
- menyimpan mahasiswa
- menghapus mahasiswa

---

## 15.2 `MahasiswaController.php`

Memiliki fungsi:

```text
index()
form()
save()
delete()
```

---

# 16. Data Mahasiswa

Field yang tersedia:

```text
NIM
Nama
Email
Program Studi
Angkatan
Semester
Jenis Kelamin
Status
```

Status saat ini:

```text
aktif
cuti
lulus
nonaktif
```

---

# 17. Pencarian Mahasiswa

Halaman mahasiswa mendukung pencarian berdasarkan:

```text
NIM
Nama
Email
Program Studi
```

Selain itu tersedia filter:

```text
Angkatan
Status
```

Query menggunakan PDO prepared statement.

Hal ini penting untuk keamanan dan juga mencegah masalah SQL Injection.

---

# 18. Modul Import / Export

Lokasi:

```text
app/modules/import_export/
├── ImportExportController.php
├── routes.php
└── views/
```

Modul ini menangani:

- import data
- preview Excel
- validasi kolom
- export data
- download template

---

# 19. File `ImportExportController.php`

Controller ini cukup besar karena saat ini menangani beberapa fungsi:

```text
index()
import()
export()
template()
```

## `index()`

Menampilkan halaman Import / Export.

## `import()`

Memproses data import.

## `export()`

Menghasilkan file CSV.

## `template()`

Menghasilkan template CSV untuk pengguna.

---

# 20. Import Excel

Teknologi yang digunakan:

```text
SheetJS
```

Library tersebut dimuat dari CDN.

Pada browser:

```text
File Excel
    │
    ▼
SheetJS
    │
    ▼
Preview
    │
    ▼
Validasi kolom
    │
    ▼
Konversi ke CSV
    │
    ▼
PHP
    │
    ▼
Database
```

Dengan pendekatan ini aplikasi tidak memerlukan library PHP Excel tambahan untuk membaca XLSX.

---

# 21. Kolom Import Dosen

Template Dosen menggunakan:

```text
NIDN
Nama
Email
NIP
Jabatan
No HP
Jenis Kelamin
Status
```

Kolom wajib:

```text
NIDN
Nama
```

---

# 22. Kolom Import Mahasiswa

Template Mahasiswa menggunakan:

```text
NIM
Nama
Email
Prodi
Angkatan
Semester
Jenis Kelamin
Status
```

Kolom wajib:

```text
NIM
Nama
```

---

# 23. Perilaku Import yang Sangat Penting

Import sekarang menggunakan konsep:

> **Update parsial**

Artinya jika data sudah ada dan file Excel memiliki kolom kosong, data lama tidak akan dihapus.

Contoh database:

```text
NIM       = 123
Nama      = andi
Angkatan  = 2025
```

File Excel:

```text
NIM       = 123
Nama      = Andi
Angkatan  =
```

Hasil:

```text
NIM       = 123
Nama      = Andi
Angkatan  = 2025
```

Jadi:

```text
Kolom berisi nilai
        ↓
Update

Kolom kosong
        ↓
Pertahankan data lama
```

---

# 24. Cara Sistem Menentukan Data yang Sama

Untuk mahasiswa:

```text
NIM
```

digunakan sebagai identitas unik.

Untuk dosen:

```text
NIDN
```

digunakan sebagai identitas unik.

Contoh:

```text
NIM 123 ditemukan
        │
        ├── Ya → Update data yang tidak kosong
        │
        └── Tidak → Buat data baru
```

Ini disebut mekanisme **upsert secara logika**.

---

# 25. Hal yang Perlu Diperhatikan Saat Import

Jika file berisi:

```text
NIM = 123
Nama = Andi
Angkatan =
```

maka angkatan lama dipertahankan.

Namun jika file berisi:

```text
NIM = 123
Nama = Andi
Angkatan = 2026
```

maka angkatan akan menjadi:

```text
2026
```

Jadi:

```text
Kosong = jangan ubah
Berisi  = update
```

---

# 26. Export Data

Export saat ini menghasilkan:

```text
CSV
```

Tersedia:

```text
Export Dosen
Export Mahasiswa
```

File akan memiliki nama seperti:

```text
dosen_export_20260914_100000.csv
```

atau:

```text
mahasiswa_export_20260914_100000.csv
```

---

# 27. Template

Template dapat diunduh dari:

```text
Import / Export
```

Tersedia:

```text
Template Dosen
Template Mahasiswa
```

Disarankan menggunakan template tersebut ketika membuat file import sendiri.

---

# 28. Folder `public/`

Folder `public` adalah **pintu masuk aplikasi dari browser**.

Document root web server sebaiknya diarahkan ke:

```text
admin-akademik-modular/public
```

Bukan ke:

```text
admin-akademik-modular/
```

Hal ini penting untuk keamanan karena folder seperti:

```text
app/
database/
storage/
```

sebaiknya tidak dapat diakses langsung dari internet.

---

# 29. File Public untuk Dashboard

```text
public/index.php
```

Berfungsi sebagai entry point Dashboard.

Alurnya:

```text
Browser
   ↓
index.php
   ↓
bootstrap.php
   ↓
DashboardController
   ↓
DashboardModel
   ↓
Database
   ↓
View
```

---

# 30. File Public untuk Dosen

```text
public/dosen.php
```

Menampilkan daftar dosen.

```text
public/dosen-form.php
```

Menampilkan form tambah/edit.

```text
public/dosen-save.php
```

Memproses penyimpanan.

```text
public/dosen-delete.php
```

Memproses penghapusan.

### Kenapa dipisah?

Agar tugas masing-masing endpoint jelas.

---

# 31. File Public untuk Mahasiswa

```text
public/mahasiswa.php
public/mahasiswa-form.php
public/mahasiswa-save.php
public/mahasiswa-delete.php
```

Fungsinya sama seperti modul Dosen.

---

# 32. File Public untuk Import / Export

```text
public/import-export.php
```

Halaman utama Import / Export.

```text
public/import-process.php
```

Memproses import.

```text
public/export.php
```

Menghasilkan file export.

```text
public/template.php
```

Menghasilkan template.

---

# 33. Login

```text
public/login.php
```

Menangani:

- tampilan login
- verifikasi email
- verifikasi password
- session login

Password diverifikasi menggunakan:

```php
password_verify()
```

Jangan menyimpan password dalam bentuk plaintext di database.

---

# 34. Logout

```text
public/logout.php
```

Menghapus session login dan mengarahkan kembali ke halaman login.

---

# 35. Folder Assets

Lokasi:

```text
public/assets/
├── css/
└── js/
```

---

## `public/assets/css/app.css`

Berisi tampilan aplikasi seperti:

- sidebar
- dashboard
- card
- tabel
- login
- responsive layout

Jika ingin mengubah tampilan umum aplikasi, file ini adalah salah satu tempat utama.

---

## `public/assets/js/app.js`

JavaScript umum aplikasi.

Saat ini antara lain menangani perilaku umum seperti alert.

---

## `public/assets/js/excel-import.js`

JavaScript khusus Import Excel.

Tugasnya:

- membaca file
- membaca worksheet
- membaca header
- validasi kolom wajib
- menampilkan preview
- mengubah XLS/XLSX menjadi CSV sebelum dikirim ke server

Jangan menaruh JavaScript fitur lain ke file ini jika tidak berhubungan dengan import.

---

# 36. Folder `app/views/layouts/`

Berisi layout yang digunakan bersama.

```text
app/views/layouts/
├── header.php
└── footer.php
```

## `header.php`

Berisi:

- HTML awal
- Bootstrap
- Bootstrap Icons
- sidebar
- menu
- judul halaman
- flash message

## `footer.php`

Berisi:

- penutup HTML
- Bootstrap JavaScript
- JavaScript aplikasi
- JavaScript khusus halaman

### Keuntungan layout

Tanpa layout, setiap halaman harus menulis ulang:

```text
HTML
head
Bootstrap
sidebar
menu
footer
JavaScript
```

Dengan layout, semua halaman dapat menggunakan struktur yang sama.

---

# 37. Folder `database/`

```text
database/
└── database.sql
```

File ini berisi:

- pembuatan database
- tabel users
- tabel dosen
- tabel mahasiswa
- data awal / seed

---

# 38. Tabel `users`

Digunakan untuk login.

Kolom utama:

```text
id
name
email
password
role
created_at
updated_at
```

---

# 39. Tabel `dosen`

Kolom:

```text
id
nidn
nama
email
nip
jabatan
no_hp
jenis_kelamin
status
created_at
updated_at
```

`nidn` dibuat unik.

---

# 40. Tabel `mahasiswa`

Kolom:

```text
id
nim
nama
email
prodi
angkatan
semester
jenis_kelamin
status
created_at
updated_at
```

`nim` dibuat unik.

---

# 41. Folder `storage/`

Struktur:

```text
storage/
├── uploads/
├── exports/
└── logs/
```

Folder ini disiapkan untuk kebutuhan aplikasi yang lebih besar.

## `uploads/`

Untuk file upload.

## `exports/`

Untuk file hasil export jika suatu saat export tidak langsung dikirim ke browser.

## `logs/`

Untuk log aplikasi.

Saat ini folder tersebut masih menggunakan `.gitkeep` agar folder tetap ada.

---

# 42. Cara Menambahkan Modul Baru

Ini bagian yang paling penting jika ingin mengembangkan aplikasi.

Misalnya kita ingin menambahkan modul:

```text
Program Studi
```

Jangan langsung memasukkan semua kode ke:

```text
index.php
```

Buat modul sendiri.

Struktur:

```text
app/modules/prodi/
├── ProdiController.php
├── ProdiModel.php
├── routes.php
└── views/
    ├── index.php
    └── form.php
```

---

# 43. Langkah 1 — Buat Tabel Database

Tambahkan tabel:

```sql
CREATE TABLE program_studi (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(150) NOT NULL,
    jenjang VARCHAR(20),
    status ENUM('aktif','nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);
```

---

# 44. Langkah 2 — Buat Model

Buat:

```text
app/modules/prodi/ProdiModel.php
```

Model menangani:

```text
SELECT
INSERT
UPDATE
DELETE
```

Jangan menaruh HTML di Model.

Model hanya fokus pada data/database.

---

# 45. Langkah 3 — Buat Controller

Buat:

```text
app/modules/prodi/ProdiController.php
```

Controller mengatur:

```text
Request
   ↓
Validasi
   ↓
Model
   ↓
View / Redirect
```

Misalnya:

```text
index()
form()
save()
delete()
```

---

# 46. Langkah 4 — Buat View

Buat:

```text
app/modules/prodi/views/
├── index.php
└── form.php
```

`index.php`:

```text
Daftar Program Studi
```

`form.php`:

```text
Tambah/Edit Program Studi
```

---

# 47. Langkah 5 — Buat Entry Point Public

Misalnya:

```text
public/prodi.php
```

Isinya secara konsep:

```php
require_once '../app/core/bootstrap.php';
require_once '../app/modules/prodi/ProdiModel.php';
require_once '../app/modules/prodi/ProdiController.php';

(new ProdiController())->index();
```

Kemudian entry point lain dapat dibuat:

```text
public/prodi-form.php
public/prodi-save.php
public/prodi-delete.php
```

---

# 48. Langkah 6 — Tambahkan Menu

Menu utama berada di:

```text
app/views/layouts/header.php
```

Tambahkan:

```text
Program Studi
```

dengan link:

```text
prodi.php
```

---

# 49. Pola Modul yang Disarankan

Setiap modul baru sebaiknya mengikuti pola:

```text
modules/
└── nama_modul/
    ├── NamaModulController.php
    ├── NamaModulModel.php
    ├── routes.php
    └── views/
        ├── index.php
        ├── form.php
        └── detail.php
```

Jika membutuhkan file tambahan:

```text
services/
validators/
```

dapat ditambahkan sesuai kebutuhan.

---

# 50. Apa yang Tidak Boleh Dilakukan Saat Menambah Modul?

Hindari pola seperti:

```text
index.php
    ↓
1000 baris kode
    ↓
Dosen
Mahasiswa
Prodi
Mata Kuliah
Jadwal
Laporan
Import
```

Jangan membuat semua fitur di satu file.

Juga hindari:

```php
SQL + HTML + proses login + validasi
```

semuanya berada dalam satu file.

Lebih baik:

```text
Controller
Model
View
```

dipisahkan.

---

# 51. Aturan Sederhana Controller, Model, dan View

Gunakan aturan ini:

## Model

> "Saya mengurus DATA."

Contoh:

```text
SELECT mahasiswa
INSERT mahasiswa
UPDATE mahasiswa
DELETE mahasiswa
```

## Controller

> "Saya mengatur PROSES."

Contoh:

```text
Terima request
Validasi
Panggil model
Redirect
```

## View

> "Saya mengurus TAMPILAN."

Contoh:

```text
HTML
Bootstrap
Table
Form
Button
```

---

# 52. Contoh Alur Tambah Mahasiswa

Ketika pengguna menekan:

```text
Simpan
```

alur:

```text
Form Mahasiswa
      │
      ▼
mahasiswa-save.php
      │
      ▼
MahasiswaController::save()
      │
      ├── cek login
      ├── cek CSRF
      ├── validasi input
      │
      ▼
MahasiswaModel::save()
      │
      ▼
Database
      │
      ▼
Flash Message
      │
      ▼
mahasiswa.php
```

---

# 53. Contoh Alur Edit Mahasiswa

```text
Klik Edit
   │
   ▼
mahasiswa-form.php?id=123
   │
   ▼
MahasiswaController::form()
   │
   ▼
MahasiswaModel::find(123)
   │
   ▼
Database
   │
   ▼
Form ditampilkan
```

Setelah disimpan:

```text
Form
 ↓
Controller
 ↓
Model
 ↓
UPDATE mahasiswa
 ↓
Redirect
```

---

# 54. Catatan Penting Tentang Database

Jangan mengubah struktur database secara sembarangan pada server produksi.

Sebelum perubahan besar:

```text
Backup database
       ↓
Ubah struktur
       ↓
Test
       ↓
Deploy
```

Untuk aplikasi yang semakin besar, sebaiknya `database.sql` nantinya dikembangkan menjadi sistem migration:

```text
database/
├── migrations/
├── seeders/
└── database.sql
```

Dengan migration, perubahan database dapat dilacak berdasarkan versi.

---

# 55. Catatan Penting Tentang Import

Import data akademik harus dianggap sebagai proses penting.

Sebelum import data besar:

1. Backup database.
2. Gunakan template.
3. Periksa NIM/NIDN.
4. Periksa nama kolom.
5. Gunakan Preview & Validasi.
6. Pastikan data benar.
7. Baru lakukan import.

Terutama karena import dapat memperbarui data yang sudah ada.

---

# 56. Perilaku Kolom Kosong Saat Import

Aturan saat ini:

```text
Data lama:
Angkatan = 2025

Excel:
Angkatan = kosong

Hasil:
Angkatan = 2025
```

Tetapi:

```text
Data lama:
Angkatan = 2025

Excel:
Angkatan = 2026

Hasil:
Angkatan = 2026
```

Jadi Excel kosong tidak dianggap sebagai perintah untuk menghapus data.

---

# 57. Catatan Tentang Penghapusan Data

Saat ini penghapusan menggunakan POST dan CSRF.

Contohnya:

```text
Klik Hapus
   ↓
Konfirmasi JavaScript
   ↓
POST
   ↓
Controller
   ↓
CSRF validation
   ↓
DELETE
```

Untuk sistem akademik yang semakin serius, sebaiknya penghapusan data nantinya menggunakan **soft delete** untuk data tertentu.

Contoh:

```text
deleted_at
```

Dengan demikian data tidak benar-benar hilang dari database.

---

# 58. Catatan Tentang Role / Permission

Saat ini aplikasi sudah memiliki:

```text
role
```

di tabel users, tetapi permission belum dikembangkan secara penuh.

Untuk versi berikutnya dapat dibuat:

```text
roles
permissions
role_permissions
```

Contoh:

```text
Admin
├── Dosen       ✓
├── Mahasiswa   ✓
├── Import      ✓
├── Export      ✓
└── Settings    ✓

Operator
├── Dosen       ✓
├── Mahasiswa   ✓
├── Import      ✓
└── Settings    ✗
```

Jangan hanya menyembunyikan menu. Permission juga harus diperiksa di server/controller.

---

# 59. Catatan Keamanan

Beberapa hal yang harus selalu dipertahankan:

### 1. Gunakan prepared statement

Benar:

```php
$stmt = $db->prepare("SELECT * FROM mahasiswa WHERE nim = ?");
$stmt->execute([$nim]);
```

Hindari membuat query seperti:

```php
"SELECT * FROM mahasiswa WHERE nim = '$nim'"
```

---

### 2. Gunakan `password_hash()`

Password harus disimpan sebagai hash.

Jangan:

```text
password
123456
admin123
```

di database dalam bentuk plaintext.

---

### 3. Gunakan CSRF

Untuk request yang mengubah data:

```text
POST
PUT
DELETE
```

gunakan proteksi CSRF.

---

### 4. Gunakan `e()` pada output

Contoh:

```php
<?= e($row['nama']) ?>
```

---

### 5. Lindungi folder `app`

Web server sebaiknya hanya mengekspos:

```text
public/
```

---

# 60. Catatan Tentang CDN

Bootstrap dan SheetJS saat ini dimuat melalui CDN.

Contohnya:

```text
cdn.jsdelivr.net
```

Keuntungannya:

- mudah
- tidak perlu menyimpan library lokal

Kekurangannya:

- membutuhkan koneksi internet
- aplikasi bergantung pada CDN

Untuk aplikasi yang harus tetap berfungsi di jaringan lokal tanpa internet, sebaiknya library tersebut nantinya disimpan secara lokal:

```text
public/assets/vendor/
├── bootstrap/
├── bootstrap-icons/
└── xlsx/
```

---

# 61. Catatan Tentang View Modul

Pada versi sekarang terdapat view di:

```text
app/modules/<module>/views/
```

dan view runtime juga tersedia di:

```text
app/views/<module>/
```

Hal ini merupakan konsekuensi dari struktur versi awal yang kemudian dibuat modular.

Untuk refactor berikutnya, sebaiknya dipilih **satu lokasi view saja**.

Pilihan yang lebih bersih untuk arsitektur feature-based adalah:

```text
app/modules/
└── mahasiswa/
    └── views/
```

kemudian helper `render()` disesuaikan agar langsung mencari view dari modul.

Dengan begitu tidak perlu menyimpan salinan view di dua lokasi.

---

# 62. Catatan Tentang `routes.php`

Setiap modul memiliki:

```text
routes.php
```

Saat ini file tersebut berfungsi sebagai dokumentasi route.

Contohnya:

```text
GET mahasiswa.php
POST mahasiswa-save.php
POST mahasiswa-delete.php
```

Belum digunakan sebagai router terpusat.

Untuk versi berikutnya, aplikasi dapat dikembangkan menjadi:

```text
public/index.php
       │
       ▼
Router
       │
       ├── /mahasiswa
       ├── /dosen
       ├── /prodi
       └── /matakuliah
```

Dengan begitu jumlah file `.php` di `public` dapat dikurangi.

---

# 63. Roadmap Pengembangan yang Disarankan

Jika aplikasi akan terus dikembangkan, urutan yang disarankan:

## Tahap 1 — Fondasi

```text
✓ Login
✓ Dashboard
✓ Dosen
✓ Mahasiswa
✓ Import
✓ Export
```

## Tahap 2 — Data Akademik

```text
□ Program Studi
□ Mata Kuliah
□ Kelas
□ Ruang
□ Tahun Akademik
□ Semester
□ Jadwal
```

## Tahap 3 — User Management

```text
□ User
□ Role
□ Permission
□ Profil pengguna
□ Ganti password
```

## Tahap 4 — Administrasi

```text
□ Surat
□ Arsip
□ Dokumen
□ Agenda
□ Disposisi
```

## Tahap 5 — Pelaporan

```text
□ Laporan Dosen
□ Laporan Mahasiswa
□ Statistik
□ Export Excel
□ PDF
```

## Tahap 6 — Sistem Lanjutan

```text
□ Activity Log
□ Audit Trail
□ Notification
□ REST API
□ Backup database
□ Scheduler
```

---

# 64. Rekomendasi Struktur Versi Lebih Besar

Jika aplikasi sudah semakin besar, struktur dapat dikembangkan menjadi:

```text
admin-akademik/
│
├── app/
│   ├── config/
│   ├── core/
│   ├── helpers/
│   │
│   ├── modules/
│   │   ├── dashboard/
│   │   ├── dosen/
│   │   ├── mahasiswa/
│   │   ├── prodi/
│   │   ├── matakuliah/
│   │   ├── kelas/
│   │   ├── jadwal/
│   │   ├── user/
│   │   ├── laporan/
│   │   └── tracer_study/
│   │
│   └── services/
│
├── database/
│   ├── migrations/
│   └── seeders/
│
├── public/
│   └── assets/
│
├── storage/
│   ├── uploads/
│   ├── exports/
│   └── logs/
│
└── README.md
```

Struktur tersebut lebih cocok jika aplikasi nantinya menjadi sistem administrasi akademik yang besar.

---

# 65. Checklist Ketika Menambahkan Modul Baru

Sebelum mengatakan modul baru selesai, periksa:

```text
[ ] Tabel database sudah dibuat
[ ] Primary key sudah benar
[ ] Kolom unik sudah ditentukan
[ ] Model sudah dibuat
[ ] Controller sudah dibuat
[ ] View list sudah dibuat
[ ] View form sudah dibuat
[ ] Entry point public sudah dibuat
[ ] Menu sidebar sudah ditambahkan
[ ] Login protection sudah ditambahkan
[ ] CSRF sudah digunakan
[ ] Input sudah divalidasi
[ ] Output sudah menggunakan e()
[ ] Query menggunakan prepared statement
[ ] Tombol delete memakai POST
[ ] Data kosong ditangani
[ ] Data duplikat ditangani
[ ] Error ditangani
[ ] Sudah dites tambah data
[ ] Sudah dites edit data
[ ] Sudah dites hapus data
[ ] Sudah dites pencarian
```

---

# 66. Checklist Sebelum Deploy

```text
[ ] Backup database
[ ] Ubah password database
[ ] Pastikan password admin aman
[ ] Arahkan DocumentRoot ke public/
[ ] Pastikan app/ tidak dapat diakses langsung
[ ] Pastikan database/ tidak dapat diakses langsung
[ ] Pastikan storage permission benar
[ ] Pastikan PHP PDO MySQL aktif
[ ] Matikan error detail PHP di production
[ ] Gunakan HTTPS
[ ] Backup database secara berkala
```

---

# 67. Login Demo

Untuk instalasi awal:

```text
Email:
admin@localhost

Password:
password
```

**Penting:** akun tersebut hanya untuk instalasi/demo.

Pada server sebenarnya, password harus segera diganti.

---

# 68. Prinsip Pengembangan Aplikasi

Saat mengembangkan aplikasi ini, gunakan prinsip sederhana:

> **Jangan membuat fitur baru dengan merusak fitur lama.**

Gunakan pola:

```text
Fitur baru
    ↓
Modul baru
    ↓
Model baru
    ↓
Controller baru
    ↓
View baru
    ↓
Route / Entry Point
    ↓
Menu
```

Bukan:

```text
Fitur baru
    ↓
Ubah semua file
    ↓
Aplikasi rusak
```

---

# 69. Ringkasan Arsitektur

Jika masih bingung, cukup ingat tabel berikut:

| Bagian | Fungsi |
|---|---|
| `public/` | Pintu masuk browser |
| `app/config/` | Konfigurasi |
| `app/core/` | Bootstrap aplikasi |
| `app/helpers/` | Fungsi bantuan |
| `app/modules/` | Modul fitur |
| `Model` | Mengurus database |
| `Controller` | Mengatur proses |
| `View` | Mengurus tampilan |
| `database/` | Struktur database |
| `storage/` | File, export, log |
| `assets/css/` | Tampilan |
| `assets/js/` | JavaScript |

---

# 70. Prinsip Utama yang Harus Diingat

Untuk pemula, cukup ingat lima aturan berikut:

### 1. Database bukan View

Jangan menaruh HTML di Model.

### 2. View bukan Database

Jangan melakukan query SQL langsung di View.

### 3. Controller adalah pengatur

Controller menerima request dan menentukan proses.

### 4. Setiap fitur sebaiknya menjadi modul

Contoh:

```text
Dosen
Mahasiswa
Prodi
Mata Kuliah
Jadwal
```

masing-masing memiliki folder sendiri.

### 5. Modul baru harus mengikuti pola yang sama

Jika semua modul mengikuti pola:

```text
Controller
Model
View
Entry Point
Database
```

aplikasi akan lebih mudah dipelihara dan dikembangkan.

---

# 71. Penutup

Aplikasi Admin Akademik ini sengaja dibuat dengan struktur modular agar dapat berkembang secara bertahap.

Saat ini modul yang tersedia:

```text
Dashboard
Dosen
Mahasiswa
Import / Export
```

Modul baru dapat ditambahkan tanpa harus membangun ulang aplikasi.

Target akhirnya dapat dikembangkan menjadi sistem administrasi akademik yang memiliki:

```text
Dashboard
│
├── Akademik
│   ├── Dosen
│   ├── Mahasiswa
│   ├── Program Studi
│   ├── Mata Kuliah
│   ├── Kelas
│   ├── Jadwal
│   └── Ruang
│
├── Administrasi
│   ├── Surat
│   ├── Dokumen
│   └── Arsip
│
├── Import / Export
│   ├── Excel
│   ├── CSV
│   └── PDF
│
├── Laporan
│
├── Tracer Study
│
└── Pengaturan
    ├── User
    ├── Role
    └── Permission
```

Dengan mempertahankan pemisahan **Model → Controller → View** dan konsep **satu fitur = satu modul**, aplikasi akan jauh lebih mudah dikembangkan ketika jumlah fitur dan data semakin besar.
