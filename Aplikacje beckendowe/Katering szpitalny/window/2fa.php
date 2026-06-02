<!-- formularz dla 2FA obslugiwnay jest analogicznie jak logowanie 1:skrypt js 2:wysyłka na serwer i odebranie danych i podjęcie decyzji co dalej -->
<!-- assets/logowanie/logowanie_2fa.js -->
<?php require_once '../template/header.php'; ?>

<div class="container-fluid login-page">
    <div class="login-wrapper">
        <div class="login-top-icon">
            <i class="bi bi-shield-lock"></i>
        </div>

        <div class="login-heading">
            <h2>Weryfikacja 2FA</h2>
            <p>Wprowadź kod wysłany na adres e-mail</p>
        </div>

        <div class="login-card">
            <form id="codeForm" novalidate>
                <div class="form-group">
                    <label for="code" class="form-label-custom">Kod z e-maila</label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-key"></i>
                        </span>
                        <input
                            type="text"
                            id="code"
                            name="code"
                            class="form-control text-center fw-semibold"
                            maxlength="6"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            placeholder="Wpisz 6-cyfrowy kod"
                        >
                    </div>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="bi bi-check2-circle me-2"></i>
                    Potwierdź kod
                </button>
            </form>

            <div id="resultBox"></div>

            <div class="login-footer-info">
                <span><i class="bi bi-envelope-check me-1"></i>Kod jednorazowy</span>
                <span><i class="bi bi-shield-check me-1"></i>Dodatkowe zabezpieczenie</span>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/logowanie/logowanie_2fa.js"></script>

<?php require_once '../template/footer.php'; ?>