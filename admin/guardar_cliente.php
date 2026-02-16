<?php
// admin/guardar_cliente.php
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

    // Buscar el índice del cliente
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
        // Actualizar estados
        $current[$index]['estado'] = $_POST['estado'];
        $current[$index]['pago'] = $_POST['pago'];
        $current[$index]['updated_at'] = date('Y-m-d H:i:s');

        // --- LÓGICA DE NOTAS ---
        // Si escribió una nota nueva, la agregamos al historial
        $nuevaNota = trim($_POST['nueva_nota'] ?? '');
        
        if (!empty($nuevaNota)) {
            // Si no existe el array 'historial_notas', lo creamos
            if (!isset($current[$index]['historial_notas']) || !is_array($current[$index]['historial_notas'])) {
                // Si tenía notas viejas (formato anterior), las migramos a la primera entrada
                $notasViejas = $current[$index]['notas'] ?? '';
                $current[$index]['historial_notas'] = [];
                if (!empty($notasViejas)) {
                    $current[$index]['historial_notas'][] = [
                        'fecha' => $current[$index]['updated_at'] ?? date('Y-m-d H:i:s'),
                        'texto' => $notasViejas
                    ];
                }
            }

            // Agregamos la nueva nota AL PRINCIPIO (lo más nuevo arriba)
            array_unshift($current[$index]['historial_notas'], [
                'fecha' => date('Y-m-d H:i:s'),
                'texto' => $nuevaNota
            ]);
        }

        if (file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Error al guardar cambios']);
        }
        exit;
    }
}
?>