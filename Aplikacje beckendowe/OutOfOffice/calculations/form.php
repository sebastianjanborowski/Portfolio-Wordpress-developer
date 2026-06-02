<?php
require_once '../config/db.php';
require_once '../includes/app-security.php';

$data = ooo_read_json_body();

ooo_require_fields($data, [
    'login' => 'login użytkownika',
    'password' => 'hasło użytkownika'
]);

$login = trim((string) $data['login']);
$password = (string) $data['password'];

try {
    $sql = 'SELECT * FROM admin WHERE login = :login LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':login', $login, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !ooo_verify_password($password, (string) ($user['password'] ?? ''))) {
        $_SESSION = [];
        session_destroy();

        ooo_json_response([
            'status' => 'error',
            'message' => 'Nieprawidłowy login lub hasło.'
        ], 401);
    }

    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'] ?? null;
    $_SESSION['login'] = $user['login'];
    $_SESSION['role'] = $user['role'] ?? ooo_role_from_login($user['login']);
    $_SESSION['zalogowany'] = 'true';

    ooo_json_response([
        'status' => 'success',
        'message' => 'Zalogowano poprawnie.',
        'redirect' => '../public/menu.php'
    ]);
} catch (PDOException $e) {
    error_log('Login error: ' . $e->getMessage());

    ooo_json_response([
        'status' => 'error',
        'message' => 'Wystąpił problem z logowaniem. Spróbuj ponownie później.'
    ], 500);
}
?>
