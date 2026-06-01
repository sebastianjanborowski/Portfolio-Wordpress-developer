<?php require_once '../template/header.php'; ?>

<main class="dashboard-page">
    <div class="container-fluid">
        <div class="dashboard-wrapper">

            <section class="dashboard-header">
                <div class="login-top-icon">
                    <i class="bi bi-plus-circle"></i>
                </div>

                <h1>Dodaj nowe zamówienie</h1>
                <p>Uzupełnij dane nowego zamówienia cateringowego</p>
            </section>

            <section class="login-card">
                <form id="orderAddForm" class="row g-3" novalidate>

                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="orderName" class="form-label-custom">Nazwa zamówienia</label>
                            <input
                                type="text"
                                id="orderName"
                                name="orderName"
                                class="form-control"
                                placeholder="Np. Dieta cukrzycowa dla oddziału Interna"
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="orderCode" class="form-label-custom">Kod zamówienia</label>
                            <input
                                type="text"
                                id="orderCode"
                                name="orderCode"
                                class="form-control"
                                placeholder="Np. ZAM001"
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="department" class="form-label-custom">Oddział</label>
                            <select id="department" name="department" class="form-control">
                                <option value="">Wybierz oddział</option>
                                <option value="Chirurgia">Chirurgia</option>
                                <option value="Interna">Interna</option>
                                <option value="Pediatria">Pediatria</option>
                                <option value="Geriatria">Geriatria</option>
                                <option value="Neurologia">Neurologia</option>
                                <option value="Onkologia">Onkologia</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="special" class="form-label-custom">Zamówienie specjalne</label>
                            <select id="special" name="special" class="form-control">
                                <option value="Nie">Nie</option>
                                <option value="Tak">Tak</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group mb-0">
                            <label for="quantity" class="form-label-custom">Liczba porcji</label>
                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                class="form-control"
                                min="1"
                                placeholder="Np. 25"
                            >
                        </div>
                    </div>


                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-0">
                            <label for="restrictions" class="form-label-custom">Ograniczenia / alergeny</label>
                            <input
                                type="text"
                                id="restrictions"
                                name="restrictions"
                                class="form-control"
                                placeholder="Np. bez laktozy, bez glutenu, bez soli"
                            >
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-0">
                            <label for="description" class="form-label-custom">Opis zamówienia</label>
                            <textarea
                                id="description"
                                name="description"
                                class="form-control"
                                rows="5"
                                placeholder="Wpisz opis zamówienia cateringowego"
                            ></textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-0">
                            <label for="additionalDescription" class="form-label-custom">Dodatkowe uwagi</label>
                            <textarea
                                id="additionalDescription"
                                name="additionalDescription"
                                class="form-control"
                                rows="3"
                                placeholder="Dodatkowe informacje dotyczące realizacji zamówienia"
                            ></textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex flex-column flex-sm-row gap-2 pt-2">
                            <button type="submit" class="btn btn-login">
                                <i class="bi bi-save me-2"></i>Zapisz zamówienie
                            </button>

                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Wyczyść formularz
                            </button>

                            <a href="dashboard_orders.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Wróć
                            </a>
                        </div>
                    </div>

                    <div id="odp"></div>
                </form>

                <div class="login-footer-info">
                    <span><i class="bi bi-journal-plus me-1"></i>Dodawanie nowego zamówienia</span>
                    <span><i class="bi bi-basket2 me-1"></i>Obsługa zamówień cateringowych</span>
                </div>
            </section>

        </div>
    </div>
</main>

<?php require_once '../template/footer.php'; ?>