<?php
/**
 * Modul Kurikulum - halaman detail (UI demo).
 * Ganti $kurikulum dan $matakuliahList dengan hasil query database.
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

?>
<link rel="stylesheet" href="assets/css/kurikulum.css">

<div class="kurikulum-page">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="text-body-secondary small mb-2">
                <a href="index.php" class="text-decoration-none">Data Master / Kurikulum</a> / Detail
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                <h1 class="h3 fw-bold mb-0"><?= e($kurikulum['nama']) ?></h1>
                <span class="badge <?= (int)$kurikulum['status'] === 1 ? 'text-bg-success' : 'text-bg-secondary' ?>">
                    <?= (int)$kurikulum['status'] === 1 ? 'Aktif' : 'Tidak Aktif' ?>
                </span>
            </div>
            <p class="text-body-secondary mb-0">
                <i class="bi bi-mortarboard me-1"></i><?= e($kurikulum['program_studi']) ?>
                <span class="mx-2">·</span>Tahun <?= e($kurikulum['tahun']) ?>
                <span class="mx-2">·</span><?= e($kurikulum['id_kurikulum']) ?>
            </p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="kurikulum.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="kurikulum-tmp.php?id=<?= (int)$kurikulum['id_kurikulum'] ?>" target="_blank" class="btn btn-outline-secondary">
                <i class="bi bi-printer me-1"></i> Cetak Kurikulum
            </a>
            <a href="kurikulum-form.php?id=<?= (int)$kurikulum['id_kurikulum'] ?>" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit Kurikulum
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-body py-3">
            <h2 class="h6 fw-bold mb-0"><i class="bi bi-info-circle text-primary me-2"></i>Identitas Kurikulum</h2>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-6 col-lg-3"><div class="detail-label">ID Kurikulum</div><div class="fw-semibold"><?= e($kurikulum['id_kurikulum']) ?></div></div>
                <div class="col-6 col-lg-3"><div class="detail-label">Index Feeder</div><div class="fw-semibold"><?= e($kurikulum['index_feeder'] ?: '-') ?></div></div>
                <div class="col-6 col-lg-3"><div class="detail-label">Program Studi</div><div class="fw-semibold"><?= e($kurikulum['program_studi']) ?></div></div>
                <div class="col-6 col-lg-3"><div class="detail-label">Tahun</div><div class="fw-semibold"><?= e($kurikulum['tahun']) ?></div></div>
                <div class="col-6 col-lg-3"><div class="detail-label">Nama Kurikulum</div><div class="fw-semibold"><?= e($kurikulum['nama']) ?></div></div>
                <div class="col-6 col-lg-3"><div class="detail-label">Angkatan</div><div class="fw-semibold"><?= e($kurikulum['angkatan'] ?: '-') ?></div></div>
                <div class="col-6 col-lg-3">
                    <div class="detail-label">Status</div>
                    <span class="badge <?= (int)$kurikulum['status'] === 1 ? 'text-bg-success' : 'text-bg-secondary' ?>">
                        <?= (int)$kurikulum['status'] === 1 ? 'Aktif' : 'Tidak Aktif' ?>
                    </span>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="detail-label">Implementasi OBE</div>
                    <span class="badge <?= (int)$kurikulum['obe'] === 1 ? 'text-bg-primary' : 'text-bg-secondary' ?>">
                        <?= (int)$kurikulum['obe'] === 1 ? 'Ya' : 'Tidak' ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-body py-3">
            <h2 class="h6 fw-bold mb-0"><i class="bi bi-calculator text-primary me-2"></i>Komposisi dan Ketentuan SKS</h2>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-6 col-xl">
                    <div class="sks-metric"><div class="detail-label">Total SKS Ditawarkan</div><div class="fs-3 fw-bold"><?= e($kurikulum['sks_ditawarkan']) ?></div><small class="text-body-secondary">SKS</small></div>
                </div>
                <div class="col-6 col-xl">
                    <div class="sks-metric"><div class="detail-label">SKS Wajib Ditawarkan</div><div class="fs-3 fw-bold"><?= e($kurikulum['sks_wajib']) ?></div><small class="text-body-secondary">SKS</small></div>
                </div>
                <div class="col-6 col-xl">
                    <div class="sks-metric"><div class="detail-label">SKS Pilihan Ditawarkan</div><div class="fs-3 fw-bold"><?= e($kurikulum['sks_pilihan']) ?></div><small class="text-body-secondary">SKS</small></div>
                </div>
                <div class="col-6 col-xl">
                    <div class="sks-metric sks-metric-required"><div class="detail-label">Minimal SKS Wajib Lulus</div><div class="fs-3 fw-bold text-success"><?= e($kurikulum['sks_wajib_lulus']) ?></div><small class="text-body-secondary">SKS yang harus lulus</small></div>
                </div>
                <div class="col-6 col-xl">
                    <div class="sks-metric sks-metric-required"><div class="detail-label">Minimal SKS Pilihan Lulus</div><div class="fs-3 fw-bold text-success"><?= e($kurikulum['sks_pilihan_lulus']) ?></div><small class="text-body-secondary">SKS yang harus lulus</small></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body py-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h2 class="h6 fw-bold mb-1"><i class="bi bi-journal-text text-primary me-2"></i>Daftar Mata Kuliah</h2>
                    <div class="small text-body-secondary">Seluruh mata kuliah yang terhubung dengan kurikulum ini.</div>
                </div>
                <a href="matakuliah-form.php?id_kurikulum=<?= rawurlencode($kurikulum['id_kurikulum']) ?>"
                   class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Matakuliah
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableMatakuliah" class="table data-table table-hover table-striped align-middle w-100">
                    <thead>
                        <tr>
                            <th>No</th><th>Kode MK</th><th>Nama Mata Kuliah</th><th>SKS</th>
                            <th>Semester</th><th>Sifat</th><th>Prasyarat</th><th>Praktikum</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($matakuliahList as $mk): ?>
                        <tr>
                            <td></td>
                            <td class="fw-semibold text-nowrap"><?= e($mk['kode']) ?></td>
                            <td><?= e($mk['matakuliah']) ?></td>
                            <td class="text-center"><?= e($mk['sks']) ?></td>
                            <td class="text-center"><?= e($mk['semester']) ?></td>
                            <td>
                                <?php if ((int)$mk['sifat_matakuliah'] === 1): ?>
                                    <span class="badge text-bg-primary">Wajib</span>
                                <?php else: ?>
                                    <span class="badge text-bg-warning">Pilihan</span>
                                <?php endif; ?>
                            </td>
                            <td><?= e($mk['prasyarat'] ?: '-') ?></td>
                            <td class="text-center">
                                <?php if ((int)$mk['praktikum'] === 1): ?>
                                    <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Ya</span>
                                <?php else: ?>
                                    <span class="text-body-secondary"><i class="bi bi-dash-circle me-1"></i>Tidak</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="small text-body-secondary mt-2">
                <?= $totalMk ?> mata kuliah pada data contoh · <?= $totalWajib ?> wajib · <?= $totalPilihan ?> pilihan.
                Angka komposisi SKS di atas tetap mengikuti field pada tabel kurikulum.
            </div>
        </div>
    </div>
</div>

<script>
(function ($) {
    $(function () {
        if (!$.fn.DataTable || $.fn.DataTable.isDataTable('#tableMatakuliah')) return;

        const table = $('#tableMatakuliah').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [[4, 'asc'], [1, 'asc']],
            scrollX: true,
            language: {
                search: 'Search:',
                lengthMenu: '_MENU_ entries per page',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                zeroRecords: 'Data tidak ditemukan',
                emptyTable: 'Belum ada mata kuliah pada kurikulum ini',
                paginate: { previous: '‹', next: '›' }
            },
            columnDefs: [{ targets: 0, searchable: false, orderable: false }],
            drawCallback: function () {
                const api = this.api();
                const start = api.page.info().start;
                api.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                    cell.innerHTML = start + i + 1;
                });
            }
        });

        $('#tableMatakuliah tfoot th').each(function (index) {
            const field = $(this).find('.column-filter');
            if (!field.length) return;
            field.on('keyup change clear', function () {
                table.column(index).search(this.value).draw();
            });
        });
    });
})(jQuery);
</script>
