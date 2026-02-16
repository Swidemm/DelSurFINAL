<?php
// admin/auth.php
session_start();

// --- TUS CREDENCIALES ---
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'delsur2026'); // ¡Cambiala por una segura!

// Verificar si está logueado
function requireLogin() {
    if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
        header('Location: login.php');
        exit;
    }
}

// Intentar loguearse
function tryLogin($user, $pass) {
    if ($user === ADMIN_USER && $pass === ADMIN_PASS) {
        $_SESSION['admin_logged'] = true;
        return true;
    }
    return false;
}

// Cerrar sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../index.php');
    exit;
}
?>