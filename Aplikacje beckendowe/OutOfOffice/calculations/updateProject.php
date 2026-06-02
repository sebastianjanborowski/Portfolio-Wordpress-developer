<?php
require_once '../config/db.php';
require_once '../includes/app-security.php';

ooo_require_api_role(['admin', 'Project_Manager']);
$data = ooo_read_json_body();

ooo_require_fields($data, [
    'Id' => 'ID projektu',
    'Project_Type' => 'typ / nazwa projektu',
    'Start_Date' => 'data rozpoczęcia projektu',
    'End_Date' => 'data zakończenia projektu',
    'Project_Manager' => 'ID kierownika projektu',
    'Comment' => 'komentarz do projektu',
    'Status' => 'status projektu'
]);

try {
    $sql = 'UPDATE Project
            SET Project_Type = :Project_Type,
                Start_Date = :Start_Date,
                End_Date = :End_Date,
                Project_Manager = :Project_Manager,
                Comment = :Comment,
                Status = :Status
            WHERE ID = :Id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':Id', (int) $data['Id'], PDO::PARAM_INT);
    $stmt->bindValue(':Project_Type', trim($data['Project_Type']), PDO::PARAM_STR);
    $stmt->bindValue(':Start_Date', trim($data['Start_Date']), PDO::PARAM_STR);
    $stmt->bindValue(':End_Date', trim($data['End_Date']), PDO::PARAM_STR);
    $stmt->bindValue(':Project_Manager', (int) $data['Project_Manager'], PDO::PARAM_INT);
    $stmt->bindValue(':Comment', trim($data['Comment']), PDO::PARAM_STR);
    $stmt->bindValue(':Status', trim($data['Status']), PDO::PARAM_STR);
    $stmt->execute();

    ooo_json_response(['status' => 'success', 'message' => 'Projekt został zaktualizowany.']);
} catch (PDOException $e) {
    error_log('Project update error: ' . $e->getMessage());
    ooo_json_response(['status' => 'error', 'message' => 'Nie udało się zaktualizować projektu.'], 500);
}
?>
