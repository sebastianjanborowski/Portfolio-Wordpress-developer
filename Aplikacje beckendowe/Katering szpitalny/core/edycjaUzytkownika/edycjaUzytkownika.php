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

/*
|--------------------------------------------------------------------------
| AKTUALIZACJA UŻYTKOWNIKA
|--------------------------------------------------------------------------
| Ten blok działa wtedy, gdy z JS przychodzi:
| login, name, surname, role, email, password, klucz
*/
if (
    isset($_POST['login']) &&
    isset($_POST['name']) &&
    isset($_POST['surname']) &&
    isset($_POST['role']) &&
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['klucz'])
) {
    $login = trim($_POST['login'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $klucz = trim($_POST['klucz'] ?? '');


    if (
        $login === '' ||
        $name === '' ||
        $surname === '' ||
        $role === '' ||
        $email === '' ||
        $klucz === ''
    ) {
        echo json_encode([
            'success' => false,
            'message' => 'Brak wymaganych danych do aktualizacji użytkownika'
        ]);
        exit;
    }

    if (mb_strlen($login) < 3) {
        echo json_encode([
            'success' => false,
            'message' => 'Login jest za krótki'
        ]);
        exit;
    }

    if (mb_strlen($name) < 2) {
        echo json_encode([
            'success' => false,
            'message' => 'Imię jest za krótkie'
        ]);
        exit;
    }

    if (mb_strlen($surname) < 2) {
        echo json_encode([
            'success' => false,
            'message' => 'Nazwisko jest za krótkie'
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'message' => 'Adres e-mail jest nieprawidłowy'
        ]);
        exit;
    }

    try {
        require_once '../config/db.php';
        // sprawdzenie czy istnieje użytkownik po kluczu
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :klucz LIMIT 1");
        $stmt->execute([
            ':klucz' => $klucz
        ]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            echo json_encode([
                'success' => false,
                'message' => 'Nie znaleziono użytkownika do aktualizacji'
            ]);
            exit;
        }

        // sprawdzenie czy nowy login nie należy do innego użytkownika
        $stmt = $pdo->prepare("SELECT id FROM users WHERE login = :login AND login != :klucz LIMIT 1");
        $stmt->execute([
            ':login' => $login,
            ':klucz' => $klucz
        ]);
        $loginExists = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($loginExists) {
            echo json_encode([
                'success' => false,
                'message' => 'Podany login jest już zajęty przez innego użytkownika'
            ]);
            exit;
        }

        // sprawdzenie czy nowy email nie należy do innego użytkownika
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email AND login != :klucz LIMIT 1");
        $stmt->execute([
            ':email' => $email,
            ':klucz' => $klucz
        ]);
        $emailExists = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($emailExists) {
            echo json_encode([
                'success' => false,
                'message' => 'Podany adres e-mail jest już zajęty przez innego użytkownika'
            ]);
            exit;
        }

        // aktualizacja bez zmiany hasła
        if ($password === '') {
            $stmt = $pdo->prepare("
                UPDATE users 
                SET 
                    login = :login,
                    name = :name,
                    surname = :surname,
                    role = :role,
                    email = :email,
                    updated_at = NOW()
                WHERE login = :klucz
            ");

            $result = $stmt->execute([
                ':login' => $login,
                ':name' => $name,
                ':surname' => $surname,
                ':role' => $role,
                ':email' => $email,
                ':klucz' => $klucz
            ]);
        } else {
            if (mb_strlen($password) < 7) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Nowe hasło jest za krótkie'
                ]);
                exit;
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("
                UPDATE users 
                SET 
                    login = :login,
                    name = :name,
                    surname = :surname,
                    role = :role,
                    email = :email,
                    password = :password,
                    updated_at = NOW()
                WHERE login = :klucz
            ");

            $result = $stmt->execute([
                ':login' => $login,
                ':name' => $name,
                ':surname' => $surname,
                ':role' => $role,
                ':email' => $email,
                ':password' => $passwordHash,
                ':klucz' => $klucz
            ]);
        }

        if (!$result) {
            echo json_encode([
                'success' => false,
                'message' => 'Błąd wykonania update użytkownika'
            ]);
            exit;
        }


        // raportowanie aktualizacji użytkownika
        require_once '../generowanieRaportow/generowanieRaportow.php';
        $who = $_SESSION['who_is_logged'] ?? '';

        // kto jaka operacja, proces wykonany, nazwa tabeli raportów w bazie danych
        $nameTable = 'raport_users';

        $dataBase = [
            'userLogin' => $login,
            'userEmail' => $email,
            'userRole' => $role,
            'userName' => $name,
            'userSurname' => $surname,
            'userPassword' => $password,
            'userCreatedAt' => $userData['created_at'] ?? null 
        ];
        
        $nazwaObiektu = $klucz;

        // trzeba wysłać tablice danych do funckji
        $wynikRaportowania = cateringGenerateRaport($who, 'Edycja użytkownika',$nazwaObiektu ,$nameTable, $pdo, $dataBase);

        if(!$wynikRaportowania){
            echo json_encode([
                'success' => false,
                'message' => 'Błąd zapisu raportowania'
                // 'redirect' => '../window/dashboard.php'
            ]);
        }


        if ($stmt->rowCount() > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Użytkownik został zaktualizowany poprawnie',
                'login' => $login
            ]);
            exit;
        }

        echo json_encode([
            'success' => false,
            'message' => 'Nie zaktualizowano żadnego rekordu. Możliwe, że dane są identyczne jak wcześniej.'
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
| WYSZUKANIE UŻYTKOWNIKA
|--------------------------------------------------------------------------
| Ten blok działa wtedy, gdy z JS przychodzi:
| userLogin
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
    require_once '../config/db.php';
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
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
        'login' => $data[0]['login'],
        'name' => $data[0]['name'],
        'surname' => $data[0]['surname'],
        'role' => $data[0]['role'],
        'email' => $data[0]['email'],
        'created_at' => $data[0]['created_at'] ?? '',
        'updated_at' => $data[0]['updated_at'] ?? ''
    ]);
    exit;

} catch (PDOException $error) {
    echo json_encode([
        'success' => false,
        'message' => 'Błąd bazy danych: ' . $error->getMessage()
    ]);
    exit;
}