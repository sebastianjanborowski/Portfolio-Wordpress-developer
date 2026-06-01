<?php
session_start();
require_once '../template/header.php';
require_once '../core/config/db.php';

/*
|--------------------------------------------------------------------------
| POBRANIE DANYCH DO PDF
|--------------------------------------------------------------------------
| Dane nie są wyświetlane na stronie.
| Są tylko pobierane z bazy i przekazywane do JavaScript.
*/
$pdfRows = [];

try {
    $sql = "SELECT 
                `id`,
                `kto`,
                `rodzajOperacji`,
                `nazwaObiektu`,
                `czas`,
                `department_id`,
                `diet_name`,
                `diet_code`,
                `is_special_diet`,
                `diet_restrictions`,
                `diet_description`,
                `diet_notes`,
                `is_active`
            FROM `raport_diet`
            ORDER BY `id` DESC";

    $stmt = $pdo->query($sql);
    $pdfRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['bad_request'] = 'Błąd pobierania danych do PDF: ' . $e->getMessage();
}
?>

<main class="dashboard-page">
    <div class="container-fluid">
        <div class="dashboard-wrapper">

            <!-- ========================================
                 SEKCJA: NAGŁÓWEK
            ========================================= -->
            <section class="dashboard-header">
                <div class="login-top-icon">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i>
                </div>

                <h1>Wybierz sposób generowania raportu</h1>
                <p>Wybierz metodę, której chcesz użyć do utworzenia pliku z danymi</p>

                <?php if (isset($_SESSION['bad_request'])): ?>
                    <p class="raport-message raport-message-error">
                        <?php echo htmlspecialchars($_SESSION['bad_request'], ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    <?php unset($_SESSION['bad_request']); ?>
                <?php endif; ?>

                <p id="pdfMessage" class="raport-message raport-message-info d-none"></p>
            </section>

            <!-- ========================================
                 SEKCJA: KAFELKI AKCJI
            ========================================= -->
            <section class="dashboard-card">
                <div class="row dashboard-grid">

                    <!-- Generowanie PHP -->
                    <div class="col-12 col-md-6">
                        <a href="/core/generowanieRaportuCSV/generowanieRaportuUzytkownik.php?typ=diet" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-filetype-php"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Eksport do pliku CSV</h3>
                                <p>Wygeneruje raport na temat aktywności użytkowników i zapisze go do pliku .csv</p>
                            </div>
                        </a>
                    </div>

                    <!-- Generowanie JS PDF -->
                    <div class="col-12 col-md-6">
                        <a href="#" id="generateUsersPdf" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Eksport do pliku PDF</h3>
                                <p>Wygeneruje raport na temat aktywności użytkowników i zapisze go do pliku .pdf</p>
                            </div>
                        </a>
                    </div>

                    <!-- Powrót -->
                    <div class="col-12">
                        <a href="dashboard_generate_raport.php" class="btn btn-outline-secondary catering-slownik-diet">
                            <i class="bi bi-arrow-left me-2"></i>Wróć
                        </a>
                    </div>
                </div>

                <!-- ========================================
                     SEKCJA: STOPKA
                ========================================= -->
                <div class="dashboard-footer-info">
                    <span><i class="bi bi-kanban me-1"></i>Wybór metody generowania</span>
                    <span><i class="bi bi-shield-lock me-1"></i>Bezpieczna obsługa danych</span>
                </div>
            </section>

        </div>
    </div>
</main>

<script>
    window.reportPdfConfig = {
        title: 'Raport diet',
        sourceTable: 'raport_diet',
        filePrefix: 'raport_diet',
        columns: [
            { key: 'id', label: 'ID' },
            { key: 'kto', label: 'Kto' },
            { key: 'rodzajOperacji', label: 'Rodzaj operacji' },
            { key: 'nazwaObiektu', label: 'Nazwa zmienianego obiektu' },
            { key: 'czas', label: 'Wykonano' },
            { key: 'department_id', label: 'Odział' },
            { key: 'diet_name', label: 'Nazwa diety' },
            { key: 'diet_code', label: 'Kod diety' },
            { key: 'is_special_diet', label: 'Czy specialna dieta' },
            { key: 'diet_restrictions', label: 'Obostrzenia' },
            { key: 'diet_description', label: 'Opis' },
            { key: 'diet_notes', label: 'Dodatkowe notatki' },
            { key: 'is_active', label: 'Status' }
        ],
        rows: <?php echo json_encode($pdfRows, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
};</script>


<?php require_once '../template/footer.php'; ?>