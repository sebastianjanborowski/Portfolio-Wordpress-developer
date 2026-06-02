<?php
// plik wyświetla listę raportów logowania:
// - na desktopie jako tabelę
// - na mobile jako accordion
// + wyszukiwanie po kliknięciu przycisku
// + sortowanie
session_start();
require_once '../core/config/db.php';

$stmt = $pdo->prepare("SELECT * FROM raport_logowanie ORDER BY id DESC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../template/header.php';
?>

<div class="dashboard-page">
    <div class="container-fluid px-3 px-xl-4">
        <div class="diet-page-wide mx-auto">

            <div class="dashboard-header mb-4">
                <div class="login-top-icon">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <h1>Raport logowania</h1>
                <p>Przegląd operacji logowania i wylogowania zapisanych w systemie</p>
            </div>

            <div class="dashboard-card diet-table-card">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
                    <div>
                        <h2 class="h5 mb-1 fw-bold text-primary-custom">Wszystkie wpisy logowania</h2>
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
                            <div class="col-12 col-lg-7">
                                <label for="reportSearch" class="form-label fw-semibold">Wyszukaj</label>
                                <div class="input-group">
                                    <span class="input-group-text reports-tool-icon">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input
                                        type="text"
                                        id="reportSearch"
                                        class="form-control"
                                        placeholder="Wpisz ID, użytkownika, rodzaj operacji albo datę..."
                                    >
                                    <button type="button" id="searchBtn" class="btn btn-primary">
                                        <i class="bi bi-search me-1"></i>Szukaj
                                    </button>
                                    <button type="button" id="clearBtn" class="btn btn-outline-secondary">
                                        <i class="bi bi-x-circle me-1"></i>Wyczyść
                                    </button>
                                </div>
                                
                            </div>

                            <div class="col-12 col-lg-5">
                                <label for="sortMobile" class="form-label fw-semibold">Sortowanie</label>
                                <select id="sortMobile" class="form-select">
                                    <option value="id-desc">ID malejąco</option>
                                    <option value="id-asc">ID rosnąco</option>
                                    <option value="kto-asc">Użytkownik A-Z</option>
                                    <option value="kto-desc">Użytkownik Z-A</option>
                                    <option value="rodzajoperacji-asc">Operacja A-Z</option>
                                    <option value="rodzajoperacji-desc">Operacja Z-A</option>
                                    <option value="czas-desc">Czas malejąco</option>
                                    <option value="czas-asc">Czas rosnąco</option>
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
                                        <button type="button" class="table-sort-btn" data-sort="czas">
                                            Czas <i class="bi bi-arrow-down-up"></i>
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="reportsTableBody">
                                <?php foreach ($data as $row): ?>
                                    <tr
                                        data-id="<?php echo htmlspecialchars((string)($row['id'] ?? '')); ?>"
                                        data-kto="<?php echo htmlspecialchars((string)($row['kto'] ?? '')); ?>"
                                        data-rodzajoperacji="<?php echo htmlspecialchars((string)($row['rodzajOperacji'] ?? '')); ?>"
                                        data-czas="<?php echo htmlspecialchars((string)($row['czas'] ?? '')); ?>"
                                        data-search="<?php echo htmlspecialchars(mb_strtolower(
                                            implode(' ', [
                                                $row['id'] ?? '',
                                                $row['kto'] ?? '',
                                                $row['rodzajOperacji'] ?? '',
                                                $row['czas'] ?? ''
                                            ])
                                        )); ?>"
                                    >
                                        <td class="fw-semibold">
                                            <?php echo htmlspecialchars($row['id'] ?? ''); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['kto'] ?? ''); ?>
                                        </td>

                                        <td class="fw-semibold">
                                            <span class="badge rounded-pill diet-code-badge">
                                                <?php echo htmlspecialchars($row['rodzajOperacji'] ?? ''); ?>
                                            </span>
                                        </td>

                                        <td class="text-wrap diet-col-wide">
                                            <?php echo htmlspecialchars($row['czas'] ?? ''); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- MOBILE: ACCORDION -->
                    <div class="accordion reports-accordion reports-mobile-accordion" id="reportsAccordion">
                        <?php foreach ($data as $index => $row): ?>
                            <?php $reportId = (int)($row['id'] ?? 0); ?>

                            <div
                                class="accordion-item reports-accordion-item mb-3 border-0 shadow-sm"
                                data-id="<?php echo htmlspecialchars((string)($row['id'] ?? '')); ?>"
                                data-kto="<?php echo htmlspecialchars((string)($row['kto'] ?? '')); ?>"
                                data-rodzajoperacji="<?php echo htmlspecialchars((string)($row['rodzajOperacji'] ?? '')); ?>"
                                data-czas="<?php echo htmlspecialchars((string)($row['czas'] ?? '')); ?>"
                                data-search="<?php echo htmlspecialchars(mb_strtolower(
                                    implode(' ', [
                                        $row['id'] ?? '',
                                        $row['kto'] ?? '',
                                        $row['rodzajOperacji'] ?? '',
                                        $row['czas'] ?? ''
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
                                                    — <?php echo htmlspecialchars($row['rodzajOperacji'] ?? 'Brak operacji'); ?>
                                                </div>

                                                <div class="small text-muted">
                                                    <?php echo htmlspecialchars($row['kto'] ?? 'Brak użytkownika'); ?>
                                                </div>

                                                <div class="small text-muted">
                                                    <?php echo htmlspecialchars($row['czas'] ?? ''); ?>
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
                                            <div class="col-12">
                                                <div class="report-info-box">
                                                    <div class="report-label">ID</div>
                                                    <div class="report-value"><?php echo htmlspecialchars($row['id'] ?? ''); ?></div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="report-info-box">
                                                    <div class="report-label">Kto</div>
                                                    <div class="report-value"><?php echo htmlspecialchars($row['kto'] ?? ''); ?></div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="report-info-box">
                                                    <div class="report-label">Rodzaj operacji</div>
                                                    <div class="report-value"><?php echo htmlspecialchars($row['rodzajOperacji'] ?? ''); ?></div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="report-info-box">
                                                    <div class="report-label">Czas</div>
                                                    <div class="report-value"><?php echo htmlspecialchars($row['czas'] ?? ''); ?></div>
                                                </div>
                                            </div>
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
                            <p class="mb-0">Brak raportów logowania w bazie danych.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="dashboard-footer-info mt-4">
                    <span><i class="bi bi-box-arrow-in-right"></i> Raport logowania systemu</span>
                    <span><i class="bi bi-layout-text-window"></i> Tabela desktop / accordion mobile</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../template/footer.php'; ?>