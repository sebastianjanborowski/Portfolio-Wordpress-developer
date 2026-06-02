<?php
// plik odpowiada za aktualizację istniejącego zamówienia cateringowego

session_start();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Nieprawidłowa forma żądania'
    ]);
    exit;
}

$orderName = trim($_POST['Order_name'] ?? '');
$orderCode = trim($_POST['Cod'] ?? '');
$department = trim($_POST['Department'] ?? '');
$special = trim($_POST['Special'] ?? '');
$restrictions = trim($_POST['Restrictions'] ?? '');
$description = trim($_POST['Describe'] ?? '');
$quantity = trim($_POST['Quantity'] ?? '');
$additionalDescription = trim($_POST['Addtional_describe'] ?? '');
$klucz = trim($_POST['klucz'] ?? '');

if ($orderName === '' || mb_strlen($orderName) < 3) {
    echo json_encode([
        'success' => false,
        'message' => 'Nazwa zamówienia powinna posiadać minimum 3 znaki'
    ]);
    exit;
}

if ($orderCode === '' || mb_strlen($orderCode) < 2) {
    echo json_encode([
        'success' => false,
        'message' => 'Kod zamówienia powinien posiadać minimum 2 znaki'
    ]);
    exit;
}

if ($department === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Wymagany jest oddział zamówienia'
    ]);
    exit;
}

if ($special === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Wymagane jest oznaczenie zamówienia specjalnego'
    ]);
    exit;
}

if ($restrictions === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Wymagane są ograniczenia / alergeny'
    ]);
    exit;
}

if ($description === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Wymagany jest opis zamówienia'
    ]);
    exit;
}

if ($quantity === '' || !is_numeric($quantity) || (int)$quantity <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Liczba porcji musi być większa od zera'
    ]);
    exit;
}

if ($additionalDescription === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Wymagane są dodatkowe uwagi'
    ]);
    exit;
}

if ($klucz === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Brak klucza identyfikującego zamówienie'
    ]);
    exit;
}

try {
    require_once '../config/db.php';

    $stmt = $pdo->prepare("
        SELECT *
        FROM order_diets
        WHERE Order_name = :klucz
        LIMIT 1
    ");

    $stmt->execute([
        ':klucz' => $klucz
    ]);

    $oldOrder = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$oldOrder) {
        echo json_encode([
            'success' => false,
            'message' => 'Nie znaleziono zamówienia do aktualizacji'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT id
        FROM order_diets
        WHERE Cod = :orderCode
        AND Order_name != :klucz
        LIMIT 1
    ");

    $stmt->execute([
        ':orderCode' => $orderCode,
        ':klucz' => $klucz
    ]);

    $duplicateCode = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($duplicateCode) {
        echo json_encode([
            'success' => false,
            'message' => 'Kod zamówienia jest już używany przez inne zamówienie',
            'error_type' => 'duplicate_order_code'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT id
        FROM order_diets
        WHERE Order_name = :orderName
        AND Order_name != :klucz
        LIMIT 1
    ");

    $stmt->execute([
        ':orderName' => $orderName,
        ':klucz' => $klucz
    ]);

    $duplicateName = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($duplicateName) {
        echo json_encode([
            'success' => false,
            'message' => 'Nazwa zamówienia jest już używana przez inne zamówienie',
            'error_type' => 'duplicate_order_name'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        UPDATE order_diets
        SET
            Order_name = :orderName,
            Cod = :orderCode,
            Department = :department,
            Special = :special,
            Restrictions = :restrictions,
            `Describe` = :description,
            Quantity = :quantity,
            Addtional_describe = :additionalDescription
        WHERE Order_name = :klucz
    ");

    $result = $stmt->execute([
        ':orderName' => $orderName,
        ':orderCode' => $orderCode,
        ':department' => $department,
        ':special' => $special,
        ':restrictions' => $restrictions,
        ':description' => $description,
        ':quantity' => (int)$quantity,
        ':additionalDescription' => $additionalDescription,
        ':klucz' => $klucz
    ]);

    if (!$result) {
        echo json_encode([
            'success' => false,
            'message' => 'Nie udało się zaktualizować zamówienia'
        ]);
        exit;
    }

    require_once '../generowanieRaportow/generowanieRaportow.php';

    $who = $_SESSION['who_is_logged'] ?? '';
    $nameTable = 'raport_orders';

    $dataBase = [
        'orderName' => $orderName,
        'orderCode' => $orderCode,
        'department' => $department,
        'special' => $special,
        'quantity' => (int)$quantity,
        'restrictions' => $restrictions,
        'description' => $description,
        'additionalDescription' => $additionalDescription,
        'isActive' => $oldOrder['is_active'] ?? 0
    ];

    $wynikRaportowania = cateringGenerateRaport(
        $who,
        'Edycja zamówienia',
        $orderName,
        $nameTable,
        $pdo,
        $dataBase
    );

    if (!$wynikRaportowania) {
        echo json_encode([
            'success' => false,
            'message' => 'Zamówienie zostało zaktualizowane, ale wystąpił błąd zapisu raportowania'
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Zamówienie zostało zaktualizowane poprawnie'
    ]);
    exit;

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Błąd serwera podczas aktualizacji zamówienia',
        'error' => $e->getMessage()
    ]);
    exit;
}