<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <form class="row g-2 flex-grow-1" method="get">
        <div class="col-md-6">
            <select class="form-select" name="q">
                <option value="">Semua prodi</option>
                <?php foreach ($homebase as $prodi): ?>
                <?php if($prodi != "" || $prodi != null): ?>
                <option value="<?= e($prodi['homebase']) ?>" <?= @$prodi == $q ? 'selected' : '' ?>>
                    <?= e($prodi['homebase']) ?></option>
                <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select" name="status">
                <option value="">Semua status</option>
                <?php foreach ($statuslist as $st): ?>
                <?php if($st != "" || $st != null): ?>
                <option value="<?= e($st['status']) ?>" <?= @$st == $status ? 'selected' : '' ?>><?= e($st['status']) ?>
                </option>
                <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto"><button class="btn btn-outline-secondary">Cari</button></div>
    </form>
    <a href="dosen-form.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Dosen</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table hover data-table align-middle mb-0">
            <thead>
                <tr>
                    <th>NIDN</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>NUPTK</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$rows): ?>
                <tr>
                    <td colspan="6" class="text-center py-5 text-secondary">Belum ada data.</td>
                </tr>
                <?php endif; ?>
                <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= e($row['nidn']) ?></td>
                    <td><?= e($row['nip']) ?></td>
                    <td class="fw-semibold"><?= e($row['nama']) ?></td>
                    <td><?= e($row['nuptk']) ?></td>
                    <td><?= e($row['email'] ?? '-') ?></td>
                    <td><span
                            class="badge text-bg-<?= e(strtolower($row['status'])) === 'aktif' ? 'success' : 'secondary' ?>"><?= e(ucfirst($row['status'])) ?></span>
                    </td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="dosen-form.php?id=<?= (int)$row['id'] ?>"><i
                                class="bi bi-pencil"></i></a>
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