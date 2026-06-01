<?php
// obsługuje weryfikacje użytkownika w 2FA obsługa danych standardowa jak w innych plikach, sprawdzenie metody kontaktu,
// pobranie danych i weryfikacja  zdanymi zapisanymi w bazie danych
session_start();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Nieprawidłowa metoda żądania'
    ]);
    exit;
}
 
$code = trim($_POST['code'] ?? '');
// wazne musi być oznacza czy user jest w procesie autoryzowany
$userId = $_SESSION['pending_2fa_user_id'] ?? null;

// z jakiegoś nie jasnego powodu nie łąpie mi zmiennej sesyjnej
if (!isset($_SESSION['pending_2fa_user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Brak aktywnej sesji logowania',
        'redirect' => '../window/login.php'
    ]);
    exit;
}

if ($code === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Kod weryfikacji jest za krótki',
        'redirect' => '../window/login.php'
    ]);
    exit;
}

try {
    require_once '../config/db.php';

    $stmt = $pdo->prepare("
        SELECT *
        FROM login_codes
        WHERE user_id = :userID AND used_at IS NULL
        ORDER BY id DESC
        LIMIT 1
    ");
    $stmt->execute([
        ':userID' => $userId
    ]);

    $response = $stmt->fetch(PDO::FETCH_ASSOC);
    $now = time();

    if (!$response) {
        echo json_encode([
            'success' => false,
            'message' => 'Nie znaleziono aktywnego kodu'
        ]);
        exit;
    }

    if (strtotime($response['expires_at']) < $now) {
        echo json_encode([
            'success' => false,
            'message' => 'Token stracił ważność'
        ]);
        exit;
    }

    if (!password_verify($code, $response['code_hash'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Kod nieprawidłowy'
        ]);
        exit;
    }


    $updateStmt = $pdo->prepare("
        UPDATE login_codes
        SET used_at = NOW()
        WHERE id = :id
    ");
    $updateStmt->execute([
        ':id' => $response['id']
    ]);

    unset($_SESSION['pending_2fa_user_id']);
    // zmienna sesyjna dla zalogowanych userów
    $_SESSION['logged_in_user_id'] = $userId;
    $_SESSION['restrictions'] = $_SESSION['helper_restrictions'];
    unset($_SESSION['helper_restrictions']);

    require_once '../generowanieRaportow/generowanieRaportow.php';
    $who = $_SESSION['who_is_logged'] ?? '';

    // kto jaka operacja, proces wykonany, nazwa tabeli raportów w bazie danych
    $nameTable = 'raport_logowanie';
    $wynikRaportowania = cateringGenerateRaport($who, 'logowanie', 'logowanie' ,$nameTable, $pdo,[]);

    if(!$wynikRaportowania){
        echo json_encode([
            'success' => false,
            'message' => 'Błąd zapisu raportowania'
            // 'redirect' => '../window/dashboard.php'
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'User przeszedł 2FA',
        'redirect' => '../window/dashboard.php'
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

