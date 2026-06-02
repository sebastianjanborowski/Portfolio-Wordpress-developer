<?php
// akceptowalne metody połączneia to wysyłka dancyh przez POST i zwracać może ten plik jak i reszta corowych tylko echo json_encode i odpowiedzi interpretuje js
session_start();
header('Content-Type: application/json; charset=utf-8');

// akceptuje tylko POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Nieprawidłowa metoda żądania'
    ]);
    exit;
}

// pobranie danych z js logowania
$login = trim($_POST['login'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($login === '' || $password === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Login i hasło są wymagane'
    ]);
    exit;
}

// nawiązanie połączneia
try {
    require_once '../config/db.php';

    $stmt = $pdo->prepare("
        SELECT id, login, name, surname, role, password, email, is_active
        FROM users 
        WHERE login = :login 
        LIMIT 1
    ");
    $stmt->execute([
        ':login' => $login
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password,$user['password'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Nieprawidłowy login lub hasło'
        ]);
        exit;
    }

    if (empty($user['email'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Brak adresu e-mail użytkownika'
        ]);
        exit;
    }

    if($user['is_active'] == 0){
        echo json_encode([
            'success' => false,
            'message' => 'Konto zostało dezaktywowane'
        ]);
        exit;
    }

    // randomizacja kodu dostępu 2FA, zapisywany jest do bazy danych i do tabeli login_codes i ważny jest 5 min
    $code = (string) random_int(100000, 999999);
    $codeHash = password_hash($code, PASSWORD_DEFAULT);
    $expiresAt = date('Y-m-d H:i:s', time() + 300);

    // kasowanie nie użytych kodów dla tego samego usera
    $deleteStmt = $pdo->prepare("
        DELETE FROM login_codes 
        WHERE user_id = :user_id AND used_at IS NULL
    ");
    $deleteStmt->execute([
        ':user_id' => $user['id']
    ]);

    // zapis kodu
    $insertStmt = $pdo->prepare("
        INSERT INTO login_codes (user_id, code_hash, expires_at) 
        VALUES (:user_id, :code_hash, :expires_at)
    ");
    $insertStmt->execute([
        ':user_id' => $user['id'],
        ':code_hash' => $codeHash,
        ':expires_at' => $expiresAt
    ]);

    // ważne ustawia zmienną sesyjną dla użytkownika podczas procesu logowania bez tego nie zadziała wejscie do 2FA
    $_SESSION['pending_2fa_user_id'] = $user['id'];
    $_SESSION['who_is_logged'] = $user['login'];
    $_SESSION['helper_restrictions'] = $user['role'];

    // dołaczneie bibliotego z phpmailer
    require_once '../mail/sendEmail.php';

    // wywołanie funkcji w osobnym pliku pomocniczym, tworzy wiadomość email i wysyła
    $mailSent = sendEmail($user['email'], $user['name'], '2fa', $code);

    if (!$mailSent) {
        echo json_encode([
            'success' => false,
            'message' => 'Nie udało się wysłać kodu weryfikacyjnego'
        ]);
        exit;
    }

    // wartość jest obsłużona prawidłowo i do powrotnych danych jest dołączony redirect który posiada konstrkcje linku gdzie trzeba iść dalej
    echo json_encode([
        'success' => true,
        'message' => 'Kod weryfikacyjny został wysłany na e-mail',
        'require_2fa' => true,
        'redirect' => BASE_URL.'/window/2fa.php'
    ]);
    exit;

} catch (Throwable $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Błąd serwera',
        'error' => $e->getMessage()
    ]);
    exit;
}