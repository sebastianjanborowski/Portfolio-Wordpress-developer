<?php
    require_once '../includes/app-security.php';
    ooo_redirect_if_not_logged_in('../public/index.php');

    $pageScript = 'leave-request-delete.js';
?>
<?php require_once "../public/header.php"; ?>

<div id="container" class="app-shell">
    <main id="main" class="app-main">
        <div class="container">
            <section id="header" class="app-hero">
                <div class="app-hero-card">
                    <span class="section-kicker">Urlopy</span>
                    <h1 class="app-title">Usuń wniosek o urlop</h1>
                    <p class="app-subtitle">Podaj ID wniosku urlopowego, który chcesz usunąć. Komunikat pojawi się pod formularzem.</p>
                </div>
            </section>

            <section id="form" class="app-card">

                    <div class="mb-3 text-start">
                        <label for="Id" class="form-label">ID wniosku do usunięcia</label>
                        <input 
                            class="form-control input" 
                            id="Id" 
                            type="number" 
                            name="Id" 
                            placeholder="Wpisz ID wniosku, np. 1"

                        >
                        <div class="form-text">Podaj ID rekordu z tabeli wniosków urlopowych.</div>
                    </div>

                <button type="button" id="leaveDeleteSubmitButton" class="btn btn-primary mt-2">
                    Usuń wniosek
                </button>

                <div id="formMessage" class="form-message" role="status" aria-live="polite"></div>
            </section>

            <div id="back_to_menu" class="backToMenu">Powrót</div>
        </div>
    </main>
</div>

<?php require_once "../public/footer.php"; ?>
