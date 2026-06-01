<!-- w tym pliku są podopcje dla sekcji związanej z posiłkami, architektura analogiczna jak w przypadku dashboard i tu też będzie ten sam
mechanizm weryfikacji roli użytkownika
-->
<?php require_once '../template/header.php'; ?>

<main class="dashboard-page">
    <div class="container-fluid">
        <div class="dashboard-wrapper">

            <!-- ========================================
                 SEKCJA: NAGŁÓWEK
            ========================================= -->
            <section class="dashboard-header">
                <div class="login-top-icon">
                    <i class="bi bi-journal-medical"></i>
                </div>

                <h1>Słownik diet</h1>
                <p>Wybierz działanie związane z zarządzaniem dietami</p>
            </section>

            <!-- ========================================
                 SEKCJA: KAFELKI AKCJI
            ========================================= -->
            <section class="dashboard-card">
                <div class="row dashboard-grid justify-content-center">

                    <!-- Wszystkie diety -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="view_diet.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-card-list"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Zobacz wszystkie diety</h3>
                                <p>Przegląd pełnej listy diet dostępnych w systemie.</p>
                            </div>
                        </a>
                    </div>

                    <!-- Dodawanie diety -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="add_diet.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Dodaj nową dietę</h3>
                                <p>Utwórz nową pozycję w słowniku diet szpitalnych.</p>
                            </div>
                        </a>
                    </div>

                    <!-- Edycja diety -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="edit_diet.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Edytuj dietę</h3>
                                <p>Wyszukaj i zmodyfikuj istniejącą dietę w systemie.</p>
                            </div>
                        </a>
                        
                    </div>

                      <!-- akceptacja diety -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="akcept_diet.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Akceptacja Diety</h3>
                                <p>Wyszukaj w systemie dietę i zatwierdz</p>
                            </div>
                        </a>
                        
                    </div>

                     <!-- kasowanie diety -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="delete_diet.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-trash"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Kasowanie Diety</h3>
                                <p>Wyszukaj w systemie dietę i wykasuj</p>
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
                    <span><i class="bi bi-journal-check me-1"></i>Zarządzanie słownikiem diet</span>
                    <span><i class="bi bi-hospital me-1"></i>Moduł żywienia szpitalnego</span>
                </div>
            </section>

        </div>
    </div>
</main>

<?php require_once '../template/footer.php'; ?>