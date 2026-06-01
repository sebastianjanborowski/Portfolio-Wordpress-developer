<?php
session_start();

if (!isset($_SESSION['logged_in_user_id'])) {
    header('Location: /window/login.php');
    exit;
}

try {
    require_once '../config/db.php';

    $stmt = $pdo->prepare("
        SELECT id, login, name, surname
        FROM users
        WHERE id = :id
        LIMIT 1
    ");

    $stmt->execute([
        ':id' => $_SESSION['logged_in_user_id']
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $stmtInsert = $pdo->prepare("
            INSERT INTO raport_logowanie (kto, rodzajOperacji, czas)
            VALUES (:who, :what, NOW())
        ");

        $stmtInsert->execute([
            ':who' => $user['login'],
            ':what' => 'Wylogowanie',
        ]);
    }

} catch (Throwable $e) {
    // Tu celowo nic nie blokuje wylogowania
}

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

session_destroy();

header('Location: /window/login.php');
exit;