<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <form class="row g-2 flex-grow-1" method="get">
        <div class="col-md-5">
            <input class="form-control" name="q" value="<?= e($q) ?>" placeholder="Cari NIM, NIK, nama, prodi, email...">
        </div>
        <div class="col-md-2">
            <input class="form-control" name="angkatan" value="<?= e($angkatan) ?>" placeholder="Angkatan">
        </div>
        <div class="col-md-3">
            <input class="form-control" name="status" value="<?= e($status) ?>" placeholder="Status mahasiswa">
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-secondary"><i class="bi bi-search"></i> Cari</button>
        </div>
    </form>
    <a href="mahasiswa-form.php" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Mahasiswa
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table id="mahasiswaTable" class="table table-hover table-striped align-middle mb-0 w-100 data-table">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Fakultas</th>
                    <th>Program Studi</th>
                    <th>Angkatan</th>
                    <th>JK</th>
                    <th>No. HP</th>
                    <th>Email</th>
                    <th>Status Mahasiswa</th>
                    <th class="text-end no-sort">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!$rows): ?>
                <tr>
                    <td colspan="11" class="text-center py-5 text-secondary">Belum ada data.</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($rows as $row): ?>
                <?php
                $statusValue = trim((string)($row['status_mahasiswa'] ?? ''));
                $statusClass = match (strtolower($statusValue)) {
                    'aktif' => 'success',
                    'lulus', 'alumni' => 'primary',
                    'cuti' => 'warning',
                    default => 'secondary',
                };
                ?>
                <tr>
                    <td><?= e($row['nim']) ?></td>
                    <td class="fw-semibold"><?= e($row['nama']) ?></td>
                    <td><?= e($row['nik'] ?? '-') ?></td>
                    <td><?= e($row['fakultas'] ?? '-') ?></td>
                    <td><?= e($row['program_studi'] ?? '-') ?></td>
                    <td><?= e($row['angkatan'] ?? '-') ?></td>
                    <td><?= e($row['jenis_kelamin'] ?? '-') ?></td>
                    <td><?= e($row['no_hp'] ?? ($row['no_telepon'] ?? '-')) ?></td>
                    <td><?= e($row['email'] ?? '-') ?></td>
                    <td>
                        <?php if ($statusValue !== ''): ?>
                            <span class="badge text-bg-<?= $statusClass ?>"><?= e($statusValue) ?></span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td class="text-end text-nowrap">
                        <a class="btn btn-sm btn-outline-primary" href="mahasiswa-form.php?id=<?= (int)$row['id'] ?>" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="post" action="mahasiswa-delete.php" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
