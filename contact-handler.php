<?php
header('Content-Type: application/json; charset=utf-8');

// Solo acepta POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Lee el body JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE || !$data || empty($data['nombre']) || empty($data['email']) || empty($data['mensaje'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

// Agrega timestamp
$data['date'] = date('c');  // ISO como en Node

// Lee contacts.json
$contactsFile = 'database/contacts.json';
$contacts = [];
if (file_exists($contactsFile)) {
    $json = file_get_contents($contactsFile);
    if ($json !== false && $json !== '') {
        $contacts = json_decode($json, true) ?: [];
        if (json_last_error() !== JSON_ERROR_NONE) {
            $contacts = [];  // Reset si malformado
        }
    }
}

// Agrega el nuevo
$contacts[] = $data;

// Guarda
if (file_put_contents($contactsFile, json_encode($contacts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar']);
} else {
    http_response_code(200);
    echo json_encode(['success' => true]);
}
?>
