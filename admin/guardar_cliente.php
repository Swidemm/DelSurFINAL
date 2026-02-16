<?php
require_once 'auth.php';
requireLogin();
header('Content-Type: application/json');

$jsonFile = '../contacts.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer datos actuales
    $current = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
    if (!is_array($current)) $current = [];

    $accion = $_POST['accion'] ?? '';
    $id = $_POST['id'] ?? '';

    // Buscar el índice del cliente en el array
    $index = -1;
    foreach ($current as $key => $client) {
        if (isset($client['id']) && $client['id'] === $id) {
            $index = $key;
            break;
        }
    }

    if ($index === -1) {
        echo json_encode(['error' => 'Cliente no encontrado']);
        exit;
    }

    // --- ACCIÓN: ELIMINAR ---
    if ($accion === 'eliminar') {
        array_splice($current, $index, 1);
        if (file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Error al escribir archivo']);
        }
        exit;
    }

    // --- ACCIÓN: ACTUALIZAR ---
    if ($accion === 'actualizar') {
        // Actualizamos SOLO los campos de gestión, sin tocar nombre/email originales
        $current[$index]['estado'] = $_POST['estado'];
        $current[$index]['pago'] = $_POST['pago'];
        $current[$index]['notas'] = $_POST['notas'];
        // Fecha de última modificación (opcional)
        $current[$index]['updated_at'] = date('Y-m-d H:i:s');

        if (file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Error al guardar cambios']);
        }
        exit;
    }
}
?>