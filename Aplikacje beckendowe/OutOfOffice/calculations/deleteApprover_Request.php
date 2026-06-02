<?php
require_once '../config/db.php';
require_once '../includes/app-security.php';

ooo_require_api_role(['admin', 'HR_Manager', 'Project_Manager']);
$data = ooo_read_json_body();

ooo_require_fields($data, ['Id' => 'ID zatwierdzenia']);

try {
    $sql = 'DELETE FROM Approval_Request WHERE ID = :Id LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':Id', (int) $data['Id'], PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        ooo_json_response(['status' => 'error', 'message' => 'Nie znaleziono zatwierdzenia o podanym ID.'], 404);
    }

    ooo_json_response(['status' => 'success', 'message' => 'Zatwierdzenie zostało usunięte.']);
} catch (PDOException $e) {
    error_log('Approval delete error: ' . $e->getMessage());
    ooo_json_response(['status' => 'error', 'message' => 'Nie udało się usunąć zatwierdzenia.'], 500);
}
?>
