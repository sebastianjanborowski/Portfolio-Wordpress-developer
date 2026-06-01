<?php
// plik odpowiada za przerobenie i dodanie diety do bazy danych, można dorobić dodatkową walidacje na wyszukanie o określonej nazwie danego posiłku jak na razie odpowiada za to tylko silnik bazodanowy
session_start();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Nieprawidłowa forma żądania'
    ]);
    exit;
}

$dietName = trim($_POST['dietName'] ?? '');
$dietCode = trim($_POST['dietCode'] ?? '');
$department = trim($_POST['department'] ?? '');
$isSpecialDiet = trim($_POST['isSpecialDiet'] ?? '');
$dietRestrictions = trim($_POST['dietRestrictions'] ?? '');
$dietDescription = trim($_POST['dietDescription'] ?? '');
$dietNotes = trim($_POST['dietNotes'] ?? '');

if ($dietName === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Nazwa diety powinna posiadać minimum 3 znaki'
    ]);
    exit;
}

if ($dietCode === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Kod diety powinien posiadać minimum 3 znaki'
    ]);
    exit;
}

if ($department === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Wymagany jest oddział dla przypisania diety'
    ]);
    exit;
}

if ($isSpecialDiet !== '0' && $isSpecialDiet !== '1') {
    echo json_encode([
        'success' => false,
        'message' => 'Wymagane jest oznaczenie czy dieta jest specjalna czy nie'
    ]);
    exit;
}

if ($dietRestrictions === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Wymagane są informacje o ograniczeniach diety'
    ]);
    exit;
}

if ($dietDescription === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Wymagany jest opis diety'
    ]);
    exit;
}

if ($dietNotes === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Wymagane są notatki na temat diety'
    ]);
    exit;
}

try {
    require_once '../config/db.php';

    $date = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("
        INSERT INTO diets (
            department_id,
            diet_name,
            diet_code,
            is_special_diet,
            diet_restrictions,
            diet_description,
            diet_notes,
            is_active,
            created_at,
            updated_at
        )
        VALUES (
            :department,
            :dietName,
            :dietCode,
            :isSpecialDiet,
            :dietRestrictions,
            :dietDescription,
            :dietNotes,
            0,
            :date,
            :date_update
        )
    ");

    $stmt->execute([
        ':department' => $department,
        ':dietName' => $dietName,
        ':dietCode' => $dietCode,
        ':isSpecialDiet' => $isSpecialDiet,
        ':dietRestrictions' => $dietRestrictions,
        ':dietDescription' => $dietDescription,
        ':dietNotes' => $dietNotes,
        ':date' => $date,
        ':date_update' => $date
    ]);


    require_once '../generowanieRaportow/generowanieRaportow.php';
    $who = $_SESSION['who_is_logged'] ?? '';

    // kto jaka operacja, proces wykonany, nazwa tabeli raportów w bazie danych
    $nameTable = 'raport_diet';

    $dataBase = [
        'dietName' => $dietName,
        'dietCode' => $dietCode,
        'department' => $department,
        'isSpecialDiet' => $isSpecialDiet,
        'dietRestrictions' => $dietRestrictions,
        'dietDescription' => $dietDescription,
        'dietNotes' => $dietNotes
    ];

    // trzeba wysłać tablice danych do funckji
    $wynikRaportowania = cateringGenerateRaport($who, 'Dodanie diety', $dietName ,$nameTable, $pdo, $dataBase);

    if(!$wynikRaportowania){
        echo json_encode([
            'success' => false,
            'message' => 'Błąd zapisu raportowania'
            // 'redirect' => '../window/dashboard.php'
        ]);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Dodana została nowa dieta'
    ]);

} catch (PDOException $e) {
    $sqlState = $e->getCode();
    $mysqlCode = $e->errorInfo[1] ?? null;
    $mysqlMessage = $e->errorInfo[2] ?? $e->getMessage();

    if($sqlState === '23000' && (int)$mysqlCode === 1062){
        echo json_encode([
            'success' => false,
            'message' => 'Kod diety istnieje w bazie danych, proszę o sprawdzenie numeru diety i podanie unikalnej wartości',
            'error_type' => 'duplicate_diet_code'
        ]);
        exit;
    }

    echo json_encode([
        'success' => false,
        'message' => 'Błąd serwera '.$e,
        'error' => $e->getMessage()
    ]);
    exit;
}