<?php
// Simple report users page
// Display data from raport_users
// Desktop: table
// Mobile / compact screen: accordion

session_start();
require_once '../core/config/db.php';

$stmt = $pdo->prepare("SELECT * FROM raport_users ORDER BY id DESC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../template/header.php';
?>

<div class="dashboard-page">
    <div class="container-fluid px-3 px-xl-4">
        <div class="diet-page-wide mx-auto">

            <div class="dashboard-header mb-4">
                <div class="login-top-icon">
                    <i class="bi bi-people"></i>
                </div>

                <h1>Lista raportów użytkowników</h1>
                <p>Przegląd operacji wykonanych na kontach użytkowników</p>
            </div>

            <div class="dashboard-card diet-table-card">

                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
                    <div>
                        <h2 class="h5 mb-1 fw-bold text-primary-custom">
                            Wszystkie raporty użytkowników
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
                                    <th>Nazwa obiektu</th>
                                    <th>Login</th>
                                    <th>Imię</th>
                                    <th>Nazwisko</th>
                                    <th>E-mail</th>
                                    <th>Rola</th>
                                    <th>Utworzono</th>
                                    <th>Zaktualizowano</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($data as $row): ?>
                                    <?php
                                        $isActive = (int)($row['is_active'] ?? 0) === 1;
                                    ?>

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
                                            <span class="badge rounded-pill diet-code-badge">
                                                <?php echo htmlspecialchars($row['nazwaObiektu'] ?? ''); ?>
                                            </span>
                                        </td>

                                        <td class="fw-semibold">
                                            <?php echo htmlspecialchars($row['login'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['imie'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['nazwisko'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['email'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['rola'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['created_at'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['updated_at'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php if ($isActive): ?>
                                                <span class="badge rounded-pill bg-success">Aktywny</span>
                                            <?php else: ?>
                                                <span class="badge rounded-pill bg-danger">Nieaktywny</span>
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
                                $isActive = (int)($row['is_active'] ?? 0) === 1;

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

                                        <?php echo htmlspecialchars($row['login'] ?? 'Brak loginu'); ?>

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
                                            <strong>Nazwa obiektu:</strong>
                                            <?php echo htmlspecialchars($row['nazwaObiektu'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Login:</strong>
                                            <?php echo htmlspecialchars($row['login'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Imię:</strong>
                                            <?php echo htmlspecialchars($row['imie'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Nazwisko:</strong>
                                            <?php echo htmlspecialchars($row['nazwisko'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>E-mail:</strong>
                                            <?php echo htmlspecialchars($row['email'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Rola:</strong>
                                            <?php echo htmlspecialchars($row['rola'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Utworzono:</strong>
                                            <?php echo htmlspecialchars($row['created_at'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Zaktualizowano:</strong>
                                            <?php echo htmlspecialchars($row['updated_at'] ?? ''); ?>
                                        </p>

                                        <p>
                                            <strong>Status:</strong>

                                            <?php if ($isActive): ?>
                                                <span class="badge rounded-pill bg-success">Aktywny</span>
                                            <?php else: ?>
                                                <span class="badge rounded-pill bg-danger">Nieaktywny</span>
                                            <?php endif; ?>
                                        </p>

                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>

                    </div>

                <?php else: ?>

                    <div class="text-center py-5">
                        <i class="bi bi-person-x display-4 text-muted"></i>

                        <h3 class="mt-3">Brak raportów użytkowników</h3>

                        <p class="text-muted">
                            W tabeli raportów użytkowników nie ma jeszcze żadnych danych.
                        </p>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php require_once '../template/footer.php'; ?>