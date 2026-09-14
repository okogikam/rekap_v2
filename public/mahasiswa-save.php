<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/core/bootstrap.php';
require_once __DIR__ . '/../app/modules/mahasiswa/MahasiswaModel.php';
require_once __DIR__ . '/../app/modules/mahasiswa/MahasiswaController.php';
(new MahasiswaController())->save();
