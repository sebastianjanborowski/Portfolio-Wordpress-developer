<?php
require_once '../config/db.php';
require_once '../includes/app-security.php';

ooo_require_api_role(['admin', 'HR_Manager', 'Project_Manager']);
$data = ooo_read_json_body();

ooo_require_fields($data, [
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

    $sql = 'INSERT INTO Approval_Request (Approver, Leave_Request, Status, Comment)
            VALUES (:Approver, :Leave_Request, :Status, :Comment)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':Approver', (int) $data['Approver'], PDO::PARAM_INT);
    $stmt->bindValue(':Leave_Request', (int) $data['Leave_Request'], PDO::PARAM_INT);
    $stmt->bindValue(':Status', trim($data['Status']), PDO::PARAM_STR);
    $stmt->bindValue(':Comment', trim($data['Comment']), PDO::PARAM_STR);
    $stmt->execute();

    ooo_json_response(['status' => 'success', 'message' => 'Zatwierdzenie zostało dodane.']);
} catch (PDOException $e) {
    error_log('Approval create error: ' . $e->getMessage());
    ooo_json_response(['status' => 'error', 'message' => 'Nie udało się dodać zatwierdzenia.'], 500);
}
?>
