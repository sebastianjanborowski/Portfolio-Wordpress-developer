<?php

declare(strict_types=1);

require_once 'includes/app-security.php';
require_once 'config/db.php';

require_login();

$pageTitle = 'Panel użytkownika | HRD';
$currentPage = 'dashboard';
$successMessage = get_flash('success');
$errorMessage = get_flash('error');
$userId = current_user_id();
$isAdmin = current_user_role() === 'admin';

if ($isAdmin) {
    $historySql = 'SELECT ds.id, ds.domain, ds.status, ds.message, ds.recommendation, ds.dns_a, ds.dns_aaaa, ds.dns_mx, ds.dns_ns, ds.created_at, u.username
                   FROM domain_searches ds
                   LEFT JOIN users u ON u.id = ds.user_id
                   ORDER BY ds.created_at DESC
                   LIMIT 50';
    $historyStmt = $pdo->prepare($historySql);
    $historyStmt->execute();
} else {
    $historySql = 'SELECT ds.id, ds.domain, ds.status, ds.message, ds.recommendation, ds.dns_a, ds.dns_aaaa, ds.dns_mx, ds.dns_ns, ds.created_at, u.username
                   FROM domain_searches ds
                   LEFT JOIN users u ON u.id = ds.user_id
                   WHERE ds.user_id = :user_id
                   ORDER BY ds.created_at DESC
                   LIMIT 50';
    $historyStmt = $pdo->prepare($historySql);
    $historyStmt->execute(['user_id' => $userId]);
}

$searches = $historyStmt->fetchAll();

if ($isAdmin) {
    $statsSql = 'SELECT
                    COUNT(*) AS total_count,
                    SUM(CASE WHEN status LIKE "%Brak aktywnych%" THEN 1 ELSE 0 END) AS available_count,
                    SUM(CASE WHEN status LIKE "%Aktywna%" THEN 1 ELSE 0 END) AS taken_count,
                    COUNT(DISTINCT user_id) AS users_count
                 FROM domain_searches';
    $statsStmt = $pdo->query($statsSql);
} else {
    $statsSql = 'SELECT
                    COUNT(*) AS total_count,
                    SUM(CASE WHEN status LIKE "%Brak aktywnych%" THEN 1 ELSE 0 END) AS available_count,
                    SUM(CASE WHEN status LIKE "%Aktywna%" THEN 1 ELSE 0 END) AS taken_count,
                    COUNT(DISTINCT user_id) AS users_count
                 FROM domain_searches
                 WHERE user_id = :user_id';
    $statsStmt = $pdo->prepare($statsSql);
    $statsStmt->execute(['user_id' => $userId]);
}

$stats = $statsStmt->fetch() ?: [
    'total_count' => 0,
    'available_count' => 0,
    'taken_count' => 0,
    'users_count' => 0,
];

require_once 'template/header.php';
?>

<main class="dashboard-page">
    <div class="container">
        <section class="dashboard-hero">
            <div>
                <span class="section-kicker">Panel użytkownika</span>
                <h1>Historia wyszukiwań domen</h1>
                <p>
                    Zalogowano jako <strong><?php echo e(current_user_name()); ?></strong>.
                    Rola: <strong><?php echo e(current_user_role()); ?></strong>.
                </p>
            </div>
            <a href="index.php#sprawdz" class="btn btn-primary">
                <i class="bi bi-search me-2"></i> Nowe wyszukiwanie
            </a>
        </section>

        <?php if ($successMessage): ?>
            <div class="alert alert-success" role="alert"><?php echo e($successMessage); ?></div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="alert alert-danger" role="alert"><?php echo e($errorMessage); ?></div>
        <?php endif; ?>

        <section class="row g-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <span>Wyszukiwania</span>
                    <strong><?php echo e($stats['total_count'] ?? 0); ?></strong>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <span>Możliwie wolne</span>
                    <strong><?php echo e($stats['available_count'] ?? 0); ?></strong>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <span>Aktywne DNS</span>
                    <strong><?php echo e($stats['taken_count'] ?? 0); ?></strong>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <span>Tryb</span>
                    <strong><?php echo $isAdmin ? 'Admin' : 'User'; ?></strong>
                </div>
            </div>
        </section>

        <section class="table-card d-none d-md-block">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <?php if ($isAdmin): ?><th>Użytkownik</th><?php endif; ?>
                            <th>Domena</th>
                            <th>Status</th>
                            <th>DNS</th>
                            <th>Komunikat</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($searches): ?>
                            <?php foreach ($searches as $row): ?>
                                <tr>
                                    <td><?php echo e($row['id']); ?></td>
                                    <?php if ($isAdmin): ?><td><?php echo e($row['username'] ?? 'Gość'); ?></td><?php endif; ?>
                                    <td><strong><?php echo e($row['domain']); ?></strong></td>
                                    <td><?php echo e($row['status']); ?></td>
                                    <td>
                                        <span class="dns-mini <?php echo (int) $row['dns_a'] === 1 ? 'on' : ''; ?>">A</span>
                                        <span class="dns-mini <?php echo (int) $row['dns_aaaa'] === 1 ? 'on' : ''; ?>">AAAA</span>
                                        <span class="dns-mini <?php echo (int) $row['dns_mx'] === 1 ? 'on' : ''; ?>">MX</span>
                                        <span class="dns-mini <?php echo (int) $row['dns_ns'] === 1 ? 'on' : ''; ?>">NS</span>
                                    </td>
                                    <td><?php echo e($row['message']); ?></td>
                                    <td><?php echo e($row['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="<?php echo $isAdmin ? '7' : '6'; ?>" class="text-center py-4">Brak historii wyszukiwań.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="mobile-accordion-card d-block d-md-none">
            <?php if ($searches): ?>
                <div class="accordion" id="historyAccordion">
                    <?php foreach ($searches as $index => $row): ?>
                        <?php
                            $headingId = 'historyHeading' . $index;
                            $collapseId = 'historyCollapse' . $index;
                        ?>
                        <div class="accordion-item app-accordion-item">
                            <h2 class="accordion-header" id="<?php echo e($headingId); ?>">
                                <button class="accordion-button collapsed app-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo e($collapseId); ?>" aria-expanded="false" aria-controls="<?php echo e($collapseId); ?>">
                                    <span>
                                        <strong><?php echo e($row['domain']); ?></strong><br>
                                        <small><?php echo e($row['status']); ?></small>
                                    </span>
                                </button>
                            </h2>
                            <div id="<?php echo e($collapseId); ?>" class="accordion-collapse collapse" aria-labelledby="<?php echo e($headingId); ?>" data-bs-parent="#historyAccordion">
                                <div class="accordion-body">
                                    <div class="mobile-row"><span>ID</span><strong><?php echo e($row['id']); ?></strong></div>
                                    <?php if ($isAdmin): ?><div class="mobile-row"><span>Użytkownik</span><strong><?php echo e($row['username'] ?? 'Gość'); ?></strong></div><?php endif; ?>
                                    <div class="mobile-row"><span>Domena</span><strong><?php echo e($row['domain']); ?></strong></div>
                                    <div class="mobile-row"><span>Status</span><strong><?php echo e($row['status']); ?></strong></div>
                                    <div class="mobile-row mobile-row-column"><span>Komunikat</span><strong><?php echo e($row['message']); ?></strong></div>
                                    <div class="mobile-row"><span>Data</span><strong><?php echo e($row['created_at']); ?></strong></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-mobile-message">Brak historii wyszukiwań.</div>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php require_once 'template/footer.php'; ?>
