<?php
// admin/login.php
require_once 'auth.php';

if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (tryLogin($_POST['user'] ?? '', $_POST['pass'] ?? '')) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Del Sur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 h-screen flex items-center justify-center font-sans">
    <div class="bg-slate-800 p-8 rounded-2xl shadow-2xl w-full max-w-sm border border-slate-700">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-white">Del Sur <span class="text-orange-500">Admin</span></h1>
            <p class="text-slate-400 text-sm">Panel de Control</p>
        </div>
        <?php if ($error): ?>
            <div class="bg-red-500/10 text-red-400 text-sm p-3 rounded mb-4 text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <input type="text" name="user" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Usuario" required autofocus>
            <input type="password" name="pass" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Contraseña" required>
            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-3 rounded-lg transition-colors">Ingresar</button>
        </form>
        <a href="../index.php" class="block text-center text-slate-500 text-sm mt-6 hover:text-white">← Volver a la web</a>
    </div>
</body>
</html>