<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/core/bootstrap.php';

if (is_logged_in()) {
    header('Location: index.php'); exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['_csrf'] ?? null)) {
        $error = 'Token keamanan tidak valid.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $stmt = Database::connection()->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            login_user($user);
            header('Location: index.php'); exit;
        }
        $error = 'Email atau password salah.';
    }
}
?>
<!doctype html>
<html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login - <?= e(APP_NAME) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"><link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="assets/css/app.css" rel="stylesheet">
</head><body class="login-page">
<div class="login-card">
<div class="text-center mb-4"><div class="login-logo"><i class="bi bi-mortarboard-fill"></i></div><h3><?= e(APP_NAME) ?></h3><p class="text-secondary mb-0">Silakan masuk untuk melanjutkan</p></div>
<?php if($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<form method="post">
<?= csrf_field() ?>
<div class="mb-3"><label class="form-label">Email</label><input class="form-control form-control-lg" type="email" name="email" value="admin@localhost" required></div>
<div class="mb-3"><label class="form-label">Password</label><input class="form-control form-control-lg" type="password" name="password" required></div>
<button class="btn btn-primary btn-lg w-100">Masuk</button>
</form>
<div class="small text-secondary text-center mt-3">Demo: admin@localhost / password</div>
</div>
</body></html>
