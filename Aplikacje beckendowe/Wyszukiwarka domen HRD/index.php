<?php

declare(strict_types=1);

require_once 'includes/app-security.php';
app_start_session();

$pageTitle = 'HRD | Aplikacja PHP do sprawdzania domen';
$currentPage = 'home';

$errorMessage = get_flash('error');
$successMessage = get_flash('success');
$domainResult = $_SESSION['last_domain_result'] ?? null;
unset($_SESSION['last_domain_result']);

require_once 'template/header.php';
?>

<main>
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-6">
                    <span class="section-kicker">Aplikacja PHP + MySQL</span>
                    <h1 class="hero-title">Analizuj domeny i zapisuj historię wyszukiwań.</h1>
                    <p class="hero-text">
                        HRD to kompletna aplikacja demonstracyjna do portfolio PHP Developera. System sprawdza format domeny,
                        wykonuje podstawową analizę DNS, zapisuje wynik w bazie MySQL i udostępnia historię w panelu użytkownika.
                    </p>

                    <div class="hero-actions">
                        <a target="_blank" href="https://who.is/" class="btn btn-primary btn-lg">
                            <i class="bi bi-globe2 me-2"></i> Sprawdź domenę
                        </a>

                        <?php if (is_logged_in()): ?>
                            <a href="dashboard.php" class="btn btn-outline-dark btn-lg">
                                <i class="bi bi-speedometer2 me-2"></i> Przejdź do panelu
                            </a>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-outline-dark btn-lg">
                                <i class="bi bi-person-lock me-2"></i> Zaloguj się
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="hero-proof mt-4">
                        <span><i class="bi bi-check-circle-fill"></i> PHP 8</span>
                        <span><i class="bi bi-check-circle-fill"></i> PDO</span>
                        <span><i class="bi bi-check-circle-fill"></i> MySQL</span>
                        <span><i class="bi bi-check-circle-fill"></i> Bootstrap 5</span>
                    </div>
                </div>

                <div class="col-12 col-lg-6" id="sprawdz">
                    <div class="domain-box">
                        <span class="section-kicker">Weryfikacja domeny</span>
                        <h2 class="domain-title">Sprawdź domenę</h2>
                        <p class="domain-desc">
                            Wpisz domenę razem z końcówką. Aplikacja sprawdzi jej format oraz podstawowe rekordy DNS: A, AAAA, MX i NS.
                        </p>

                        <?php if ($errorMessage): ?>
                            <div class="alert alert-danger" role="alert"><?php echo e($errorMessage); ?></div>
                        <?php endif; ?>

                        <?php if ($successMessage): ?>
                            <div class="alert alert-success" role="alert"><?php echo e($successMessage); ?></div>
                        <?php endif; ?>

                        <?php require 'template/domain-form.php'; ?>

                        <?php if ($domainResult): ?>
                            <div class="result-card mt-4">
                                <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                                    <div>
                                        <span class="small-label">Wynik analizy</span>
                                        <h3><?php echo e($domainResult['domain']); ?></h3>
                                        <p><?php echo e($domainResult['message']); ?></p>
                                        <p class="result-recommendation"><?php echo e($domainResult['recommendation']); ?></p>
                                    </div>
                                    <div>
                                        <span class="badge text-bg-<?php echo e($domainResult['badge']); ?> result-badge">
                                            <?php echo e($domainResult['short_status']); ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="dns-grid mt-3">
                                    <div class="dns-item <?php echo !empty($domainResult['dns_a']) ? 'dns-active' : ''; ?>">A</div>
                                    <div class="dns-item <?php echo !empty($domainResult['dns_aaaa']) ? 'dns-active' : ''; ?>">AAAA</div>
                                    <div class="dns-item <?php echo !empty($domainResult['dns_mx']) ? 'dns-active' : ''; ?>">MX</div>
                                    <div class="dns-item <?php echo !empty($domainResult['dns_ns']) ? 'dns-active' : ''; ?>">NS</div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <p class="domain-note mt-3">
                            Uwaga: brak rekordów DNS nie daje stuprocentowej gwarancji, że domena jest wolna. Pełną dostępność potwierdza rejestrator domen lub WHOIS.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="mozliwosci" class="section-padding">
        <div class="container">
            <div class="section-heading text-center">
                <span class="section-kicker">Możliwości</span>
                <h2>Co potrafi aplikacja?</h2>
                <p>
                    Projekt nie jest pustym landing page’em. Zawiera realną logikę backendową, bazę danych, sesje użytkownika i zapisywanie wyników.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="bi bi-globe2"></i>
                        <h3>Analiza domeny</h3>
                        <p>System normalizuje wpisaną wartość, usuwa protokół, ścieżki i prefiks www, a następnie sprawdza poprawność domeny.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="bi bi-hdd-network"></i>
                        <h3>Podstawowe DNS</h3>
                        <p>Aplikacja sprawdza rekordy A, AAAA, MX i NS. Dzięki temu użytkownik widzi, czy domena posiada aktywną konfigurację.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="bi bi-database-check"></i>
                        <h3>Historia w MySQL</h3>
                        <p>Każde wyszukiwanie jest zapisywane w tabeli <code>domain_searches</code> razem ze statusem, komunikatem, IP i datą.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="bi bi-shield-lock"></i>
                        <h3>Bezpieczne logowanie</h3>
                        <p>Hasła są przechowywane jako hash i weryfikowane przez <code>password_verify()</code>. Formularze używają tokenu CSRF.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="bi bi-person-workspace"></i>
                        <h3>Panel użytkownika</h3>
                        <p>Zalogowany użytkownik może przeglądać swoje wyszukiwania, a administrator widzi pełniejszy zakres danych.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="feature-card">
                        <i class="bi bi-phone"></i>
                        <h3>Responsywny interfejs</h3>
                        <p>Widoki działają na komputerze i telefonie. Tabele na mobile są pokazane jako czytelne karty akordeonu.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="proces" class="section-padding section-muted">
        <div class="container">
            <div class="section-heading text-center">
                <span class="section-kicker">Proces</span>
                <h2>Jak działa sprawdzanie?</h2>
                <p>Aplikacja prowadzi użytkownika przez prosty proces od wpisania domeny do zapisania wyniku w historii.</p>
            </div>

            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="step-card">
                        <span>01</span>
                        <h3>Wpisanie domeny</h3>
                        <p>Użytkownik podaje np. <strong>mojafirma.pl</strong> albo pełny adres URL.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="step-card">
                        <span>02</span>
                        <h3>Walidacja</h3>
                        <p>PHP sprawdza format, długość, kropki, myślniki i końcówkę domeny.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="step-card">
                        <span>03</span>
                        <h3>DNS check</h3>
                        <p>Backend sprawdza wybrane rekordy DNS i tworzy czytelny komunikat.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="step-card">
                        <span>04</span>
                        <h3>Zapis w bazie</h3>
                        <p>Wynik trafia do MySQL i może zostać pokazany w panelu użytkownika.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="technologie" class="section-padding">
        <div class="container">
            <div class="tech-card">
                <div class="row align-items-center g-4">
                    <div class="col-12 col-lg-5">
                        <span class="section-kicker">Technologie</span>
                        <h2>Stack projektu</h2>
                        <p>
                            Projekt został napisany w czystym PHP, bez frameworka, aby pokazać praktyczne podstawy backendu:
                            PDO, sesje, formularze, walidację i pracę z bazą danych.
                        </p>
                    </div>

                    <div class="col-12 col-lg-7">
                        <div class="tech-list">
                            <span>PHP 8</span>
                            <span>MySQL</span>
                            <span>PDO</span>
                            <span>Prepared statements</span>
                            <span>Sessions</span>
                            <span>CSRF token</span>
                            <span>Password hashing</span>
                            <span>DNS check</span>
                            <span>Bootstrap 5</span>
                            <span>JavaScript</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

   

    
</main>

<?php require_once 'template/footer.php'; ?>
