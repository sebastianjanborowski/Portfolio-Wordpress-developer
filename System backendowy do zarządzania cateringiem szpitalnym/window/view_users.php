<?php
// plik wyświetla listę użytkowników całościowo
session_start();
require_once '../core/config/db.php';

$stmt = $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
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
                <h1>Lista użytkowników</h1>
                <p>Przegląd wszystkich użytkowników dostępnych w systemie</p>
            </div>

            <div class="dashboard-card diet-table-card">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
                    <div>
                        <h2 class="h5 mb-1 fw-bold text-primary-custom">Wszyscy użytkownicy</h2>
                        <div class="text-muted small">
                            Liczba rekordów: <?php echo count($data); ?>
                        </div>
                    </div>

                    <div>
                        <a href="dashboard_users.php" class="btn btn-outline-secondary diet-back-btn-bootstrap">
                            <i class="bi bi-arrow-left me-2"></i>Wróć
                        </a>
                    </div>
                </div>

                <div class="table-responsive diet-table-bootstrap-wrap">
                    <table class="table table-hover align-middle mb-0 diet-table-bootstrap">
                        <thead>
                            <tr>
                                <th>Login</th>
                                <th>Imię</th>
                                <th>Nazwisko</th>
                                <th>Rola</th>
                                <th>E-mail</th>
                                <th>Status konta</th>
                                <th>Utworzono</th>
                                <th>Zaktualizowano ostatnio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data)): ?>
                                <?php foreach ($data as $row): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['login'] ?? ''); ?></td>

                                        <td class="fw-semibold">
                                            <?php echo htmlspecialchars($row['name'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <span class="badge rounded-pill diet-code-badge">
                                                <?php echo htmlspecialchars($row['surname'] ?? ''); ?>
                                            </span>
                                        </td>

                                        <td class="fw-semibold">
                                            <?php echo htmlspecialchars($row['role'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <span class="badge rounded-pill diet-status-badge diet-status-special">
                                                <?php echo htmlspecialchars($row['email'] ?? ''); ?>
                                            </span>
                                        </td>

                                        <td>
                                            <?php if ((int)($row['is_active'] ?? 0) === 1): ?>
                                                <span class="badge rounded-pill bg-success">Aktywne</span>
                                            <?php else: ?>
                                                <span class="badge rounded-pill bg-danger">Nieaktywne</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-wrap diet-col-wide">
                                            <?php echo htmlspecialchars($row['created_at'] ?? ''); ?>
                                        </td>

                                        <td class="text-wrap diet-col-wide">
                                            <?php echo htmlspecialchars($row['updated_at'] ?? ''); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="diet-empty-state">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            <p class="mb-0">Brak użytkowników w bazie danych.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="dashboard-footer-info mt-4">
                    <span><i class="bi bi-people"></i> Lista użytkowników systemu</span>
                    <span><i class="bi bi-database"></i> Widok listy rekordów</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../template/footer.php'; ?>