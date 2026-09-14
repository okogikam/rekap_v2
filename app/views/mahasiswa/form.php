<?php $row=$row??[]; ?>
<div class="card border-0 shadow-sm"><div class="card-body p-4">
<form method="post" action="mahasiswa-save.php">
<?= csrf_field() ?><?php if(!empty($row['id'])): ?><input type="hidden" name="id" value="<?= (int)$row['id'] ?>"><?php endif; ?>
<div class="row g-3">
<div class="col-md-4"><label class="form-label">NIM *</label><input class="form-control" name="nim" required value="<?= e($row['nim']??'') ?>"></div>
<div class="col-md-8"><label class="form-label">Nama *</label><input class="form-control" name="nama" required value="<?= e($row['nama']??'') ?>"></div>
<div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="<?= e($row['email']??'') ?>"></div>
<div class="col-md-6"><label class="form-label">Program Studi</label><input class="form-control" name="prodi" value="<?= e($row['prodi']??'') ?>"></div>
<div class="col-md-3"><label class="form-label">Angkatan</label><input type="number" class="form-control" name="angkatan" value="<?= e($row['angkatan']??'') ?>"></div>
<div class="col-md-3"><label class="form-label">Semester</label><input type="number" min="1" max="20" class="form-control" name="semester" value="<?= e($row['semester']??'') ?>"></div>
<div class="col-md-3"><label class="form-label">JK</label><select class="form-select" name="jenis_kelamin"><option value="">-</option><option value="L" <?= ($row['jenis_kelamin']??'')==='L'?'selected':'' ?>>L</option><option value="P" <?= ($row['jenis_kelamin']??'')==='P'?'selected':'' ?>>P</option></select></div>
<div class="col-md-3"><label class="form-label">Status</label><select class="form-select" name="status"><?php foreach(['aktif','cuti','lulus','nonaktif'] as $s): ?><option value="<?= $s ?>" <?= ($row['status']??'aktif')===$s?'selected':'' ?>><?= ucfirst($s) ?></option><?php endforeach; ?></select></div>
</div>
<div class="mt-4 d-flex gap-2"><a href="mahasiswa.php" class="btn btn-light">Batal</a><button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button></div>
</form></div></div>
