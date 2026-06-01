<?php
// plik wyświetla liste diet całościowo, uproszczona logika przesyłu danych dlatego by nie dodawać zbędnego obsużenia w js jak w reszcie przypadków
session_start();
require_once '../core/config/db.php';

$stmt = $pdo->prepare("SELECT * FROM diets ORDER BY id DESC");
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
                <h1>Lista diet</h1>
                <p>Przegląd wszystkich diet dostępnych w systemie</p>
            </div>

            <div class="dashboard-card diet-table-card">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
                    <div>
                        <h2 class="h5 mb-1 fw-bold text-primary-custom">Wszystkie diety</h2>
                        <div class="text-muted small">
                            Liczba rekordów: <?php echo count($data); ?>
                        </div>
                    </div>

                    <div>
                        <a href="dashboard_diet.php" class="btn btn-outline-secondary diet-back-btn-bootstrap">
                            <i class="bi bi-arrow-left me-2"></i>Wróć
                        </a>
                    </div>
                </div>

                <div class="table-responsive diet-table-bootstrap-wrap">
                    <table class="table table-hover align-middle mb-0 diet-table-bootstrap">
                        <thead>
                            <tr>
                                <th>Oddział</th>
                                <th>Nazwa diety</th>
                                <th>Kod diety</th>
                                <th>Specjalna</th>
                                <th>Ograniczenia</th>
                                <th>Opis</th>
                                <th>Notatki</th>
                                <th>Aktywna</th>
                                <th>Utworzono</th>
                                <th>Zaktualizowano</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data)): ?>
                                <?php foreach ($data as $row): ?>
                                    <tr>
                                        <?php
                                        $odzial;
                                            if($row['department_id'] == 1)$odzial = "Chirurgia";
                                            elseif($row['department_id'] == 2)$odzial = "Interna";
                                            elseif($row['department_id'] == 3)$odzial = "Pediatria";
                                            elseif($row['department_id'] == 4)$odzial = "Geriatria";
                                            elseif($row['department_id'] == 5)$odzial = "Neurologia";
                                            elseif($row['department_id'] == 6)$odzial = "Onkologia";
                                            else $odzial = "Niezdefiniowane w bazie danych";
                                        ?>
                                        <td><?php echo htmlspecialchars($odzial ?? ''); ?></td>

                                        <td class="fw-semibold"><?php echo htmlspecialchars($row['diet_name'] ?? ''); ?></td>
                                        
                                        <td>
                                            <span class="badge rounded-pill diet-code-badge">
                                                <?php echo htmlspecialchars($row['diet_code'] ?? ''); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (($row['is_special_diet'] ?? 0) == 1): ?>
                                                <span class="badge rounded-pill diet-status-badge diet-status-special">Tak</span>
                                            <?php else: ?>
                                                <span class="badge rounded-pill diet-status-badge diet-status-normal">Nie</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-wrap diet-col-wide"><?php echo htmlspecialchars($row['diet_restrictions'] ?? ''); ?></td>
                                        <td class="text-wrap diet-col-wide"><?php echo htmlspecialchars($row['diet_description'] ?? ''); ?></td>
                                        <td class="text-wrap diet-col-wide"><?php echo htmlspecialchars($row['diet_notes'] ?? ''); ?></td>
                                        <td>
                                            <?php if (($row['is_active'] ?? 0) == 1): ?>
                                                <span class="badge rounded-pill diet-status-badge diet-status-active">Aktywna</span>
                                            <?php else: ?>
                                                <span class="badge rounded-pill diet-status-badge diet-status-inactive">Nieaktywna</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-nowrap"><?php echo htmlspecialchars($row['created_at'] ?? ''); ?></td>
                                        <td class="text-nowrap"><?php echo htmlspecialchars($row['updated_at'] ?? ''); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11" class="text-center py-5">
                                        <div class="diet-empty-state">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            <p class="mb-0">Brak diet w bazie danych.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="dashboard-footer-info mt-4">
                    <span><i class="bi bi-journal-medical"></i> Słownik diet szpitalnych</span>
                    <span><i class="bi bi-database"></i> Widok listy rekordów</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../template/footer.php'; ?>