<?php
    require_once '../includes/app-security.php';
    ooo_redirect_if_not_logged_in('../public/index.php');

    $pageScript = 'approval-request-update.js';
?>
<?php require_once "../public/header.php"; ?>

<div id="container" class="app-shell">
    <main id="main" class="app-main">
        <div class="container">
            <section id="header" class="app-hero">
                <div class="app-hero-card">
                    <span class="section-kicker">Zatwierdzenia</span>
                    <h1 class="app-title">Aktualizuj wniosek o zatwierdzenie</h1>
                    <p class="app-subtitle">Podaj ID zatwierdzenia oraz nowe dane. Komunikat po aktualizacji pojawi się pod formularzem.</p>
                </div>
            </section>

            <section id="form" class="app-card">

                    <div class="mb-3 text-start">
                        <label for="Id" class="form-label">ID zatwierdzenia do aktualizacji</label>
                        <input 
                            class="form-control input" 
                            id="Id" 
                            type="number" 
                            name="Id" 
                            placeholder="Wpisz ID zatwierdzenia, np. 1"

                        >
                        <div class="form-text">Podaj ID rekordu, który chcesz zmienić.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Approver" class="form-label">ID osoby zatwierdzającej</label>
                        <input 
                            class="form-control input" 
                            id="Approver" 
                            type="number" 
                            name="Approver" 
                            placeholder="Wpisz ID zatwierdzającego"

                        >
                        <div class="form-text">Podaj ID osoby, która zatwierdza wniosek.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Leave_Request" class="form-label">ID wniosku urlopowego</label>
                        <input 
                            class="form-control input" 
                            id="Leave_Request" 
                            type="number" 
                            name="Leave_Request" 
                            placeholder="Wpisz ID wniosku urlopowego"

                        >
                        <div class="form-text">Podaj ID wniosku urlopowego do zatwierdzenia.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Status" class="form-label">Status zatwierdzenia</label>
                        <input 
                            class="form-control input" 
                            id="Status" 
                            type="text" 
                            name="Status" 
                            placeholder="Wpisz status"

                        >
                        <div class="form-text">Określ aktualny status zatwierdzenia.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Comment" class="form-label">Komentarz do zatwierdzenia</label>
                        <input 
                            class="form-control input" 
                            id="Comment" 
                            type="text" 
                            name="Comment" 
                            placeholder="Wpisz komentarz"

                        >
                        <div class="form-text">Dodaj dodatkową informację do zatwierdzenia.</div>
                    </div>

                <button type="button" id="approvalUpdateSubmitButton" class="btn btn-primary mt-2">
                    Aktualizuj zatwierdzenie
                </button>

                <div id="formMessage" class="form-message" role="status" aria-live="polite"></div>
            </section>

            <div id="back_to_menu" class="backToMenu">Powrót</div>
        </div>
    </main>
</div>

<?php require_once "../public/footer.php"; ?>
