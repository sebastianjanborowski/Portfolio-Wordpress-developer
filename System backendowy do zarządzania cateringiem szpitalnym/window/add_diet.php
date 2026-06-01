<!-- ten plik odpowiada za formularz dodawania posiłków do bazy danych, baza sama w sobie rozróznia duplikaty w nazwach diet i nie przepuści duplikatów
łączy się z plikiem  assets/js/rejestracjaDiety/rejestracjaDiety.js
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
                    <i class="bi bi-plus-circle"></i>
                </div>

                <h1>Dodaj nową dietę</h1>
                <p>Uzupełnij dane nowej diety w słowniku</p>
            </section>

            <!-- ========================================
                 SEKCJA: FORMULARZ DODAWANIA DIETY
            ========================================= -->
            <section class="login-card">
                <form id="dietAddForm" class="row g-3" novalidate>

                    <!-- Nazwa diety -->
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="dietName" class="form-label-custom">Nazwa diety</label>
                            <input
                                type="text"
                                id="dietName"
                                name="dietName"
                                class="form-control"
                                placeholder="Np. Dieta lekkostrawna"
                            >
                        </div>
                    </div>

                    <!-- Kod diety -->
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="dietCode" class="form-label-custom">Kod diety</label>
                            <input
                                type="text"
                                id="dietCode"
                                name="dietCode"
                                class="form-control"
                                placeholder="Np. D1, D2, CUKRZYCOWA"
                            >
                        </div>
                    </div>

                    <!-- Dział / oddział -->
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="department" class="form-label-custom">Dział / oddział</label>
                            <select id="department" name="department" class="form-control">
                                <option value="">Wybierz dział</option>
                                <option value="1">Chirurgia</option>
                                <option value="2">Interna</option>
                                <option value="3">Pediatria</option>
                                <option value="4">Geriatria</option>
                                <option value="5">Neurologia</option>
                                <option value="6">Onkologia</option>
                            </select>
                        </div>
                    </div>

                    <!-- Dieta specjalna -->
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="isSpecialDiet" class="form-label-custom">Czy dieta specjalna</label>
                            <select id="isSpecialDiet" name="isSpecialDiet" class="form-control">
                                <option value="0">Nie</option>
                                <option value="1">Tak</option>
                            </select>
                        </div>
                    </div>


                    <!-- Ograniczenia -->
                    <div class="col-12">
                        <div class="form-group mb-0">
                            <label for="dietRestrictions" class="form-label-custom">Ograniczenia / alergeny</label>
                            <input
                                type="text"
                                id="dietRestrictions"
                                name="dietRestrictions"
                                class="form-control"
                                placeholder="Np. bez laktozy, bez glutenu, bez soli"
                            >
                        </div>
                    </div>

                    <!-- Opis -->
                    <div class="col-12">
                        <div class="form-group mb-0">
                            <label for="dietDescription" class="form-label-custom">Opis diety</label>
                            <textarea
                                id="dietDescription"
                                name="dietDescription"
                                class="form-control"
                                rows="5"
                                placeholder="Wpisz opis diety, zasady stosowania i dodatkowe informacje"
                            ></textarea>
                        </div>
                    </div>

                    <!-- Uwagi -->
                    <div class="col-12">
                        <div class="form-group mb-0">
                            <label for="dietNotes" class="form-label-custom">Uwagi dodatkowe</label>
                            <textarea
                                id="dietNotes"
                                name="dietNotes"
                                class="form-control"
                                rows="3"
                                placeholder="Dodatkowe uwagi organizacyjne"
                            ></textarea>
                        </div>
                    </div>

                    <!-- Przyciski -->
                    <div class="col-12">
                        <div class="d-flex flex-column flex-sm-row gap-2 pt-2">
                            <button type="submit" class="btn btn-login">
                                <i class="bi bi-save me-2"></i>Zapisz dietę
                            </button>

                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Wyczyść formularz
                            </button>

                            <a href="dashboard_diet.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Wróć
                            </a>
                        </div>
                    </div>
                    <div id="odp"></div>
                </form>

                <!-- ========================================
                     SEKCJA: STOPKA FORMULARZA
                ========================================= -->
                <div class="login-footer-info">
                    <span><i class="bi bi-journal-plus me-1"></i>Dodawanie nowej diety</span>
                    <span><i class="bi bi-person-lines-fill me-1"></i>Przypisania do pacjentów</span>
                </div>
            </section>

        </div>
    </div>
</main>

<?php require_once '../template/footer.php'; ?>