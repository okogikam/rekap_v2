<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/core/bootstrap.php';
require_once __DIR__ . '/../../app/modules/kurikulum/KurikulumModel.php';
require_once __DIR__ . '/../../app/modules/kurikulum/KurikulumController.php';
(new KurikulumController())->index();
