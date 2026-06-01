
document.addEventListener('DOMContentLoaded', function () {
    const searchInput   = document.getElementById('reportSearch');
    const searchBtn     = document.getElementById('searchBtn');
    const clearBtn      = document.getElementById('clearBtn');
    const statusFilter  = document.getElementById('statusFilter');
    const sortMobile    = document.getElementById('sortMobile');
    const countBox      = document.getElementById('reportsCount');
    const noResultsBox  = document.getElementById('reportsNoResults');

    const tableBody     = document.getElementById('reportsTableBody');
    const tableRows     = tableBody ? Array.from(tableBody.querySelectorAll('tr')) : [];
    const accordion     = document.getElementById('reportsAccordion');
    const accordionItems = accordion ? Array.from(accordion.querySelectorAll('.accordion-item')) : [];
    const sortButtons   = Array.from(document.querySelectorAll('.table-sort-btn'));

    if (!tableBody && !accordion) {
        return;
    }

    let currentSortKey = 'id';
    let currentSortDirection = 'desc';
    let appliedSearchQuery = '';

    function normalize(val) {
        return (val || '').toString().trim().toLowerCase();
    }

    function parseValue(value, key) {
        const normalized = normalize(value);

        // pola liczbowe
        if (['id', 'is_active', 'rola'].includes(key)) {
            const num = parseInt(normalized, 10);
            return isNaN(num) ? 0 : num;
        }

        // pola daty/czasu
        if (['created_at', 'updated_at', 'czas'].includes(key)) {
            const time = Date.parse(normalized.replace(' ', 'T'));
            return isNaN(time) ? 0 : time;
        }

        return normalized;
    }

    function compareValues(a, b, key, direction) {
        const aVal = parseValue(a.dataset[key], key);
        const bVal = parseValue(b.dataset[key], key);

        let result = 0;

        if (typeof aVal === 'number' && typeof bVal === 'number') {
            result = aVal - bVal;
        } else {
            result = aVal.localeCompare(bVal, 'pl', {
                numeric: true,
                sensitivity: 'base'
            });
        }

        return direction === 'asc' ? result : -result;
    }

    function getAppliedQuery() {
        return normalize(appliedSearchQuery);
    }

    function getStatus() {
        return statusFilter ? statusFilter.value : '';
    }

    function itemMatches(item) {
        const query = getAppliedQuery();
        const status = getStatus();

        const haystack = normalize(item.dataset.search);
        const itemStatus = normalize(item.dataset.is_active);

        const matchesQuery = !query || haystack.includes(query);

        // jeśli nie ma statusFilter albo element nie ma data-is_active,
        // to filtr statusu nie blokuje wyników
        const matchesStatus =
            !statusFilter ||
            status === '' ||
            itemStatus === status;

        return matchesQuery && matchesStatus;
    }

    function sortCollection(items) {
        return items.sort((a, b) => compareValues(a, b, currentSortKey, currentSortDirection));
    }

    function updateSortButtonsUI() {
        sortButtons.forEach(btn => {
            btn.classList.remove('active');
            const icon = btn.querySelector('i');

            if (icon) {
                icon.className = 'bi bi-arrow-down-up';
            }

            if (btn.dataset.sort === currentSortKey) {
                btn.classList.add('active');

                if (icon) {
                    if (['id', 'is_active', 'rola', 'created_at', 'updated_at', 'czas'].includes(currentSortKey)) {
                        icon.className = currentSortDirection === 'asc'
                            ? 'bi bi-sort-numeric-down'
                            : 'bi bi-sort-numeric-up';
                    } else {
                        icon.className = currentSortDirection === 'asc'
                            ? 'bi bi-sort-alpha-down'
                            : 'bi bi-sort-alpha-up';
                    }
                }
            }
        });
    }

    function renderTable() {
        if (!tableBody) return 0;

        const filtered = tableRows.filter(itemMatches);
        sortCollection(filtered);

        tableRows.forEach(row => {
            row.style.display = 'none';
        });

        filtered.forEach(row => {
            row.style.display = '';
            tableBody.appendChild(row);
        });

        return filtered.length;
    }

    function renderAccordion() {
        if (!accordion) return 0;

        const filtered = accordionItems.filter(itemMatches);
        sortCollection(filtered);

        accordionItems.forEach(item => {
            item.style.display = 'none';
        });

        filtered.forEach(item => {
            item.style.display = '';
            accordion.appendChild(item);
        });

        return filtered.length;
    }

    function renderAll() {
        const tableCount = renderTable();
        const accordionCount = renderAccordion();
        const visibleCount = Math.max(tableCount, accordionCount);

        if (countBox) {
            countBox.textContent = visibleCount;
        }

        if (noResultsBox) {
            noResultsBox.classList.toggle('d-none', visibleCount > 0);
        }
    }

    function applySearch() {
        appliedSearchQuery = searchInput ? searchInput.value : '';
        renderAll();
    }

    function clearSearch() {
        appliedSearchQuery = '';

        if (searchInput) {
            searchInput.value = '';
        }

        if (statusFilter) {
            statusFilter.value = '';
        }

        renderAll();
    }

    sortButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const key = this.dataset.sort;

            if (currentSortKey === key) {
                currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                currentSortKey = key;
                currentSortDirection = ['id', 'created_at', 'updated_at', 'czas'].includes(key) ? 'desc' : 'asc';
            }

            updateSortButtonsUI();

            if (sortMobile) {
                sortMobile.value = `${currentSortKey}-${currentSortDirection}`;
            }

            renderAll();
        });
    });

    if (sortMobile) {
        sortMobile.addEventListener('change', function () {
            const parts = this.value.split('-');
            currentSortKey = parts[0];
            currentSortDirection = parts[1] || 'asc';
            updateSortButtonsUI();
            renderAll();
        });
    }

    if (searchBtn) {
        searchBtn.addEventListener('click', applySearch);
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', clearSearch);
    }

    if (searchInput) {
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                applySearch();
            }
        });
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', renderAll);
    }

    updateSortButtonsUI();
    renderAll();
});
