CREATE DATABASE IF NOT EXISTS admin_akademik
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE admin_akademik;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(30) NOT NULL UNIQUE,
    nama VARCHAR(150) NOT NULL,
    email VARCHAR(150) NULL,
    prodi VARCHAR(150) NULL,
    angkatan YEAR NULL,
    semester TINYINT UNSIGNED NULL,
    jenis_kelamin ENUM('L','P') NULL,
    status ENUM('aktif','cuti','lulus','nonaktif') NOT NULL DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_mahasiswa_nama (nama),
    INDEX idx_mahasiswa_status (status),
    INDEX idx_mahasiswa_angkatan (angkatan)
) ENGINE=InnoDB;

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
    email = VALUES(email),
    jabatan = VALUES(jabatan),
    pangkat = VALUES(pangkat);

INSERT INTO mahasiswa (nim, nama, email, prodi, angkatan, semester, jenis_kelamin, status)
VALUES
('20260001', 'Contoh Mahasiswa', 'mahasiswa@example.com', 'Pendidikan Komputer', 2026, 1, 'L', 'aktif')
ON DUPLICATE KEY UPDATE nama = VALUES(nama);
