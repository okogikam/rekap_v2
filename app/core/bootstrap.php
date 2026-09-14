<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../helpers/view.php';
require_once __DIR__ . '/../helpers/response.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
