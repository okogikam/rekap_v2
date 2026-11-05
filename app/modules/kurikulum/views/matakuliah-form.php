<?php
/**
 * Form tambah/edit mata kuliah pada suatu kurikulum.
 * UI demo: ganti $formData dan $listKurikulum dengan data database.
 */
if (!function_exists('e')) {
    function e($value): string {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

$listKurikulum = $listKurikulum ?? [
    ['id_kurikulum' => 'KUR-2024', 'nama' => 'Kurikulum Pendidikan Komputer 2024', 'tahun' => '2024'],
    ['id_kurikulum' => 'KUR-2020', 'nama' => 'Kurikulum Pendidikan Komputer 2020', 'tahun' => '2020'],
];

$formData = $formData ?? [
    'id' => null,
    'id_kurikulum' => $_GET['id_kurikulum'] ?? 'KUR-2024',
    'kelompok' => '',
    'kode' => '',
    'matakuliah' => '',
    'sks' => 3,
    'semester' => '1',
    'sifat_matakuliah' => 1,
    'prasyarat' => '',
    'praktikum' => 0,
];

$isEdit = !empty($formData['id']);
?>
<link rel="stylesheet" href="assets/css/kurikulum.css">

<div class="kurikulum-page">
    <div class="mb-4">
        <div class="text-body-secondary small mb-2">
            <a href="index.php" class="text-decoration-none">Data Master / Kurikulum</a>
            /
            <a href="detail.php?id=<?= (int)($_GET['kurikulum_id'] ?? 1) ?>" class="text-decoration-none">Detail</a>
            / <?= $isEdit ? 'Edit Matakuliah' : 'Tambah Matakuliah' ?>
        </div>
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div>
                <h1 class="h3 fw-bold mb-1"><?= $isEdit ? 'Edit Matakuliah' : 'Tambah Matakuliah' ?></h1>
                <p class="text-body-secondary mb-0">Masukkan informasi mata kuliah dan pengaturannya pada kurikulum.</p>
            </div>
            <a href="kurikulum-detail.php?id=<?= (int)($_GET['kurikulum_id'] ?? 1) ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
            </a>
        </div>
    </div>

    <form id="formMatakuliah" method="post" action="">
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= (int)$formData['id'] ?>">
        <?php endif; ?>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-body py-3">
                <h2 class="h6 fw-bold mb-0"><i class="bi bi-journal-plus text-primary me-2"></i>Informasi Mata Kuliah</h2>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="id_kurikulum" class="form-label">Kurikulum <span class="text-danger">*</span></label>
                        <select class="form-select" id="id_kurikulum" name="id_kurikulum" required>
                            <option value="">Pilih kurikulum</option>
                            <?php foreach ($listKurikulum as $kur): ?>
                                <option value="<?= e($kur['id_kurikulum']) ?>"
                                    <?= $formData['id_kurikulum'] === $kur['id_kurikulum'] ? 'selected' : '' ?>>
                                    <?= e($kur['nama']) ?> (<?= e($kur['tahun']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Mata kuliah akan dihubungkan ke kurikulum yang dipilih.</div>
                    </div>

                    <div class="col-md-4">
                        <label for="kode" class="form-label">Kode Mata Kuliah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kode" name="kode" maxlength="10"
                               required value="<?= e($formData['kode']) ?>" placeholder="Contoh: PK101">
                    </div>
                    <div class="col-md-8">
                        <label for="matakuliah" class="form-label">Nama Mata Kuliah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="matakuliah" name="matakuliah"
                               required value="<?= e($formData['matakuliah']) ?>"
                               placeholder="Masukkan nama mata kuliah">
                    </div>
                    <div class="col-md-4">
                        <label for="kelompok" class="form-label">Kelompok Mata Kuliah</label>
                        <select class="form-select" id="kelompok" name="kelompok">
                            <option value="">Pilih kelompok</option>
                            <?php foreach (($listKelompok ?? ['MKWK', 'MKK', 'MKB', 'MPK', 'MBB']) as $kelompok): ?>
                                <option value="<?= e($kelompok) ?>" <?= $formData['kelompok'] === $kelompok ? 'selected' : '' ?>>
                                    <?= e($kelompok) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="sks" class="form-label">Bobot SKS <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="sks" name="sks"
                                   min="0" max="99" required value="<?= e($formData['sks']) ?>">
                            <span class="input-group-text">SKS</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                        <select class="form-select" id="semester" name="semester" required>
                            <option value="">Pilih semester</option>
                            <?php for ($semester = 1; $semester <= 14; $semester++): ?>
                                <option value="<?= $semester ?>" <?= (string)$formData['semester'] === (string)$semester ? 'selected' : '' ?>>
                                    Semester <?= $semester ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="prasyarat" class="form-label">Prasyarat</label>
                        <textarea class="form-control" id="prasyarat" name="prasyarat" rows="2"
                                  placeholder="Contoh: PK101 - Algoritma dan Pemrograman"><?= e($formData['prasyarat']) ?></textarea>
                        <div class="form-text">Kosongkan jika mata kuliah tidak memiliki prasyarat.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-body py-3">
                <h2 class="h6 fw-bold mb-0"><i class="bi bi-toggles text-primary me-2"></i>Pengaturan Mata Kuliah</h2>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label d-block">Sifat Mata Kuliah <span class="text-danger">*</span></label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sifat_matakuliah"
                                       id="sifatWajib" value="1"
                                       <?= (int)$formData['sifat_matakuliah'] === 1 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="sifatWajib">Wajib</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sifat_matakuliah"
                                       id="sifatPilihan" value="0"
                                       <?= (int)$formData['sifat_matakuliah'] === 0 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="sifatPilihan">Pilihan</label>
                            </div>
                        </div>
                        <div class="form-text">Nilai database: 1 = Wajib, 0 = Pilihan.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label d-block">Praktikum <span class="text-danger">*</span></label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="praktikum"
                                       id="praktikumYa" value="1"
                                       <?= (int)$formData['praktikum'] === 1 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="praktikumYa">Ya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="praktikum"
                                       id="praktikumTidak" value="0"
                                       <?= (int)$formData['praktikum'] === 0 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="praktikumTidak">Tidak</label>
                            </div>
                        </div>
                        <div class="form-text">Nilai database: 1 = Ya, 0 = Tidak.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-end gap-2 mb-4">
            <a href="kurikulum-detail.php?id=<?= (int)($_GET['kurikulum_id'] ?? 1) ?>" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Matakuliah' ?>
            </button>
        </div>
    </form>
</div>
