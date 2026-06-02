<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo json_encode([
        'success' => false,
        'message' => 'Nie prawidłowa forma wysyłki danych'
    ]);
    exit;
}

$diet_name = trim($_POST['diet_name'] ?? '');
$diet_code = trim($_POST['diet_code'] ?? '');
$departament = trim($_POST['department'] ?? '');
$is_special_diet = trim($_POST['is_special_diet'] ?? '');
$diet_restrictions = trim($_POST['diet_restrictions'] ?? '');
$diet_description = trim($_POST['diet_description'] ?? '');
$diet_notes = trim($_POST['diet_notes'] ?? '');
$klucz = trim($_POST['klucz'] ?? '');


$departament_value;

if($departament == "Chirurgia") $departament_value = 1;
else if($departament == "Interna") $departament_value = 2;
else if($departament == "Pediatria") $departament_value = 3;
else if($departament == "Geriatria") $departament_value = 4;
else if($departament == "Neurologia") $departament_value = 5;
else if($departament == "Onkologia") $departament_value = 6;
else{
    $departament_value = "Parametr nie zdefiniowany";
}           

if($diet_name !== '' && $diet_code !== '' && $departament !== '' && $is_special_diet !== '' 
&& $diet_restrictions !== '' && $diet_description !== '' && $diet_notes !== '' && $klucz && $klucz !== ''){
    require_once '../config/db.php';

    $time = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("UPDATE diets SET department_id = :department_id,diet_name = :diet_name,
        diet_code = :diet_code, is_special_diet = :is_special_diet, diet_restrictions = :diet_restrictions,
        diet_description = :diet_description, diet_notes = :diet_notes, is_active = :is_active, updated_at = :updated_at
        WHERE diet_name = :diet_key
    ");

    $stmt->execute([
        ':department_id' => $departament,
        ':diet_name' => $diet_name,
        ':diet_code' => $diet_code ,
        ':is_special_diet' => $is_special_diet,
        ':diet_restrictions' => $diet_restrictions,
        ':diet_description' => $diet_description,
        ':diet_notes' => $diet_notes,
        ':is_active' => 0,
        ':updated_at' => $time,
        ':diet_key' => $klucz
    ]);





    require_once '../generowanieRaportow/generowanieRaportow.php';
    $who = $_SESSION['who_is_logged'] ?? '';

    // kto jaka operacja, proces wykonany, nazwa tabeli raportów w bazie danych
    $nameTable = 'raport_diet';

    $dataBase = [
        'dietName' => $diet_name,
        'dietCode' => $diet_code,
        'department' => $departament,
        'isSpecialDiet' => $is_special_diet,
        'dietRestrictions' => $diet_restrictions,
        'dietDescription' => $diet_description,
        'dietNotes' => $diet_notes
    ];

    // trzeba wysłać tablice danych do funckji
    $wynikRaportowania = cateringGenerateRaport($who, 'Edycja diety', $klucz ,$nameTable, $pdo, $dataBase);

    if(!$wynikRaportowania){
        echo json_encode([
            'success' => false,
            'message' => 'Błąd zapisu raportowania'
            // 'redirect' => '../window/dashboard.php'
        ]);
    }





    echo json_encode([
        'success' => true,
        'message' => 'Edycja zakończona powodzeniem'
    ]);

}else{
    echo json_encode([
        'success' => false,
        'message' => 'Brak co najmiej jednej jednostki danych'
    ]);
}