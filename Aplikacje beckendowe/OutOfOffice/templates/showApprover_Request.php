<?php
    require_once '../includes/app-security.php';
    ooo_redirect_if_not_logged_in('../public/index.php');

    require_once '../config/db.php';

    $sql = "SELECT * FROM Approval_Request";
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
                    <span class="section-kicker">Zatwierdzenia</span>

                    <h1 class="app-title">Lista zatwierdzeń</h1>

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
                                <th>ID osoby zatwierdzającej</th>
                                <th>ID wniosku urlopowego</th>
                                <th>Status</th>
                                <th>Komentarz</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($result)): ?>
                                <?php foreach ($result as $row): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['ID'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Approver'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Leave_Request'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Status'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Comment'] ?? ''); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        Brak wniosków o zatwierdzenie do wyświetlenia.
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
                    <div class="accordion approval-mobile-accordion" id="approvalAccordion">
                        <?php foreach ($result as $index => $row): ?>
                            <?php
                                $approvalId = htmlspecialchars($row['ID'] ?? '');
                                $approver = htmlspecialchars($row['Approver'] ?? '');
                                $leaveRequest = htmlspecialchars($row['Leave_Request'] ?? '');
                                $status = htmlspecialchars($row['Status'] ?? '');
                                $comment = htmlspecialchars($row['Comment'] ?? '');

                                $headingId = 'approvalHeading' . $index;
                                $collapseId = 'approvalCollapse' . $index;
                            ?>

                            <div class="accordion-item approval-accordion-item">
                                <h2 class="accordion-header" id="<?php echo $headingId; ?>">
                                    <button
                                        class="accordion-button collapsed approval-accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#<?php echo $collapseId; ?>"
                                        aria-expanded="false"
                                        aria-controls="<?php echo $collapseId; ?>"
                                    >
                                        <span class="approval-accordion-main">
                                            <span class="approval-accordion-name">
                                                Zatwierdzenie #<?php echo $approvalId; ?>
                                            </span>

                                            <span class="approval-accordion-small">
                                                Status: <?php echo $status ?: 'brak statusu'; ?>
                                            </span>
                                        </span>
                                    </button>
                                </h2>

                                <div
                                    id="<?php echo $collapseId; ?>"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="<?php echo $headingId; ?>"
                                    data-bs-parent="#approvalAccordion"
                                >
                                    <div class="accordion-body approval-accordion-body">
                                        <div class="approval-mobile-row">
                                            <span class="approval-mobile-label">ID zatwierdzenia</span>
                                            <span class="approval-mobile-value"><?php echo $approvalId; ?></span>
                                        </div>

                                        <div class="approval-mobile-row">
                                            <span class="approval-mobile-label">ID osoby zatwierdzającej</span>
                                            <span class="approval-mobile-value"><?php echo $approver; ?></span>
                                        </div>

                                        <div class="approval-mobile-row">
                                            <span class="approval-mobile-label">ID wniosku urlopowego</span>
                                            <span class="approval-mobile-value"><?php echo $leaveRequest; ?></span>
                                        </div>

                                        <div class="approval-mobile-row">
                                            <span class="approval-mobile-label">Status</span>
                                            <span class="approval-mobile-value"><?php echo $status; ?></span>
                                        </div>

                                        <div class="approval-mobile-row approval-mobile-row-comment">
                                            <span class="approval-mobile-label">Komentarz</span>
                                            <span class="approval-mobile-value"><?php echo $comment; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-mobile-message">
                        Brak wniosków o zatwierdzenie do wyświetlenia.
                    </div>
                <?php endif; ?>
            </section>

            <div id="back_to_menu" class="backToMenu">Powrót</div>
        </div>
    </main>
</div>

<?php require_once "../public/footer.php"; ?>