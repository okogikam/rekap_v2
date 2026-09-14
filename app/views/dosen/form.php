<?php $row = $row ?? []; ?>
<div class="card border-0 shadow-sm">
<div class="card-body p-4">
<form method="post" action="dosen-save.php">
    <?= csrf_field() ?>
    <?php if (!empty($row['id'])): ?><input type="hidden" name="id" value="<?= (int)$row['id'] ?>"><?php endif; ?>
    <div class="row g-3">
        <div class="col-md-4"><label class="form-label">NIDN *</label><input class="form-control" name="nidn" required value="<?= e($row['nidn'] ?? '') ?>"></div>
        <div class="col-md-8"><label class="form-label">Nama *</label><input class="form-control" name="nama" required value="<?= e($row['nama'] ?? '') ?>"></div>
        <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="<?= e($row['email'] ?? '') ?>"></div>
        <div class="col-md-6"><label class="form-label">NIP</label><input class="form-control" name="nip" value="<?= e($row['nip'] ?? '') ?>"></div>
        <div class="col-md-4"><label class="form-label">Jabatan</label><input class="form-control" name="jabatan" value="<?= e($row['jabatan'] ?? '') ?>"></div>
        <div class="col-md-4"><label class="form-label">No. HP</label><input class="form-control" name="no_hp" value="<?= e($row['no_hp'] ?? '') ?>"></div>
        <div class="col-md-2"><label class="form-label">JK</label><select class="form-select" name="jenis_kelamin"><option value="">-</option><option value="L" <?= ($row['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' ?>>L</option><option value="P" <?= ($row['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>P</option></select></div>
        <div class="col-md-2"><label class="form-label">Status</label><select class="form-select" name="status"><option value="aktif" <?= ($row['status'] ?? 'aktif') === 'aktif' ? 'selected' : '' ?>>Aktif</option><option value="nonaktif" <?= ($row['status'] ?? '') === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option></select></div>
    </div>
    <div class="mt-4 d-flex gap-2"><a href="dosen.php" class="btn btn-light">Batal</a><button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button></div>
</form>
</div>
</div>
