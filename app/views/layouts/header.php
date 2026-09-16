<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? APP_NAME) ?> - <?= e(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div class="brand">
            <i class="bi bi-mortarboard-fill"></i>
            <span><?= e(APP_NAME) ?></span>
        </div>
        <nav class="nav flex-column gap-1">
<ul class="nav nav-pills flex-column mb-auto">
<li class="nav-item">
            <a class="nav-link <?= ($active ?? '') === 'dashboard' ? 'active' : '' ?>" href="index.php">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
</li>
<li class="nav-item">
                <a class="nav-link text-white btn-toggle d-flex align-items-center justify-content-between" 
                   data-bs-toggle="collapse" 
                   href="#dataMaster" 
                   role="button" 
                   aria-expanded="false" 
                   aria-controls="dataMaster">
                    <span>
                        <i class="bi bi-database me-2"></i>
                        Data Master
                    </span>
                    <i class="bi bi-chevron-down fs-7"></i>
                </a>
                
                <!-- Sub Menu Produk -->
                <div class="collapse ms-3 mt-1" id="dataMaster">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li>
            <a class="nav-link <?= ($active ?? '') === 'dosen' ? 'active' : '' ?>" href="dosen.php">
                <i class="bi bi-person-badge-fill"></i> Dosen
            </a>
                        </li>
                        <li>
            <a class="nav-link <?= ($active ?? '') === 'mahasiswa' ? 'active' : '' ?>" href="mahasiswa.php">
                <i class="bi bi-people-fill"></i> Mahasiswa
            </a>
                        </li>
                    </ul>
                </div>
            </li>

</ul>



            <div class="nav-section">DATA</div>
            <a class="nav-link <?= ($active ?? '') === 'import_export' ? 'active' : '' ?>" href="import-export.php">
                <i class="bi bi-file-earmark-spreadsheet-fill"></i> Import / Export
            </a>
        </nav>
        <div class="sidebar-bottom">
            <div class="small text-secondary mb-2">Login sebagai</div>
            <div class="fw-semibold"><?= e($_SESSION['user']['name'] ?? '-') ?></div>
            <div class="small text-secondary"><?= e($_SESSION['user']['role'] ?? '-') ?></div>
            <a href="logout.php" class="btn btn-outline-light btn-sm w-100 mt-3">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </a>
        </div>
    </aside>

    <main class="main-content">
        <div class="topbar">
            <div>
                <h1 class="page-title"><?= e($title ?? APP_NAME) ?></h1>
                <div class="text-secondary small"><?= e($subtitle ?? '') ?></div>
            </div>
        </div>

        <?php foreach (pull_flashes() as $flash): ?>
            <div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show" role="alert">
                <?= e($flash['message']) ?>
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endforeach; ?>
