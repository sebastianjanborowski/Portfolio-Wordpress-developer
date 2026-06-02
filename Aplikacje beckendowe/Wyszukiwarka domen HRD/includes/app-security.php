<?php
/**
 * Wspólne funkcje bezpieczeństwa aplikacji HRD.
 */

declare(strict_types=1);

function app_start_session(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function is_logged_in(): bool
{
    app_start_session();

    return isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['role']);
}

function current_user_id(): ?int
{
    app_start_session();

    return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
}

function current_user_name(): string
{
    app_start_session();

    return (string) ($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Gość');
}

function current_user_role(): string
{
    app_start_session();

    return (string) ($_SESSION['role'] ?? 'guest');
}

function require_login(): void
{
    if (!is_logged_in()) {
        $_SESSION['flash_error'] = 'Zaloguj się, aby przejść do panelu użytkownika.';
        header('Location: login.php');
        exit;
    }
}

function require_role(array $allowedRoles): void
{
    require_login();

    if (!in_array(current_user_role(), $allowedRoles, true)) {
        http_response_code(403);
        exit('Brak uprawnień do tej części aplikacji.');
    }
}

function csrf_token(): string
{
    app_start_session();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return (string) $_SESSION['csrf_token'];
}

function verify_csrf(): void
{
    app_start_session();

    $token = $_POST['csrf_token'] ?? '';

    if (!is_string($token) || !hash_equals((string) ($_SESSION['csrf_token'] ?? ''), $token)) {
        $_SESSION['flash_error'] = 'Sesja formularza wygasła. Odśwież stronę i spróbuj ponownie.';
        header('Location: ../../index.php');
        exit;
    }
}

function set_flash(string $type, string $message): void
{
    app_start_session();
    $_SESSION['flash_' . $type] = $message;
}

function get_flash(string $type): string
{
    app_start_session();

    $key = 'flash_' . $type;
    $message = (string) ($_SESSION[$key] ?? '');
    unset($_SESSION[$key]);

    return $message;
}

function redirect_to(string $path): never
{
    header('Location: ' . $path);
    exit;
}
