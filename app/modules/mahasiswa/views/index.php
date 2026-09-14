<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
<form class="row g-2 flex-grow-1" method="get">
    <div class="col-md-5"><input class="form-control" name="q" value="<?= e($q) ?>" placeholder="Cari NIM, nama, email, prodi..."></div>
    <div class="col-md-2"><input class="form-control" name="angkatan" value="<?= e($angkatan) ?>" placeholder="Angkatan"></div>
    <div class="col-md-3"><select class="form-select" name="status"><option value="">Semua status</option><?php foreach(['aktif','cuti','lulus','nonaktif'] as $s): ?><option value="<?= $s ?>" <?= $status===$s?'selected':'' ?>><?= ucfirst($s) ?></option><?php endforeach; ?></select></div>
    <div class="col-auto"><button class="btn btn-outline-secondary">Cari</button></div>
</form>
<a href="mahasiswa-form.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Mahasiswa</a>
</div>

<div class="card border-0 shadow-sm">
<div class="table-responsive">
<table id="mahasiswaTable" class="table table-hover table-striped align-middle mb-0 w-100">
<thead><tr><th>NIM</th><th>Nama</th><th>Prodi</th><th>Angkatan</th><th>Semester</th><th>Status</th><th class="text-end no-sort">Aksi</th></tr></thead>
<tbody>
<?php if(!$rows): ?><tr><td colspan="7" class="text-center py-5 text-secondary">Belum ada data.</td></tr><?php endif; ?>
<?php foreach($rows as $row): ?>
<tr>
<td><?= e($row['nim']) ?></td><td class="fw-semibold"><?= e($row['nama']) ?></td><td><?= e($row['prodi']??'-') ?></td>
<td><?= e($row['angkatan']??'-') ?></td><td><?= e($row['semester']??'-') ?></td>
<td><span class="badge text-bg-<?= $row['status']==='aktif'?'success':($row['status']==='lulus'?'primary':'secondary') ?>"><?= e(ucfirst($row['status'])) ?></span></td>
<td class="text-end">
<a class="btn btn-sm btn-outline-primary" href="mahasiswa-form.php?id=<?= (int)$row['id'] ?>"><i class="bi bi-pencil"></i></a>
<form method="post" action="mahasiswa-delete.php" class="d-inline" onsubmit="return confirm('Hapus data ini?')"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$row['id'] ?>"><button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
</td>
</tr>
<?php endforeach; ?>
</tbody></table>
</div></div>
