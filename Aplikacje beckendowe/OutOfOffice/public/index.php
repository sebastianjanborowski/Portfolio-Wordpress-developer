<?php
require_once '../includes/app-security.php';

if (ooo_is_logged_in()) {
    header('Location:../public/menu.php');
    exit;
}

$pageScript = 'auth-login.js';
?>
<?php require_once 'header.php'; ?>

<div id="container" class="app-shell">
    <main id="main" class="app-main">
        <div class="container">
            <section id="header" class="app-hero">
                <div class="app-hero-card">
                    <span class="section-kicker">Backend application</span>
                    <h1 class="app-title">Formularz logowania</h1>
                    <p class="app-subtitle">
                        Profesjonalny panel do zarządzania pracownikami, projektami oraz wnioskami urlopowymi.
                    </p>
                </div>
            </section>

            <section id="form" class="app-card login-card">
                <div class="mb-3 text-start">
                    <label for="login" class="form-label">Login użytkownika</label>
                    <input
                        type="text"
                        id="login"
                        name="login"
                        class="form-control input"
                        placeholder="Wpisz login, np. admin"
                        autocomplete="username"
                    >
                    <div class="form-text">Wpisz login przypisany do konta w systemie.</div>
                </div>

                <div class="mb-4 text-start">
                    <label for="password" class="form-label">Hasło użytkownika</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control input"
                        placeholder="Wpisz hasło"
                        autocomplete="current-password"
                    >
                    <div class="form-text">Wpisz hasło przypisane do konta użytkownika.</div>
                </div>

                <button type="button" id="loginSubmitButton" class="btn btn-primary">
                    Zaloguj
                </button>

                <div id="formMessage" class="form-message" role="status" aria-live="polite"></div>
            </section>
        </div>
    </main>
</div>

<?php require_once 'footer.php'; ?>
