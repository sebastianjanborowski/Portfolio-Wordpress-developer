<?php
// plik odpowiada za wyszukanie zamówienia po nazwie i zwrócenie danych do JS

session_start();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Nieprawidłowa forma żądania'
    ]);
    exit;
}

$nazwaZamowienia = trim($_POST['nazwaZamowienia'] ?? '');

if ($nazwaZamowienia === '' || mb_strlen($nazwaZamowienia) < 3) {
    echo json_encode([
        'success' => false,
        'message' => 'Nazwa zamówienia powinna posiadać minimum 3 znaki'
    ]);
    exit;
}

try {
    require_once '../config/db.php';

    $stmt = $pdo->prepare("
        SELECT 
            id,
            Order_name,
            Cod,
            Department,
            Special,
            Restrictions,
            `Describe`,
            Quantity,
            Addtional_describe,
            Created_at,
            is_active
        FROM order_diets
        WHERE Cod = :cod
        LIMIT 1
    ");

    $stmt->execute([
        ':cod' => $nazwaZamowienia
    ]);

    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo json_encode([
            'success' => false,
            'message' => 'Nie znaleziono zamówienia o podanej nazwie'
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Znaleziono zamówienie',
        'id' => $order['id'],
        'Order_name' => $order['Order_name'],
        'Cod' => $order['Cod'],
        'Department' => $order['Department'],
        'Special' => $order['Special'],
        'Restrictions' => $order['Restrictions'],
        'Describe' => $order['Describe'],
        'Quantity' => $order['Quantity'],
        'Addtional_describe' => $order['Addtional_describe'],
        'Created_at' => $order['Created_at'],
        'is_active' => $order['is_active']
    ]);
    exit;

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Błąd serwera podczas wyszukiwania zamówienia',
        'error' => $e->getMessage()
    ]);
    exit;
}