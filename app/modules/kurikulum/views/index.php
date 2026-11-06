<?php
/**
 * Modul Kurikulum - halaman index (UI demo).
 * Integrasi: ganti $kurikulumList dengan hasil query database.
 * Dependensi dari layout utama: Bootstrap 5, Bootstrap Icons,
 * jQuery, DataTables + DataTables Bootstrap 5 integration.
 */
if (!function_exists('e')) {
    function e($value): string {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

$kurikulumList = $kurikulumList ?? [
    [
        'id' => 1, 'id_kurikulum' => 'KUR-2024', 'index_feeder' => 'IDX-2024-001',
        'program_studi' => 'Pendidikan Komputer', 'tahun' => '2024',
        'nama' => 'Kurikulum Pendidikan Komputer 2024', 'angkatan' => '2024, 2025',
        'status' => 1, 'obe' => 1, 'sks_wajib' => 120, 'sks_pilihan' => 24,
        'sks_wajib_lulus' => 120, 'sks_pilihan_lulus' => 18, 'sks_ditawarkan' => 144,
        'jumlah_mk' => 58,
    ],
    [
        'id' => 2, 'id_kurikulum' => 'KUR-2020', 'index_feeder' => 'IDX-2020-001',
        'program_studi' => 'Pendidikan Komputer', 'tahun' => '2020',
        'nama' => 'Kurikulum Pendidikan Komputer 2020', 'angkatan' => '2020–2023',
        'status' => 0, 'obe' => 0, 'sks_wajib' => 126, 'sks_pilihan' => 18,
        'sks_wajib_lulus' => 126, 'sks_pilihan_lulus' => 12, 'sks_ditawarkan' => 144,
        'jumlah_mk' => 62,
    ],
    [
        'id' => 3, 'id_kurikulum' => 'KUR-2017', 'index_feeder' => 'IDX-2017-001',
        'program_studi' => 'Pendidikan Komputer', 'tahun' => '2017',
        'nama' => 'Kurikulum Pendidikan Komputer 2017', 'angkatan' => '2017–2019',
        'status' => 0, 'obe' => 0, 'sks_wajib' => 132, 'sks_pilihan' => 12,
        'sks_wajib_lulus' => 132, 'sks_pilihan_lulus' => 9, 'sks_ditawarkan' => 144,
        'jumlah_mk' => 60,
    ],
];
?>
<link rel="stylesheet" href="assets/css/kurikulum.css">

<div class="kurikulum-page">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="text-body-secondary small mb-1">DATA MASTER / KURIKULUM</div>
            <h1 class="h3 fw-bold mb-1">Data Kurikulum</h1>
            <p class="text-body-secondary mb-0">Kelola daftar kurikulum program studi.</p>
        </div>
        <a href="kurikulum-form.php" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kurikulum
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body">
                <div class="small text-body-secondary">Total Kurikulum</div>
                <div class="fs-3 fw-bold"><?= count($kurikulumList) ?></div>
            </div></div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body">
                <div class="small text-body-secondary">Kurikulum Aktif</div>
                <div class="fs-3 fw-bold text-success">
                    <?= count(array_filter($kurikulumList, fn($r) => (int)$r['status'] === 1)) ?>
                </div>
            </div></div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body">
                <div class="small text-body-secondary">Implementasi OBE</div>
                <div class="fs-3 fw-bold text-primary">
                    <?= count(array_filter($kurikulumList, fn($r) => (int)$r['obe'] === 1)) ?>
                </div>
            </div></div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body">
                <div class="small text-body-secondary">Program Studi</div>
                <div class="fs-3 fw-bold">
                    <?= count(array_unique(array_column($kurikulumList, 'program_studi'))) ?>
                </div>
            </div></div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body py-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h2 class="h6 fw-bold mb-1">Daftar Kurikulum</h2>
                    <div class="small text-body-secondary">Gunakan pencarian dan filter DataTables untuk menemukan data.</div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableKurikulum" class="table data-table table-hover table-striped align-middle w-100">
                    <thead>
                        <tr>
                            <th>ID Kurikulum</th>
                            <th>Index Feeder</th>
                            <th>Program Studi</th>
                            <th>Tahun</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Matakuliah</th>
                            <th>OBE</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($kurikulumList as $row): ?>
                        <tr>
                            <td class="fw-semibold text-nowrap"><?= e($row['id_kurikulum']) ?></td>
                            <td><?= e($row['index_feeder'] ?: '-') ?></td>
                            <td><?= e($row['program_studi']) ?></td>
                            <td><?= e($row['tahun']) ?></td>
                            <td><?= e($row['nama']) ?></td>
                            <td>
                                <?php if ((int)$row['status'] === 1): ?>
                                    <span class="badge text-bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge text-bg-secondary">Tidak Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge text-bg-info"><?= e($row['jumlah_mk'] ?? 0) ?> MK</span></td>
                            <td>
                                <span class="badge <?= (int)$row['obe'] === 1 ? 'text-bg-primary' : 'text-bg-secondary' ?>">
                                    <?= (int)$row['obe'] === 1 ? 'Ya' : 'Tidak' ?>
                                </span>
                            </td>
                            <td class="text-end text-nowrap">
                                <a class="btn btn-sm btn-outline-primary"
                                   href="kurikulum-detail.php?id=<?= (int)$row['id_kurikulum'] ?>" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-outline-secondary"
                                   href="kurikulum-form.php?id=<?= (int)$row['id_kurikulum'] ?>" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
(function ($) {
    $(function () {
        if (!$.fn.DataTable || $.fn.DataTable.isDataTable('#tableKurikulum')) return;

        const table = $('#tableKurikulum').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            order: [[3, 'desc']],
            scrollX: true,
            language: {
                search: 'Search:',
                lengthMenu: '_MENU_ entries per page',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                zeroRecords: 'Data tidak ditemukan',
                emptyTable: 'Belum ada data kurikulum',
                paginate: { previous: '‹', next: '›' }
            },
            columnDefs: [{ targets: 8, orderable: false, searchable: false }]
        });

        $('#tableKurikulum tfoot th').each(function (index) {
            const field = $(this).find('.column-filter');
            if (!field.length) return;

            field.on('keyup change clear', function () {
                table.column(index).search(this.value).draw();
            });
        });
    });
})(jQuery);
</script>
