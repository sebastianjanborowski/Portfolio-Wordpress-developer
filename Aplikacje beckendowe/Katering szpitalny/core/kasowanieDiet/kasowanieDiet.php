<?php
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

    /*
    |--------------------------------------------------------------------------
    | 1. Kasowanie diety
    |--------------------------------------------------------------------------
    */
    if (isset($_POST['deleteDietName'])) {
        $deleteDietCode = trim($_POST['deleteDietName'] ?? '');

        if ($deleteDietCode === '') {
            echo json_encode([
                'success' => false,
                'message' => 'Brak kodu diety do usunięcia'
            ]);
            exit;
        }

        $stmtDiet = $pdo->prepare("
            SELECT
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
            FROM diets
            WHERE diet_code = :diet_code
            LIMIT 1
        ");

        $stmtDiet->execute([
            ':diet_code' => $deleteDietCode
        ]);

        $diet = $stmtDiet->fetch(PDO::FETCH_ASSOC);

        if (!$diet) {
            echo json_encode([
                'success' => false,
                'message' => 'Nie znaleziono diety o podanym kodzie',
                'diet_code' => $deleteDietCode
            ]);
            exit;
        }

        $stmt = $pdo->prepare("
            DELETE FROM diets
            WHERE diet_code = :diet_code
        ");

        $result = $stmt->execute([
            ':diet_code' => $deleteDietCode
        ]);

        if (!$result) {
            echo json_encode([
                'success' => false,
                'message' => 'Błąd wykonania kasowania diety'
            ]);
            exit;
        }

        if ($stmt->rowCount() === 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Nie usunięto żadnego rekordu. Możliwe, że dieta nie istnieje.',
                'diet_code' => $deleteDietCode
            ]);
            exit;
        }

        require_once '../generowanieRaportow/generowanieRaportow.php';

        $who = $_SESSION['who_is_logged'] ?? '';
        $nameTable = 'raport_diet';
        $operacja = 'Usunięcie diety';

        $dataBase = [
            'department' => $diet['department_id'] ?? null,
            'dietName' => $diet['diet_name'] ?? null,
            'dietCode' => $diet['diet_code'] ?? null,
            'isSpecialDiet' => $diet['is_special_diet'] ?? 0,
            'dietRestrictions' => $diet['diet_restrictions'] ?? null,
            'dietDescription' => $diet['diet_description'] ?? null,
            'dietNotes' => $diet['diet_notes'] ?? null,
            'flaga' => $diet['is_active'] ?? 0
        ];

        $wynikRaportowania = cateringGenerateRaport(
            $who,
            $operacja,
            $diet['diet_name'] ?? $deleteDietCode,
            $nameTable,
            $pdo,
            $dataBase
        );

        if (!$wynikRaportowania) {
            echo json_encode([
                'success' => false,
                'message' => 'Dieta została usunięta, ale zapis raportowania nie powiódł się'
            ]);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => 'Dieta ' . ($diet['diet_name'] ?? $deleteDietCode) . ' została usunięta',
            'diet_name' => $diet['diet_name'] ?? null,
            'diet_code' => $diet['diet_code'] ?? $deleteDietCode
        ]);
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | 2. Wyszukiwanie diety po kodzie diety
    |--------------------------------------------------------------------------
    */
    $dietCode = trim($_POST['dietName'] ?? '');

    if ($dietCode === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Kod diety nie może być pusty'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT *
        FROM diets
        WHERE diet_code = :diet_code
    ");

    $stmt->execute([
        ':diet_code' => $dietCode
    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($data) === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Nie znaleziono diety o podanym kodzie'
        ]);
        exit;
    }

    if (count($data) > 1) {
        echo json_encode([
            'success' => false,
            'message' => 'W bazie są duplikaty kodów diet, do poprawy'
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Znaleziono dietę w bazie danych',
        'department_id' => $data[0]['department_id'],
        'diet_name' => $data[0]['diet_name'],
        'diet_code' => $data[0]['diet_code'],
        'is_special_diet' => $data[0]['is_special_diet'],
        'diet_restrictions' => $data[0]['diet_restrictions'],
        'diet_description' => $data[0]['diet_description'],
        'diet_notes' => $data[0]['diet_notes'],
        'is_active' => $data[0]['is_active'],
        'created_at' => $data[0]['created_at'],
        'updated_at' => $data[0]['updated_at']
    ]);
    exit;

} catch (PDOException $e) {
    $sqlState = $e->getCode();
    $mysqlCode = $e->errorInfo[1] ?? null;

    if ($sqlState === '23000' && (int)$mysqlCode === 1451) {
        echo json_encode([
            'success' => false,
            'message' => 'Nie można usunąć diety, ponieważ jest powiązana z innymi danymi w bazie',
            'error_type' => 'foreign_key_constraint'
        ]);
        exit;
    }

    echo json_encode([
        'success' => false,
        'message' => 'Błąd serwera',
        'error' => $e->getMessage()
    ]);
    exit;

} catch (Throwable $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Błąd aplikacji',
        'error' => $e->getMessage()
    ]);
    exit;
}