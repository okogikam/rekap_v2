<?php $row = $row ?? []; ?>
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="post" action="dosen-save.php">
            <?= csrf_field() ?>
            <?php if (!empty($row['id'])): ?>
                <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
            <?php endif; ?>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">NIDN *</label>
                    <input class="form-control" name="nidn" required value="<?= e($row['nidn'] ?? '') ?>">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Nama *</label>
                    <input class="form-control" name="nama" required value="<?= e($row['nama'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">NIP</label>
                    <input class="form-control" name="nip" value="<?= e($row['nip'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Gelar Depan</label>
                    <input class="form-control" name="gelar_depan" value="<?= e($row['gelar_depan'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Gelar Belakang</label>
                    <input class="form-control" name="gelar_belakang" value="<?= e($row['gelar_belakang'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?= e($row['email'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jabatan</label>
                    <input class="form-control" name="jabatan" placeholder="Contoh: Lektor (300.00)" value="<?= e($row['jabatan'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pangkat / Golongan</label>
                    <input class="form-control" name="pangkat" placeholder="Contoh: III/d (Penata Tk. I)" value="<?= e($row['pangkat'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pendidikan Terakhir</label>
                    <input class="form-control" name="pendidikan_terakhir" value="<?= e($row['pendidikan_terakhir'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <input class="form-control" name="status" value="<?= e($row['status'] ?? '') ?>">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Homebase</label>
                    <input class="form-control" name="homebase" value="<?= e($row['homebase'] ?? '') ?>">
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <a href="dosen.php" class="btn btn-light">Batal</a>
                <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
