<form method="POST" action="core/findDomain/searchDomain.php" class="domain-search-form js-validate-form" novalidate>
    <input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>">

    <div class="row g-3 align-items-start justify-content-center">
        <div class="col-12 col-xl">
            <label for="domain" class="form-label fw-bold">Nazwa domeny</label>
            <input
                id="domain"
                type="text"
                class="form-control domain-input"
                name="domain"
                placeholder="np. mojafirma.pl"
                value="<?php echo e($_POST['domain'] ?? ''); ?>"
                autocomplete="off"
                required
                data-label="Nazwa domeny"
            >
            <div class="form-text">Wpisz pełną domenę razem z końcówką, np. <strong>mojafirma.pl</strong>, <strong>sklep.com</strong> albo <strong>portfolio.dev</strong>.</div>
        </div>

        <div class="col-12 col-xl-auto pt-xl-4">
            <button type="submit" class="btn btn-primary domain-btn w-100">
                <i class="bi bi-search me-2"></i> Sprawdź domenę
            </button>
        </div>
    </div>

    <div class="form-message js-form-message mt-3" aria-live="polite"></div>
</form>
