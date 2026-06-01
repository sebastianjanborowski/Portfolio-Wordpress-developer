<?php
session_start();
require_once '../template/header.php';
require_once '../core/config/db.php';

$pdfRows = [];

try {
    $sql = "SELECT 
                `id`,
                `Who`,
                `Type_operation`,
                DATE_FORMAT(`Created_at`, '%d-%m-%Y %H:%i:%s') AS `Created_at`,
                `Name`,
                `Department_id`,
                `Order_name`,
                `Order_code`,
                `Is_special`,
                `Order_restrictions`,
                `Order_description`,
                `Is_active`
            FROM `raport_orders`
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

            <section class="dashboard-header">
                <div class="login-top-icon">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i>
                </div>

                <h1>Wybierz sposób generowania raportu zamówień</h1>
                <p>Wybierz metodę, której chcesz użyć do utworzenia pliku z danymi zamówień</p>

                <?php if (isset($_SESSION['bad_request'])): ?>
                    <p class="raport-message raport-message-error">
                        <?php echo htmlspecialchars($_SESSION['bad_request'], ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    <?php unset($_SESSION['bad_request']); ?>
                <?php endif; ?>

                <p id="pdfMessage" class="raport-message raport-message-info d-none"></p>
            </section>

            <section class="dashboard-card">
                <div class="row dashboard-grid">
                    <div class="col-12 col-md-6">
                        <a href="/core/generowanieRaportuCSV/generowanieRaportuUzytkownik.php?typ=orders" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-filetype-csv"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Eksport do pliku CSV</h3>
                                <p>Wygeneruje raport zamówień cateringowych i zapisze go do pliku .csv</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6">
                        <a href="#" id="generateUsersPdf" class="dashboard-tile">
                            <div class="dashboard-tile-icon">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </div>
                            <div class="dashboard-tile-content">
                                <h3>Eksport do pliku PDF</h3>
                                <p>Wygeneruje raport zamówień cateringowych i zapisze go do pliku .pdf</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12">
                        <a href="dashboard_generate_raport.php" class="btn btn-outline-secondary catering-slownik-diet">
                            <i class="bi bi-arrow-left me-2"></i>Wróć
                        </a>
                    </div>
                </div>

                <div class="dashboard-footer-info">
                    <span><i class="bi bi-kanban me-1"></i>Wybór metody generowania</span>
                    <span><i class="bi bi-basket2 me-1"></i>Raport zamówień cateringowych</span>
                </div>
            </section>

        </div>
    </div>
</main>

<script>
window.reportPdfConfig = {
    title: 'Raport zamówień cateringowych',
    sourceTable: 'raport_orders',
    filePrefix: 'raport_zamowien_cateringowych',
    columns: [
        { key: 'id', label: 'ID' },
        { key: 'Who', label: 'Kto' },
        { key: 'Type_operation', label: 'Rodzaj operacji' },
        { key: 'Created_at', label: 'Czas wykonania akcji' },
        { key: 'Name', label: 'Nazwa obiektu' },
        { key: 'Department_id', label: 'Oddział' },
        { key: 'Order_name', label: 'Nazwa zamówienia' },
        { key: 'Order_code', label: 'Kod zamówienia' },
        { key: 'Is_special', label: 'Zamówienie specjalne' },
        { key: 'Order_restrictions', label: 'Ograniczenia' },
        { key: 'Order_description', label: 'Opis zamówienia' },
        { key: 'Is_active', label: 'Status' }
    ],
    rows: <?php echo json_encode($pdfRows, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
};
</script>

<?php require_once '../template/footer.php'; ?>