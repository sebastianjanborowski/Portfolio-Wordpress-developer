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
| 1. Kasowanie użytkownika
|--------------------------------------------------------------------------
*/
if (isset($_POST['deleteLogin'])) {
    $deleteLogin = trim($_POST['deleteLogin'] ?? '');

    if ($deleteLogin === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Brak loginu użytkownika do usunięcia'
        ]);
        exit;
    }

    try {
        // pobranie danych usera przed usunięciem, potrzebne do raportowania
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
            ':login' => $deleteLogin
        ]);

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            echo json_encode([
                'success' => false,
                'message' => 'Nie znaleziono użytkownika o podanym loginie',
                'login' => $deleteLogin
            ]);
            exit;
        }

        $stmt = $pdo->prepare("
            DELETE FROM users
            WHERE login = :login
        ");

        $result = $stmt->execute([
            ':login' => $deleteLogin
        ]);

        if (!$result) {
            echo json_encode([
                'success' => false,
                'message' => 'Błąd wykonania kasowania użytkownika'
            ]);
            exit;
        }

        if ($stmt->rowCount() > 0) {
            // raportowanie usunięcia użytkownika
            require_once '../generowanieRaportow/generowanieRaportow.php';
            $who = $_SESSION['who_is_logged'] ?? '';

            // kto jaka operacja, proces wykonany, nazwa tabeli raportów w bazie danych
            $nameTable = 'raport_users';

            $dataBase = [
                'userLogin' => $userData['login'],
                'userEmail' => $userData['email'],
                'userRole' => $userData['role'],
                'userName' => $userData['name'],
                'userSurname' => $userData['surname'],
                'userPassword' => $userData['password'],
                'userCreatedAt' => $userData['created_at'] ?? null,
                'userUpdatedAt' => $userData['updated_at'] ?? null,
                'is_active' => $userData['is_active'] ?? 0
            ];

            $nazwaObiektu = $userData['login'];

            // trzeba wysłać tablice danych do funckji
            $wynikRaportowania = cateringGenerateRaport(
                $who,
                'Usunięcie użytkownika',
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

            echo json_encode([
                'success' => true,
                'message' => 'Użytkownik ' . $deleteLogin . ' został usunięty',
                'login' => $deleteLogin
            ]);
            exit;
        }

        echo json_encode([
            'success' => false,
            'message' => 'Nie usunięto żadnego rekordu. Możliwe, że użytkownik nie istnieje.',
            'login' => $deleteLogin
        ]);
        exit;

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
            'message' => 'W bazie są duplikaty loginów użytkowników, do poprawy'
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