<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo json_encode([
        'success' => false,
        'message' => "Nieprawidłowa forma żądania"
    ]);
    exit;
}

$nazwaDiety = trim($_POST['nazwaDiety'] ?? '');

if($nazwaDiety === ''){
    echo json_encode([
        'success' => false,
        'message' => 'Nazwa diety nie może być pusta'
    ]);
    exit;
}

require_once '../config/db.php';

$stmt = $pdo->prepare("SELECT * FROM diets WHERE diet_code = :dietCode");
$stmt->execute([
    ':dietCode' => $nazwaDiety
]);

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(count($data) === 0){
    echo json_encode([
        'success' => false,
        'message' => 'Nie znaleziono diety o podanej nazwie'
    ]);
    exit;
}

if(count($data) > 1){
    echo json_encode([
        'success' => false,
        'message' => 'W bazie są duplikaty nazw diet, do poprawy'
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Znaleziono dietę w bazie danych',
    'department_id' => $data[0]['department_id'],
    'diet_name' => $data[0]['diet_name'],
    'diet_code' => $data[0]['diet_code'],
    'is_special_diet' => $data[0]['is_special_diet'],
    'diet_restrictions' => $data[0]['diet_restrictions'],
    'diet_description' => $data[0]['diet_description'],
    'diet_notes' => $data[0]['diet_notes'],
]);
exit;