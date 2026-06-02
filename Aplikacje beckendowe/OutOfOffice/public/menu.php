<?php
require_once '../includes/app-security.php';
ooo_redirect_if_not_logged_in('../public/index.php');

$dostep = 'dostęp';
$login = $_SESSION['login'] ?? '';
$role = ooo_current_role();

$menuItems = [];

if ($role === 'admin') {
    $menuItems = [
        ['show', 'Lista pracowników', 'bi-people-fill'],
        ['add', 'Dodaj pracownika', 'bi-person-plus-fill'],
        ['update', 'Aktualizuj pracownika', 'bi-person-gear'],
        ['delete', 'Usuń pracownika', 'bi-person-x-fill'],

        ['showProject', 'Lista projektów', 'bi-folder2-open'],
        ['project', 'Dodaj projekt', 'bi-folder-plus'],
        ['updateProject', 'Aktualizuj projekt', 'bi-folder-symlink'],
        ['deleteProject', 'Usuń projekt', 'bi-folder-x'],

        ['showLeaveRequest', 'Pokaż wnioski o urlop', 'bi-calendar-week'],
        ['addLeaveRequest', 'Dodaj wniosek o urlop', 'bi-calendar-plus'],
        ['updateLeaveRequest', 'Aktualizuj wnioski o urlop', 'bi-calendar-check'],
        ['deleteLeaveRequest', 'Usuń wniosek o urlop', 'bi-calendar-x'],

        ['showApprover_Request', 'Pokaż wnioski o zatwierdzenie', 'bi-clipboard-check'],
        ['addApprover_Request', 'Dodaj wniosek o zatwierdzenie', 'bi-clipboard-plus'],
        ['updateApprover_Request', 'Aktualizuj wnioski o zatwierdzenie', 'bi-clipboard-data'],
        ['deleteApprover_Request', 'Usuń wniosek o zatwierdzenie', 'bi-clipboard-x']
    ];
} elseif ($role === 'HR_Manager') {
    $menuItems = [
        ['show', 'Lista pracowników', 'bi-people-fill'],
        ['add', 'Dodaj pracownika', 'bi-person-plus-fill'],
        ['update', 'Aktualizuj pracownika', 'bi-person-gear'],
        ['delete', 'Usuń pracownika', 'bi-person-x-fill'],
        ['showProject', 'Lista projektów', 'bi-folder2-open'],
        ['addApprover_Request', 'Dodaj wniosek o zatwierdzenie', 'bi-clipboard-plus'],
        ['deleteApprover_Request', 'Usuń wniosek o zatwierdzenie', 'bi-clipboard-x']
    ];
} elseif ($role === 'Project_Manager') {
    $menuItems = [
        ['show', 'Lista pracowników', 'bi-people-fill'],
        ['showProject', 'Lista projektów', 'bi-folder2-open'],
        ['project', 'Dodaj projekt', 'bi-folder-plus'],
        ['updateProject', 'Aktualizuj projekt', 'bi-folder-symlink'],
        ['deleteProject', 'Usuń projekt', 'bi-folder-x'],
        ['addApprover_Request', 'Dodaj wniosek o zatwierdzenie', 'bi-clipboard-plus'],
        ['deleteApprover_Request', 'Usuń wniosek o zatwierdzenie', 'bi-clipboard-x']
    ];
} elseif ($role === 'Employee') {
    $menuItems = [
        ['addLeaveRequest', 'Dodaj wniosek o urlop', 'bi-calendar-plus']
    ];
}
?>

<?php require_once 'header.php'; ?>

<div id="container" class="app-shell">
    <main id="main" class="app-main">
        <div class="container">
            <section id="header" class="app-hero">
                <div class="app-hero-card">
                    <span class="section-kicker">System zarządzania</span>
                    <h1 class="app-title">Panel administracyjny</h1>
                    <p class="app-subtitle">
                        Masz <?php echo htmlspecialchars($dostep); ?> jako
                        <strong><?php echo htmlspecialchars($login ?: 'niezalogowany'); ?></strong>
                        z rolą <strong><?php echo htmlspecialchars($role); ?></strong>.
                        Wybierz moduł, który chcesz otworzyć.
                    </p>
                </div>
            </section>

            <section class="menu-grid" aria-label="Menu aplikacji">
                <?php foreach ($menuItems as $item): ?>
                    <div
                        id="<?php echo htmlspecialchars($item[0]); ?>"
                        class="opcja menu-card"
                        role="button"
                        tabindex="0"
                    >
                        <div class="menu-card-icon">
                            <i class="bi <?php echo htmlspecialchars($item[2]); ?>"></i>
                        </div>

                        <div class="menu-card-title">
                            <?php echo htmlspecialchars($item[1]); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>

            <div id="backToForm">Wyloguj</div>
        </div>
    </main>
</div>

<?php require_once 'footer.php'; ?>
