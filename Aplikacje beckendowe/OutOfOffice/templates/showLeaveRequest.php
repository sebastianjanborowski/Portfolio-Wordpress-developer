<?php
    require_once '../includes/app-security.php';
    ooo_redirect_if_not_logged_in('../public/index.php');

    require_once '../config/db.php';

    $sql = "SELECT * FROM Leave_Request";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once "../public/header.php"; ?>

<div id="container" class="app-shell">
    <main id="main" class="app-main">
        <div class="container">
            <section id="header" class="app-hero">
                <div class="app-hero-card">
                    <span class="section-kicker">Urlopy</span>

                    <h1 class="app-title">Lista wniosków o urlop</h1>

                    <p class="app-subtitle">
                        Na komputerze lista jest pokazana jako tabela. Na telefonie dane są pokazane jako rozwijane karty.
                    </p>
                </div>
            </section>

            <!-- DESKTOP TABLE -->
            <section class="table-card d-none d-md-block">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID pracownika</th>
                                <th>Powód nieobecności</th>
                                <th>Data rozpoczęcia</th>
                                <th>Data zakończenia</th>
                                <th>Komentarz</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($result)): ?>
                                <?php foreach ($result as $row): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['ID'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Employee'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Absense_Reason'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Start_Date'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['End_Date'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Comment'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Status'] ?? ''); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        Brak wniosków o urlop do wyświetlenia.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- MOBILE ACCORDION -->
            <section class="mobile-accordion-card d-block d-md-none">
                <?php if (!empty($result)): ?>
                    <div class="accordion leave-mobile-accordion" id="leaveRequestAccordion">
                        <?php foreach ($result as $index => $row): ?>
                            <?php
                                $leaveId = htmlspecialchars($row['ID'] ?? '');
                                $employee = htmlspecialchars($row['Employee'] ?? '');
                                $absenceReason = htmlspecialchars($row['Absense_Reason'] ?? '');
                                $startDate = htmlspecialchars($row['Start_Date'] ?? '');
                                $endDate = htmlspecialchars($row['End_Date'] ?? '');
                                $comment = htmlspecialchars($row['Comment'] ?? '');
                                $status = htmlspecialchars($row['Status'] ?? '');

                                $headingId = 'leaveHeading' . $index;
                                $collapseId = 'leaveCollapse' . $index;
                            ?>

                            <div class="accordion-item leave-accordion-item">
                                <h2 class="accordion-header" id="<?php echo $headingId; ?>">
                                    <button
                                        class="accordion-button collapsed leave-accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#<?php echo $collapseId; ?>"
                                        aria-expanded="false"
                                        aria-controls="<?php echo $collapseId; ?>"
                                    >
                                        <span class="leave-accordion-main">
                                            <span class="leave-accordion-name">
                                                Wniosek urlopowy #<?php echo $leaveId; ?>
                                            </span>

                                            <span class="leave-accordion-small">
                                                <?php echo $startDate ?: 'brak daty'; ?>
                                                —
                                                <?php echo $endDate ?: 'brak daty'; ?>
                                            </span>
                                        </span>
                                    </button>
                                </h2>

                                <div
                                    id="<?php echo $collapseId; ?>"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="<?php echo $headingId; ?>"
                                    data-bs-parent="#leaveRequestAccordion"
                                >
                                    <div class="accordion-body leave-accordion-body">
                                        <div class="leave-mobile-row">
                                            <span class="leave-mobile-label">ID wniosku</span>
                                            <span class="leave-mobile-value"><?php echo $leaveId; ?></span>
                                        </div>

                                        <div class="leave-mobile-row">
                                            <span class="leave-mobile-label">ID pracownika</span>
                                            <span class="leave-mobile-value"><?php echo $employee; ?></span>
                                        </div>

                                        <div class="leave-mobile-row">
                                            <span class="leave-mobile-label">Powód nieobecności</span>
                                            <span class="leave-mobile-value"><?php echo $absenceReason; ?></span>
                                        </div>

                                        <div class="leave-mobile-row">
                                            <span class="leave-mobile-label">Data rozpoczęcia</span>
                                            <span class="leave-mobile-value"><?php echo $startDate; ?></span>
                                        </div>

                                        <div class="leave-mobile-row">
                                            <span class="leave-mobile-label">Data zakończenia</span>
                                            <span class="leave-mobile-value"><?php echo $endDate; ?></span>
                                        </div>

                                        <div class="leave-mobile-row">
                                            <span class="leave-mobile-label">Status</span>
                                            <span class="leave-mobile-value"><?php echo $status; ?></span>
                                        </div>

                                        <div class="leave-mobile-row leave-mobile-row-comment">
                                            <span class="leave-mobile-label">Komentarz</span>
                                            <span class="leave-mobile-value"><?php echo $comment; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-mobile-message">
                        Brak wniosków o urlop do wyświetlenia.
                    </div>
                <?php endif; ?>
            </section>

            <div id="back_to_menu" class="backToMenu">Powrót</div>
        </div>
    </main>
</div>

<?php require_once "../public/footer.php"; ?>