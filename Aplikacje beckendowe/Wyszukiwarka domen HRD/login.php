<?php

declare(strict_types=1);

require_once 'includes/app-security.php';
app_start_session();

if (is_logged_in()) {
    redirect_to('dashboard.php');
}

$pageTitle = 'Logowanie | HRD';
$currentPage = 'login';
$errorMessage = get_flash('error');
$successMessage = get_flash('success');

require_once 'template/header.php';
?>

<main class="login-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-lg-5">
                <div class="login-card">
                    <span class="section-kicker">Panel użytkownika</span>
                    <h1>Logowanie</h1>
                    <p>Zaloguj się, aby zobaczyć historię wyszukiwań domen i dane zapisane w bazie MySQL.</p>

                    <?php if ($errorMessage): ?>
                        <div class="alert alert-danger" role="alert"><?php echo e($errorMessage); ?></div>
                    <?php endif; ?>

                    <?php if ($successMessage): ?>
                        <div class="alert alert-success" role="alert"><?php echo e($successMessage); ?></div>
                    <?php endif; ?>

                    <form method="POST" action="core/auth/login.php" class="js-validate-form" novalidate>
                        <input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>">

                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">Login użytkownika</label>
                            <input id="username" name="username" type="text" class="form-control" placeholder="np. admin" required autocomplete="username" data-label="Login użytkownika">
                            <div class="form-text">Wpisz login testowy: <strong>admin</strong> albo <strong>demo</strong>.</div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Hasło</label>
                            <input id="password" name="password" type="password" class="form-control" placeholder="np. admin" required autocomplete="current-password" data-label="Hasło">
                            <div class="form-text">Hasło jest weryfikowane przez <code>password_verify()</code>.</div>
                        </div>

                        <div class="form-message js-form-message mb-3" aria-live="polite"></div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Zaloguj się
                        </button>
                    </form>

                    <div class="demo-login-box mt-4">
                        <strong>Dane testowe:</strong><br>
                        Administrator: <code>admin</code> / <code>admin</code><br>
                        Użytkownik demo: <code>demo</code> / <code>demo123</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'template/footer.php'; ?>
