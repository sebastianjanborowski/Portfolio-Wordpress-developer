<?php
    require_once '../includes/app-security.php';
    ooo_redirect_if_not_logged_in('../public/index.php');

    $pageScript = 'project-create.js';
?>
<?php require_once "../public/header.php"; ?>

<div id="container" class="app-shell">
    <main id="main" class="app-main">
        <div class="container">
            <section id="header" class="app-hero">
                <div class="app-hero-card">
                    <span class="section-kicker">Projekty</span>
                    <h1 class="app-title">Dodaj projekt</h1>
                    <p class="app-subtitle">Uzupełnij dane nowego projektu. Komunikat po zapisie pojawi się pod formularzem.</p>
                </div>
            </section>

            <section id="form" class="app-card">

                    <div class="mb-3 text-start">
                        <label for="Project_Type" class="form-label">Typ / nazwa projektu</label>
                        <input 
                            class="form-control input" 
                            id="Project_Type" 
                            type="text" 
                            name="Project_Type" 
                            placeholder="Wpisz typ projektu, np. Wdrożenie CRM"

                        >
                        <div class="form-text">Podaj nazwę albo rodzaj projektu.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Start_Date" class="form-label">Data rozpoczęcia projektu</label>
                        <input 
                            class="form-control input" 
                            id="Start_Date" 
                            type="date" 
                            name="Start_Date" 


                        >
                        <div class="form-text">Wybierz datę rozpoczęcia projektu.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="End_Date" class="form-label">Data zakończenia projektu</label>
                        <input 
                            class="form-control input" 
                            id="End_Date" 
                            type="date" 
                            name="End_Date" 


                        >
                        <div class="form-text">Wybierz planowaną datę zakończenia projektu.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Project_Manager" class="form-label">ID kierownika projektu</label>
                        <input 
                            class="form-control input" 
                            id="Project_Manager" 
                            type="number" 
                            name="Project_Manager" 
                            placeholder="Wpisz ID kierownika, np. 2"

                        >
                        <div class="form-text">Podaj ID osoby odpowiedzialnej za projekt.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Comment" class="form-label">Komentarz do projektu</label>
                        <input 
                            class="form-control input" 
                            id="Comment" 
                            type="text" 
                            name="Comment" 
                            placeholder="Wpisz krótki komentarz"

                        >
                        <div class="form-text">Dodaj najważniejszą informację organizacyjną.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Status" class="form-label">Status projektu</label>
                        <input 
                            class="form-control input" 
                            id="Status" 
                            type="text" 
                            name="Status" 
                            placeholder="Wpisz status, np. aktywny"

                        >
                        <div class="form-text">Określ aktualny status projektu.</div>
                    </div>

                <button type="button" id="projectCreateSubmitButton" class="btn btn-primary mt-2">
                    Dodaj projekt
                </button>

                <div id="formMessage" class="form-message" role="status" aria-live="polite"></div>
            </section>

            <div id="back_to_menu" class="backToMenu">Powrót</div>
        </div>
    </main>
</div>

<?php require_once "../public/footer.php"; ?>
