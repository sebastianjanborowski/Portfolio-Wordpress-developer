<?php
// Simple report orders page
// Display data from raport_orders
// Desktop: table
// Mobile/screen compact: accordion

session_start();
require_once '../core/config/db.php';

$stmt = $pdo->prepare("SELECT * FROM raport_orders ORDER BY id DESC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../template/header.php';
?>

<div class="dashboard-page">
    <div class="container-fluid px-3 px-xl-4">
        <div class="diet-page-wide mx-auto">

            <div class="dashboard-header mb-4">
                <div class="login-top-icon">
                    <i class="bi bi-journal-text"></i>
                </div>

                <h1>Lista raportów zamówień</h1>
                <p>Przegląd raportów związanych z obsługą zamówień cateringowych</p>
            </div>

            <div class="dashboard-card diet-table-card">

                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
                    <div>
                        <h2 class="h5 mb-1 fw-bold text-primary-custom">
                            Wszystkie raporty zamówień
                        </h2>

                        <div class="text-muted small">
                            Liczba rekordów: <?php echo count($data); ?>
                        </div>
                    </div>

                    <div>
                        <a href="dashboard_raport_show.php" class="btn btn-outline-secondary diet-back-btn-bootstrap">
                            <i class="bi bi-arrow-left me-2"></i>Wróć
                        </a>
                    </div>
                </div>

                <?php if (!empty($data)): ?>

                    <!-- DESKTOP TABLE -->
                    <div class="table-responsive diet-table-bootstrap-wrap reports-desktop-table mb-4">
                        <table class="table table-hover align-middle mb-0 diet-table-bootstrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kto</th>
                                    <th>Rodzaj operacji</th>
                                    <th>Data operacji</th>
                                    <th>Nazwa obiektu</th>
                                    <th>Oddział</th>
                                    <th>Nazwa zamówienia</th>
                                    <th>Kod zamówienia</th>
                                    <th>Specjalne</th>
                                    <th>Ograniczenia</th>
                                    <th>Opis</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($data as $row): ?>
                                    <?php
                                        $isActive = (int)($row['Is_active'] ?? 0) === 1;
                                        $isSpecial = (int)($row['Is_special'] ?? 0) === 1;
                                    ?>

                                    <tr>
                                        <td class="fw-semibold">
                                            <?php echo htmlspecialchars($row['id'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['Who'] ?? ''); ?>
                                        </td>

                                        <td class="fw-semibold">
                                            <?php echo htmlspecialchars($row['Type_operation'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['Created_at'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['Name'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['Department_id'] ?? ''); ?>
                                        </td>

                                        <td class="fw-semibold">
                                            <?php echo htmlspecialchars($row['Order_name'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <span class="badge rounded-pill diet-code-badge">
                                                <?php echo htmlspecialchars($row['Order_code'] ?? ''); ?>
                                            </span>
                                        </td>

                                        <td>
                                            <?php if ($isSpecial): ?>
                                                <span class="badge rounded-pill bg-warning text-dark">Tak</span>
                                            <?php else: ?>
                                                <span class="badge rounded-pill bg-secondary">Nie</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-wrap diet-col-wide">
                                            <?php echo htmlspecialchars($row['Order_restrictions'] ?? ''); ?>
                                        </td>

                                        <td class="text-wrap diet-col-wide">
                                            <?php echo htmlspecialchars($row['Order_description'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php if ($isActive): ?>
                                                <span class="badge rounded-pill bg-success">Aktywne</span>
                                            <?php else: ?>
                                                <span class="badge rounded-pill bg-danger">Nieaktywne</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- ACCORDION METHOD -->
                    <div class="accordion reports-accordion reports-mobile-accordion" id="reportsAccordion">

                        <?php foreach ($data as $index => $row): ?>
                            <?php
                                $isActive = (int)($row['Is_active'] ?? 0) === 1;
                                $isSpecial = (int)($row['Is_special'] ?? 0) === 1;

                                $accordionId = 'report_' . $index . '_' . (int)($row['id'] ?? 0);
                                $headingId = 'heading_' . $accordionId;
                                $collapseId = 'collapse_' . $accordionId;
                            ?>

                            <div class="accordion-item report-mobile-item">

                                <h2 class="accordion-header" id="<?php echo $headingId; ?>">
                                    <button
                                        class="accordion-button <?php echo $index === 0 ? '' : 'collapsed'; ?>"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#<?php echo $collapseId; ?>"
                                        aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                                        aria-controls="<?php echo $collapseId; ?>"
                                    >
                                        <span class="fw-semibold me-2">
                                            #<?php echo htmlspecialchars($row['id'] ?? ''); ?>
                                        </span>

                                        <?php echo htmlspecialchars($row['Order_code'] ?? 'Brak kodu'); ?>

                                        —

                                        <?php echo htmlspecialchars($row['Type_operation'] ?? 'Brak operacji'); ?>
                                    </button>
                                </h2>

                                <div
                                    id="<?php echo $collapseId; ?>"
                                    class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>"
                                    aria-labelledby="<?php echo $headingId; ?>"
                                    data-bs-parent="#reportsAccordion"
                                >
                                    <div class="accordion-body">

                                        <p>
                                            <strong>Kto:</strong>
                                            <?php echo htmlspecialchars($row['Who'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Rodzaj operacji:</strong>
                                            <?php echo htmlspecialchars($row['Type_operation'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Data operacji:</strong>
                                            <?php echo htmlspecialchars($row['Created_at'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Nazwa obiektu:</strong>
                                            <?php echo htmlspecialchars($row['Name'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Oddział:</strong>
                                            <?php echo htmlspecialchars($row['Department_id'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Nazwa zamówienia:</strong>
                                            <?php echo htmlspecialchars($row['Order_name'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Kod zamówienia:</strong>
                                            <?php echo htmlspecialchars($row['Order_code'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Zamówienie specjalne:</strong>
                                            <?php echo $isSpecial ? 'Tak' : 'Nie'; ?>
                                        </p>

                                        <p>
                                            <strong>Ograniczenia:</strong>
                                            <?php echo htmlspecialchars($row['Order_restrictions'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Opis:</strong>
                                            <?php echo htmlspecialchars($row['Order_description'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Status:</strong>

                                            <?php if ($isActive): ?>
                                                <span class="badge rounded-pill bg-success">Aktywne</span>
                                            <?php else: ?>
                                                <span class="badge rounded-pill bg-danger">Nieaktywne</span>
                                            <?php endif; ?>
                                        </p>

                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>

                    </div>

                <?php else: ?>

                    <div class="text-center py-5">
                        <i class="bi bi-journal-x display-4 text-muted"></i>

                        <h3 class="mt-3">Brak raportów</h3>

                        <p class="text-muted">
                            W tabeli raportów zamówień nie ma jeszcze żadnych danych.
                        </p>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php require_once '../template/footer.php'; ?>