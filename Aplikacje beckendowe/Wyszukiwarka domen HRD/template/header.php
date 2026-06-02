<?php
require_once __DIR__ . '/../includes/app-security.php';
app_start_session();
$pageTitle = $pageTitle ?? 'HRD | Host Ready Domains';
$currentPage = $currentPage ?? '';
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HRD to aplikacja PHP do analizy domen, logowania użytkowników i zapisywania historii wyszukiwań w MySQL.">
    <title><?php echo e($pageTitle); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg app-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php" aria-label="Strona główna HRD">
            <span class="brand-mark">HD</span>
            <span>Host Ready Domains</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Przełącz menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainMenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2 text-center">
                <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'home' ? 'active' : ''; ?>" href="index.php">Start</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#mozliwosci">Możliwości</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#proces">Proces</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#technologie">Technologie</a></li>

                <?php if (is_logged_in()): ?>
                    <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'dashboard' ? 'active' : ''; ?>" href="dashboard.php">Panel</a></li>
                    <li class="nav-item">
                        <a class="btn btn-dark btn-sm px-3" href="logout.php">
                            <i class="bi bi-box-arrow-right me-1"></i> Wyloguj
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm px-3 py-2" href="login.php">
                            <i class="bi bi-person-lock me-1"></i> Logowanie
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
