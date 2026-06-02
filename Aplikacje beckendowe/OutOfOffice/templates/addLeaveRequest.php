<?php
    require_once '../includes/app-security.php';
    ooo_redirect_if_not_logged_in('../public/index.php');

    $pageScript = 'leave-request-create.js';
?>
<?php require_once "../public/header.php"; ?>

<div id="container" class="app-shell">
    <main id="main" class="app-main">
        <div class="container">
            <section id="header" class="app-hero">
                <div class="app-hero-card">
                    <span class="section-kicker">Urlopy</span>
                    <h1 class="app-title">Dodaj wniosek o urlop</h1>
                    <p class="app-subtitle">Uzupełnij dane wniosku urlopowego. Komunikat po zapisie pojawi się pod formularzem.</p>
                </div>
            </section>

            <section id="form" class="app-card">

                    <div class="mb-3 text-start">
                        <label for="Employee" class="form-label">ID pracownika</label>
                        <input 
                            class="form-control input" 
                            id="Employee" 
                            type="number" 
                            name="Employee" 
                            placeholder="Wpisz ID pracownika, np. 1"

                        >
                        <div class="form-text">Podaj ID pracownika, którego dotyczy wniosek.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Absense_Reason" class="form-label">Powód nieobecności</label>
                        <input 
                            class="form-control input" 
                            id="Absense_Reason" 
                            type="text" 
                            name="Absense_Reason" 
                            placeholder="Wpisz powód, np. urlop wypoczynkowy"

                        >
                        <div class="form-text">Podaj powód planowanej nieobecności.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Start_Date" class="form-label">Data rozpoczęcia urlopu</label>
                        <input 
                            class="form-control input" 
                            id="Start_Date" 
                            type="date" 
                            name="Start_Date" 


                        >
                        <div class="form-text">Wybierz pierwszy dzień urlopu.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="End_Date" class="form-label">Data zakończenia urlopu</label>
                        <input 
                            class="form-control input" 
                            id="End_Date" 
                            type="date" 
                            name="End_Date" 


                        >
                        <div class="form-text">Wybierz ostatni dzień urlopu.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Comment" class="form-label">Komentarz do wniosku</label>
                        <input 
                            class="form-control input" 
                            id="Comment" 
                            type="text" 
                            name="Comment" 
                            placeholder="Wpisz komentarz"

                        >
                        <div class="form-text">Dodaj dodatkową informację do wniosku.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Status" class="form-label">Status wniosku</label>
                        <input 
                            class="form-control input" 
                            id="Status" 
                            type="text" 
                            name="Status" 
                            placeholder="Wpisz status, np. oczekuje"

                        >
                        <div class="form-text">Określ status wniosku.</div>
                    </div>

                <button type="button" id="leaveCreateSubmitButton" class="btn btn-primary mt-2">
                    Dodaj wniosek
                </button>

                <div id="formMessage" class="form-message" role="status" aria-live="polite"></div>
            </section>

            <div id="back_to_menu" class="backToMenu">Powrót</div>
        </div>
    </main>
</div>

<?php require_once "../public/footer.php"; ?>
