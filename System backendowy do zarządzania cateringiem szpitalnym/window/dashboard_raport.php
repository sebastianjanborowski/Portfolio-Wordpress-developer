<?php
// w tym pliku są podopcje dla sekcji związanej z raportami, architektura analogiczna jak w przypadku dashboard
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
                    <i class="bi bi-file-earmark-bar-graph"></i>
                </div>

                <h1>Raporty</h1>
                <p>Wybierz działanie związane z raportami i analizą danych</p>
            </section>

            <!-- ========================================
                 SEKCJA: KAFELKI AKCJI
            ========================================= -->
            <section class="dashboard-card">
                <div class="row dashboard-grid justify-content-center">

                    <!-- Lista raportów -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="dashboard_raport_show.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-card-list"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Zobacz wszystkie raporty</h3>
                                <p>Przegląd pełnej listy raportów dostępnych w systemie.</p>
                            </div>
                        </a>
                    </div>


                    <!-- Generowanie raportu -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="dashboard_generate_raport.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-bar-chart-line"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Generuj raport</h3>
                                <p>Wygeneruj zestawienie i analizę na podstawie wybranych danych.</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12">
                        <a href="dashboard.php" class="btn btn-outline-secondary catering-slownik-diet">
                            <i class="bi bi-arrow-left me-2"></i>Wróć
                        </a>
                    </div>
                </div>

                <!-- ========================================
                     SEKCJA: STOPKA
                ========================================= -->
                <div class="dashboard-footer-info">
                    <span><i class="bi bi-file-earmark-text me-1"></i>Zarządzanie raportami</span>
                    <span><i class="bi bi-graph-up-arrow me-1"></i>Analiza i eksport danych</span>
                </div>
            </section>

        </div>
    </div>
</main>

<?php require_once '../template/footer.php'; ?>