<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/core/bootstrap.php';
require_once __DIR__ . '/../app/modules/import_export/ImportExportController.php';
(new ImportExportController())->import();
