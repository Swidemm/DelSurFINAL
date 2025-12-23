<?php
// save_similar.php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['error' => 'Método no permitido']));
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validamos los campos nuevos que pediste
if (empty($data['nombre']) || empty($data['contacto']) || empty($data['estructura']) || empty($data['zona'])) {
    http_response_code(400);
    exit(json_encode(['error' => 'Faltan datos obligatorios']));
}

$file = __DIR__ . '/similar.json';
$data['fecha'] = date('Y-m-d H:i:s');

// Leemos, agregamos y guardamos
$current = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
if (!is_array($current)) $current = [];
$current[] = $data;

if (file_put_contents($file, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar']);
}
?>