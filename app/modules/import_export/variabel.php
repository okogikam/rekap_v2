<?php

$tables = [
    "mahasiswa"  => [
        'field' => ['nim', 'nik', 'nama', 'fakultas', 'program_studi', 'angkatan', 'jenis_kelamin',
            'tempat_lahir', 'tanggal_lahir', 'agama', 'status_nikah', 'no_telepon', 'no_hp',
            'email', 'jalur_masuk', 'alamat', 'kota', 'propinsi', 'kode_pos',
            'status_tempat_tinggal', 'pembiayaan_kuliah', 'tinggi_badan_cm', 'berat_badan_kg',
            'gol_darah', 'asal_sekolah', 'kota_sekolah', 'total_nilai_un', 'rata_nilai_un',
            'masuk_s1', 'tamat_s1', 'perguruan_tinggi_s1', 'fakultas_s1', 'prodi_s1', 'ipk_s1',
            'gelar_s1', 'nik_ayah', 'nama_ayah', 'nik_ibu', 'nama_ibu', 'status_ayah', 'status_ibu', 'telepon_ortu', 'alamat_ortu', 'pekerjaan_ayah', 'pekerjaan_ibu', 'penghasilan_ortu', 'jumlah_tanggungan_ortu', 'nama_wali', 'alamat_wali', 'telepon_wali', 'nomor_tes', 'semester_masuk', 'jenis_pendaftaran', 'status_mahasiswa', 'semester_keluar', 'beasiswa'],
        'key'   => ['nim'],
    ],
    "dosen"      => [
        'field' => ['nip', 'nidn', 'gelar_depan', 'nama', 'gelar_belakang', 'jabatan', 'pendidikan_terakhir', 'pangkat', 'status', 'homebase', 'email', 'nuptk'],
        'key'   => ['nip'],
    ],
    "tabel_pa"   => [
        'field' => ['nip_dosen', 'nama_dosen', 'nim', 'nama_mahasiswa'],
        'key'   => ['nim'],
    ],
    "matakuliah" => [
        'field' => ['kelompok', 'kode', 'matakuliah', 'sks', 'prasyarat', 'semester', 'id_kurikulum', 'sifat_matakuliah', 'praktikum'],
        'key'   => ['kode', 'id_kurikulum'],
    ],
    "kurikulum"  => [
        'field' => ['id_kurikulum', 'index_feeder', 'program_studi', 'tahun', 'nama', 'angkatan', 'obe', 'sks_wajib', 'sks_pilihan', 'sks_wajib_lulus', 'sks_pilihan_lulus', 'sks_ditawarkan', 'status'],
        'key'   => ['id_kurikulum'],
    ],

];

$tabel_lists = [
    'mahasiswa'  => 'Mahasiswa',
    'dosen'      => 'Dosen',
    'matakuliah' => 'Matakuliah',
    'alumni'     => 'Alumni',
    'kurikulum'  => 'Kurikulum',
    'skripsi'    => 'Skripsi',
    'prodi'      => 'Program Studi',
    'tabel_pa'   => 'Dosen PA',
];
