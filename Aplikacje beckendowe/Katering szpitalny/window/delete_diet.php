<?php
// odpowiada za wyszukanie danych po nazwie diety i zwrócenie ich z użyciem js na ekran
// oraz dokonanie usunięcia diety z bazy danych
session_start();
require_once "../template/header.php";
?>

<div class="dashboard-page">
    <div class="container-fluid px-3 px-xl-4">
        <div class="diet-page-wide mx-auto">

            <div class="dashboard-header mb-4">
                <div class="login-top-icon">
                    <i class="bi bi-search"></i>
                </div>
                <h1>Wyszukiwanie diety do usunięcia</h1>
                <p>Podaj kod diety, aby przejść do formularza kasowania</p>
            </div>

            <div class="dashboard-card diet-form-card">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
                    <div>
                        <h2 class="h5 mb-1 fw-bold text-primary-custom">Znajdź dietę</h2>
                        <div class="text-muted small">
                            Wprowadź prawidłowy kod diety
                        </div>
                    </div>

                    <div>
                        <a href="dashboard_diet.php" class="btn btn-outline-secondary diet-back-btn-bootstrap">
                            <i class="bi bi-arrow-left me-2"></i>Wróć
                        </a>
                    </div>
                </div>

                <form id="catering_delete_diet_form" method="POST">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="diet_name_find" class="form-label-custom">Kod diety</label>
                            <input
                                type="text"
                                name="diet_name"
                                id="diet_name_find"
                                class="form-control"
                                placeholder="Podaj kod diety"
                                required
                            >
                            <div id="catering_odp"></div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 mt-4">
                        <a href="dashboard_diet.php" class="btn btn-outline-secondary diet-back-btn-bootstrap">
                            Anuluj
                        </a>

                        <button type="submit" class="btn btn-danger diet-btn-save">
                            <i class="bi bi-trash me-2"></i>Przejdź do kasowania
                        </button>
                    </div>
                </form>

                <div class="dashboard-footer-info mt-4">
                    <span><i class="bi bi-journal-medical"></i> Zarządzanie słownikiem diet</span>
                    <span><i class="bi bi-trash"></i> Przejście do kasowania po nazwie diety</span>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="container catering-margin">
    <div class="row">
        <div class="col-lg-12">
            <div id="catering_container_formularz_edit"></div>
            <div id="catering_response"></div>
        </div>
    </div>
</div>

<?php require_once "../template/footer.php"; ?>