<?php
// Simple report login page
// Display data from raport_logowanie
// Desktop: table
// Mobile / compact screen: accordion

session_start();
require_once '../core/config/db.php';

$stmt = $pdo->prepare("SELECT * FROM raport_logowanie ORDER BY id DESC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../template/header.php';
?>

<div class="dashboard-page">
    <div class="container-fluid px-3 px-xl-4">
        <div class="diet-page-wide mx-auto">

            <div class="dashboard-header mb-4">
                <div class="login-top-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>

                <h1>Lista raportów logowania</h1>
                <p>Przegląd historii logowań i operacji użytkowników w systemie</p>
            </div>

            <div class="dashboard-card diet-table-card">

                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
                    <div>
                        <h2 class="h5 mb-1 fw-bold text-primary-custom">
                            Wszystkie raporty logowania
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
                                    <th>Czas wykonania akcji</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($data as $row): ?>
                                    <tr>
                                        <td class="fw-semibold">
                                            <?php echo htmlspecialchars($row['id'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['kto'] ?? ''); ?>
                                        </td>

                                        <td class="fw-semibold">
                                            <?php echo htmlspecialchars($row['rodzajOperacji'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['czas'] ?? ''); ?>
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

                                        <?php echo htmlspecialchars($row['kto'] ?? 'Brak użytkownika'); ?>

                                        —

                                        <?php echo htmlspecialchars($row['rodzajOperacji'] ?? 'Brak operacji'); ?>
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
                                            <strong>ID:</strong>
                                            <?php echo htmlspecialchars($row['id'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Kto:</strong>
                                            <?php echo htmlspecialchars($row['kto'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Rodzaj operacji:</strong>
                                            <?php echo htmlspecialchars($row['rodzajOperacji'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Czas wykonania akcji:</strong>
                                            <?php echo htmlspecialchars($row['czas'] ?? ''); ?>
                                        </p>

                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>

                    </div>

                <?php else: ?>

                    <div class="text-center py-5">
                        <i class="bi bi-shield-x display-4 text-muted"></i>

                        <h3 class="mt-3">Brak raportów logowania</h3>

                        <p class="text-muted">
                            W tabeli raportów logowania nie ma jeszcze żadnych danych.
                        </p>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php require_once '../template/footer.php'; ?>