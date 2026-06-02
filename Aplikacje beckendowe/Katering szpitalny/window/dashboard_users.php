<?php
// w tym pliku są podopcje dla sekcji związanej z użytkownikami, architektura analogiczna jak w przypadku dashboard
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
                    <i class="bi bi-people"></i>
                </div>

                <h1>Użytkownicy</h1>
                <p>Wybierz działanie związane z zarządzaniem użytkownikami</p>
            </section>

            <!-- ========================================
                 SEKCJA: KAFELKI AKCJI
            ========================================= -->
            <section class="dashboard-card">
                <div class="row dashboard-grid justify-content-center">

                    <!-- Wszyscy użytkownicy -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="view_users.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-card-list"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Zobacz wszystkich użytkowników</h3>
                                <p>Przegląd pełnej listy użytkowników dostępnych w systemie.</p>
                            </div>
                        </a>
                    </div>

                    <!-- Dodawanie użytkownika -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="add_user.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Dodaj nowego użytkownika</h3>
                                <p>Utwórz nowego użytkownika w systemie szpitalnym.</p>
                            </div>
                        </a>
                    </div>

                    <!-- Edycja użytkownika -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="edit_user.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Edytuj użytkownika</h3>
                                <p>Wyszukaj i zmodyfikuj istniejącego użytkownika w systemie.</p>
                            </div>
                        </a>
                    </div>

                    <!-- Aktywacja / dezaktywacja użytkownika -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="akcept_user.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Aktywacja użytkownika</h3>
                                <p>Wyszukaj użytkownika i zmień jego status aktywności.</p>
                            </div>
                        </a>
                    </div>

                     <!-- kasowanie usera -->
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="delete_user.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-trash"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>kasowanie użytkownika</h3>
                                <p>Wykasuj użyutkownika z systemu</p>
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
                    <span><i class="bi bi-people-fill me-1"></i>Zarządzanie użytkownikami</span>
                    <span><i class="bi bi-shield-lock me-1"></i>Role i uprawnienia systemowe</span>
                </div>
            </section>

        </div>
    </div>
</main>

<?php require_once '../template/footer.php'; ?>