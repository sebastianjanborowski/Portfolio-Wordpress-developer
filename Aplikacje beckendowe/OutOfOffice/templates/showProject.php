<?php
    require_once '../includes/app-security.php';
    ooo_redirect_if_not_logged_in('../public/index.php');

    require_once '../config/db.php';

    $sql = "SELECT * FROM Project";
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
                    <span class="section-kicker">Projekty</span>

                    <h1 class="app-title">Lista projektów</h1>

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
                                <th>Typ / nazwa projektu</th>
                                <th>Data rozpoczęcia</th>
                                <th>Data zakończenia</th>
                                <th>ID kierownika</th>
                                <th>Komentarz</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($result)): ?>
                                <?php foreach ($result as $row): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['ID'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Project_Type'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Start_Date'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['End_Date'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Project_Manager'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Comment'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Status'] ?? ''); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        Brak projektów do wyświetlenia.
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
                    <div class="accordion project-mobile-accordion" id="projectAccordion">
                        <?php foreach ($result as $index => $row): ?>
                            <?php
                                $projectId = htmlspecialchars($row['ID'] ?? '');
                                $projectType = htmlspecialchars($row['Project_Type'] ?? 'Brak nazwy projektu');
                                $startDate = htmlspecialchars($row['Start_Date'] ?? '');
                                $endDate = htmlspecialchars($row['End_Date'] ?? '');
                                $projectManager = htmlspecialchars($row['Project_Manager'] ?? '');
                                $comment = htmlspecialchars($row['Comment'] ?? '');
                                $status = htmlspecialchars($row['Status'] ?? '');

                                $headingId = 'projectHeading' . $index;
                                $collapseId = 'projectCollapse' . $index;
                            ?>

                            <div class="accordion-item project-accordion-item">
                                <h2 class="accordion-header" id="<?php echo $headingId; ?>">
                                    <button
                                        class="accordion-button collapsed project-accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#<?php echo $collapseId; ?>"
                                        aria-expanded="false"
                                        aria-controls="<?php echo $collapseId; ?>"
                                    >
                                        <span class="project-accordion-main">
                                            <span class="project-accordion-name">
                                                <?php echo $projectType; ?>
                                            </span>

                                            <span class="project-accordion-small">
                                                ID projektu: <?php echo $projectId ?: 'brak ID'; ?>
                                            </span>
                                        </span>
                                    </button>
                                </h2>

                                <div
                                    id="<?php echo $collapseId; ?>"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="<?php echo $headingId; ?>"
                                    data-bs-parent="#projectAccordion"
                                >
                                    <div class="accordion-body project-accordion-body">
                                        <div class="project-mobile-row">
                                            <span class="project-mobile-label">ID projektu</span>
                                            <span class="project-mobile-value"><?php echo $projectId; ?></span>
                                        </div>

                                        <div class="project-mobile-row">
                                            <span class="project-mobile-label">Typ / nazwa projektu</span>
                                            <span class="project-mobile-value"><?php echo $projectType; ?></span>
                                        </div>

                                        <div class="project-mobile-row">
                                            <span class="project-mobile-label">Data rozpoczęcia</span>
                                            <span class="project-mobile-value"><?php echo $startDate; ?></span>
                                        </div>

                                        <div class="project-mobile-row">
                                            <span class="project-mobile-label">Data zakończenia</span>
                                            <span class="project-mobile-value"><?php echo $endDate; ?></span>
                                        </div>

                                        <div class="project-mobile-row">
                                            <span class="project-mobile-label">ID kierownika</span>
                                            <span class="project-mobile-value"><?php echo $projectManager; ?></span>
                                        </div>

                                        <div class="project-mobile-row">
                                            <span class="project-mobile-label">Status</span>
                                            <span class="project-mobile-value"><?php echo $status; ?></span>
                                        </div>

                                        <div class="project-mobile-row project-mobile-row-comment">
                                            <span class="project-mobile-label">Komentarz</span>
                                            <span class="project-mobile-value"><?php echo $comment; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-mobile-message">
                        Brak projektów do wyświetlenia.
                    </div>
                <?php endif; ?>
            </section>

            <div id="back_to_menu" class="backToMenu">Powrót</div>
        </div>
    </main>
</div>

<?php require_once "../public/footer.php"; ?>