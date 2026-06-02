<?php
require_once '../config/db.php';
require_once '../includes/app-security.php';

ooo_require_api_role(['admin', 'HR_Manager']);
$data = ooo_read_json_body();

ooo_require_fields($data, [
    'Id' => 'ID pracownika',
    'Full_Name' => 'imię i nazwisko pracownika',
    'Subdivision' => 'dział / jednostka organizacyjna',
    'Position' => 'stanowisko',
    'Status' => 'status pracownika',
    'People_Partner' => 'ID opiekuna HR',
    'Out_of_Balance' => 'Out of Balance'
]);

try {
    $sql = 'UPDATE Employees
            SET Full_Name = :Full_Name,
                Subdivision = :Subdivision,
                Position = :Position,
                Status = :Status,
                People_Partner = :People_Partner,
                Out_of_Balance = :Out_of_Balance
            WHERE ID = :Id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':Id', (int) $data['Id'], PDO::PARAM_INT);
    $stmt->bindValue(':Full_Name', trim($data['Full_Name']), PDO::PARAM_STR);
    $stmt->bindValue(':Subdivision', trim($data['Subdivision']), PDO::PARAM_STR);
    $stmt->bindValue(':Position', trim($data['Position']), PDO::PARAM_STR);
    $stmt->bindValue(':Status', trim($data['Status']), PDO::PARAM_STR);
    $stmt->bindValue(':People_Partner', (int) $data['People_Partner'], PDO::PARAM_INT);
    $stmt->bindValue(':Out_of_Balance', trim($data['Out_of_Balance']), PDO::PARAM_STR);
    $stmt->execute();

    ooo_json_response(['status' => 'success', 'message' => 'Dane pracownika zostały zaktualizowane.']);
} catch (PDOException $e) {
    error_log('Employee update error: ' . $e->getMessage());
    ooo_json_response(['status' => 'error', 'message' => 'Nie udało się zaktualizować pracownika.'], 500);
}
?>
