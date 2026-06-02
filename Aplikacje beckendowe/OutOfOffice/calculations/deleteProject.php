<?php
require_once '../config/db.php';
require_once '../includes/app-security.php';

ooo_require_api_role(['admin', 'Project_Manager']);
$data = ooo_read_json_body();

ooo_require_fields($data, ['Id' => 'ID projektu']);

try {
    $sql = 'DELETE FROM Project WHERE ID = :Id LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':Id', (int) $data['Id'], PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        ooo_json_response(['status' => 'error', 'message' => 'Nie znaleziono projektu o podanym ID.'], 404);
    }

    ooo_json_response(['status' => 'success', 'message' => 'Projekt został usunięty.']);
} catch (PDOException $e) {
    error_log('Project delete error: ' . $e->getMessage());
    ooo_json_response(['status' => 'error', 'message' => 'Nie udało się usunąć projektu. Sprawdź powiązania z innymi rekordami.'], 500);
}
?>
