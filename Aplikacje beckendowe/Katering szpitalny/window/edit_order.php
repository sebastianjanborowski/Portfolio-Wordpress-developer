<?php
// odpowiada za wyszukanie zamówienia po nazwie i przejście do formularza edycji

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
                <h1>Wyszukiwanie zamówienia do edycji</h1>
                <p>Podaj nazwę zamówienia cateringowego, aby przejść do formularza edycji</p>
            </div>

            <div class="dashboard-card diet-form-card">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
                    <div>
                        <h2 class="h5 mb-1 fw-bold text-primary-custom">Znajdź zamówienie</h2>
                        <div class="text-muted small">
                            Wprowadź prawidłową nazwę zamówienia cateringowego
                        </div>
                    </div>

                    <div>
                        <a href="dashboard_orders.php" class="btn btn-outline-secondary diet-back-btn-bootstrap">
                            <i class="bi bi-arrow-left me-2"></i>Wróć
                        </a>
                    </div>
                </div>

                <form id="catering_edit_order_form" method="POST">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="order_name_find" class="form-label-custom">Kod zamówienia</label>
                            <input
                                type="text"
                                name="order_name"
                                id="order_name_find"
                                class="form-control"
                                placeholder="Podaj kod zamówienia"
                                required
                            >
                            <div id="catering_odp"></div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 mt-4">
                        <a href="dashboard_orders.php" class="btn btn-outline-secondary diet-back-btn-bootstrap">
                            Anuluj
                        </a>

                        <button type="submit" class="btn btn-primary diet-btn-save">
                            <i class="bi bi-pencil-square me-2"></i>Przejdź do edycji
                        </button>
                    </div>
                </form>

                <div class="dashboard-footer-info mt-4">
                    <span><i class="bi bi-basket2"></i> Zamówienia cateringowe</span>
                    <span><i class="bi bi-pencil-square"></i> Edycja istniejącego zamówienia</span>
                </div>
                <div id="catering_response"></div>
            </div>

        </div>
    </div>
</div>

<div class="container catering-margin">
    <div class="row">
        <div class="col-lg-12">
            <div id="catering_container_formularz_edit_order"></div>
            
        </div>
    </div>
</div>

<?php require_once "../template/footer.php"; ?>