<?php
session_start();
require_once '../core/config/db.php';

$stmt = $pdo->prepare("SELECT * FROM order_diets ORDER BY id DESC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../template/header.php';
?>

<div class="dashboard-page">
    <div class="container-fluid px-3 px-xl-4">
        <div class="diet-page-wide mx-auto">

            <div class="dashboard-header mb-4">
                <div class="login-top-icon">
                    <i class="bi bi-basket2-fill"></i>
                </div>
                <h1>Lista zamówień cateringowych</h1>
                <p>Przegląd wszystkich zamówień dietetycznych zapisanych w systemie</p>
            </div>

            <div class="dashboard-card diet-table-card">

                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
                    <div>
                        <h2 class="h5 mb-1 fw-bold text-primary-custom">Wszystkie zamówienia</h2>
                        <div class="text-muted small">
                            Liczba rekordów: <span id="ordersCount"><?php echo count($data); ?></span>
                        </div>
                    </div>

                    <div>
                        <a href="dashboard_orders.php" class="btn btn-outline-secondary diet-back-btn-bootstrap">
                            <i class="bi bi-arrow-left me-2"></i>Wróć
                        </a>
                    </div>
                </div>

                <?php if (!empty($data)): ?>

                    <div class="reports-tools mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-lg-6">
                                <label for="orderSearch" class="form-label fw-semibold">Wyszukaj</label>
                                <div class="input-group">
                                    <span class="input-group-text reports-tool-icon">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input
                                        type="text"
                                        id="orderSearch"
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
                                <label for="statusFilter" class="form-label fw-semibold">Status zamówienia</label>
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
                                    <option value="order_name-asc">Nazwa A-Z</option>
                                    <option value="order_name-desc">Nazwa Z-A</option>
                                    <option value="department-asc">Oddział A-Z</option>
                                    <option value="department-desc">Oddział Z-A</option>
                                    <option value="quantity-asc">Ilość rosnąco</option>
                                    <option value="quantity-desc">Ilość malejąco</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive diet-table-bootstrap-wrap reports-desktop-table">
                        <table class="table table-hover align-middle mb-0 diet-table-bootstrap" id="ordersTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nazwa zamówienia</th>
                                    <th>Kod</th>
                                    <th>Oddział</th>
                                    <th>Specjalne</th>
                                    <th>Ograniczenia</th>
                                    <th>Opis</th>
                                    <th>Ilość</th>
                                    <th>Dodatkowy opis</th>
                                    <th>Utworzono</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody id="ordersTableBody">
                                <?php foreach ($data as $row): ?>
                                    <?php $isActive = (int)($row['is_active'] ?? 0) === 1; ?>

                                    <tr
                                        data-id="<?php echo htmlspecialchars((string)($row['id'] ?? '')); ?>"
                                        data-order_name="<?php echo htmlspecialchars((string)($row['Order_name'] ?? '')); ?>"
                                        data-cod="<?php echo htmlspecialchars((string)($row['Cod'] ?? '')); ?>"
                                        data-department="<?php echo htmlspecialchars((string)($row['Department'] ?? '')); ?>"
                                        data-special="<?php echo htmlspecialchars((string)($row['Special'] ?? '')); ?>"
                                        data-restrictions="<?php echo htmlspecialchars((string)($row['Restrictions'] ?? '')); ?>"
                                        data-describe="<?php echo htmlspecialchars((string)($row['Describe'] ?? '')); ?>"
                                        data-quantity="<?php echo htmlspecialchars((string)($row['Quantity'] ?? '')); ?>"
                                        data-addtional_describe="<?php echo htmlspecialchars((string)($row['Addtional_describe'] ?? '')); ?>"
                                        data-created_at="<?php echo htmlspecialchars((string)($row['Created_at'] ?? '')); ?>"
                                        data-is_active="<?php echo htmlspecialchars((string)($row['is_active'] ?? '0')); ?>"
                                        data-search="<?php echo htmlspecialchars(mb_strtolower(
                                            implode(' ', [
                                                $row['id'] ?? '',
                                                $row['Order_name'] ?? '',
                                                $row['Cod'] ?? '',
                                                $row['Department'] ?? '',
                                                $row['Special'] ?? '',
                                                $row['Restrictions'] ?? '',
                                                $row['Describe'] ?? '',
                                                $row['Quantity'] ?? '',
                                                $row['Addtional_describe'] ?? '',
                                                $row['Created_at'] ?? '',
                                                ((int)($row['is_active'] ?? 0) === 1 ? 'aktywne' : 'nieaktywne')
                                            ])
                                        )); ?>"
                                    >
                                        <td class="fw-semibold"><?php echo htmlspecialchars($row['id'] ?? ''); ?></td>
                                        <td class="fw-semibold"><?php echo htmlspecialchars($row['Order_name'] ?? ''); ?></td>
                                        <td>
                                            <span class="badge rounded-pill diet-code-badge">
                                                <?php echo htmlspecialchars($row['Cod'] ?? ''); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['Department'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($row['Special'] ?? ''); ?></td>
                                        <td class="text-wrap diet-col-wide"><?php echo htmlspecialchars($row['Restrictions'] ?? ''); ?></td>
                                        <td class="text-wrap diet-col-wide"><?php echo htmlspecialchars($row['Describe'] ?? ''); ?></td>
                                        <td class="fw-semibold"><?php echo htmlspecialchars($row['Quantity'] ?? ''); ?></td>
                                        <td class="text-wrap diet-col-wide"><?php echo htmlspecialchars($row['Addtional_describe'] ?? ''); ?></td>
                                        <td class="text-wrap diet-col-wide"><?php echo htmlspecialchars($row['Created_at'] ?? ''); ?></td>
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

                    <div class="accordion reports-accordion reports-mobile-accordion" id="ordersAccordion">
                        <?php foreach ($data as $index => $row): ?>
                            <?php
                                $orderId = (int)($row['id'] ?? 0);
                                $isActive = (int)($row['is_active'] ?? 0) === 1;
                            ?>

                            <div
                                class="accordion-item order-mobile-item"
                                data-id="<?php echo htmlspecialchars((string)($row['id'] ?? '')); ?>"
                                data-order_name="<?php echo htmlspecialchars((string)($row['Order_name'] ?? '')); ?>"
                                data-department="<?php echo htmlspecialchars((string)($row['Department'] ?? '')); ?>"
                                data-quantity="<?php echo htmlspecialchars((string)($row['Quantity'] ?? '')); ?>"
                                data-created_at="<?php echo htmlspecialchars((string)($row['Created_at'] ?? '')); ?>"
                                data-is_active="<?php echo htmlspecialchars((string)($row['is_active'] ?? '0')); ?>"
                                data-search="<?php echo htmlspecialchars(mb_strtolower(
                                    implode(' ', [
                                        $row['id'] ?? '',
                                        $row['Order_name'] ?? '',
                                        $row['Cod'] ?? '',
                                        $row['Department'] ?? '',
                                        $row['Special'] ?? '',
                                        $row['Restrictions'] ?? '',
                                        $row['Describe'] ?? '',
                                        $row['Quantity'] ?? '',
                                        $row['Addtional_describe'] ?? '',
                                        $row['Created_at'] ?? '',
                                        ((int)($row['is_active'] ?? 0) === 1 ? 'aktywne' : 'nieaktywne')
                                    ])
                                )); ?>"
                            >
                                <h2 class="accordion-header" id="headingOrder<?php echo $orderId; ?>">
                                    <button
                                        class="accordion-button <?php echo $index === 0 ? '' : 'collapsed'; ?>"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseOrder<?php echo $orderId; ?>"
                                        aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                                        aria-controls="collapseOrder<?php echo $orderId; ?>"
                                    >
                                        <span class="fw-semibold me-2">
                                            #<?php echo htmlspecialchars($row['id'] ?? ''); ?>
                                        </span>
                                        <?php echo htmlspecialchars($row['Order_name'] ?? 'Brak nazwy'); ?>
                                    </button>
                                </h2>

                                <div
                                    id="collapseOrder<?php echo $orderId; ?>"
                                    class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>"
                                    aria-labelledby="headingOrder<?php echo $orderId; ?>"
                                    data-bs-parent="#ordersAccordion"
                                >
                                    <div class="accordion-body">
                                        <p><strong>Kod:</strong> <?php echo htmlspecialchars($row['Cod'] ?? ''); ?></p>
                                        <p><strong>Oddział:</strong> <?php echo htmlspecialchars($row['Department'] ?? ''); ?></p>
                                        <p><strong>Specjalne:</strong> <?php echo htmlspecialchars($row['Special'] ?? ''); ?></p>
                                        <p><strong>Ograniczenia:</strong> <?php echo htmlspecialchars($row['Restrictions'] ?? ''); ?></p>
                                        <p><strong>Opis:</strong> <?php echo htmlspecialchars($row['Describe'] ?? ''); ?></p>
                                        <p><strong>Ilość:</strong> <?php echo htmlspecialchars($row['Quantity'] ?? ''); ?></p>
                                        <p><strong>Dodatkowy opis:</strong> <?php echo htmlspecialchars($row['Addtional_describe'] ?? ''); ?></p>
                                        <p><strong>Utworzono:</strong> <?php echo htmlspecialchars($row['Created_at'] ?? ''); ?></p>
                                        <p>
                                            <strong>Status:</strong>
                                            <?php if ($isActive): ?>
                                                <span class="badge rounded-pill bg-success">Aktywne</span>
                                            <?php else: ?>
                                                <span class="badge rounded-pill bg-danger">Nieaktywne</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                <?php else: ?>

                    <div class="text-center py-5">
                        <i class="bi bi-basket2 display-4 text-muted"></i>
                        <h3 class="mt-3">Brak zamówień</h3>
                        <p class="text-muted">W systemie nie zapisano jeszcze żadnych zamówień cateringowych.</p>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('orderSearch');
    const searchBtn = document.getElementById('searchBtn');
    const clearBtn = document.getElementById('clearBtn');
    const statusFilter = document.getElementById('statusFilter');
    const sortMobile = document.getElementById('sortMobile');
    const countElement = document.getElementById('ordersCount');

    const tableBody = document.getElementById('ordersTableBody');
    const tableRows = tableBody ? Array.from(tableBody.querySelectorAll('tr')) : [];
    const mobileItems = Array.from(document.querySelectorAll('.order-mobile-item'));

    function normalizeText(value) {
        return String(value || '').toLowerCase().trim();
    }

    function getSortValue(element, key) {
        const value = element.dataset[key] || '';

        if (key === 'id' || key === 'quantity') {
            return parseFloat(value) || 0;
        }

        if (key === 'created_at') {
            return new Date(value).getTime() || 0;
        }

        return normalizeText(value);
    }

    function sortElements(elements, sortValue) {
        const [key, direction] = sortValue.split('-');

        return elements.sort((a, b) => {
            const aValue = getSortValue(a, key);
            const bValue = getSortValue(b, key);

            if (typeof aValue === 'number' && typeof bValue === 'number') {
                return direction === 'asc' ? aValue - bValue : bValue - aValue;
            }

            return direction === 'asc'
                ? String(aValue).localeCompare(String(bValue), 'pl')
                : String(bValue).localeCompare(String(aValue), 'pl');
        });
    }

    function filterAndSort() {
        const searchValue = normalizeText(searchInput ? searchInput.value : '');
        const statusValue = statusFilter ? statusFilter.value : '';
        const sortValue = sortMobile ? sortMobile.value : 'id-desc';

        let visibleCount = 0;

        tableRows.forEach(row => {
            const matchesSearch = !searchValue || normalizeText(row.dataset.search).includes(searchValue);
            const matchesStatus = statusValue === '' || row.dataset.is_active === statusValue;
            const isVisible = matchesSearch && matchesStatus;

            row.style.display = isVisible ? '' : 'none';

            if (isVisible) {
                visibleCount++;
            }
        });

        mobileItems.forEach(item => {
            const matchesSearch = !searchValue || normalizeText(item.dataset.search).includes(searchValue);
            const matchesStatus = statusValue === '' || item.dataset.is_active === statusValue;
            const isVisible = matchesSearch && matchesStatus;

            item.style.display = isVisible ? '' : 'none';
        });

        if (tableBody) {
            sortElements(tableRows, sortValue).forEach(row => tableBody.appendChild(row));
        }

        const accordion = document.getElementById('ordersAccordion');
        if (accordion) {
            sortElements(mobileItems, sortValue).forEach(item => accordion.appendChild(item));
        }

        if (countElement) {
            countElement.textContent = visibleCount;
        }
    }

    if (searchBtn) {
        searchBtn.addEventListener('click', filterAndSort);
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            if (searchInput) searchInput.value = '';
            if (statusFilter) statusFilter.value = '';
            if (sortMobile) sortMobile.value = 'id-desc';
            filterAndSort();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('keyup', function (event) {
            if (event.key === 'Enter') {
                filterAndSort();
            }
        });
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', filterAndSort);
    }

    if (sortMobile) {
        sortMobile.addEventListener('change', filterAndSort);
    }
});
</script>

<?php require_once '../template/footer.php'; ?>