<?php

declare(strict_types=1);

require_once __DIR__ . '/../../includes/app-security.php';
require_once __DIR__ . '/../../config/db.php';

app_start_session();
verify_csrf();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_to('../../login.php');
}

$username = trim((string) ($_POST['username'] ?? ''));
$password = (string) ($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    set_flash('error', 'Uzupełnij login i hasło. Oba pola są wymagane.');
    redirect_to('../../login.php');
}

$sql = 'SELECT id, username, password_hash, role, full_name, is_active
        FROM users
        WHERE username = :username
        LIMIT 1';

$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username]);
$user = $stmt->fetch();

if (!$user || (int) $user['is_active'] !== 1 || !password_verify($password, (string) $user['password_hash'])) {
    set_flash('error', 'Niepoprawny login lub hasło. Sprawdź dane i spróbuj ponownie.');
    redirect_to('../../login.php');
}

session_regenerate_id(true);
$_SESSION['user_id'] = (int) $user['id'];
$_SESSION['username'] = (string) $user['username'];
$_SESSION['role'] = (string) $user['role'];
$_SESSION['full_name'] = (string) $user['full_name'];

set_flash('success', 'Zalogowano poprawnie. Możesz korzystać z panelu użytkownika.');
redirect_to('../../dashboard.php');
