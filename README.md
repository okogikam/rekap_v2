# Admin Akademik Modular

Aplikasi administrasi akademik berbasis PHP + MySQL/MariaDB dengan arsitektur modular/feature-based.

## Modul saat ini

- Dashboard
- Dosen
- Mahasiswa
- Import / Export
  - Import Excel/CSV dengan SheetJS preview
  - Import parsial: sel kosong pada file tidak menghapus data lama
  - Export CSV
  - Template CSV
- DataTables pada tabel Dosen dan Mahasiswa
  - 25 data per halaman secara default
  - 10 / 25 / 50 / 100 data per halaman
  - pencarian, sorting, informasi jumlah data
  - scroll horizontal untuk tabel lebar

## Teknologi

- PHP 8+
- PDO
- MySQL/MariaDB
- Bootstrap 5
- Bootstrap Icons
- jQuery 3.7.1 (untuk integrasi DataTables Bootstrap)
- DataTables 2.3.3
- SheetJS
- Session authentication
- CSRF token

## Struktur

```text
admin-akademik-modular/
├── app/
│   ├── config/
│   ├── core/
│   ├── helpers/
│   ├── modules/
│   │   ├── dashboard/
│   │   ├── dosen/
│   │   ├── mahasiswa/
│   │   └── import_export/
│   └── views/
│       ├── dashboard/
│       ├── dosen/
│       ├── mahasiswa/
│       ├── import_export/
│       └── layouts/
├── database/
│   └── database.sql
├── public/
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── dosen*.php
│   ├── mahasiswa*.php
│   ├── import*.php
│   ├── export.php
│   ├── template.php
│   └── assets/
└── storage/
```

## Instalasi

1. Buat database atau import `database/database.sql`.
2. Atur koneksi pada `app/config/config.php`.
3. Arahkan document root web server ke folder `public/`.
4. Pastikan PHP memiliki PDO MySQL.
5. Pastikan folder `storage` dapat ditulis jika memakai fitur upload/export.

## Login demo

- Email: `admin@localhost`
- Password: `password`

## Struktur tabel Mahasiswa terbaru

Modul Mahasiswa sekarang mengikuti struktur tabel yang memiliki 56 field data utama berikut:

- Identitas: `nim`, `nik`, `nama`, `fakultas`, `program_studi`, `angkatan`, `jenis_kelamin`
- Biodata: `tempat_lahir`, `tanggal_lahir`, `agama`, `status_nikah`
- Kontak: `no_telepon`, `no_hp`, `email`
- Alamat/registrasi: `jalur_masuk`, `alamat`, `kota`, `propinsi`, `kode_pos`
- Kondisi: `status_tempat_tinggal`, `pembiayaan_kuliah`, `tinggi_badan_cm`, `berat_badan_kg`, `gol_darah`
- Asal sekolah: `asal_sekolah`, `kota_sekolah`, `total_nilai_un`, `rata_nilai_un`
- Riwayat S1: `masuk_s1`, `tamat_s1`, `perguruan_tinggi_s1`, `fakultas_s1`, `prodi_s1`, `ipk_s1`, `gelar_s1`
- Orang tua: `nik_ayah`, `nama_ayah`, `nik_ibu`, `nama_ibu`, `status_ayah`, `status_ibu`, `telepon_ortu`, `alamat_ortu`, `pekerjaan_ayah`, `pekerjaan_ibu`, `penghasilan_ortu`, `jumlah_tanggungan_ortu`
- Wali: `nama_wali`, `alamat_wali`, `telepon_wali`
- Akademik/pendaftaran: `nomor_tes`, `semester_masuk`, `jenis_pendaftaran`, `status_mahasiswa`, `semester_keluar`, `beasiswa`
- Sistem: `id`, `created_at`, `updated_at`

`nim` adalah unique key untuk pencocokan import.

## Form Mahasiswa

Form Mahasiswa dibagi menjadi beberapa bagian agar 56 field tetap mudah dikelola:

1. Identitas Mahasiswa
2. Kontak & Alamat
3. Asal Sekolah
4. Riwayat S1
5. Orang Tua / Wali
6. Registrasi & Status Akademik

Field wajib hanya `NIM` dan `Nama`.

## Tabel Mahasiswa

Tampilan daftar tidak menampilkan seluruh 56 field sekaligus. Kolom utama yang ditampilkan:

`NIM`, `Nama`, `NIK`, `Fakultas`, `Program Studi`, `Angkatan`, `JK`, `No. HP`, `Email`, `Status Mahasiswa`, dan `Aksi`.

Detail lengkap dapat dilihat melalui form Edit/Tambah.

## Import Mahasiswa

Template Mahasiswa menggunakan seluruh field tabel terbaru. `NIM` dan `Nama` wajib.

Perilaku import untuk record yang sudah ada:

- pencocokan berdasarkan `NIM`
- hanya nilai yang berisi yang diperbarui
- sel kosong pada file tidak menghapus nilai lama
- record baru dapat dibuat dengan field opsional kosong

Contoh:

```text
Database:
NIM=123
Nama=Andi
Angkatan=2025

File import:
NIM=123
Nama=Andi Pratama
Angkatan=

Hasil:
NIM=123
Nama=Andi Pratama
Angkatan=2025
```

## DataTables

Tabel Mahasiswa dan Dosen menggunakan DataTables 2.3.3. `public/assets/js/app.js` memiliki guard `DataTable.isDataTable()` sehingga tabel tidak akan diinisialisasi dua kali jika script termuat ulang.

Seluruh data masih diambil dari database lalu dipaginasi di browser. Untuk puluhan ribu data, disarankan migrasi ke server-side processing.

## Catatan view

`render()` saat ini mengambil view dari `app/views/`. Karena itu perubahan tampilan harus dilakukan pada:

```text
app/views/mahasiswa/
```

Folder `app/modules/*/views/` dipertahankan untuk kompatibilitas/dokumentasi arsitektur, tetapi view aktif yang dirender aplikasi berada di `app/views/`.

## Rencana Fitur 
1. Daftar Kurikulum & daftar matakuliah
2. data mahasiswa baru / tahun
3. data mahasiswa skripsi & distribusi pembimbing skripsi
4. hasil studi, ipk & ip
6. data lulusan
7. data tracer studi / tahun
8. data kegiatan prodi / tahun
9. data publikasi dosen, daftar artikel, sitasi / tahun
10. data penelitian & pengabdian dosen
11. data prestasi mahasiswa
