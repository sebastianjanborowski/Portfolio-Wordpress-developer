<?php
// plik odpowiada za przerobienie i dodanie zamówienia cateringowego do bazy danych

session_start();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Nieprawidłowa forma żądania'
    ]);
    exit;
}

$orderName = trim($_POST['orderName'] ?? '');
$orderCode = trim($_POST['orderCode'] ?? '');
$department = trim($_POST['department'] ?? '');
$special = trim($_POST['special'] ?? '');
$quantity = trim($_POST['quantity'] ?? '');
$restrictions = trim($_POST['restrictions'] ?? '');
$description = trim($_POST['description'] ?? '');
$additionalDescription = trim($_POST['additionalDescription'] ?? '');

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
        'message' => 'Wymagany jest oddział dla zamówienia'
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

if ($quantity === '' || !is_numeric($quantity) || (int)$quantity <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Liczba porcji musi być większa od zera'
    ]);
    exit;
}

if ($restrictions === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Wymagane są informacje o ograniczeniach zamówienia'
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

if ($additionalDescription === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Wymagane są dodatkowe uwagi do zamówienia'
    ]);
    exit;
}

try {
    require_once '../config/db.php';

    // sprawdzenie, czy kod zamówienia już istnieje
    $stmtCheck = $pdo->prepare("
        SELECT id
        FROM order_diets
        WHERE `Cod` = :orderCode
        LIMIT 1
    ");

    $stmtCheck->execute([
        ':orderCode' => $orderCode
    ]);

    if ($stmtCheck->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode([
            'success' => false,
            'message' => 'Kod zamówienia istnieje już w bazie danych, podaj unikalny kod',
            'error_type' => 'duplicate_order_code'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        INSERT INTO order_diets (
            `Order_name`,
            `Cod`,
            `Department`,
            `Special`,
            `Restrictions`,
            `Describe`,
            `Quantity`,
            `Addtional_describe`,
            `is_active`
        )
        VALUES (
            :orderName,
            :orderCode,
            :department,
            :special,
            :restrictions,
            :description,
            :quantity,
            :additionalDescription,
            0
        )
    ");

    $stmt->execute([
        ':orderName' => $orderName,
        ':orderCode' => $orderCode,
        ':department' => $department,
        ':special' => $special,
        ':restrictions' => $restrictions,
        ':description' => $description,
        ':quantity' => (int)$quantity,
        ':additionalDescription' => $additionalDescription
    ]);

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
        'isActive' => 0
    ];

    $wynikRaportowania = cateringGenerateRaport(
        $who,
        'Dodanie zamówienia',
        $orderName,
        $nameTable,
        $pdo,
        $dataBase
    );

    if (!$wynikRaportowania) {
        echo json_encode([
            'success' => false,
            'message' => 'Zamówienie zostało dodane, ale wystąpił błąd zapisu raportowania'
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Dodane zostało nowe zamówienie cateringowe'
    ]);
    exit;

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Błąd serwera',
        'error' => $e->getMessage()
    ]);
    exit;
}