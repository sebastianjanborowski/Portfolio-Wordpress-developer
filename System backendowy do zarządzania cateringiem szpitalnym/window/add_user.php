<?php
// ten plik odpowiada za formularz dodawania użytkowników do bazy danych
// łączy się np. z plikiem assets/js/rejestracjaUzytkownika/rejestracjaUzytkownika.js

require_once '../template/header.php';
?>

<main class="dashboard-page">
    <div class="container-fluid">
        <div class="dashboard-wrapper">

            <section class="dashboard-header">
                <div class="login-top-icon">
                    <i class="bi bi-person-plus"></i>
                </div>

                <h1>Dodaj nowego użytkownika</h1>
                <p>Uzupełnij dane nowego użytkownika w systemie</p>
            </section>

            <section class="login-card">
                <form id="userAddForm" class="row g-3" novalidate>

                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="userLogin" class="form-label-custom">Login</label>
                            <input
                                type="text"
                                id="userLogin"
                                name="userLogin"
                                class="form-control"
                                placeholder="Np. admin, sebastian.borowski"
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="userEmail" class="form-label-custom">E-mail</label>
                            <input
                                type="email"
                                id="userEmail"
                                name="userEmail"
                                class="form-control"
                                placeholder="Np. user@firma.pl"
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="userName" class="form-label-custom">Imię</label>
                            <input
                                type="text"
                                id="userName"
                                name="userName"
                                class="form-control"
                                placeholder="Np. Sebastian"
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="userSurname" class="form-label-custom">Nazwisko</label>
                            <input
                                type="text"
                                id="userSurname"
                                name="userSurname"
                                class="form-control"
                                placeholder="Np. Borowski"
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="userRole" class="form-label-custom">Rola</label>
                            <select id="userRole" name="userRole" class="form-control">
                                <option value="">Wybierz rolę</option>
                                <option value="1">Administrator</option>
                                <option value="2">Dietetyk</option>
                                <option value="3">Pracownik kuchni</option>
                                <option value="4">Obsługa oddziału</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="userPassword" class="form-label-custom">Hasło</label>
                            <input
                                type="password"
                                id="userPassword"
                                name="userPassword"
                                class="form-control"
                                placeholder="Wprowadź hasło użytkownika"
                            >
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex flex-column flex-sm-row gap-2 pt-2">
                            <button type="submit" class="btn btn-login">
                                <i class="bi bi-save me-2"></i>Zapisz użytkownika
                            </button>

                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Wyczyść formularz
                            </button>

                            <a href="dashboard_users.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Wróć
                            </a>
                        </div>
                    </div>

                    <div id="odp"></div>
                </form>

                <div class="login-footer-info">
                    <span><i class="bi bi-person-plus-fill me-1"></i>Dodawanie nowego użytkownika</span>
                    <span><i class="bi bi-shield-lock me-1"></i>Uprawnienia i dostęp do systemu</span>
                </div>
            </section>

        </div>
    </div>
</main>

<?php require_once '../template/footer.php'; ?>