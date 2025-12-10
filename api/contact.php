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

// 3. Validar datos mínimos requeridos
if (!is_array($data) || empty($data['email']) || empty($data['nombre'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos o inválidos']);
    exit;
}

// Agregamos la fecha
$data['date'] = date('c'); // ISO 8601

// Ruta al archivo de contactos
$contactsFile = __DIR__ . '/../contacts.json';

// 4. Abrir el archivo en modo escritura segura
$fp = fopen($contactsFile, 'c+'); // 'c+' crea el archivo si no existe, o lee/escribe si existe

if ($fp && flock($fp, LOCK_EX)) { // LOCK_EX = Bloqueo exclusivo (solo yo escribo)
    
    // Leer contenido actual
    $fileSize = filesize($contactsFile);
    $currentData = $fileSize > 0 ? fread($fp, $fileSize) : '[]';
    $contacts = json_decode($currentData, true) ?? [];

    if (!is_array($contacts)) {
        $contacts = [];
    }

    // Agregar el nuevo contacto
    $contacts[] = $data;

    // Borrar contenido previo del archivo y rebobinar al inicio
    ftruncate($fp, 0);
    rewind($fp);

    // Escribir los datos actualizados
    fwrite($fp, json_encode($contacts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    // Asegurar que se guarden los cambios antes de soltar el candado
    fflush($fp);
    flock($fp, LOCK_UN); // Soltar candado
    fclose($fp);

    echo json_encode(['success' => true]);

} else {
    // Si no se pudo bloquear el archivo (muy raro), dar error
    http_response_code(500);
    echo json_encode(['error' => 'Error interno al guardar contacto']);
    if ($fp) fclose($fp);
}
?>