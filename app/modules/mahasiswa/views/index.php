<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <form class="row g-2 flex-grow-1" method="get">
        <div class="col-md-2">
            <select class="form-select" name="angkatan">
                <option value="">Semua angkatan</option>
               <?php foreach ($listangkatan as $akt): ?>
			<option value="<?= e($akt['angkatan']); ?>"><?= e($akt['angkatan']); ?></option>
                <?php endforeach; ?>
	    </select>
        </div>
        <div class="col-md-3">
            <select class="form-select" name="status">
                <option value="">Semua status</option>
               <?php foreach ($liststatus as $st): ?>
			<option value="<?= trim($st['status_mahasiswa']); ?>"><?= e($st['status_mahasiswa']); ?></option>
                <?php endforeach; ?>
	    </select>
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
                    <th>PA</th>		   
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
                    <td class="fw-semibold"><?= e($row['nama_dosen']) ?></td>
                    <td><?= e($row['angkatan'] ?? '-') ?></td>
                    <td><?= e($row['jenis_kelamin'] ?? '-') ?></td>
                    <td><?= e($row['no_hp'] ?? ($row['no_telepon'] ?? '-')) ?></td>
                    <td><?= e($row['email'] ?? '-') ?></td>
                    <td>
                        <?php if ($row['status_mahasiswa'] !== ''): ?>
                            <span class="<?= strtolower($row['status_mahasiswa']) ?>"><?= e($row['status_mahasiswa']) ?></span>
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
                            <input type="hidden" name="nim" value="<?= e($row['nim']) ?>">
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
