<?php
require_once '../config/db.php';
require_once '../includes/app-security.php';

ooo_require_api_role(['admin', 'Employee']);
$data = ooo_read_json_body();

ooo_require_fields($data, [
    'Id' => 'ID wniosku urlopowego',
    'Employee' => 'ID pracownika',
    'Absense_Reason' => 'powód nieobecności',
    'Start_Date' => 'data rozpoczęcia urlopu',
    'End_Date' => 'data zakończenia urlopu',
    'Comment' => 'komentarz do wniosku',
    'Status' => 'status wniosku'
]);

try {
    $check = $pdo->prepare('SELECT COUNT(*) FROM Employees WHERE ID = :Employee');
    $check->bindValue(':Employee', (int) $data['Employee'], PDO::PARAM_INT);
    $check->execute();

    if ((int) $check->fetchColumn() === 0) {
        ooo_json_response(['status' => 'error', 'message' => 'Nie istnieje pracownik o podanym ID.'], 400);
    }

    $sql = 'UPDATE Leave_Request
            SET Employee = :Employee,
                Absense_Reason = :Absense_Reason,
                Start_Date = :Start_Date,
                End_Date = :End_Date,
                Comment = :Comment,
                Status = :Status
            WHERE ID = :Id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':Id', (int) $data['Id'], PDO::PARAM_INT);
    $stmt->bindValue(':Employee', (int) $data['Employee'], PDO::PARAM_INT);
    $stmt->bindValue(':Absense_Reason', trim($data['Absense_Reason']), PDO::PARAM_STR);
    $stmt->bindValue(':Start_Date', trim($data['Start_Date']), PDO::PARAM_STR);
    $stmt->bindValue(':End_Date', trim($data['End_Date']), PDO::PARAM_STR);
    $stmt->bindValue(':Comment', trim($data['Comment']), PDO::PARAM_STR);
    $stmt->bindValue(':Status', trim($data['Status']), PDO::PARAM_STR);
    $stmt->execute();

    ooo_json_response(['status' => 'success', 'message' => 'Wniosek urlopowy został zaktualizowany.']);
} catch (PDOException $e) {
    error_log('Leave update error: ' . $e->getMessage());
    ooo_json_response(['status' => 'error', 'message' => 'Nie udało się zaktualizować wniosku urlopowego.'], 500);
}
?>
