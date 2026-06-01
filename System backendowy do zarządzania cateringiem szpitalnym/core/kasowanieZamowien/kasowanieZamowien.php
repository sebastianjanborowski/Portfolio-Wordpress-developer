<?php
// plik odpowiada za wyszukanie zamówienia po kodzie oraz usunięcie zamówienia z bazy danych

session_start();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Nieprawidłowa forma żądania'
    ]);
    exit;
}

try {
    require_once '../config/db.php';

    if (isset($_POST['orderCode'])) {
        $orderCode = trim($_POST['orderCode'] ?? '');

        if ($orderCode === '' || mb_strlen($orderCode) < 2) {
            echo json_encode([
                'success' => false,
                'message' => 'Kod zamówienia powinien posiadać minimum 2 znaki'
            ]);
            exit;
        }

        $stmt = $pdo->prepare("
            SELECT
                `id`,
                `Order_name`,
                `Cod`,
                `Department`,
                `Special`,
                `Restrictions`,
                `Describe`,
                `Quantity`,
                `Addtional_describe`,
                `Created_at`,
                `is_active`
            FROM order_diets
            WHERE `Cod` = :orderCode
            LIMIT 1
        ");

        $stmt->execute([
            ':orderCode' => $orderCode
        ]);

        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            echo json_encode([
                'success' => false,
                'message' => 'Nie znaleziono zamówienia o podanym kodzie'
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
    }

    if (isset($_POST['deleteOrderCode'])) {
        $deleteOrderCode = trim($_POST['deleteOrderCode'] ?? '');

        if ($deleteOrderCode === '' || mb_strlen($deleteOrderCode) < 2) {
            echo json_encode([
                'success' => false,
                'message' => 'Brak prawidłowego kodu zamówienia do usunięcia'
            ]);
            exit;
        }

        $stmt = $pdo->prepare("
            SELECT *
            FROM order_diets
            WHERE `Cod` = :orderCode
            LIMIT 1
        ");

        $stmt->execute([
            ':orderCode' => $deleteOrderCode
        ]);

        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            echo json_encode([
                'success' => false,
                'message' => 'Nie znaleziono zamówienia do usunięcia'
            ]);
            exit;
        }

        require_once '../generowanieRaportow/generowanieRaportow.php';

        $who = $_SESSION['who_is_logged'] ?? '';
        $nameTable = 'raport_orders';

        $dataBase = [
            'orderName' => $order['Order_name'] ?? null,
            'orderCode' => $order['Cod'] ?? null,
            'department' => $order['Department'] ?? null,
            'special' => $order['Special'] ?? null,
            'quantity' => (int)($order['Quantity'] ?? 0),
            'restrictions' => $order['Restrictions'] ?? null,
            'description' => $order['Describe'] ?? null,
            'additionalDescription' => $order['Addtional_describe'] ?? null,
            'isActive' => (int)($order['is_active'] ?? 0)
        ];

        $wynikRaportowania = cateringGenerateRaport(
            $who,
            'Usunięcie zamówienia',
            $order['Cod'],
            $nameTable,
            $pdo,
            $dataBase
        );

        if (!$wynikRaportowania) {
            echo json_encode([
                'success' => false,
                'message' => 'Wystąpił błąd zapisu raportowania. Zamówienie nie zostało usunięte.'
            ]);
            exit;
        }

        $stmt = $pdo->prepare("
            DELETE FROM order_diets
            WHERE `id` = :id
            LIMIT 1
        ");

        $deleted = $stmt->execute([
            ':id' => (int)$order['id']
        ]);

        if (!$deleted) {
            echo json_encode([
                'success' => false,
                'message' => 'Nie udało się usunąć zamówienia'
            ]);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => 'Zamówienie zostało usunięte z bazy danych'
        ]);
        exit;
    }

    echo json_encode([
        'success' => false,
        'message' => 'Brak wymaganych danych'
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