<?php
/**
 * Template laporan/cetak kurikulum.
 * File ini sengaja terpisah dari UI dashboard agar format dokumen mudah diubah.
 * Ganti data dummy dengan query kurikulum + seluruh matakuliah berdasarkan id_kurikulum.
 */
if (!function_exists('e')) {
    function e($value): string {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

$kurikulum = $kurikulum ?? [
    'id' => 1, 'id_kurikulum' => 'KUR-2024', 'index_feeder' => 'IDX-2024-001',
    'program_studi' => 'Pendidikan Komputer', 'tahun' => '2024',
    'nama' => 'Kurikulum Pendidikan Komputer 2024', 'angkatan' => '2024, 2025',
    'status' => 1, 'obe' => 1, 'sks_wajib' => 120, 'sks_pilihan' => 24,
    'sks_wajib_lulus' => 120, 'sks_pilihan_lulus' => 18, 'sks_ditawarkan' => 144,
];

$matakuliahList = $matakuliahList ?? [
    ['kelompok'=>'MKK', 'kode'=>'PK101', 'matakuliah'=>'Algoritma dan Pemrograman', 'sks'=>3, 'semester'=>'1', 'sifat_matakuliah'=>1, 'prasyarat'=>'-', 'praktikum'=>1],
    ['kelompok'=>'MKK', 'kode'=>'PK102', 'matakuliah'=>'Matematika Diskrit', 'sks'=>3, 'semester'=>'1', 'sifat_matakuliah'=>1, 'prasyarat'=>'-', 'praktikum'=>0],
    ['kelompok'=>'MKK', 'kode'=>'PK103', 'matakuliah'=>'Pengantar Komputer', 'sks'=>2, 'semester'=>'1', 'sifat_matakuliah'=>1, 'prasyarat'=>'-', 'praktikum'=>0],
    ['kelompok'=>'MKB', 'kode'=>'PK201', 'matakuliah'=>'Pemrograman Web', 'sks'=>3, 'semester'=>'2', 'sifat_matakuliah'=>1, 'prasyarat'=>'PK101', 'praktikum'=>1],
    ['kelompok'=>'MKB', 'kode'=>'PK202', 'matakuliah'=>'Desain Antarmuka Pengguna', 'sks'=>2, 'semester'=>'2', 'sifat_matakuliah'=>0, 'prasyarat'=>'PK103', 'praktikum'=>1],
    ['kelompok'=>'MKB', 'kode'=>'PK301', 'matakuliah'=>'Basis Data Lanjut', 'sks'=>3, 'semester'=>'3', 'sifat_matakuliah'=>1, 'prasyarat'=>'PK201', 'praktikum'=>1],
    ['kelompok'=>'MKB', 'kode'=>'PK401', 'matakuliah'=>'Pengembangan Game', 'sks'=>3, 'semester'=>'4', 'sifat_matakuliah'=>0, 'prasyarat'=>'PK201', 'praktikum'=>1],
];

$totalMk = count($matakuliahList);
$totalWajib = count(array_filter($matakuliahList, fn($m) => (int)$m['sifat_matakuliah'] === 1));
$totalPilihan = $totalMk - $totalWajib;
$totalSksData = array_sum(array_map(fn($m) => (int)$m['sks'], $matakuliahList));
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Kurikulum - <?= e($kurikulum['nama']) ?></title>
    <link rel="stylesheet" href="assets/css/kurikulum.css">
</head>
<body class="report-body">
    <div class="report-toolbar no-print">
        <a href="kurikulum-detail.php?id=<?= (int)$kurikulum['id_kurikulum'] ?>" class="btn-report btn-light-report">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="button" class="btn-report btn-primary-report" onclick="window.print()">
            <i class="bi bi-printer"></i> Cetak / Simpan PDF
        </button>
    </div>

    <main class="report-container">
        <header class="report-header">
            <!-- Sesuaikan nama institusi, alamat, logo, dan identitas unit di bagian ini. -->
            <div class="report-logo-placeholder">LOGO UNIVERSITAS</div>
            <div class="report-institution">
                <h1>UNIVERSITAS LAMBUNG MANGKURAT</h1>
                <h2>FAKULTAS KEGURUAN DAN ILMU PENDIDIKAN</h2>
                <h3>PROGRAM STUDI <?= e(strtoupper($kurikulum['program_studi'])) ?></h3>
                <p>Banjarmasin, Kalimantan Selatan</p>
            </div>
        </header>

        <div class="report-title">
            <h2>DOKUMEN KURIKULUM</h2>
            <h3><?= e(strtoupper($kurikulum['nama'])) ?></h3>
            <p>Tahun Kurikulum <?= e($kurikulum['tahun']) ?></p>
        </div>

        <section class="report-section">
            <h3>A. IDENTITAS KURIKULUM</h3>
            <table class="report-info-table">
                <tbody>
                    <tr><th>ID Kurikulum</th><td><?= e($kurikulum['id_kurikulum']) ?></td><th>Index Feeder</th><td><?= e($kurikulum['index_feeder'] ?: '-') ?></td></tr>
                    <tr><th>Program Studi</th><td><?= e($kurikulum['program_studi']) ?></td><th>Tahun</th><td><?= e($kurikulum['tahun']) ?></td></tr>
                    <tr><th>Nama Kurikulum</th><td><?= e($kurikulum['nama']) ?></td><th>Angkatan</th><td><?= e($kurikulum['angkatan'] ?: '-') ?></td></tr>
                    <tr><th>Status</th><td><?= (int)$kurikulum['status'] === 1 ? 'Aktif' : 'Tidak Aktif' ?></td><th>OBE</th><td><?= (int)$kurikulum['obe'] === 1 ? 'Ya' : 'Tidak' ?></td></tr>
                </tbody>
            </table>
        </section>

        <section class="report-section">
            <h3>B. KOMPOSISI DAN KETENTUAN SKS</h3>
            <table class="report-info-table sks-report-table">
                <thead><tr><th>Komponen</th><th>Jumlah SKS</th><th>Keterangan</th></tr></thead>
                <tbody>
                    <tr><td>Total SKS Ditawarkan</td><td class="text-center"><?= e($kurikulum['sks_ditawarkan']) ?></td><td>Keseluruhan SKS yang ditawarkan</td></tr>
                    <tr><td>SKS Wajib Ditawarkan</td><td class="text-center"><?= e($kurikulum['sks_wajib']) ?></td><td>Komponen mata kuliah wajib</td></tr>
                    <tr><td>SKS Pilihan Ditawarkan</td><td class="text-center"><?= e($kurikulum['sks_pilihan']) ?></td><td>Komponen mata kuliah pilihan</td></tr>
                    <tr><td>Minimal SKS Wajib Lulus</td><td class="text-center"><?= e($kurikulum['sks_wajib_lulus']) ?></td><td>Minimal SKS wajib yang harus lulus</td></tr>
                    <tr><td>Minimal SKS Pilihan Lulus</td><td class="text-center"><?= e($kurikulum['sks_pilihan_lulus']) ?></td><td>Minimal SKS pilihan yang harus lulus</td></tr>
                </tbody>
            </table>
        </section>

        <section class="report-section">
            <h3>C. DAFTAR MATA KULIAH</h3>
            <p class="report-note">
                Total <?= $totalMk ?> mata kuliah pada data yang dimuat
                (<?= $totalWajib ?> wajib, <?= $totalPilihan ?> pilihan).
            </p>
            <table class="report-course-table">
                <thead>
                    <tr>
                        <th class="col-no">No.</th>
                        <th class="col-code">Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th class="col-sks">SKS</th>
                        <th class="col-sem">Semester</th>
                        <th class="col-group">Kelompok</th>
                        <th class="col-kind">Sifat</th>
                        <th>Prasyarat</th>
                        <th class="col-lab">Praktikum</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Urutkan laporan berdasarkan semester kemudian kode mata kuliah.
                usort($matakuliahList, function ($a, $b) {
                    $semesterCompare = (int)$a['semester'] <=> (int)$b['semester'];
                    return $semesterCompare !== 0 ? $semesterCompare : strcmp($a['kode'], $b['kode']);
                });
                ?>
                <?php foreach ($matakuliahList as $index => $mk): ?>
                    <tr>
                        <td class="text-center"><?= $index + 1 ?></td>
                        <td><?= e($mk['kode']) ?></td>
                        <td><?= e($mk['matakuliah']) ?></td>
                        <td class="text-center"><?= e($mk['sks']) ?></td>
                        <td class="text-center"><?= e($mk['semester']) ?></td>
                        <td><?= e($mk['kelompok'] ?: '-') ?></td>
                        <td><?= (int)$mk['sifat_matakuliah'] === 1 ? 'Wajib' : 'Pilihan' ?></td>
                        <td><?= e($mk['prasyarat'] ?: '-') ?></td>
                        <td class="text-center"><?= (int)$mk['praktikum'] === 1 ? 'Ya' : 'Tidak' ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total SKS dari daftar yang dimuat</th>
                        <th class="text-center"><?= $totalSksData ?></th>
                        <th colspan="5"></th>
                    </tr>
                </tfoot>
            </table>
        </section>

        <section class="report-signatures">
            <div>
                <p>Banjarmasin, <?= date('d-m-Y') ?></p>
                <p>Mengetahui,</p>
                <p class="signature-space"></p>
                <strong>Ketua Program Studi</strong>
                <p>NIP. ....................................</p>
            </div>
        </section>

        <footer class="report-footer">
            <span><?= e($kurikulum['id_kurikulum']) ?> · <?= e($kurikulum['tahun']) ?></span>
            <span>Dicetak pada <?= date('d-m-Y H:i') ?></span>
        </footer>
    </main>
</body>
</html>
