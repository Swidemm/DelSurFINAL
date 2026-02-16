<?php
// admin/guardar_proyecto.php
require_once 'auth.php';
requireLogin();
header('Content-Type: application/json');

$jsonFile = '../proyectos.json';
$uploadDir = '../imagenes/proyectos/';

if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
    if (!is_array($current)) $current = [];

    $accion = $_POST['accion'] ?? '';

    if ($accion === 'eliminar') {
        $id = $_POST['id'];
        $nuevo = array_values(array_filter($current, fn($i) => $i['id'] !== $id));
        file_put_contents($jsonFile, json_encode($nuevo, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true]);
        exit;
    }

    if ($accion === 'crear') {
        $imgName = 'default.webp';
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $imgName = uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir . $imgName);
        }

        $nuevoProyecto = [
            'id' => uniqid('p_'),
            'titulo' => $_POST['titulo'],
            'categoria' => $_POST['categoria'],
            'descripcion' => $_POST['descripcion'],
            'imagen' => 'imagenes/proyectos/' . $imgName,
            'fecha' => date('Y-m-d')
        ];

        array_unshift($current, $nuevoProyecto);
        if (file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'No se pudo escribir en el archivo JSON']);
        }
    }
}
?>