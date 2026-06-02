<!-- tu jest cała nawigacja tego co można zrobić tym narzędziem tylko dla zalogowanych 
będzie tu ziamplementowany mechanizm przydzielania dostępu na podstawie wartosci w kolumnie userów o nazwie role
-->
<?php session_start(); ?>
<?php

// badanie czy użytkownik jest autoryzowany do przebywania na tym pliku jak nie to równoznacznie z nie zalogowany
if (!isset($_SESSION['logged_in_user_id']) || !isset($_SESSION['restrictions'])) {
    header('Location: login.php');
    exit;
}

$value = (int)($_SESSION['restrictions']);

?>

<?php require_once '../template/header.php'; ?>

<div class="container-fluid dashboard-page">
    <div class="dashboard-wrapper">

        <div class="login-top-icon">
            <i class="bi bi-grid-1x2"></i>
        </div>

        <div class="login-heading">
            <h2>Panel główny</h2>
            <p>Wybierz moduł systemu</p>
        </div>

        <div class="dashboard-card">
            <div class="row g-3 d-flex justify-content-center">
            <?php if($value === 1 || $value === 2){ ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="dashboard_orders.php" class="dashboard-tile text-decoration-none">
                        <div class="dashboard-tile-icon">
                            <i class="bi bi-bag-check"></i>
                        </div>
                        <div class="dashboard-tile-content">
                            <h3>Zamówienia</h3>
                            <p>Obsługa i podgląd zamówień</p>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <?php if($value === 1 || $value === 2){ ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="dashboard_diet.php" class="dashboard-tile text-decoration-none">
                        <div class="dashboard-tile-icon">
                            <i class="bi bi-cup-hot"></i>
                        </div>
                        <div class="dashboard-tile-content">
                            <h3>Posiłki</h3>
                            <p>Zarządzanie jadłospisem i posiłkami</p>
                        </div>
                    </a>
                </div>
            <?php } ?>

            <?php if($value === 1 || $value === 2 || $value === 3){ ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="dashboard_users.php" class="dashboard-tile text-decoration-none">
                        <div class="dashboard-tile-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="dashboard-tile-content">
                            <h3>Użytkownicy</h3>
                            <p>Zarządzanie kontami użytkowników</p>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <?php if($value === 1 || $value === 2 || $value === 3){ ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="dashboard_raport.php" class="dashboard-tile text-decoration-none">
                        <div class="dashboard-tile-icon">
                            <i class="bi bi-bar-chart"></i>
                        </div>
                        <div class="dashboard-tile-content">
                            <h3>Raporty</h3>
                            <p>Przegląd raportów i statystyk</p>
                        </div>
                    </a>
                </div>
            <?php } ?>
                

                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="/core/wylogowywanie/unlogin.php" class="dashboard-tile text-decoration-none dashboard-tile-danger">
                        <div class="dashboard-tile-icon">
                            <i class="bi bi-box-arrow-right"></i>
                        </div>
                        <div class="dashboard-tile-content">
                            <h3>Wyloguj</h3>
                            <p>Zakończ pracę w systemie</p>
                        </div>
                    </a>
                </div>

            </div>

            <div class="dashboard-footer-info">
                <span><i class="bi bi-shield-lock me-1"></i>Bezpieczna sesja</span>
                <span><i class="bi bi-grid me-1"></i>Panel modułów</span>
            </div>
        </div>

    </div>
</div>

<?php require_once '../template/footer.php'; ?>