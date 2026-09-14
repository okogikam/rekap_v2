<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <form class="row g-2 flex-grow-1" method="get">
        <div class="col-md-8">
            <input class="form-control" name="q" value="<?= e($q) ?>"
                   placeholder="Cari NIDN, nama, NIP, email, jabatan, pangkat...">
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-secondary"><i class="bi bi-search"></i> Cari</button>
        </div>
    </form>
    <a href="dosen-form.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Dosen</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table id="dosenTable" class="table table-hover table-striped align-middle mb-0 w-100">
            <thead class="table-light">
            <tr>
                <th>NIDN</th>
                <th>NAMA</th>
                <th>NIP</th>
                <th>EMAIL</th>
                <th>JABATAN</th>
                <th>PANGKAT</th>
                <th class="text-end no-sort">AKSI</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!$rows): ?>
                <tr><td colspan="7" class="text-center py-5 text-secondary">Belum ada data.</td></tr>
            <?php endif; ?>

            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= e($row['nidn']) ?></td>
                    <td class="fw-semibold">
                        <?= e(trim(($row['gelar_depan'] ?? '') . ' ' . ($row['nama'] ?? '') . ' ' . ($row['gelar_belakang'] ?? ''))) ?>
                    </td>
                    <td><?= e($row['nip'] ?? '-') ?></td>
                    <td><?= e($row['email'] ?? '-') ?></td>
                    <td><?= e($row['jabatan'] ?? '-') ?></td>
                    <td><?= e($row['pangkat'] ?? '-') ?></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="dosen-form.php?id=<?= (int)$row['id'] ?>">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="post" action="dosen-delete.php" class="d-inline"
                              onsubmit="return confirm('Hapus data ini?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
