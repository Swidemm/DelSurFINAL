<?php
// Handle POST contact submissions
header('Content-Type: application/json; charset=utf-8');

// 1. Validar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

// 2. Obtener y decodificar el JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// 3. Validar datos mínimos requeridos, formato de email y Honeypot (Anti-spam)
if (!is_array($data) || empty($data['email']) || empty($data['nombre']) || !empty($data['honeypot'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos, inválidos o spam detectado']);
    exit;
}
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Por favor, ingresa un email válido']);
    exit;
}

// Agregamos la fecha
$data['date'] = date('c'); // ISO 8601

// Ruta al archivo de contactos
$contactsFile = __DIR__ . '/../contacts.json';

// 4. Abrir el archivo en modo escritura segura con bloqueo
$fp = fopen($contactsFile, 'c+');

if ($fp && flock($fp, LOCK_EX)) {
    // Leer contenido actual
    $fileSize = filesize($contactsFile);
    $currentData = $fileSize > 0 ? fread($fp, $fileSize) : '[]';
    $contacts = json_decode($currentData, true) ?? [];

    if (!is_array($contacts)) {
        $contacts = [];
    }

    // Agregar el nuevo contacto
    // Quitamos el campo honeypot antes de guardar
    unset($data['honeypot']);
    $contacts[] = $data;

    // Borrar contenido previo y escribir
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode($contacts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    
    http_response_code(200);
    echo json_encode(['message' => 'Mensaje recibido correctamente']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor']);
}
?>