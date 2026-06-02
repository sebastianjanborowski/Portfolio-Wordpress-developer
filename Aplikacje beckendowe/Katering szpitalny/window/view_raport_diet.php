<?php
session_start();
require_once '../core/config/db.php';

$stmt = $pdo->prepare("SELECT * FROM raport_diet ORDER BY id DESC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../template/header.php';
?>

<div class="dashboard-page">
    <div class="container-fluid px-3 px-xl-4">
        <div class="diet-page-wide mx-auto">

            <div class="dashboard-header mb-4">
                <div class="login-top-icon">
                    <i class="bi bi-journal-richtext"></i>
                </div>
                <h1>Lista raportów diet</h1>
                <p>Przegląd raportów związanych z dietami i posiłkami</p>
            </div>

            <div class="dashboard-card diet-table-card">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
                    <div>
                        <h2 class="h5 mb-1 fw-bold text-primary-custom">Wszystkie raporty diet</h2>
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
                                <label for="statusFilter" class="form-label fw-semibold">Status</label>
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
                                    <option value="kto-asc">Kto A-Z</option>
                                    <option value="kto-desc">Kto Z-A</option>
                                    <option value="rodzajoperacji-asc">Operacja A-Z</option>
                                    <option value="rodzajoperacji-desc">Operacja Z-A</option>
                                    <option value="nazwaobiektu-asc">Obiekt A-Z</option>
                                    <option value="nazwaobiektu-desc">Obiekt Z-A</option>
                                    <option value="czas-desc">Czas malejąco</option>
                                    <option value="czas-asc">Czas rosnąco</option>
                                    <option value="diet_name-asc">Nazwa diety A-Z</option>
                                    <option value="diet_name-desc">Nazwa diety Z-A</option>
                                    <option value="diet_code-asc">Kod diety A-Z</option>
                                    <option value="diet_code-desc">Kod diety Z-A</option>
                                    <option value="department_id-desc">ID działu malejąco</option>
                                    <option value="department_id-asc">ID działu rosnąco</option>
                                </select>
                            </div>
                        </div>
                    </div>

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
                                        <button type="button" class="table-sort-btn" data-sort="czas">
                                            Czas <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="department_id">
                                            ID działu <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="diet_name">
                                            Nazwa diety <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="diet_code">
                                            Kod diety <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="is_special_diet">
                                            Dieta specjalna <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="diet_restrictions">
                                            Ograniczenia <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="diet_description">
                                            Opis diety <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="diet_notes">
                                            Notatki <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                    <th>
                                        <button type="button" class="table-sort-btn" data-sort="is_active">
                                            Status <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="reportsTableBody">
                                <?php foreach ($data as $row): ?>
                                    <?php
                                        $isActive = (int)($row['is_active'] ?? 0) === 1;
                                        $isSpecialDiet = (int)($row['is_special_diet'] ?? 0) === 1;
                                    ?>
                                    <tr
                                        data-id="<?php echo htmlspecialchars((string)($row['id'] ?? '')); ?>"
                                        data-kto="<?php echo htmlspecialchars((string)($row['kto'] ?? '')); ?>"
                                        data-rodzajoperacji="<?php echo htmlspecialchars((string)($row['rodzajOperacji'] ?? '')); ?>"
                                        data-nazwaobiektu="<?php echo htmlspecialchars((string)($row['nazwaObiektu'] ?? '')); ?>"
                                        data-czas="<?php echo htmlspecialchars((string)($row['czas'] ?? '')); ?>"
                                        data-department_id="<?php echo htmlspecialchars((string)($row['department_id'] ?? '')); ?>"
                                        data-diet_name="<?php echo htmlspecialchars((string)($row['diet_name'] ?? '')); ?>"
                                        data-diet_code="<?php echo htmlspecialchars((string)($row['diet_code'] ?? '')); ?>"
                                        data-is_special_diet="<?php echo htmlspecialchars((string)($row['is_special_diet'] ?? '0')); ?>"
                                        data-diet_restrictions="<?php echo htmlspecialchars((string)($row['diet_restrictions'] ?? '')); ?>"
                                        data-diet_description="<?php echo htmlspecialchars((string)($row['diet_description'] ?? '')); ?>"
                                        data-diet_notes="<?php echo htmlspecialchars((string)($row['diet_notes'] ?? '')); ?>"
                                        data-is_active="<?php echo htmlspecialchars((string)($row['is_active'] ?? '0')); ?>"
                                        data-created_at="<?php echo htmlspecialchars((string)($row['czas'] ?? '')); ?>"
                                        data-updated_at="<?php echo htmlspecialchars((string)($row['czas'] ?? '')); ?>"
                                        data-search="<?php echo htmlspecialchars(mb_strtolower(
                                            implode(' ', [
                                                $row['id'] ?? '',
                                                $row['kto'] ?? '',
                                                $row['rodzajOperacji'] ?? '',
                                                $row['nazwaObiektu'] ?? '',
                                                $row['czas'] ?? '',
                                                $row['department_id'] ?? '',
                                                $row['diet_name'] ?? '',
                                                $row['diet_code'] ?? '',
                                                ((int)($row['is_special_diet'] ?? 0) === 1 ? 'tak specjalna dieta' : 'nie zwykla dieta'),
                                                $row['diet_restrictions'] ?? '',
                                                $row['diet_description'] ?? '',
                                                $row['diet_notes'] ?? '',
                                                ((int)($row['is_active'] ?? 0) === 1 ? 'aktywne' : 'nieaktywne')
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
                                        <td><?php echo htmlspecialchars($row['czas'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['department_id'] ?? ''); ?></td>
                                        <td class="fw-semibold"><?php echo htmlspecialchars($row['diet_name'] ?? ''); ?></td>
                                        <td>
                                            <span class="badge rounded-pill diet-status-badge diet-status-special">
                                                <?php echo htmlspecialchars($row['diet_code'] ?? ''); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($isSpecialDiet): ?>
                                                <span class="badge rounded-pill bg-warning text-dark">Tak</span>
                                            <?php else: ?>
                                                <span class="badge rounded-pill bg-secondary">Nie</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-wrap diet-col-wide"><?php echo htmlspecialchars($row['diet_restrictions'] ?? ''); ?></td>
                                        <td class="text-wrap diet-col-wide"><?php echo htmlspecialchars($row['diet_description'] ?? ''); ?></td>
                                        <td class="text-wrap diet-col-wide"><?php echo htmlspecialchars($row['diet_notes'] ?? ''); ?></td>
                                        <td>
                                            <?php if ($isActive): ?>
                                                <span class="badge rounded-pill bg-success">Aktywne</span>
                                            <?php else: ?>
                                                <span class="badge rounded-pill bg-danger">Nieaktywne</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="accordion reports-accordion reports-mobile-accordion" id="reportsAccordion">
                        <?php foreach ($data as $index => $row): ?>
                            <?php
                                $reportId = (int)($row['id'] ?? 0);
                                $isActive = (int)($row['is_active'] ?? 0) === 1;
                                $isSpecialDiet = (int)($row['is_special_diet'] ?? 0) === 1;

                                $statusText = $isActive ? 'Aktywne' : 'Nieaktywne';
                                $statusClass = $isActive ? 'bg-success' : 'bg-danger';

                                $specialDietText = $isSpecialDiet ? 'Tak' : 'Nie';
                                $specialDietClass = $isSpecialDiet ? 'bg-warning text-dark' : 'bg-secondary';
                            ?>
                            <div
                                class="accordion-item reports-accordion-item mb-3 border-0 shadow-sm"
                                data-id="<?php echo htmlspecialchars((string)($row['id'] ?? '')); ?>"
                                data-kto="<?php echo htmlspecialchars((string)($row['kto'] ?? '')); ?>"
                                data-rodzajoperacji="<?php echo htmlspecialchars((string)($row['rodzajOperacji'] ?? '')); ?>"
                                data-nazwaobiektu="<?php echo htmlspecialchars((string)($row['nazwaObiektu'] ?? '')); ?>"
                                data-czas="<?php echo htmlspecialchars((string)($row['czas'] ?? '')); ?>"
                                data-department_id="<?php echo htmlspecialchars((string)($row['department_id'] ?? '')); ?>"
                                data-diet_name="<?php echo htmlspecialchars((string)($row['diet_name'] ?? '')); ?>"
                                data-diet_code="<?php echo htmlspecialchars((string)($row['diet_code'] ?? '')); ?>"
                                data-is_special_diet="<?php echo htmlspecialchars((string)($row['is_special_diet'] ?? '0')); ?>"
                                data-diet_restrictions="<?php echo htmlspecialchars((string)($row['diet_restrictions'] ?? '')); ?>"
                                data-diet_description="<?php echo htmlspecialchars((string)($row['diet_description'] ?? '')); ?>"
                                data-diet_notes="<?php echo htmlspecialchars((string)($row['diet_notes'] ?? '')); ?>"
                                data-is_active="<?php echo htmlspecialchars((string)($row['is_active'] ?? '0')); ?>"
                                data-created_at="<?php echo htmlspecialchars((string)($row['czas'] ?? '')); ?>"
                                data-updated_at="<?php echo htmlspecialchars((string)($row['czas'] ?? '')); ?>"
                                data-search="<?php echo htmlspecialchars(mb_strtolower(
                                    implode(' ', [
                                        $row['id'] ?? '',
                                        $row['kto'] ?? '',
                                        $row['rodzajOperacji'] ?? '',
                                        $row['nazwaObiektu'] ?? '',
                                        $row['czas'] ?? '',
                                        $row['department_id'] ?? '',
                                        $row['diet_name'] ?? '',
                                        $row['diet_code'] ?? '',
                                        ((int)($row['is_special_diet'] ?? 0) === 1 ? 'tak specjalna dieta' : 'nie zwykla dieta'),
                                        $row['diet_restrictions'] ?? '',
                                        $row['diet_description'] ?? '',
                                        $row['diet_notes'] ?? '',
                                        ((int)($row['is_active'] ?? 0) === 1 ? 'aktywne' : 'nieaktywne')
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
                                                    <?php echo htmlspecialchars($row['diet_name'] ?? 'Brak nazwy diety'); ?>
                                                </div>

                                                <div class="d-flex flex-wrap gap-2">
                                                    <span class="badge rounded-pill diet-code-badge">
                                                        <?php echo htmlspecialchars($row['nazwaObiektu'] ?? 'Brak obiektu'); ?>
                                                    </span>
                                                    <span class="badge rounded-pill diet-status-badge diet-status-special">
                                                        <?php echo htmlspecialchars($row['diet_code'] ?? 'Brak kodu'); ?>
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
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Czas</div><div class="report-value"><?php echo htmlspecialchars($row['czas'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">ID działu</div><div class="report-value"><?php echo htmlspecialchars($row['department_id'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Nazwa diety</div><div class="report-value"><?php echo htmlspecialchars($row['diet_name'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Kod diety</div><div class="report-value"><?php echo htmlspecialchars($row['diet_code'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Dieta specjalna</div><div class="report-value"><span class="badge rounded-pill <?php echo $specialDietClass; ?>"><?php echo $specialDietText; ?></span></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Ograniczenia</div><div class="report-value text-break"><?php echo htmlspecialchars($row['diet_restrictions'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Opis diety</div><div class="report-value text-break"><?php echo htmlspecialchars($row['diet_description'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Notatki</div><div class="report-value text-break"><?php echo htmlspecialchars($row['diet_notes'] ?? ''); ?></div></div></div>
                                            <div class="col-12"><div class="report-info-box"><div class="report-label">Status</div><div class="report-value"><span class="badge rounded-pill <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></div></div></div>
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
                            <p class="mb-0">Brak raportów diet w bazie danych.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="dashboard-footer-info mt-4">
                    <span><i class="bi bi-file-earmark-text"></i> Lista raportów diet</span>
                    <span><i class="bi bi-layout-text-window"></i> Tabela desktop / accordion mobile</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../template/footer.php'; ?>