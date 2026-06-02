<?php
session_start();
require_once "../template/header.php";
?>

<div class="dashboard-page user-search-page">
    <div class="container-fluid px-3 px-xl-4">
        <div class="diet-page-wide user-page-wide mx-auto">

            <div class="dashboard-header mb-4">
                <div class="login-top-icon">
                    <i class="bi bi-search"></i>
                </div>
                <h1>Wyszukiwanie użytkownika do aktywacji lub dezaktywacji</h1>
                <p>Podaj login użytkownika, aby przejść do zmiany statusu konta</p>
            </div>

            <div class="dashboard-card diet-form-card user-form-card">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
                    <div>
                        <h2 class="h5 mb-1 fw-bold text-primary-custom">Znajdź użytkownika</h2>
                        <div class="text-muted small">
                            Wprowadź prawidłowy login użytkownika
                        </div>
                    </div>

                    <div>
                        <a href="dashboard_users.php" class="btn btn-outline-secondary diet-back-btn-bootstrap user-back-btn-bootstrap">
                            <i class="bi bi-arrow-left me-2"></i>Wróć
                        </a>
                    </div>
                </div>

                <form id="user_find_form" method="POST" autocomplete="off">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="user_login_find" class="form-label-custom">Login użytkownika</label>
                            <input
                                type="text"
                                name="user_login"
                                id="user_login_find"
                                class="form-control"
                                placeholder="Podaj login użytkownika"
                                required
                            >
                            <div id="user_find_response" class="mt-2"></div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 mt-4">
                        <a href="dashboard_users.php" class="btn btn-outline-secondary diet-back-btn-bootstrap user-back-btn-bootstrap">
                            Anuluj
                        </a>

                        <button type="submit" class="btn btn-primary diet-btn-save user-btn-save">
                            <i class="bi bi-pencil-square me-2"></i>Przejdź dalej
                        </button>
                    </div>
                </form>

                <div class="dashboard-footer-info mt-4">
                    <span><i class="bi bi-people"></i> Zarządzanie użytkownikami systemu</span>
                    <span><i class="bi bi-person-check"></i> Aktywacja i dezaktywacja kont</span>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="container catering-margin">
    <div class="row">
        <div class="col-lg-12">
            <div id="user_container_formularz_edit"></div>
            <div id="user_response"></div>
        </div>
    </div>
</div>

<?php require_once "../template/footer.php"; ?>