<?php
// admin/guardar_proyecto.php
require_once 'auth.php';
requireLogin();
header('Content-Type: application/json');

$jsonFile = '../proyectos.json';
$uploadDir = '../imagenes/proyectos/';

// Crear directorio si no existe
if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
    if (!is_array($current)) $current = [];

    $accion = $_POST['accion'] ?? '';

    // --- ACCIÓN: ELIMINAR ---
    if ($accion === 'eliminar') {
        $id = $_POST['id'];
        $nuevo = array_values(array_filter($current, fn($i) => $i['id'] !== $id));
        file_put_contents($jsonFile, json_encode($nuevo, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true]);
        exit;
    }

    // --- ACCIÓN: CREAR O EDITAR ---
    if ($accion === 'crear' || $accion === 'editar') {
        
        // 1. Procesar Lista de Features (textarea -> array)
        $featuresRaw = $_POST['features'] ?? '';
        // Separamos por salto de línea (\n), limpiamos espacios y filtramos vacíos
        $featuresArray = array_filter(array_map('trim', explode("\n", $featuresRaw)));
        // Si quedó vacío, ponemos uno por defecto
        if(empty($featuresArray)) $featuresArray = ["Consultar detalles"];

        // 2. Procesar Imágenes Nuevas (si se subieron)
        $imagenesNuevas = [];
        if (isset($_FILES['imagenes']) && !empty($_FILES['imagenes']['name'][0])) {
            $totalFiles = count($_FILES['imagenes']['name']);
            for ($i = 0; $i < $totalFiles; $i++) {
                if ($_FILES['imagenes']['error'][$i] === 0) {
                    $ext = pathinfo($_FILES['imagenes']['name'][$i], PATHINFO_EXTENSION);
                    $newName = uniqid('img_') . '_' . $i . '.' . $ext;
                    if (move_uploaded_file($_FILES['imagenes']['tmp_name'][$i], $uploadDir . $newName)) {
                        $imagenesNuevas[] = 'imagenes/proyectos/' . $newName;
                    }
                }
            }
        }

        // --- LÓGICA PARA CREAR ---
        if ($accion === 'crear') {
            // Si no subió foto al crear, usamos default
            if (empty($imagenesNuevas)) $imagenesNuevas[] = 'imagenes/logo.webp';

            $nuevoProyecto = [
                'id' => uniqid('p'),
                'titulo' => $_POST['titulo'],
                'categoria' => $_POST['categoria'],
                'descripcion' => $_POST['descripcion'],
                // Campos Nuevos
                'ubicacion' => $_POST['ubicacion'] ?: 'Consultar',
                'medidas' => $_POST['medidas'] ?: 'A medida',
                'anio' => $_POST['anio'] ?: date('Y'),
                'titulo_features' => $_POST['titulo_features'] ?: 'Características',
                'features' => array_values($featuresArray),
                'imagenes' => $imagenesNuevas,
                'fecha_carga' => date('Y-m-d')
            ];
            
            // Agregamos al principio de la lista
            array_unshift($current, $nuevoProyecto);

        // --- LÓGICA PARA EDITAR ---
        } elseif ($accion === 'editar') {
            $id = $_POST['id'];
            $found = false;
            
            foreach ($current as &$p) {
                if ($p['id'] === $id) {
                    // Actualizamos todos los textos
                    $p['titulo'] = $_POST['titulo'];
                    $p['categoria'] = $_POST['categoria'];
                    $p['descripcion'] = $_POST['descripcion'];
                    $p['ubicacion'] = $_POST['ubicacion'];
                    $p['medidas'] = $_POST['medidas'];
                    $p['anio'] = $_POST['anio'];
                    $p['titulo_features'] = $_POST['titulo_features'];
                    $p['features'] = array_values($featuresArray);
                    
                    // Manejo de Imágenes:
                    // Si el proyecto viejo tiene la imagen como string (formato antiguo), la convertimos a array
                    if (!is_array($p['imagenes'])) $p['imagenes'] = [$p['imagenes']];
                    
                    // Si subieron fotos nuevas, las SUMAMOS a las que ya tenía
                    if (!empty($imagenesNuevas)) {
                        $p['imagenes'] = array_merge($p['imagenes'], $imagenesNuevas);
                    }
                    
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                echo json_encode(['error' => 'Proyecto no encontrado']);
                exit;
            }
        }

        // Guardar JSON
        if (file_put_contents($jsonFile, json_encode($current, JSON_PRETTY_PRINT))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Error al escribir en el archivo JSON']);
        }
    }
}
?>