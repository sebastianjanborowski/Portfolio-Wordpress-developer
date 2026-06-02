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
    | 1. Zmiana statusu diety
    |--------------------------------------------------------------------------
    */
    if (isset($_POST['flaga']) && isset($_POST['nazwa'])) {
        $flaga = trim($_POST['flaga'] ?? '');
        $nazwa = trim($_POST['nazwa'] ?? '');

        if ($flaga === '' || $nazwa === '') {
            echo json_encode([
                'success' => false,
                'message' => 'Brak wymaganych danych'
            ]);
            exit;
        }

        $isActive = ($flaga === '1') ? 1 : 0;

        $stmt = $pdo->prepare("
            UPDATE diets
            SET is_active = :is_active
            WHERE diet_name = :nazwa
        ");

        $result = $stmt->execute([
            ':is_active' => $isActive,
            ':nazwa' => $nazwa
        ]);

        if (!$result) {
            echo json_encode([
                'success' => false,
                'message' => 'Błąd wykonania aktualizacji'
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
            WHERE diet_name = :nazwa
            LIMIT 1
        ");

        $stmtDiet->execute([
            ':nazwa' => $nazwa
        ]);

        $diet = $stmtDiet->fetch(PDO::FETCH_ASSOC);

        if (!$diet) {
            echo json_encode([
                'success' => false,
                'message' => 'Zmieniono status, ale nie udało się ponownie pobrać danych diety'
            ]);
            exit;
        }

        require_once '../generowanieRaportow/generowanieRaportow.php';

        $who = $_SESSION['who_is_logged'] ?? '';
        $nameTable = 'raport_diet';
        $operacja = ($isActive === 1) ? 'Akceptacja diety' : 'Dezaktywacja diety';

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
            $nazwa,
            $nameTable,
            $pdo,
            $dataBase
        );

        if (!$wynikRaportowania) {
            echo json_encode([
                'success' => false,
                'message' => 'Zmieniono status diety, ale zapis raportowania nie powiódł się'
            ]);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => ($isActive === 1)
                ? 'Dieta ' . $nazwa . ' została zaakceptowana'
                : 'Dieta ' . $nazwa . ' została dezaktywowana',
            'is_active' => $isActive,
            'diet_name' => $nazwa
        ]);
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | 2. Pobranie danych diety po nazwie
    |--------------------------------------------------------------------------
    */
    $nazwaDiety = trim($_POST['nazwaDiety'] ?? '');

    if ($nazwaDiety === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Nazwa diety nie może być pusta'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT *
        FROM diets
        WHERE diet_code = :dietCode
    ");

    $stmt->execute([
        ':dietCode' => $nazwaDiety
    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($data) === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Nie znaleziono diety o podanej nazwie'
        ]);
        exit;
    }

    if (count($data) > 1) {
        echo json_encode([
            'success' => false,
            'message' => 'W bazie są duplikaty nazw diet, do poprawy'
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

    if ($sqlState === '23000' && (int)$mysqlCode === 1062) {
        echo json_encode([
            'success' => false,
            'message' => 'Wystąpił konflikt danych unikalnych w bazie',
            'error_type' => 'duplicate_entry'
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

// 