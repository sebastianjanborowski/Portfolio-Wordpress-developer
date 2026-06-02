<?php
require_once '../config/db.php';
require_once '../includes/app-security.php';

ooo_require_api_role(['admin', 'Employee']);
$data = ooo_read_json_body();

ooo_require_fields($data, ['Id' => 'ID wniosku urlopowego']);

try {
    $sql = 'DELETE FROM Leave_Request WHERE ID = :Id LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':Id', (int) $data['Id'], PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        ooo_json_response(['status' => 'error', 'message' => 'Nie znaleziono wniosku urlopowego o podanym ID.'], 404);
    }

    ooo_json_response(['status' => 'success', 'message' => 'Wniosek urlopowy został usunięty.']);
} catch (PDOException $e) {
    error_log('Leave delete error: ' . $e->getMessage());
    ooo_json_response(['status' => 'error', 'message' => 'Nie udało się usunąć wniosku urlopowego. Sprawdź powiązania z zatwierdzeniami.'], 500);
}
?>
