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

    // --- ELIMINAR ---
    if ($accion === 'eliminar') {
        $id = $_POST['id'];
        $current = array_values(array_filter($current, fn($i) => $i['id'] !== $id));
        file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true]);
        exit;
    }

    // --- TOGGLE DESTACADO (ESTRELLA) ---
    if ($accion === 'toggle_destacado') {
        $id = $_POST['id'];
        foreach ($current as &$p) {
            if ($p['id'] === $id) {
                $p['destacado'] = !(isset($p['destacado']) && $p['destacado'] === true);
                break;
            }
        }
        file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true]);
        exit;
    }

    // --- CREAR O EDITAR ---
    if ($accion === 'crear' || $accion === 'editar') {
        $featuresArray = array_filter(array_map('trim', explode("\n", $_POST['features'])));
        
        $imagenesNuevas = [];
        if (isset($_FILES['imagenes']) && !empty($_FILES['imagenes']['name'][0])) {
            foreach ($_FILES['imagenes']['tmp_name'] as $i => $tmp) {
                if ($_FILES['imagenes']['error'][$i] === 0) {
                    $ext = pathinfo($_FILES['imagenes']['name'][$i], PATHINFO_EXTENSION);
                    $newName = uniqid('img_') . '.' . $ext;
                    move_uploaded_file($tmp, $uploadDir . $newName);
                    $imagenesNuevas[] = 'imagenes/proyectos/' . $newName;
                }
            }
        }

        if ($accion === 'crear') {
            $nuevo = [
                'id' => uniqid('p'),
                'titulo' => $_POST['titulo'],
                'categoria' => $_POST['categoria'],
                'descripcion' => $_POST['descripcion'],
                'ubicacion' => $_POST['ubicacion'] ?: 'Consultar',
                'anio' => $_POST['anio'] ?: date('Y'),
                'medidas' => $_POST['medidas'] ?: '-',
                'titulo_features' => $_POST['titulo_features'] ?: 'Servicios',
                'features' => array_values($featuresArray),
                'imagenes' => !empty($imagenesNuevas) ? $imagenesNuevas : ['imagenes/logo.webp'],
                'destacado' => false
            ];
            array_unshift($current, $nuevo);
        } else {
            foreach ($current as &$p) {
                if ($p['id'] === $_POST['id']) {
                    $p['titulo'] = $_POST['titulo'];
                    $p['categoria'] = $_POST['categoria'];
                    $p['descripcion'] = $_POST['descripcion'];
                    $p['ubicacion'] = $_POST['ubicacion'];
                    $p['anio'] = $_POST['anio'];
                    $p['medidas'] = $_POST['medidas'];
                    $p['titulo_features'] = $_POST['titulo_features'];
                    $p['features'] = array_values($featuresArray);
                    if (!empty($imagenesNuevas)) $p['imagenes'] = array_merge((array)$p['imagenes'], $imagenesNuevas);
                }
            }
        }

        file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true]);
    }
}
?>