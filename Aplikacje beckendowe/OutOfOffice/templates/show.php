<?php
    require_once '../includes/app-security.php';
    ooo_redirect_if_not_logged_in('../public/index.php');

    require_once '../config/db.php';

    $sql = "SELECT * FROM Employees";
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
                    <span class="section-kicker">Pracownicy</span>

                    <h1 class="app-title">Lista pracowników</h1>

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
                                <th>Imię i nazwisko</th>
                                <th>Dział</th>
                                <th>Stanowisko</th>
                                <th>Status</th>
                                <th>ID opiekuna HR</th>
                                <th>Out of Balance</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($result)): ?>
                                <?php foreach ($result as $row): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['ID'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Full_Name'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Subdivision'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Position'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Status'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['People_Partner'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Out_of_Balance'] ?? ''); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        Brak pracowników do wyświetlenia.
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
                    <div class="accordion employee-mobile-accordion" id="employeesAccordion">
                        <?php foreach ($result as $index => $row): ?>
                            <?php
                                $employeeId = htmlspecialchars($row['ID'] ?? '');
                                $fullName = htmlspecialchars($row['Full_Name'] ?? 'Brak imienia i nazwiska');
                                $subdivision = htmlspecialchars($row['Subdivision'] ?? '');
                                $position = htmlspecialchars($row['Position'] ?? '');
                                $status = htmlspecialchars($row['Status'] ?? '');
                                $peoplePartner = htmlspecialchars($row['People_Partner'] ?? '');
                                $outOfBalance = htmlspecialchars($row['Out_of_Balance'] ?? '');

                                $headingId = 'employeeHeading' . $index;
                                $collapseId = 'employeeCollapse' . $index;
                            ?>

                            <div class="accordion-item employee-accordion-item">
                                <h2 class="accordion-header" id="<?php echo $headingId; ?>">
                                    <button
                                        class="accordion-button collapsed employee-accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#<?php echo $collapseId; ?>"
                                        aria-expanded="false"
                                        aria-controls="<?php echo $collapseId; ?>"
                                    >
                                        <span class="employee-accordion-main">
                                            <span class="employee-accordion-name">
                                                <?php echo $fullName; ?>
                                            </span>

                                            <span class="employee-accordion-small">
                                                ID: <?php echo $employeeId; ?>
                                            </span>
                                        </span>
                                    </button>
                                </h2>

                                <div
                                    id="<?php echo $collapseId; ?>"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="<?php echo $headingId; ?>"
                                    data-bs-parent="#employeesAccordion"
                                >
                                    <div class="accordion-body employee-accordion-body">
                                        <div class="employee-mobile-row">
                                            <span class="employee-mobile-label">ID pracownika</span>
                                            <span class="employee-mobile-value"><?php echo $employeeId; ?></span>
                                        </div>

                                        <div class="employee-mobile-row">
                                            <span class="employee-mobile-label">Imię i nazwisko</span>
                                            <span class="employee-mobile-value"><?php echo $fullName; ?></span>
                                        </div>

                                        <div class="employee-mobile-row">
                                            <span class="employee-mobile-label">Dział</span>
                                            <span class="employee-mobile-value"><?php echo $subdivision; ?></span>
                                        </div>

                                        <div class="employee-mobile-row">
                                            <span class="employee-mobile-label">Stanowisko</span>
                                            <span class="employee-mobile-value"><?php echo $position; ?></span>
                                        </div>

                                        <div class="employee-mobile-row">
                                            <span class="employee-mobile-label">Status</span>
                                            <span class="employee-mobile-value"><?php echo $status; ?></span>
                                        </div>

                                        <div class="employee-mobile-row">
                                            <span class="employee-mobile-label">ID opiekuna HR</span>
                                            <span class="employee-mobile-value"><?php echo $peoplePartner; ?></span>
                                        </div>

                                        <div class="employee-mobile-row">
                                            <span class="employee-mobile-label">Out of Balance</span>
                                            <span class="employee-mobile-value"><?php echo $outOfBalance; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-mobile-message">
                        Brak pracowników do wyświetlenia.
                    </div>
                <?php endif; ?>
            </section>

            <div id="back_to_menu" class="backToMenu">Powrót</div>
        </div>
    </main>
</div>

<?php require_once "../public/footer.php"; ?>