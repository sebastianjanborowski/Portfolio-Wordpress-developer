<?php
// plik odpowiada za wyszukanie zamówienia oraz zapis akceptacji / braku akceptacji

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

    if (isset($_POST['nazwaZamowienia'])) {
        $nazwaZamowienia = trim($_POST['nazwaZamowienia'] ?? '');

        if ($nazwaZamowienia === '' || mb_strlen($nazwaZamowienia) < 3) {
            echo json_encode([
                'success' => false,
                'message' => 'Nazwa zamówienia powinna posiadać minimum 3 znaki'
            ]);
            exit;
        }

        $stmt = $pdo->prepare("
            SELECT
                id,
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
            WHERE `Cod` = :cod
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
    }

    if (isset($_POST['flaga'], $_POST['nazwa'])) {
        $flaga = trim($_POST['flaga']);
        $nazwa = trim($_POST['nazwa']);

        if ($flaga !== '0' && $flaga !== '1') {
            echo json_encode([
                'success' => false,
                'message' => 'Nieprawidłowa wartość akceptacji'
            ]);
            exit;
        }

        if ($nazwa === '') {
            echo json_encode([
                'success' => false,
                'message' => 'Brak nazwy zamówienia'
            ]);
            exit;
        }

        $stmt = $pdo->prepare("
            SELECT *
            FROM order_diets
            WHERE `Order_name` = :orderName
            LIMIT 1
        ");

        $stmt->execute([
            ':orderName' => $nazwa
        ]);

        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            echo json_encode([
                'success' => false,
                'message' => 'Nie znaleziono zamówienia do aktualizacji'
            ]);
            exit;
        }

        $stmt = $pdo->prepare("
            UPDATE order_diets
            SET `is_active` = :isActive
            WHERE `Order_name` = :orderName
            LIMIT 1
        ");

        $result = $stmt->execute([
            ':isActive' => (int)$flaga,
            ':orderName' => $nazwa
        ]);

        if (!$result) {
            echo json_encode([
                'success' => false,
                'message' => 'Nie udało się zmienić statusu zamówienia'
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
            'isActive' => (int)$flaga
        ];

        $operationName = ((int)$flaga === 1)
            ? 'Akceptacja zamówienia'
            : 'Brak akceptacji zamówienia';

        $wynikRaportowania = cateringGenerateRaport(
            $who,
            $operationName,
            $order['Order_name'],
            $nameTable,
            $pdo,
            $dataBase
        );

        if (!$wynikRaportowania) {
            echo json_encode([
                'success' => false,
                'message' => 'Status zamówienia został zmieniony, ale wystąpił błąd zapisu raportowania'
            ]);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => ((int)$flaga === 1)
                ? 'Zamówienie zostało zaakceptowane'
                : 'Zamówienie zostało oznaczone jako niezaakceptowane'
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