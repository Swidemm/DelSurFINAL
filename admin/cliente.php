<?php
// admin/cliente.php
require_once 'auth.php';
requireLogin();

// 1. Obtener ID
$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

// 2. Cargar datos
$jsonFile = '../contacts.json';
$contacts = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
$cliente = null;

// 3. Buscar cliente
foreach ($contacts as $c) {
    if (isset($c['id']) && $c['id'] === $id) {
        $cliente = $c;
        break;
    }
}

if (!$cliente) { echo "Cliente no encontrado."; exit; }

// Preparar historial de notas (compatibilidad con versiones anteriores)
$historial = $cliente['historial_notas'] ?? [];
// Si no hay historial pero hay nota vieja, la mostramos
if (empty($historial) && !empty($cliente['notas'])) {
    $historial[] = ['fecha' => 'Nota anterior', 'texto' => $cliente['notas']];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha Cliente - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-slate-100 text-slate-800 font-sans pb-20">

    <nav class="bg-slate-900 text-white p-4 mb-6 sticky top-0 z-50 shadow-md">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <h1 class="font-bold text-lg flex items-center gap-2">
                <i class="ph ph-user text-orange-500"></i> <?php echo htmlspecialchars($cliente['nombre']); ?>
            </h1>
            <a href="index.php" class="text-sm text-slate-300 hover:text-white flex items-center gap-1">
                <i class="ph ph-arrow-left"></i> Volver
            </a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 grid md:grid-cols-3 gap-6">

        <div class="space-y-6">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Contacto</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs text-slate-500">Email</label>
                        <a href="mailto:<?php echo $cliente['email']; ?>" class="text-blue-600 hover:underline break-all">
                            <?php echo htmlspecialchars($cliente['email'] ?? '-'); ?>
                        </a>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500">Teléfono</label>
                        <?php if(!empty($cliente['telefono'])): ?>
                            <a href="https://wa.me/549<?php echo preg_replace('/[^0-9]/', '', $cliente['telefono']); ?>" target="_blank" class="flex items-center gap-2 text-green-600 font-medium hover:underline">
                                <i class="ph ph-whatsapp-logo text-lg"></i> 
                                <?php echo htmlspecialchars($cliente['telefono']); ?>
                            </a>
                        <?php else: ?>
                            <span class="text-slate-700">-</span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500">Origen</label>
                        <span class="text-xs font-bold bg-slate-100 px-2 py-1 rounded text-slate-600">
                            <?php echo htmlspecialchars($cliente['origen'] ?? 'Web'); ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Mensaje Inicial</h3>
                <p class="text-sm text-slate-600 italic bg-slate-50 p-3 rounded border border-slate-100">
                    "<?php echo nl2br(htmlspecialchars($cliente['mensaje'] ?? 'Sin mensaje')); ?>"
                </p>
                <?php if(isset($cliente['estructura'])): ?>
                    <div class="mt-3 pt-3 border-t border-slate-100 text-xs space-y-1">
                        <p><strong>Ref:</strong> <?php echo htmlspecialchars($cliente['ref_proyecto'] ?? '-'); ?></p>
                        <p><strong>Tipo:</strong> <?php echo htmlspecialchars($cliente['estructura'] ?? '-'); ?></p>
                        <p><strong>Zona:</strong> <?php echo htmlspecialchars($cliente['zona'] ?? '-'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <button onclick="borrarCliente()" class="w-full text-red-500 text-sm hover:text-red-700 hover:bg-red-50 border border-transparent hover:border-red-200 p-2 rounded transition flex items-center justify-center gap-2">
                <i class="ph ph-trash"></i> Eliminar Cliente
            </button>
        </div>

        <div class="md:col-span-2 space-y-6">
            <form id="formGestion">
                <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                
                <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Estado</label>
                        <select name="estado" class="w-full border border-slate-300 rounded p-2 bg-white text-sm focus:ring-2 focus:ring-orange-500 outline-none">
                            <?php $st = $cliente['estado'] ?? 'Nuevo'; ?>
                            <option value="Nuevo" <?php echo $st=='Nuevo'?'selected':''; ?>>✨ Nuevo</option>
                            <option value="Contactado" <?php echo $st=='Contactado'?'selected':''; ?>>📞 Contactado</option>
                            <option value="Presupuestado" <?php echo $st=='Presupuestado'?'selected':''; ?>>📄 Presupuesto</option>
                            <option value="En Negociación" <?php echo $st=='En Negociación'?'selected':''; ?>>🤝 En Negociación</option>
                            <option value="Ganado" <?php echo $st=='Ganado'?'selected':''; ?>>✅ Venta Cerrada</option>
                            <option value="Perdido" <?php echo $st=='Perdido'?'selected':''; ?>>❌ Perdido</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pago</label>
                        <select name="pago" class="w-full border border-slate-300 rounded p-2 bg-white text-sm focus:ring-2 focus:ring-orange-500 outline-none">
                            <?php $pg = $cliente['pago'] ?? 'N/A'; ?>
                            <option value="N/A" <?php echo $pg=='N/A'?'selected':''; ?>>N/A</option>
                            <option value="Pendiente" <?php echo $pg=='Pendiente'?'selected':''; ?>>⏳ Pendiente</option>
                            <option value="Seña" <?php echo $pg=='Seña'?'selected':''; ?>>💳 Seña</option>
                            <option value="Total" <?php echo $pg=='Total'?'selected':''; ?>>💰 Pagado</option>
                        </select>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg border border-orange-100 overflow-hidden">
                    <div class="bg-slate-50 px-5 py-3 border-b border-slate-200 flex justify-between items-center">
                        <h3 class="font-bold text-slate-700 flex items-center gap-2"><i class="ph ph-notepad text-orange-500"></i> Notas Internas</h3>
                    </div>
                    
                    <div class="p-5">
                        <div class="flex gap-2 mb-6">
                            <input type="text" name="nueva_nota" id="inputNota" class="flex-1 border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Escribí una nueva observación..." autocomplete="off">
                            <button type="submit" id="btnGuardar" class="bg-orange-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-orange-700 transition shadow-sm">
                                <i class="ph ph-paper-plane-right"></i>
                            </button>
                        </div>

                        <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2">
                            <?php if(empty($historial)): ?>
                                <p class="text-center text-slate-400 text-sm py-4">No hay notas registradas.</p>
                            <?php else: ?>
                                <?php foreach($historial as $nota): ?>
                                <div class="flex gap-3 items-start">
                                    <div class="mt-1 w-2 h-2 rounded-full bg-orange-300 shrink-0"></div>
                                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-100 flex-1">
                                        <p class="text-slate-700 text-sm"><?php echo nl2br(htmlspecialchars($nota['texto'])); ?></p>
                                        <p class="text-xs text-slate-400 mt-1 text-right">
                                            <?php 
                                                $fecha = $nota['fecha'];
                                                // Intentar formatear fecha si es válida
                                                echo (strtotime($fecha) ? date('d/m/Y H:i', strtotime($fecha)) : $fecha); 
                                            ?>
                                        </p>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <script>
        document.getElementById('formGestion').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('btnGuardar');
            const icon = btn.innerHTML;
            
            // Animación simple de carga
            btn.disabled = true;
            btn.innerHTML = '<i class="ph ph-spinner animate-spin"></i>';

            const formData = new FormData(e.target);
            formData.append('accion', 'actualizar');

            try {
                const res = await fetch('guardar_cliente.php', { method: 'POST', body: formData });
                const data = await res.json();
                
                if (data.success) {
                    // Si escribió nota, limpiamos el input para que no la mande de nuevo
                    document.getElementById('inputNota').value = '';
                    // Recargamos la página para ver la nota nueva en la lista
                    window.location.reload(); 
                } else {
                    alert('Error: ' + data.error);
                    btn.innerHTML = icon;
                    btn.disabled = false;
                }
            } catch (err) {
                alert('Error de conexión');
                btn.innerHTML = icon;
                btn.disabled = false;
            }
        });

        async function borrarCliente() {
            if(!confirm('¿Eliminar cliente?')) return;
            const formData = new FormData();
            formData.append('accion', 'eliminar');
            formData.append('id', '<?php echo $cliente['id']; ?>');
            await fetch('guardar_cliente.php', { method: 'POST', body: formData });
            window.location.href = 'index.php';
        }
    </script>
</body>
</html>