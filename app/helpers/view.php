<?php
declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function render(string $view, array $data = []): void
{
    extract($data);
    $viewFile = __DIR__ . '/../views/' . $view . '.php';
    if (!is_file($viewFile)) {
        http_response_code(500);
        exit('View tidak ditemukan: ' . e($view));
    }

    require __DIR__ . '/../views/layouts/header.php';
    require $viewFile;
    require __DIR__ . '/../views/layouts/footer.php';
}
