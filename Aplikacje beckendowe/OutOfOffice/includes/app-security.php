<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/app-response.php';

function ooo_is_logged_in(): bool
{
    return (($_SESSION['zalogowany'] ?? 'false') === 'true') && !empty($_SESSION['login']);
}

function ooo_redirect_if_not_logged_in(string $redirectPath = '../public/index.php'): void
{
    if (!ooo_is_logged_in()) {
        header('Location:' . $redirectPath);
        exit;
    }
}

function ooo_require_api_auth(): void
{
    if (!ooo_is_logged_in()) {
        ooo_json_response([
            'status' => 'error',
            'message' => 'Brak dostępu. Zaloguj się ponownie.'
        ], 401);
    }
}

function ooo_role_from_login(string $login): string
{
    $roles = [
        'admin' => 'admin',
        'HR_Manager' => 'HR_Manager',
        'Project_Manager' => 'Project_Manager',
        'Employee' => 'Employee'
    ];

    return $roles[$login] ?? 'Employee';
}

function ooo_current_role(): string
{
    return $_SESSION['role'] ?? ooo_role_from_login($_SESSION['login'] ?? '');
}

function ooo_user_has_role(array $allowedRoles): bool
{
    return in_array(ooo_current_role(), $allowedRoles, true);
}

function ooo_require_api_role(array $allowedRoles): void
{
    ooo_require_api_auth();

    if (!ooo_user_has_role($allowedRoles)) {
        ooo_json_response([
            'status' => 'error',
            'message' => 'Brak uprawnień do wykonania tej operacji.'
        ], 403);
    }
}

function ooo_verify_password(string $plainPassword, string $storedPassword): bool
{
    $passwordInfo = password_get_info($storedPassword);

    if (($passwordInfo['algo'] ?? 0) !== 0) {
        return password_verify($plainPassword, $storedPassword);
    }

    // Kompatybilność ze starą bazą, w której hasła mogły być zapisane tekstowo.
    // Do wersji CV / GitHub użyj haseł zapisanych przez password_hash().
    return hash_equals($storedPassword, $plainPassword);
}
?>
