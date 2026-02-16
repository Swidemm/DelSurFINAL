<?php
// admin/index.php
require_once 'auth.php';
requireLogin();

// Leer últimos contactos
$contactsFile = '../contacts.json';
$leads = [];
$totalLeads = 0;
if (file_exists($contactsFile)) {
    $data = json_decode(file_get_contents($contactsFile), true);
    if (is_array($data)) {
        $leads = array_slice($data, 0, 10); // Muestro los últimos 10 para que veas más historial
        $totalLeads = count($data);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Del Sur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-slate-100 text-slate-800 font-sans">
    <nav class="bg-slate-900 text-white sticky top-0 z-50 px-4 h-16 flex items-center justify-between shadow-md">
        <span class="font-bold text-lg">Del Sur <span class="text-orange-500">Admin</span></span>
        <div class="flex gap-4 text-sm">
            <span class="text-slate-400 hidden sm:block">Admin</span>
            <a href="auth.php?logout=true" class="hover:text-red-400">Salir</a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-600 flex justify-between items-center">
                <div>
                    <p class="text-slate-500 text-sm uppercase font-bold">Total Clientes</p>
                    <h3 class="text-3xl font-bold"><?php echo $totalLeads; ?></h3>
                </div>
                <i class="ph ph-users text-4xl text-blue-100"></i>
            </div>
            
            <a href="proyectos.php" class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-orange-500 flex justify-between items-center hover:bg-orange-50 transition cursor-pointer group">
                <div>
                    <p class="text-slate-500 text-sm uppercase font-bold group-hover:text-orange-600">Gestionar Proyectos</p>
                    <h3 class="text-xl font-bold text-slate-800">Ir al Editor &rarr;</h3>
                </div>
                <i class="ph ph-buildings text-4xl text-orange-100 group-hover:text-orange-200"></i>
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h3 class="font-bold text-slate-700">Últimos Contactos Recibidos</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">Origen</th>
                            <th class="px-6 py-3">Mensaje / Detalle</th>
                            <th class="px-6 py-3">Fecha</th>
                            <th class="px-6 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (empty($leads)): ?>
                            <tr><td colspan="5" class="px-6 py-8 text-center text-slate-400">No hay contactos todavía.</td></tr>
                        <?php else: ?>
                            <?php foreach ($leads as $l): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-3 font-medium text-slate-900"><?php echo htmlspecialchars($l['nombre'] ?? '-'); ?></td>
                                <td class="px-6 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-bold <?php echo ($l['origen']??'')=='Cotizador' ? 'bg-purple-100 text-purple-700':'bg-blue-100 text-blue-700'; ?>">
                                        <?php echo htmlspecialchars($l['origen'] ?? 'Web'); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-3 truncate max-w-xs text-slate-500">
                                    <?php echo htmlspecialchars($l['mensaje'] ?? ($l['email'] ?? '')); ?>
                                </td>
                                <td class="px-6 py-3 text-slate-400">
                                    <?php echo date('d/m H:i', strtotime($l['fecha_registro'] ?? $l['date'] ?? 'now')); ?>
                                </td>
                                
                                <td class="px-6 py-3 text-right flex items-center justify-end gap-2">
                                    <?php if(isset($l['estado']) && $l['estado'] != 'Nuevo'): ?>
                                        <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded border border-orange-100 whitespace-nowrap">
                                            <?php echo htmlspecialchars($l['estado']); ?>
                                        </span>
                                    <?php endif; ?>

                                    <a href="cliente.php?id=<?php echo $l['id'] ?? ''; ?>" class="text-slate-500 hover:text-orange-600 bg-white border border-slate-200 hover:border-orange-300 p-2 rounded-lg transition shadow-sm" title="Gestionar Cliente">
                                        <i class="ph ph-pencil-simple text-lg"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>