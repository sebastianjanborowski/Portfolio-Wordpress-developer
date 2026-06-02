<?php
function ooo_json_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function ooo_read_json_body(): array
{
    $rawBody = file_get_contents('php://input');
    $data = json_decode($rawBody, true);

    if (!is_array($data)) {
        ooo_json_response([
            'status' => 'error',
            'message' => 'Nieprawidłowe dane wejściowe. Wyślij poprawny JSON.'
        ], 400);
    }

    return $data;
}

function ooo_require_fields(array $data, array $fields): void
{
    $missing = [];

    foreach ($fields as $field => $label) {
        if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
            $missing[] = $label;
        }
    }

    if (!empty($missing)) {
        ooo_json_response([
            'status' => 'error',
            'message' => 'Brakuje wymaganych danych: ' . implode(', ', $missing) . '.',
            'missing_fields' => $missing
        ], 400);
    }
}
?>
