<?php

declare(strict_types=1);

require_once __DIR__ . '/../../includes/app-security.php';
require_once __DIR__ . '/../../includes/domain-utils.php';
require_once __DIR__ . '/../../config/db.php';

app_start_session();
verify_csrf();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_to('../../index.php');
}

$rawDomain = (string) ($_POST['domain'] ?? '');
$domain = normalize_domain($rawDomain);
[$isValid, $validationMessage] = validate_domain_name($domain);

if (!$isValid) {
    set_flash('error', $validationMessage);
    redirect_to('../../index.php#sprawdz');
}

$result = analyze_domain($domain);

try {
    $sql = 'INSERT INTO domain_searches
            (user_id, domain, status, message, recommendation, dns_a, dns_aaaa, dns_mx, dns_ns, ip_address, user_agent, created_at)
            VALUES
            (:user_id, :domain, :status, :message, :recommendation, :dns_a, :dns_aaaa, :dns_mx, :dns_ns, :ip_address, :user_agent, NOW())';

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'user_id' => current_user_id(),
        'domain' => $domain,
        'status' => $result['status'],
        'message' => $result['message'],
        'recommendation' => $result['recommendation'],
        'dns_a' => $result['dns_a'] ? 1 : 0,
        'dns_aaaa' => $result['dns_aaaa'] ? 1 : 0,
        'dns_mx' => $result['dns_mx'] ? 1 : 0,
        'dns_ns' => $result['dns_ns'] ? 1 : 0,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
        'user_agent' => substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255),
    ]);
} catch (Throwable $exception) {
    set_flash('error', 'Domena została sprawdzona, ale nie udało się zapisać wyniku w historii. Sprawdź strukturę bazy danych.');
}

$_SESSION['last_domain_result'] = [
    'domain' => $domain,
    'status' => $result['status'],
    'short_status' => $result['short_status'],
    'badge' => $result['badge'],
    'message' => $result['message'],
    'recommendation' => $result['recommendation'],
    'dns_a' => $result['dns_a'],
    'dns_aaaa' => $result['dns_aaaa'],
    'dns_mx' => $result['dns_mx'],
    'dns_ns' => $result['dns_ns'],
];

set_flash('success', 'Analiza domeny została wykonana poprawnie.');
redirect_to('../../index.php#sprawdz');
