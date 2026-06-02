<?php
// plik odpowiada za walidacje danych i zapis użytkownika do bazy danych
session_start();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Nieprawidłowa forma żądania'
    ]);
    exit;
}

$userLogin = trim($_POST['userLogin'] ?? '');
$userEmail = trim($_POST['userEmail'] ?? '');
$userName = trim($_POST['userName'] ?? '');
$userSurname = trim($_POST['userSurname'] ?? '');
$userRole = trim($_POST['userRole'] ?? '');
$userPassword = trim($_POST['userPassword'] ?? '');


if (
    $userLogin === '' ||
    $userEmail === '' ||
    $userName === '' ||
    $userSurname === '' ||
    $userRole === '' ||
    $userPassword === ''
) {
    echo json_encode([
        'success' => false,
        'message' => 'Brak wymaganych danych'
    ]);
    exit;
}

if (mb_strlen($userLogin) < 3) {
    echo json_encode([
        'success' => false,
        'message' => 'Login jest za krótki'
    ]);
    exit;
}

if (mb_strlen($userName) < 2) {
    echo json_encode([
        'success' => false,
        'message' => 'Imię jest za krótkie'
    ]);
    exit;
}

if (mb_strlen($userSurname) < 2) {
    echo json_encode([
        'success' => false,
        'message' => 'Nazwisko jest za krótkie'
    ]);
    exit;
}

if (mb_strlen($userPassword) < 6) {
    echo json_encode([
        'success' => false,
        'message' => 'Hasło jest za krótkie'
    ]);
    exit;
}

if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Adres e-mail jest nieprawidłowy'
    ]);
    exit;
}

require_once '../config/db.php';

try {
    // sprawdzenie czy login już istnieje
    $stmt = $pdo->prepare("SELECT id FROM users WHERE login = :login LIMIT 1");
    $stmt->execute([
        ':login' => $userLogin
    ]);
    $loginExists = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($loginExists) {
        echo json_encode([
            'success' => false,
            'message' => 'Podany login już istnieje w bazie danych'
        ]);
        exit;
    }

    // sprawdzenie czy email już istnieje
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
    $stmt->execute([
        ':email' => $userEmail
    ]);
    $emailExists = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($emailExists) {
        echo json_encode([
            'success' => false,
            'message' => 'Podany adres e-mail już istnieje w bazie danych'
        ]);
        exit;
    }

    // hashowanie hasła
    $passwordHash = password_hash($userPassword, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO users (
            login,
            name,
            surname,
            role,
            password,
            email,
            is_active,
            created_at,
            updated_at
        ) VALUES (
            :login,
            :name,
            :surname,
            :role,
            :password,
            :email,
            :is_active,
            NOW(),
            NOW()
        )
    ");

    $result = $stmt->execute([
        ':login' => $userLogin,
        ':name' => $userName,
        ':surname' => $userSurname,
        ':role' => $userRole,
        ':password' => $passwordHash,
        ':email' => $userEmail,
        ':is_active' => 0
    ]);


    // raportowanie utworzenia nowego użytkownika

    require_once '../generowanieRaportow/generowanieRaportow.php';
    $who = $_SESSION['who_is_logged'] ?? '';

    // kto jaka operacja, proces wykonany, nazwa tabeli raportów w bazie danych
    $nameTable = 'raport_users';

    $dataBase = [
        'userLogin' => $userLogin,
        'userEmail' => $userEmail,
        'userRole' => $userRole,
        'userName' => $userName,
        'userSurname' => $userSurname,
        'userPassword' => $userPassword,
        'userCreatedAt' => (new DateTime())->format('Y-m-d H:i:s')
    ];
    
    $nazwaObiektu = $userLogin;

    // trzeba wysłać tablice danych do funckji
    $wynikRaportowania = cateringGenerateRaport($who, 'Dodanie nowego użytkownika',$nazwaObiektu ,$nameTable, $pdo, $dataBase);

    if(!$wynikRaportowania){
        echo json_encode([
            'success' => false,
            'message' => 'Błąd zapisu raportowania'
            // 'redirect' => '../window/dashboard.php'
        ]);
    }

    

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Użytkownik został dodany poprawnie'
        ]);
        exit;
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Nie udało się dodać użytkownika'
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