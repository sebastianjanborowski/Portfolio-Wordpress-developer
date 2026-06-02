<?php
// w tym pliku są podopcje dla sekcji podglądu raportów na ekranie

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
                    <i class="bi bi-file-earmark-text"></i>
                </div>

                <h1>Podgląd raportów</h1>
                <p>Wybierz typ raportu, który chcesz wyświetlić na ekranie</p>
            </section>

            <!-- ========================================
                 SEKCJA: KAFELKI RAPORTÓW
            ========================================= -->
            <section class="dashboard-card">
                <div class="row dashboard-grid justify-content-center">

                    <!-- Raport zamówień -->
                    <div class="col-12 col-md-6 col-xl-3">
                        <a href="show_raport_orders.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-basket2"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Zamówienia</h3>
                                <p>Wyświetl raport operacji wykonanych na zamówieniach cateringowych.</p>
                            </div>
                        </a>
                    </div>

                    <!-- Raport diet -->
                    <div class="col-12 col-md-6 col-xl-3">
                        <a href="show_raport_diets.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-journal-medical"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Diety</h3>
                                <p>Wyświetl raport dodawania, edycji, akceptacji i usuwania diet.</p>
                            </div>
                        </a>
                    </div>

                    <!-- Raport logowania -->
                    <div class="col-12 col-md-6 col-xl-3">
                        <a href="show_raport_logged.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Logowanie</h3>
                                <p>Wyświetl historię logowań oraz aktywności użytkowników w systemie.</p>
                            </div>
                        </a>
                    </div>

                    <!-- Raport użytkowników -->
                    <div class="col-12 col-md-6 col-xl-3">
                        <a href="show_raport_users.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Użytkownicy</h3>
                                <p>Wyświetl raport operacji wykonanych na kontach użytkowników.</p>
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
                    <span><i class="bi bi-eye me-1"></i>Podgląd raportów na ekranie</span>
                    <span><i class="bi bi-card-list me-1"></i>Raporty systemowe</span>
                </div>
            </section>

        </div>
    </div>
</main>

<?php require_once '../template/footer.php'; ?>