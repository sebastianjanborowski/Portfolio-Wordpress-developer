<?php
    require_once '../includes/app-security.php';
    ooo_redirect_if_not_logged_in('../public/index.php');

    $pageScript = 'employee-update.js';
?>
<?php require_once "../public/header.php"; ?>

<div id="container" class="app-shell">
    <main id="main" class="app-main">
        <div class="container">
            <section id="header" class="app-hero">
                <div class="app-hero-card">
                    <span class="section-kicker">Pracownicy</span>
                    <h1 class="app-title">Aktualizuj pracownika</h1>
                    <p class="app-subtitle">Podaj ID pracownika oraz nowe dane. Komunikat po aktualizacji pojawi się pod formularzem.</p>
                </div>
            </section>

            <section id="form" class="app-card">

                    <div class="mb-3 text-start">
                        <label for="Id" class="form-label">ID pracownika do aktualizacji</label>
                        <input 
                            class="form-control input" 
                            id="Id" 
                            type="number" 
                            name="Id" 
                            placeholder="Wpisz ID pracownika, np. 1"

                        >
                        <div class="form-text">Podaj ID rekordu, który chcesz zmienić.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Full_Name" class="form-label">Imię i nazwisko pracownika</label>
                        <input 
                            class="form-control input" 
                            id="Full_Name" 
                            type="text" 
                            name="Full_Name" 
                            placeholder="Wpisz pełne imię i nazwisko"

                        >
                        <div class="form-text">Podaj aktualną pełną nazwę pracownika.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Subdivision" class="form-label">Dział / jednostka organizacyjna</label>
                        <input 
                            class="form-control input" 
                            id="Subdivision" 
                            type="text" 
                            name="Subdivision" 
                            placeholder="Wpisz dział"

                        >
                        <div class="form-text">Podaj aktualny dział pracownika.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Position" class="form-label">Stanowisko</label>
                        <input 
                            class="form-control input" 
                            id="Position" 
                            type="text" 
                            name="Position" 
                            placeholder="Wpisz stanowisko"

                        >
                        <div class="form-text">Podaj aktualne stanowisko pracownika.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Status" class="form-label">Status pracownika</label>
                        <input 
                            class="form-control input" 
                            id="Status" 
                            type="text" 
                            name="Status" 
                            placeholder="Wpisz status"

                        >
                        <div class="form-text">Podaj aktualny status pracownika.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="People_Partner" class="form-label">ID opiekuna HR / People Partner</label>
                        <input 
                            class="form-control input" 
                            id="People_Partner" 
                            type="number" 
                            name="People_Partner" 
                            placeholder="Wpisz ID opiekuna"

                        >
                        <div class="form-text">Podaj identyfikator opiekuna pracownika.</div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="Out_of_Balance" class="form-label">Wartość Out of Balance</label>
                        <input 
                            class="form-control input" 
                            id="Out_of_Balance" 
                            type="number" 
                            name="Out_of_Balance" 
                            placeholder="Wpisz wartość, np. 0.00"
                            step="0.01" min="0" max="999.99"
                        >
                        <div class="form-text">Podaj wartość liczbową. Możesz użyć dwóch miejsc po przecinku.</div>
                    </div>

                <button type="button" id="employeeUpdateSubmitButton" class="btn btn-primary mt-2">
                    Aktualizuj pracownika
                </button>

                <div id="formMessage" class="form-message" role="status" aria-live="polite"></div>
            </section>

            <div id="back_to_menu" class="backToMenu">Powrót</div>
        </div>
    </main>
</div>

<?php require_once "../public/footer.php"; ?>
