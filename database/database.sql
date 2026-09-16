CREATE DATABASE IF NOT EXISTS admin_akademik CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE admin_akademik;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS dosen (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nip VARCHAR(30) NULL,
    nidn VARCHAR(20) NOT NULL UNIQUE,
    gelar_depan VARCHAR(50) NULL,
    nama VARCHAR(150) NOT NULL,
    gelar_belakang VARCHAR(50) NULL,
    jabatan VARCHAR(150) NULL,
    pendidikan_terakhir VARCHAR(50) NULL,
    pangkat VARCHAR(100) NULL,
    status VARCHAR(50) NULL,
    homebase VARCHAR(150) NULL,
    email VARCHAR(150) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_dosen_nama (nama),
    INDEX idx_dosen_nip (nip)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS mahasiswa (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nim VARCHAR(30) NOT NULL,
    nik VARCHAR(30) NULL,
    nama VARCHAR(150) NOT NULL,

    fakultas VARCHAR(100) NULL,
    program_studi VARCHAR(150) NULL,
    angkatan YEAR NULL,
    jenis_kelamin VARCHAR(20) NULL,

    tempat_lahir VARCHAR(100) NULL,
    tanggal_lahir DATE NULL,
    agama VARCHAR(50) NULL,
    status_nikah VARCHAR(50) NULL,

    no_telepon VARCHAR(30) NULL,
    no_hp VARCHAR(30) NULL,
    email VARCHAR(150) NULL,

    jalur_masuk VARCHAR(255) NULL,
    alamat TEXT NULL,
    kota VARCHAR(100) NULL,
    propinsi VARCHAR(100) NULL,
    kode_pos VARCHAR(10) NULL,

    status_tempat_tinggal VARCHAR(100) NULL,
    pembiayaan_kuliah VARCHAR(100) NULL,

    tinggi_badan_cm DECIMAL(5,2) NULL,
    berat_badan_kg DECIMAL(5,2) NULL,
    gol_darah VARCHAR(5) NULL,

    asal_sekolah VARCHAR(200) NULL,
    kota_sekolah VARCHAR(100) NULL,
    total_nilai_un DECIMAL(10,2) NULL,
    rata_nilai_un DECIMAL(10,2) NULL,

    masuk_s1 YEAR NULL,
    tamat_s1 YEAR NULL,
    perguruan_tinggi_s1 VARCHAR(200) NULL,
    fakultas_s1 VARCHAR(150) NULL,
    prodi_s1 VARCHAR(150) NULL,
    ipk_s1 DECIMAL(4,2) NULL,
    gelar_s1 VARCHAR(50) NULL,

    nik_ayah VARCHAR(30) NULL,
    nama_ayah VARCHAR(150) NULL,
    nik_ibu VARCHAR(30) NULL,
    nama_ibu VARCHAR(150) NULL,

    status_ayah VARCHAR(30) NULL,
    status_ibu VARCHAR(30) NULL,

    telepon_ortu VARCHAR(30) NULL,
    alamat_ortu TEXT NULL,

    pekerjaan_ayah VARCHAR(150) NULL,
    pekerjaan_ibu VARCHAR(150) NULL,
    penghasilan_ortu VARCHAR(100) NULL,
    jumlah_tanggungan_ortu INT NULL,

    nama_wali VARCHAR(150) NULL,
    alamat_wali TEXT NULL,
    telepon_wali VARCHAR(30) NULL,

    nomor_tes VARCHAR(50) NULL,
    semester_masuk VARCHAR(10) NULL,
    jenis_pendaftaran VARCHAR(100) NULL,
    status_mahasiswa VARCHAR(50) NULL,
    semester_keluar VARCHAR(10) NULL,
    beasiswa VARCHAR(150) NULL,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uk_mahasiswa_nim (nim),

    KEY idx_nama (nama),
    KEY idx_nik (nik),
    KEY idx_fakultas (fakultas),
    KEY idx_program_studi (program_studi),
    KEY idx_angkatan (angkatan),
    KEY idx_status_mahasiswa (status_mahasiswa)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (name, email, password, role)
VALUES (
    'Administrator',
    'admin@localhost',
    '$2y$12$0kx788NPNK/9b9Av9aZu9.XZRJaCPz15fIWYkRN/GWybC8bdS2p2u',
    'admin'
)
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    role = VALUES(role);

INSERT INTO dosen
(nip, nidn, gelar_depan, nama, gelar_belakang, jabatan, pendidikan_terakhir, pangkat, status, homebase, email)
VALUES
('1980000000000000', '0012345678', NULL, 'Contoh Dosen', NULL, 'Lektor', 'S2', 'III/c (Penata)', 'Aktif', 'Pendidikan Komputer', 'dosen@example.ac.id')
ON DUPLICATE KEY UPDATE
    nama = VALUES(nama),
    nip = VALUES(nip),
    email = VALUES(email);
