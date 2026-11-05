MODUL KURIKULUM - UI DEMO

Isi:
- index.php                  Daftar kurikulum + DataTables
- detail.php                 Detail kurikulum + komposisi SKS + tabel mata kuliah
- template.php               Template laporan/cetak A4 terpisah
- assets/css/kurikulum.css   CSS halaman dan laporan

ASUMSI INTEGRASI
1. Menggunakan PHP 8+ dan Bootstrap 5.
2. Layout utama aplikasi sudah memuat Bootstrap 5, Bootstrap Icons, jQuery,
   DataTables core, dan DataTables Bootstrap 5 integration.
3. File view ini diasumsikan dirender dari layout aplikasi yang sudah ada.
   Hapus atau sesuaikan tag <link> jika path asset pada aplikasi berbeda.
4. Semua data saat ini adalah dummy. Tidak ada query database atau proses CRUD.

FIELD DATABASE YANG DIPAKAI
kurikulum:
id, id_kurikulum, index_feeder, program_studi, tahun, nama, angkatan,
status, obe, sks_wajib, sks_pilihan, sks_wajib_lulus,
sks_pilihan_lulus, sks_ditawarkan

matakuliah:
id, kelompok, kode, matakuliah, sks, prasyarat, semester,
id_kurikulum, sifat_matakuliah, praktikum

KONVERSI BOOLEAN
- kurikulum.status: 1 = Aktif, 0 = Tidak Aktif
- kurikulum.obe: 1 = Ya, 0 = Tidak
- matakuliah.sifat_matakuliah: 1 = Wajib, 0 = Pilihan
- matakuliah.praktikum: 1 = Ya, 0 = Tidak

PENGGANTIAN DATA DUMMY
- index.php: isi variabel $kurikulumList dari query database.
- detail.php: isi $kurikulum dan $matakuliahList dari query database.
- template.php: isi $kurikulum dan $matakuliahList dari query database.
  Pastikan query laporan mengambil SEMUA mata kuliah kurikulum, tidak dibatasi
  pagination/filter DataTables.

CATATAN
- Tautan form.php dan matakuliah-form.php adalah placeholder navigasi.
  Sesuaikan dengan route/form yang sudah ada di aplikasi.
- template.php dapat dibuka dari tombol Cetak Kurikulum. Tombol "Cetak / Simpan PDF"
  menggunakan dialog print browser.
- Kop universitas, logo, alamat, penandatangan, dan format laporan adalah contoh
  dan perlu disesuaikan dengan standar dokumen resmi unit.
- Nama file template.php dipertahankan sesuai permintaan. File ini berisi dokumen
  HTML lengkap, bukan partial view.
