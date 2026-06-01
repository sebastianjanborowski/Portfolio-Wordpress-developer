<?php require_once '../template/header.php'; ?>

<main class="dashboard-page">
    <div class="container-fluid">
        <div class="dashboard-wrapper">

            <section class="dashboard-header">
                <div class="login-top-icon">
                    <i class="bi bi-journal-medical"></i>
                </div>

                <h1>Zamówienia</h1>
                <p>Wybierz działanie związane z obsługą zamówień cateringowych</p>
            </section>

            <section class="dashboard-card">
                <div class="row dashboard-grid justify-content-center">

                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="view_raport_users.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-card-list"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Zobacz wszystkie zamówienia</h3>
                                <p>Przeglądaj pełną listę zamówień cateringowych zapisanych w systemie.</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="add_orders.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Dodaj nowe zamówienie</h3>
                                <p>Utwórz nowe zamówienie cateringowe, wybierz dietę, oddział oraz liczbę porcji.</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="edit_order.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Edytuj zamówienie</h3>
                                <p>Wyszukaj istniejące zamówienie i zmień jego dane.</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="akcept_order.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Zatwierdź zamówienie</h3>
                                <p>Sprawdź zamówienie cateringowe i zatwierdź je do realizacji.</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="delete_order.php" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-trash"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Usuń zamówienie</h3>
                                <p>Wyszukaj zamówienie cateringowe i usuń je z systemu.</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12">
                        <a href="dashboard.php" class="btn btn-outline-secondary catering-slownik-diet">
                            <i class="bi bi-arrow-left me-2"></i>Wróć
                        </a>
                    </div>

                </div>

                <div class="dashboard-footer-info">
                    <span><i class="bi bi-journal-check me-1"></i>Zarządzanie zamówieniami cateringowymi</span>
                    <span><i class="bi bi-hospital me-1"></i>Moduł żywienia szpitalnego</span>
                </div>
            </section>

        </div>
    </div>
</main>

<?php require_once '../template/footer.php'; ?>