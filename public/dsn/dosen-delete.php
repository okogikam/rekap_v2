<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/core/bootstrap.php';
require_once __DIR__ . '/../../app/modules/dosen/DosenModel.php';
require_once __DIR__ . '/../../app/modules/dosen/DosenController.php';
(new DosenController())->delete();
