<?php
/**
 * Funkcje domenowe: normalizacja, walidacja i podstawowa analiza DNS.
 */

declare(strict_types=1);

function normalize_domain(string $domain): string
{
    $domain = trim($domain);
    $domain = mb_strtolower($domain, 'UTF-8');
    $domain = preg_replace('#^https?://#i', '', $domain) ?? $domain;
    $domain = preg_replace('#/.*$#', '', $domain) ?? $domain;
    $domain = preg_replace('#\?.*$#', '', $domain) ?? $domain;
    $domain = preg_replace('#^www\.#i', '', $domain) ?? $domain;

    return trim($domain, " \t\n\r\0\x0B.");
}

function validate_domain_name(string $domain): array
{
    if ($domain === '') {
        return [false, 'Wpisz nazwę domeny, np. mojafirma.pl.'];
    }

    if (strlen($domain) > 253) {
        return [false, 'Nazwa domeny jest za długa. Maksymalna długość to 253 znaki.'];
    }

    if (str_contains($domain, '..')) {
        return [false, 'Domena nie może zawierać dwóch kropek obok siebie.'];
    }

    if (!preg_match('/^[a-z0-9.-]+\.[a-z]{2,}$/i', $domain)) {
        return [false, 'Wpisz poprawną domenę razem z końcówką, np. mojafirma.pl, sklep.com albo projekt.eu.'];
    }

    $labels = explode('.', $domain);

    foreach ($labels as $label) {
        if ($label === '') {
            return [false, 'Domena zawiera pusty fragment. Sprawdź kropki w nazwie.'];
        }

        if (strlen($label) > 63) {
            return [false, 'Pojedynczy fragment domeny nie może mieć więcej niż 63 znaki.'];
        }

        if (str_starts_with($label, '-') || str_ends_with($label, '-')) {
            return [false, 'Fragment domeny nie może zaczynać się ani kończyć myślnikiem.'];
        }
    }

    return [true, 'OK'];
}

function get_dns_flags(string $domain): array
{
    return [
        'A' => checkdnsrr($domain, 'A'),
        'AAAA' => checkdnsrr($domain, 'AAAA'),
        'MX' => checkdnsrr($domain, 'MX'),
        'NS' => checkdnsrr($domain, 'NS'),
    ];
}

function analyze_domain(string $domain): array
{
    $dns = get_dns_flags($domain);
    $hasDns = in_array(true, $dns, true);

    $records = [];
    foreach ($dns as $type => $exists) {
        if ($exists) {
            $records[] = $type;
        }
    }

    if ($hasDns) {
        return [
            'status' => 'Aktywna / prawdopodobnie zajęta',
            'short_status' => 'Zajęta',
            'badge' => 'danger',
            'message' => 'Domena posiada aktywne rekordy DNS: ' . implode(', ', $records) . '. Oznacza to, że prawdopodobnie jest już używana lub skonfigurowana.',
            'recommendation' => 'Jeżeli chcesz kupić tę domenę, sprawdź ją dodatkowo u rejestratora albo przez WHOIS.',
            'dns_a' => $dns['A'],
            'dns_aaaa' => $dns['AAAA'],
            'dns_mx' => $dns['MX'],
            'dns_ns' => $dns['NS'],
        ];
    }

    return [
        'status' => 'Brak aktywnych DNS / możliwa dostępność',
        'short_status' => 'Możliwie wolna',
        'badge' => 'success',
        'message' => 'Nie znaleziono podstawowych rekordów DNS dla tej domeny. Domena może być wolna, ale nie jest to pełna gwarancja dostępności.',
        'recommendation' => 'Potwierdź dostępność domeny u rejestratora, ponieważ brak DNS nie zawsze oznacza, że domena jest wolna.',
        'dns_a' => false,
        'dns_aaaa' => false,
        'dns_mx' => false,
        'dns_ns' => false,
    ];
}
