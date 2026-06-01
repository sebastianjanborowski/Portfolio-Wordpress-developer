<?php

declare(strict_types=1);
session_start();

$dozwoloneraporty = [
    'users',
    'raport_logowanie',
    'diet',
    'orders'
];

$tableraport = [
    'users' => [
        'table' => 'raport_users',
        'filename' => 'raport_uzytkownicy_' . date('Y-m-d_H-i-s') . '.csv',
        'columns' => [
            'id',
            'kto',
            'rodzajOperacji',
            'nazwaObiektu',
            'login',
            'imie',
            'nazwisko',
            'rola',
            'email',
            'is_active',
            'created_at',
            'updated_at'
        ],
        'headers' => [
            'ID',
            'Kto wykonał operację',
            'Rodzaj wykonanej czynności',
            'Nazwa zmienianego obiektu',
            'Login',
            'Imię',
            'Nazwisko',
            'Rola',
            'E-mail',
            'Aktywne',
            'Utworzone',
            'Zaktualizowane'
        ]
    ],

    'raport_logowanie' => [
        'table' => 'raport_logowanie',
        'filename' => 'raport_logowania_uzytkownicy_' . date('Y-m-d_H-i-s') . '.csv',
        'columns' => [
            'id',
            'kto',
            'rodzajOperacji',
            'czas'
        ],
        'headers' => [
            'ID',
            'Kto',
            'Rodzaj operacji',
            'Czas wykonania akcji'
        ]
    ],

    'diet' => [
        'table' => 'raport_diet',
        'filename' => 'raport_diety_' . date('Y-m-d_H-i-s') . '.csv',
        'columns' => [
            'id',
            'kto',
            'rodzajOperacji',
            'nazwaObiektu',
            'czas',
            'department_id',
            'diet_name',
            'diet_code',
            'is_special_diet',
            'diet_restrictions',
            'diet_description',
            'diet_notes',
            'is_active'
        ],
        'headers' => [
            'ID',
            'Kto',
            'Operacja',
            'Nazwa obiektu',
            'Czas',
            'Oddział',
            'Nazwa diety',
            'Kod diety',
            'Czy dieta specjalna',
            'Ograniczenia diety',
            'Opis diety',
            'Dodatkowe notatki',
            'Status'
        ]
    ],

    'orders' => [
        'table' => 'raport_orders',
        'filename' => 'raport_zamowien_cateringowych_' . date('Y-m-d_H-i-s') . '.csv',
        'columns' => [
            'id',
            'Who',
            'Type_operation',
            'Created_at',
            'Name',
            'Department_id',
            'Order_name',
            'Order_code',
            'Is_special',
            'Order_restrictions',
            'Order_description',
            'Is_active'
        ],
        'headers' => [
            'ID',
            'Kto wykonał operację',
            'Rodzaj wykonanej czynności',
            'Czas wykonania akcji',
            'Nazwa obiektu',
            'Oddział',
            'Nazwa zamówienia',
            'Kod zamówienia',
            'Zamówienie specjalne',
            'Ograniczenia zamówienia',
            'Opis zamówienia',
            'Status'
        ]
    ]
];

/*
|--------------------------------------------------------------------------
| POBRANIE TYPU
|--------------------------------------------------------------------------
*/
$typ = $_GET['typ'] ?? '';

/*
|--------------------------------------------------------------------------
| WALIDACJA ŻĄDANIA
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    $_SESSION['bad_request'] = 'Nieprawidłowa forma żądania';
    header('Location: ../../window/dashboard_generate_raport.php');
    exit;
}

if (!in_array($typ, $dozwoloneraporty, true)) {
    $_SESSION['bad_request'] = 'Nieprawidłowy typ raportu';
    header('Location: ../../window/dashboard_generate_raport.php');
    exit;
}

if (!isset($tableraport[$typ])) {
    $_SESSION['bad_request'] = 'Brak konfiguracji dla wybranego raportu';
    header('Location: ../../window/dashboard_generate_raport.php');
    exit;
}

require_once '../config/db.php';

$config = $tableraport[$typ];
$table = $config['table'];
$filename = $config['filename'];
$columns = $config['columns'];
$headers = $config['headers'];

$columnsSql = '`' . implode('`,`', $columns) . '`';

try {
    $sql = "SELECT {$columnsSql} FROM `{$table}` ORDER BY `id` DESC";
    $stmt = $pdo->query($sql);

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');

    fwrite($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
    fputcsv($output, $headers, ';');

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row, ';');
    }

    fclose($output);
    exit;

} catch (PDOException $error) {
    $_SESSION['bad_request'] = 'Błąd generowania raportu: ' . $error->getMessage();
    header('Location: ../../window/dashboard_generate_raport.php');
    exit;
}