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

require_once '../config/db.php';

/*
|--------------------------------------------------------------------------
| 1. Zmiana statusu konta użytkownika
|--------------------------------------------------------------------------
| Oczekuje:
| - flaga
| - login
*/
if (isset($_POST['flaga']) && isset($_POST['login'])) {
    $flaga = trim($_POST['flaga'] ?? '');
    $login = trim($_POST['login'] ?? '');

    if ($flaga === '' || $login === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Brak wymaganych danych: flaga lub login'
        ]);
        exit;
    }

    $isActive = ($flaga === '1') ? 1 : 0;

    try {
        $stmt = $pdo->prepare("
            UPDATE users
            SET 
                is_active = :is_active,
                updated_at = NOW()
            WHERE login = :login
        ");

        $result = $stmt->execute([
            ':is_active' => $isActive,
            ':login' => $login
        ]);

        if (!$result) {
            echo json_encode([
                'success' => false,
                'message' => 'Błąd wykonania update użytkownika'
            ]);
            exit;
        }

        if ($stmt->rowCount() === 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Nie zaktualizowano żadnego rekordu. Możliwe, że użytkownik nie istnieje albo wartość była już ustawiona.',
                'is_active' => $isActive,
                'login' => $login
            ]);
            exit;
        }

        // pobranie świeżych danych po update
        $stmt = $pdo->prepare("
            SELECT
                id,
                login,
                name,
                surname,
                role,
                email,
                password,
                is_active,
                created_at,
                updated_at
            FROM users
            WHERE login = :login
            LIMIT 1
        ");

        $stmt->execute([
            ':login' => $login
        ]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            echo json_encode([
                'success' => false,
                'message' => 'Nie udało się pobrać danych użytkownika po aktualizacji'
            ]);
            exit;
        }

        // raportowanie aktualizacji użytkownika
        require_once '../generowanieRaportow/generowanieRaportow.php';
        $who = $_SESSION['who_is_logged'] ?? '';

        // kto jaka operacja, proces wykonany, nazwa tabeli raportów w bazie danych
        $nameTable = 'raport_users';

        $dataBase = [
            'userLogin' => $data['login'],
            'userEmail' => $data['email'],
            'userRole' => $data['role'],
            'userName' => $data['name'],
            'userSurname' => $data['surname'],
            'userPassword' => $data['password'],
            'userCreatedAt' => $data['created_at'] ?? null,
            'userUpdatedAt' => $data['updated_at'] ?? null,
            'is_active' => $data['is_active'] ?? 0
        ];

        $nazwaObiektu = $data['login'];
        $rodzajOperacji = ($isActive === 1) ? 'Akceptacja użytkownika' : 'Dezaktywacja użytkownika';

        // trzeba wysłać tablice danych do funckji
        $wynikRaportowania = cateringGenerateRaport(
            $who,
            $rodzajOperacji,
            $nazwaObiektu,
            $nameTable,
            $pdo,
            $dataBase
        );

        if (!$wynikRaportowania) {
            echo json_encode([
                'success' => false,
                'message' => 'Błąd zapisu raportowania'
            ]);
            exit;
        }

        if ($isActive === 1) {
            echo json_encode([
                'success' => true,
                'message' => 'Użytkownik ' . $login . ' został aktywowany',
                'is_active' => $isActive,
                'login' => $login,
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ]);
            exit;
        } else {
            echo json_encode([
                'success' => true,
                'message' => 'Użytkownik ' . $login . ' został dezaktywowany',
                'is_active' => $isActive,
                'login' => $login,
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at']
            ]);
            exit;
        }

    } catch (PDOException $error) {
        echo json_encode([
            'success' => false,
            'message' => 'Błąd bazy danych: ' . $error->getMessage()
        ]);
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| 2. Wyszukiwanie użytkownika po loginie
|--------------------------------------------------------------------------
| Oczekuje:
| - userLogin
*/
$userLogin = trim($_POST['userLogin'] ?? '');

if ($userLogin === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Login użytkownika nie może być pusty'
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT
            id,
            login,
            name,
            surname,
            role,
            email,
            is_active,
            created_at,
            updated_at
        FROM users
        WHERE login = :login
    ");

    $stmt->execute([
        ':login' => $userLogin
    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($data) === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Nie znaleziono użytkownika o podanym loginie'
        ]);
        exit;
    }

    if (count($data) > 1) {
        echo json_encode([
            'success' => false,
            'message' => 'W bazie są duplikaty loginów, do poprawy'
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Znaleziono użytkownika w bazie danych',
        'id' => $data[0]['id'],
        'login' => $data[0]['login'],
        'name' => $data[0]['name'],
        'surname' => $data[0]['surname'],
        'role' => $data[0]['role'],
        'email' => $data[0]['email'],
        'is_active' => $data[0]['is_active'],
        'created_at' => $data[0]['created_at'],
        'updated_at' => $data[0]['updated_at']
    ]);
    exit;

} catch (PDOException $error) {
    echo json_encode([
        'success' => false,
        'message' => 'Błąd bazy danych: ' . $error->getMessage()
    ]);
    exit;
}