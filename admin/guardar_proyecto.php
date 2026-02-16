<?php
// admin/guardar_proyecto.php
require_once 'auth.php';
requireLogin();
header('Content-Type: application/json');

$jsonFile = '../proyectos.json';
$uploadDir = '../imagenes/proyectos/';

// Crear carpeta si no existe
if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
    if (!is_array($current)) $current = [];

    $accion = $_POST['accion'] ?? '';

    // --- ELIMINAR PROYECTO ---
    if ($accion === 'eliminar') {
        $id = $_POST['id'];
        // Filtramos para sacar el que coincide
        $nuevo = array_values(array_filter($current, fn($i) => $i['id'] !== $id));
        file_put_contents($jsonFile, json_encode($nuevo, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true]);
        exit;
    }

    // --- CREAR PROYECTO ---
    if ($accion === 'crear') {
        $imagenesGuardadas = [];

        // Procesar Múltiples Imágenes
        if (isset($_FILES['imagenes']) && !empty($_FILES['imagenes']['name'][0])) {
            $totalFiles = count($_FILES['imagenes']['name']);
            
            for ($i = 0; $i < $totalFiles; $i++) {
                if ($_FILES['imagenes']['error'][$i] === 0) {
                    $ext = pathinfo($_FILES['imagenes']['name'][$i], PATHINFO_EXTENSION);
                    $newName = uniqid('img_') . '_' . $i . '.' . $ext;
                    
                    if (move_uploaded_file($_FILES['imagenes']['tmp_name'][$i], $uploadDir . $newName)) {
                        $imagenesGuardadas[] = 'imagenes/proyectos/' . $newName;
                    }
                }
            }
        }

        // Si no subió nada, ponemos una por defecto
        if (empty($imagenesGuardadas)) {
            $imagenesGuardadas[] = 'imagenes/logo.webp'; 
        }

        $nuevoProyecto = [
            'id' => uniqid('p'),
            'titulo' => $_POST['titulo'],
            'categoria' => $_POST['categoria'],
            'descripcion' => $_POST['descripcion'],
            'imagenes' => $imagenesGuardadas, // Guardamos el array completo
            'fecha' => date('Y-m-d')
        ];

        // Agregamos al principio
        array_unshift($current, $nuevoProyecto);
        
        if (file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'No se pudo escribir en el JSON']);
        }
    }
}
?>