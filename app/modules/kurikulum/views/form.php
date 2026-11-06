<?php
/**
 * Form tambah/edit kurikulum.
 * UI demo: ganti $formData dengan record hasil query ketika integrasi database.
 */
if (!function_exists('e')) {
    function e($value): string {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

$formData = $formData ?? [
    'id' => null,
    'id_kurikulum' => '',
    'index_feeder' => '',
    'program_studi' => 'Pendidikan Komputer',
    'tahun' => date('Y'),
    'nama' => '',
    'angkatan' => '',
    'status' => 1,
    'obe' => 1,
    'sks_wajib' => 0,
    'sks_pilihan' => 0,
    'sks_wajib_lulus' => 0,
    'sks_pilihan_lulus' => 0,
    'sks_ditawarkan' => 0,
];

$isEdit = !empty($formData['id']);
?>
<link rel="stylesheet" href="assets/css/kurikulum.css">

<div class="kurikulum-page">
    <div class="mb-4">
        <div class="text-body-secondary small mb-2">
            <a href="index.php" class="text-decoration-none">Data Master / Kurikulum</a>
            / <?= $isEdit ? 'Edit' : 'Tambah' ?>
        </div>
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div>
                <h1 class="h3 fw-bold mb-1"><?= $isEdit ? 'Edit Kurikulum' : 'Tambah Kurikulum' ?></h1>
                <p class="text-body-secondary mb-0">
                    <?= $isEdit ? 'Perbarui informasi dan ketentuan kurikulum.' : 'Lengkapi identitas dan ketentuan kurikulum baru.' ?>
                </p>
            </div>
            <a href="kurikulum.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <form id="formKurikulum" method="post" action="save-kurikulum.php">
        <?= csrf_field() ?>
        <!-- Tambahkan CSRF token sesuai mekanisme aplikasi. -->
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= (int)$formData['id'] ?>">
        <?php endif; ?>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-body py-3">
                <h2 class="h6 fw-bold mb-0"><i class="bi bi-card-list text-primary me-2"></i>Identitas Kurikulum</h2>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-xl-4">
                        <label for="id_kurikulum" class="form-label">ID Kurikulum <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="id_kurikulum" name="id_kurikulum"
                               maxlength="20" required value="<?= e($formData['id_kurikulum']) ?>"
                               placeholder="Contoh: KUR-2024">
                        <div class="form-text">Maksimal 20 karakter dan harus unik.</div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <label for="index_feeder" class="form-label">Index Feeder</label>
                        <input type="text" class="form-control" id="index_feeder" name="index_feeder"
                               maxlength="20" value="<?= e($formData['index_feeder']) ?>"
                               placeholder="Masukkan index Feeder">
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <label for="program_studi" class="form-label">Program Studi <span class="text-danger">*</span></label>
                        <select class="form-select" id="program_studi" name="program_studi" required>
                            <option value="">Pilih program studi</option>
                            <?php foreach (($listProgramStudi ?? ['Pendidikan Komputer']) as $prodi): ?>
                                <option value="<?= e($prodi) ?>" <?= $formData['program_studi'] === $prodi ? 'selected' : '' ?>>
                                    <?= e($prodi) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <label for="tahun" class="form-label">Tahun Kurikulum <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="tahun" name="tahun"
                               min="1900" max="2100" required value="<?= e($formData['tahun']) ?>">
                    </div>
                    <div class="col-md-6 col-xl-8">
                        <label for="nama" class="form-label">Nama Kurikulum <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama"
                               maxlength="50" required value="<?= e($formData['nama']) ?>"
                               placeholder="Contoh: Kurikulum Pendidikan Komputer 2024">
                    </div>
                    <div class="col-12">
                        <label for="angkatan" class="form-label">Angkatan</label>
                        <input type="text" class="form-control" id="angkatan" name="angkatan"
                               value="<?= e($formData['angkatan']) ?>"
                               placeholder="Contoh: 2024, 2025, 2026">
                        <div class="form-text">Isi angkatan yang menggunakan kurikulum ini.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-body py-3">
                <h2 class="h6 fw-bold mb-0"><i class="bi bi-sliders text-primary me-2"></i>Status dan Implementasi</h2>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label d-block">Status Kurikulum</label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusAktif"
                                       value="1" <?= (int)$formData['status'] === 1 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="statusAktif">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusNonaktif"
                                       value="0" <?= (int)$formData['status'] === 0 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="statusNonaktif">Tidak Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label d-block">Implementasi OBE</label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="obe" id="obeYa"
                                       value="1" <?= (int)$formData['obe'] === 1 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="obeYa">Ya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="obe" id="obeTidak"
                                       value="0" <?= (int)$formData['obe'] === 0 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="obeTidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-body py-3">
                <h2 class="h6 fw-bold mb-0"><i class="bi bi-calculator text-primary me-2"></i>Komposisi dan Ketentuan SKS</h2>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-xl-4">
                        <label for="sks_wajib" class="form-label">SKS Wajib Ditawarkan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" min="0" max="999" class="form-control sks-offered"
                                   id="sks_wajib" name="sks_wajib" required value="<?= e($formData['sks_wajib']) ?>">
                            <span class="input-group-text">SKS</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <label for="sks_pilihan" class="form-label">SKS Pilihan Ditawarkan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" min="0" max="999" class="form-control sks-offered"
                                   id="sks_pilihan" name="sks_pilihan" required value="<?= e($formData['sks_pilihan']) ?>">
                            <span class="input-group-text">SKS</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <label for="sks_ditawarkan" class="form-label">Total SKS Ditawarkan</label>
                        <div class="input-group">
                            <input type="number" min="0" max="999" class="form-control bg-body-secondary"
                                   id="sks_ditawarkan" name="sks_ditawarkan" readonly
                                   value="<?= e($formData['sks_ditawarkan']) ?>">
                            <span class="input-group-text">SKS</span>
                        </div>
                        <div class="form-text">Dihitung otomatis dari SKS wajib + SKS pilihan.</div>
                    </div>
                    <div class="col-md-6 col-xl-6">
                        <label for="sks_wajib_lulus" class="form-label">Minimal SKS Wajib Lulus <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" min="0" max="999" class="form-control"
                                   id="sks_wajib_lulus" name="sks_wajib_lulus" required
                                   value="<?= e($formData['sks_wajib_lulus']) ?>">
                            <span class="input-group-text">SKS</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-6">
                        <label for="sks_pilihan_lulus" class="form-label">Minimal SKS Pilihan Lulus <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" min="0" max="999" class="form-control"
                                   id="sks_pilihan_lulus" name="sks_pilihan_lulus" required
                                   value="<?= e($formData['sks_pilihan_lulus']) ?>">
                            <span class="input-group-text">SKS</span>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info d-flex gap-2 align-items-start mt-3 mb-0">
                    <i class="bi bi-info-circle mt-1"></i>
                    <div class="small">
                        SKS ditawarkan menunjukkan total beban mata kuliah yang tersedia.
                        Minimal SKS lulus menunjukkan ketentuan yang harus dipenuhi mahasiswa.
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-end gap-2 mb-4">
            <a href="kurikulum.php" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Kurikulum' ?>
            </button>
        </div>
    </form>
</div>

<script>
(function () {
    const wajib = document.getElementById('sks_wajib');
    const pilihan = document.getElementById('sks_pilihan');
    const total = document.getElementById('sks_ditawarkan');

    function updateTotal() {
        total.value = (parseInt(wajib.value || 0, 10) || 0)
                    + (parseInt(pilihan.value || 0, 10) || 0);
    }

    wajib.addEventListener('input', updateTotal);
    pilihan.addEventListener('input', updateTotal);
    updateTotal();
})();
</script>
