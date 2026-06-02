<?php
/**
 * Konfiguracja połączenia z bazą danych.
 * Domyślne dane działają w XAMPP: użytkownik root bez hasła.
 */

declare(strict_types=1);

$host = 'localhost';
$dbname = 'hrd';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $exception) {
    http_response_code(500);
    exit('Błąd połączenia z bazą danych. Sprawdź config/db.php oraz zaimportuj plik database/hrd.sql.');
}
