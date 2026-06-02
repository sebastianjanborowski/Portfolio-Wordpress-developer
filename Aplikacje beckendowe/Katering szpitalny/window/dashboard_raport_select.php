<?php
// w tym pliku są podopcje głównych sekcji systemu, architektura analogiczna jak w przypadku dashboard
// i tu też będzie ten sam mechanizm weryfikacji roli użytkownika
require_once '../template/header.php';
?>

<main class="dashboard-page">
    <div class="container-fluid">
        <div class="dashboard-wrapper">

            <!-- ========================================
                 SEKCJA: NAGŁÓWEK
            ========================================= -->
            <section class="dashboard-header">
                <div class="login-top-icon">
                    <i class="bi bi-grid-1x2-fill"></i>
                </div>

                <h1>Szczegółowe Raporty</h1>
                <p>Wybierz sekcję, którą chcesz zarządzać w systemie</p>
            </section>

            <!-- ========================================
                 SEKCJA: KAFELKI AKCJI
            ========================================= -->
            <section class="dashboard-card">
                <div class="row dashboard-grid justify-content-center">

                    <!-- Użytkownicy -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="view_raport_users.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Użytkownicy</h3>
                                <p>Zarządzaj kontami użytkowników, rolami i dostępami w systemie.</p>
                            </div>
                        </a>
                    </div>

                    <!-- Użytkownicy logowanie -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="view_users_logged.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Logowanie Użytkowników</h3>
                                <p>Zarządzaj kontami użytkowników, rolami i dostępami w systemie.</p>
                            </div>
                        </a>
                    </div>

                    <!-- Posiłki -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="view_raport_diet.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-cup-hot"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Posiłki</h3>
                                <p>Przeglądaj, dodawaj i zarządzaj posiłkami dostępnymi w systemie.</p>
                            </div>
                        </a>
                    </div>

                    <!-- Zamówienia -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="orders.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-basket"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Zamówienia</h3>
                                <p>Obsługuj zamówienia, sprawdzaj statusy i zarządzaj realizacją.</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12">
                        <a href="dashboard_raport.php" class="btn btn-outline-secondary catering-slownik-diet">
                            <i class="bi bi-arrow-left me-2"></i>Wróć
                        </a>
                    </div>
                </div>

                <!-- ========================================
                     SEKCJA: STOPKA
                ========================================= -->
                <div class="dashboard-footer-info">
                    <span><i class="bi bi-kanban me-1"></i>Główne sekcje systemu</span>
                    <span><i class="bi bi-shield-lock me-1"></i>Bezpieczne zarządzanie danymi</span>
                </div>
            </section>

        </div>
    </div>
</main>

<?php require_once '../template/footer.php'; ?>