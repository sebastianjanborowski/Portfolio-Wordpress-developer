<?php
require_once '../config/db.php';
require_once '../includes/app-security.php';

ooo_require_api_role(['admin', 'HR_Manager', 'Project_Manager']);
$data = ooo_read_json_body();

ooo_require_fields($data, [
    'Id' => 'ID zatwierdzenia',
    'Approver' => 'ID osoby zatwierdzającej',
    'Leave_Request' => 'ID wniosku urlopowego',
    'Status' => 'status zatwierdzenia',
    'Comment' => 'komentarz do zatwierdzenia'
]);

try {
    $leaveCheck = $pdo->prepare('SELECT COUNT(*) FROM Leave_Request WHERE ID = :Leave_Request');
    $leaveCheck->bindValue(':Leave_Request', (int) $data['Leave_Request'], PDO::PARAM_INT);
    $leaveCheck->execute();

    if ((int) $leaveCheck->fetchColumn() === 0) {
        ooo_json_response(['status' => 'error', 'message' => 'Nie istnieje wniosek urlopowy o podanym ID.'], 400);
    }

    $approverCheck = $pdo->prepare('SELECT COUNT(*) FROM Employees WHERE ID = :Approver');
    $approverCheck->bindValue(':Approver', (int) $data['Approver'], PDO::PARAM_INT);
    $approverCheck->execute();

    if ((int) $approverCheck->fetchColumn() === 0) {
        ooo_json_response(['status' => 'error', 'message' => 'Nie istnieje osoba zatwierdzająca o podanym ID.'], 400);
    }

    $sql = 'UPDATE Approval_Request
            SET Approver = :Approver,
                Leave_Request = :Leave_Request,
                Status = :Status,
                Comment = :Comment
            WHERE ID = :Id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':Id', (int) $data['Id'], PDO::PARAM_INT);
    $stmt->bindValue(':Approver', (int) $data['Approver'], PDO::PARAM_INT);
    $stmt->bindValue(':Leave_Request', (int) $data['Leave_Request'], PDO::PARAM_INT);
    $stmt->bindValue(':Status', trim($data['Status']), PDO::PARAM_STR);
    $stmt->bindValue(':Comment', trim($data['Comment']), PDO::PARAM_STR);
    $stmt->execute();

    ooo_json_response(['status' => 'success', 'message' => 'Zatwierdzenie zostało zaktualizowane.']);
} catch (PDOException $e) {
    error_log('Approval update error: ' . $e->getMessage());
    ooo_json_response(['status' => 'error', 'message' => 'Nie udało się zaktualizować zatwierdzenia.'], 500);
}
?>
