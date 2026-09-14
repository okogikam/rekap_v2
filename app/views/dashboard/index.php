<div class="row g-4">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-person-badge-fill"></i></div>
            <div class="stat-label">Total Dosen</div>
            <div class="stat-value"><?= e($stats['dosen']) ?></div>
            <div class="stat-meta"><?= e($stats['dosen_aktif']) ?> aktif</div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="stat-label">Total Mahasiswa</div>
            <div class="stat-value"><?= e($stats['mahasiswa']) ?></div>
            <div class="stat-meta"><?= e($stats['mahasiswa_aktif']) ?> aktif</div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <a href="dosen.php" class="quick-card">
            <i class="bi bi-person-plus-fill"></i>
            <strong>Kelola Dosen</strong>
            <span>Tambah, edit, cari, dan hapus data dosen.</span>
        </a>
    </div>
    <div class="col-md-6 col-xl-3">
        <a href="mahasiswa.php" class="quick-card">
            <i class="bi bi-person-plus"></i>
            <strong>Kelola Mahasiswa</strong>
            <span>Kelola data mahasiswa secara terpusat.</span>
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-body p-4">
        <h5 class="mb-2">Import / Export</h5>
        <p class="text-secondary mb-3">Gunakan Excel/CSV untuk memasukkan data dalam jumlah banyak atau mengunduh data.</p>
        <a href="import-export.php" class="btn btn-primary">
            <i class="bi bi-file-earmark-spreadsheet"></i> Buka Import / Export
        </a>
    </div>
</div>
