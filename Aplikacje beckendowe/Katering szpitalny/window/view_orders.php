<?php
// plik wyświetla listę raportów:
// - na desktopie jako tabelę
// - na mobile jako accordion
// + wyszukiwanie po kliknięciu przycisku
// + sortowanie
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
                    <i class="bi bi-journal-text"></i>
                </div>
                <h1>Lista raportów użytkowników</h1>
                <p>Przegląd raportów użytkowników związanych z Posiłkami i zarządzaniem użytkownikami</p>
            </div>

            <div class="dashboard-card diet-table-card">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
                    <div>
                        <h2 class="h5 mb-1 fw-bold text-primary-custom">Wszystkie raporty</h2>
                        <div class="text-muted small">
                            Liczba rekordów: <span id="reportsCount"><?php echo count($data); ?></span>
                        </div>
                    </div>

                    <div>
                        <a href="dashboard_raport_select.php" class="btn btn-outline-secondary diet-back-btn-bootstrap">
                            <i class="bi bi-arrow-left me-2"></i>Wróć
                        </a>
                    </div>
                </div>

                <?php if (!empty($data)): ?>

                    <!-- FILTRY -->
                    <div class="reports-tools mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-lg-6">
                                <label for="reportSearch" class="form-label fw-semibold">Wyszukaj</label>
                                <div class="input-group">
                                    <span class="input-group-text reports-tool-icon">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input
                                        type="text"
                                        id="reportSearch"
                                        class="form-control"
                                        placeholder="Wpisz frazę do wyszukania..."
                                    >
                                    <button type="button" id="searchBtn" class="btn btn-primary">
                                        <i class="bi bi-search me-1"></i>Szukaj
                                    </button>
                                    <button type="button" id="clearBtn" class="btn btn-outline-secondary">
                                        <i class="bi bi-x-circle me-1"></i>Wyczyść
                                    </button>
                                </div>
                               
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="statusFilter" class="form-label fw-semibold">Status konta</label>
                                <select id="statusFilter" class="form-select">
                                    <option value="">Wszystkie</option>
                                    <option value="1">Aktywne</option>
                                    <option value="0">Nieaktywne</option>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="sortMobile" class="form-label fw-semibold">Sortowanie</label>
                                <select id="sortMobile" class="form-select">
                                    <option value="id-desc">ID malejąco</option>
                                    <option value="id-asc">ID rosnąco</option>
                                    <option value="created_at-desc">Data utworzenia malejąco</option>
                                    <option value="created_at-asc">Data utworzenia rosnąco</option>
                                    <option value="updated_at-desc">Data aktualizacji malejąco</option>
                                    <option value="updated_at-asc">Data aktualizacji rosnąco</option>
                                    <option value="login-asc">Login A-Z</option>
                                    <option value="login-desc">Login Z-A</option>
                                    <option value="imie-asc">Imię A-Z</option>
                                    <option value="imie-desc">Imię Z-A</option>
                                    <option value="nazwisko-asc">Nazwisko A-Z</option>
                                    <option value="nazwisko-desc">Nazwisko Z-A</option>
                                    <option value="rodzajOperacji-asc">Operacja A-Z</option>
                                    <option value="rodzajOperacji-desc">Operacja Z-A</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- DESKTOP / TABLET: TABELA -->
                    <div class="table-responsive diet-table-bootstrap-wrap reports-desktop-table">
                        <table class="table table-hover align-middle mb-0 diet-table-bootstrap" id="reportsTable">
                            <thead>
                                <tr>
                                    <th>
                                        <button type="button" class="table-sort-btn active" data-sort="id">
                                            ID <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="kto">
                                            Kto <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="rodzajoperacji">
                                            Rodzaj operacji <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="nazwaobiektu">
                                            Nazwa obiektu <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="login">
                                            Login <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="imie">
                                            Imię <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="nazwisko">
                                            Nazwisko <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="rola">
                                            Rola <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="email">
                                            E-mail <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="is_active">
                                            Status konta <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="created_at">
                                            Utworzono <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="updated_at">
                                            Zaktualizowano <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="reportsTableBody">
                                <?php foreach ($data as $row): ?>
                                    <?php $isActive = (int)($row['is_active'] ?? 0) === 1; ?>
                                    <tr
                                        data-id="<?php echo htmlspecialchars((string)($row['id'] ?? '')); ?>"
                                        data-kto="<?php echo htmlspecialchars((string)($row['kto'] ?? '')); ?>"
                                        data-rodzajoperacji="<?php echo htmlspecialchars((string)($row['rodzajOperacji'] ?? '')); ?>"
                                        data-nazwaobiektu="<?php echo htmlspecialchars((string)($row['nazwaObiektu'] ?? '')); ?>"
                                        data-login="<?php echo htmlspecialchars((string)($row['login'] ?? '')); ?>"
                                        data-imie="<?php echo htmlspecialchars((string)($row['imie'] ?? '')); ?>"
                                        data-nazwisko="<?php echo htmlspecialchars((string)($row['nazwisko'] ?? '')); ?>"
                                        data-rola="<?php echo htmlspecialchars((string)($row['rola'] ?? '')); ?>"
                                        data-email="<?php echo htmlspecialchars((string)($row['email'] ?? '')); ?>"
                                        data-is_active="<?php echo htmlspecialchars((string)($row['is_active'] ?? '0')); ?>"
                                        data-created_at="<?php echo htmlspecialchars((string)($row['created_at'] ?? '')); ?>"
                                        data-updated_at="<?php echo htmlspecialchars((string)($row['updated_at'] ?? '')); ?>"
                                        data-search="<?php echo htmlspecialchars(mb_strtolower(
                                            implode(' ', [
                                                $row['id'] ?? '',
                                                $row['kto'] ?? '',
                                                $row['rodzajOperacji'] ?? '',
                                                $row['nazwaObiektu'] ?? '',
                                                $row['login'] ?? '',
                                                $row['imie'] ?? '',
                                                $row['nazwisko'] ?? '',
                                                $row['rola'] ?? '',
                                                $row['email'] ?? '',
                                                ((int)($row['is_active'] ?? 0) === 1 ? 'aktywne' : 'nieaktywne'),
                                                $row['created_at'] ?? '',
                                                $row['updated_at'] ?? ''
                                            ])
                                        )); ?>"
                                    >
                                        <td class="fw-semibold"><?php echo htmlspecialchars($row['id'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['kto'] ?? ''); ?></td>
                                        <td class="fw-semibold"><?php echo htmlspecialchars($row['rodzajOperacji'] ?? ''); ?></td>
                                        <td>
                                            <span class="badge rounded-pill diet-code-badge">
                                                <?php echo htmlspecialchars($row['nazwaObiektu'] ?? ''); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['login'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['imie'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['nazwisko'] ?? ''); ?></td>
                                        <td class="fw-semibold"><?php echo htmlspecialchars($row['rola'] ?? ''); ?></td>
                                        <td class="text-wrap diet-col-wide">
                                            <span class="badge rounded-pill diet-status-badge diet-status-special report-email-badge">
                                                <?php echo htmlspecialchars($row['email'] ?? ''); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($isActive): ?>
                                                <span class="badge rounded-pill bg-success">Aktywne</span>
                                            <?php else: ?>
                                                <span class="badge rounded-pill bg-danger">Nieaktywne</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-wrap diet-col-wide"><?php echo htmlspecialchars($row['created_at'] ?? ''); ?></td>
                                        <td class="text-wrap diet-col-wide"><?php echo htmlspecialchars($row['updated_at'] ?? ''); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- MOBILE: ACCORDION -->
                    <div class="accordion reports-accordion reports-mobile-accordion" id="reportsAccordion">
                        <?php foreach ($data as $index => $row): ?>
                            <?php
                                $reportId = (int)($row['id'] ?? 0);
                                $isActive = (int)($row['is_active'] ?? 0) === 1;
                                $statusText = $isActive ? 'Aktywne' : 'Nieaktywne';
                                $statusClass = $isActive ? 'bg-success' : 'bg-danger';
                            ?>
                            <div
                                class="accordion-item reports-accordion-item mb-3 border-0 shadow-sm"
                                data-id="<?php echo htmlspecialchars((string)($row['id'] ?? '')); ?>"
                                data-kto="<?php echo htmlspecialchars((string)($row['kto'] ?? '')); ?>"
                                data-rodzajoperacji="<?php echo htmlspecialchars((string)($row['rodzajOperacji'] ?? '')); ?>"
                                data-nazwaobiektu="<?php echo htmlspecialchars((string)($row['nazwaObiektu'] ?? '')); ?>"
                                data-login="<?php echo htmlspecialchars((string)($row['login'] ?? '')); ?>"
                                data-imie="<?php echo htmlspecialchars((string)($row['imie'] ?? '')); ?>"
                                data-nazwisko="<?php echo htmlspecialchars((string)($row['nazwisko'] ?? '')); ?>"
                                data-rola="<?php echo htmlspecialchars((string)($row['rola'] ?? '')); ?>"
                                data-email="<?php echo htmlspecialchars((string)($row['email'] ?? '')); ?>"
                                data-is_active="<?php echo htmlspecialchars((string)($row['is_active'] ?? '0')); ?>"
                                data-created_at="<?php echo htmlspecialchars((string)($row['created_at'] ?? '')); ?>"
                                data-updated_at="<?php echo htmlspecialchars((string)($row['updated_at'] ?? '')); ?>"
                                data-search="<?php echo htmlspecialchars(mb_strtolower(
                                    implode(' ', [
                                        $row['id'] ?? '',
                                        $row['kto'] ?? '',
                                        $row['rodzajOperacji'] ?? '',
                                        $row['nazwaObiektu'] ?? '',
                                        $row['login'] ?? '',
                                        $row['imie'] ?? '',
                                        $row['nazwisko'] ?? '',
                                        $row['rola'] ?? '',
                                        $row['email'] ?? '',
                                        ((int)($row['is_active'] ?? 0) === 1 ? 'aktywne' : 'nieaktywne'),
                                        $row['created_at'] ?? '',
                                        $row['updated_at'] ?? ''
                                    ])
                                )); ?>"
                            >
                                <h2 class="accordion-header" id="heading-<?php echo $reportId; ?>">
                                    <button
                                        class="accordion-button <?php echo $index !== 0 ? 'collapsed' : ''; ?> reports-accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse-<?php echo $reportId; ?>"
                                        aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                                        aria-controls="collapse-<?php echo $reportId; ?>"
                                    >
                                        <div class="w-100 pe-3">
                                            <div class="d-flex flex-column gap-2 text-start">
                                                <div class="fw-bold text-dark">
                                                    #<?php echo htmlspecialchars($row['id'] ?? ''); ?>
                                                    — <?php echo htmlspecialchars($row['rodzajOperacji'] ?? 'Brak rodzaju operacji'); ?>
                                                </div>

                                                <div class="small text-muted">
                                                    <?php echo htmlspecialchars($row['login'] ?? 'Brak loginu'); ?>
                                                </div>

                                                <div class="d-flex flex-wrap gap-2">
                                                    <span class="badge rounded-pill diet-code-badge">
                                                        <?php echo htmlspecialchars($row['nazwaObiektu'] ?? 'Brak obiektu'); ?>
                                                    </span>
                                                    <span class="badge rounded-pill <?php echo $statusClass; ?>">
                                                        <?php echo $statusText; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </h2>

                                <div
                                    id="collapse-<?php echo $reportId; ?>"
                                    class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>"
                                    aria-labelledby="heading-<?php echo $reportId; ?>"
                                    data-bs-parent="#reportsAccordion"
                                >
                                    <div class="accordion-body reports-accordion-body">
                                        <div class="row g-3">
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">ID</div><div class="report-value"><?php echo htmlspecialchars($row['id'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Kto</div><div class="report-value"><?php echo htmlspecialchars($row['kto'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Rodzaj operacji</div><div class="report-value"><?php echo htmlspecialchars($row['rodzajOperacji'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Nazwa obiektu</div><div class="report-value"><?php echo htmlspecialchars($row['nazwaObiektu'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Login</div><div class="report-value"><?php echo htmlspecialchars($row['login'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Imię</div><div class="report-value"><?php echo htmlspecialchars($row['imie'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Nazwisko</div><div class="report-value"><?php echo htmlspecialchars($row['nazwisko'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Rola</div><div class="report-value"><?php echo htmlspecialchars($row['rola'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">E-mail</div><div class="report-value text-break"><?php echo htmlspecialchars($row['email'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Status konta</div><div class="report-value"><span class="badge rounded-pill <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Utworzono</div><div class="report-value"><?php echo htmlspecialchars($row['created_at'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Zaktualizowano</div><div class="report-value"><?php echo htmlspecialchars($row['updated_at'] ?? ''); ?></div></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div id="reportsNoResults" class="text-center py-5 d-none">
                        <div class="diet-empty-state">
                            <i class="bi bi-search fs-1 d-block mb-2"></i>
                            <p class="mb-0">Brak wyników dla podanych filtrów.</p>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="diet-empty-state">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            <p class="mb-0">Brak raportów w bazie danych.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="dashboard-footer-info mt-4">
                    <span><i class="bi bi-file-earmark-text"></i> Lista raportów systemu</span>
                    <span><i class="bi bi-layout-text-window"></i> Tabela desktop / accordion mobile</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../template/footer.php'; ?>