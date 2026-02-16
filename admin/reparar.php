<?php
// admin/reparar.php
require_once 'auth.php';
requireLogin();

$jsonFile = '../contacts.json';

if (!file_exists($jsonFile)) {
    die("No se encontró el archivo de contactos.");
}

// Leemos la base de datos
$data = json_decode(file_get_contents($jsonFile), true);
if (!is_array($data)) {
    die("La base de datos está vacía o tiene un error de formato.");
}

$reparados = 0;
foreach ($data as &$cliente) {
    // Si no tiene ID, le creamos uno único
    if (!isset($cliente['id']) || empty($cliente['id'])) {
        $cliente['id'] = uniqid();
        $reparados++;
    }
    
    // De paso, si no tiene fecha de registro unificada, la arreglamos
    if (!isset($cliente['fecha_registro']) && isset($cliente['date'])) {
        $cliente['fecha_registro'] = $cliente['date'];
    }
}

// Guardamos los cambios
if (file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    echo "<h1>✅ ¡Reparación Exitosa!</h1>";
    echo "<p>Se asignaron IDs a <strong>$reparados</strong> clientes antiguos.</p>";
    echo "<p>Ahora podés editar a cualquier cliente sin problemas.</p>";
    echo "<br><a href='index.php' style='background: orange; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Volver al Panel</a>";
} else {
    echo "❌ Error al guardar los cambios en el archivo.";
}
?>