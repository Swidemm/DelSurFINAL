<?php
require_once 'auth.php';
requireLogin();

// 1. Obtener ID del cliente desde la URL
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php'); // Si no hay ID, volvemos al inicio
    exit;
}

// 2. Cargar base de datos
$jsonFile = '../contacts.json';
$contacts = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
$cliente = null;

// 3. Buscar el cliente específico
foreach ($contacts as $c) {
    if (isset($c['id']) && $c['id'] === $id) {
        $cliente = $c;
        break;
    }
}

if (!$cliente) {
    echo "Cliente no encontrado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Cliente - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-slate-100 text-slate-800 font-sans pb-20">

    <nav class="bg-slate-900 text-white p-4 mb-6 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <h1 class="font-bold text-lg flex items-center gap-2">
                <i class="ph ph-user-gear text-orange-500"></i> Ficha de Cliente
            </h1>
            <a href="index.php" class="text-sm text-slate-300 hover:text-white flex items-center gap-1">
                <i class="ph ph-arrow-left"></i> Volver al Tablero
            </a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 grid md:grid-cols-3 gap-6">

        <div class="md:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Datos de Contacto</h3>
                
                <div class="mb-4">
                    <label class="block text-sm text-slate-500">Nombre</label>
                    <div class="font-bold text-lg text-delsur-blue"><?php echo htmlspecialchars($cliente['nombre']); ?></div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-slate-500">Origen</label>
                    <span class="inline-block px-2 py-1 rounded text-xs font-bold bg-blue-100 text-blue-700">
                        <?php echo htmlspecialchars($cliente['origen'] ?? 'Web'); ?>
                    </span>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-slate-500">Email</label>
                    <div class="text-slate-700 break-words"><?php echo htmlspecialchars($cliente['email'] ?? '-'); ?></div>
                    <?php if(!empty($cliente['email'])): ?>
                        <a href="mailto:<?php echo $cliente['email']; ?>" class="text-xs text-orange-600 hover:underline">Enviar Correo</a>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-slate-500">Teléfono</label>
                    <div class="text-slate-700"><?php echo htmlspecialchars($cliente['telefono'] ?? $cliente['contacto'] ?? '-'); ?></div>
                    <?php if(!empty($cliente['telefono'])): ?>
                        <a href="https://wa.me/549<?php echo preg_replace('/[^0-9]/', '', $cliente['telefono']); ?>" target="_blank" class="text-xs text-green-600 hover:underline flex items-center gap-1 mt-1">
                            <i class="ph ph-whatsapp-logo"></i> Abrir WhatsApp
                        </a>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-slate-500">Fecha de Ingreso</label>
                    <div class="text-slate-700 text-sm">
                        <?php echo date('d/m/Y H:i', strtotime($cliente['fecha_registro'] ?? $cliente['date'] ?? 'now')); ?>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Mensaje Original</h3>
                <p class="text-sm text-slate-600 italic bg-slate-50 p-3 rounded border border-slate-100">
                    "<?php echo nl2br(htmlspecialchars($cliente['mensaje'] ?? 'Sin mensaje')); ?>"
                </p>
                <?php if(isset($cliente['estructura'])): ?>
                    <div class="mt-3 pt-3 border-t border-slate-100">
                        <p class="text-xs text-slate-500"><strong>Interés:</strong> <?php echo htmlspecialchars($cliente['ref_proyecto'] ?? '-'); ?></p>
                        <p class="text-xs text-slate-500"><strong>Tipo:</strong> <?php echo htmlspecialchars($cliente['estructura'] ?? '-'); ?></p>
                        <p class="text-xs text-slate-500"><strong>Zona:</strong> <?php echo htmlspecialchars($cliente['zona'] ?? '-'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="md:col-span-2">
            <form id="formGestion" class="bg-white p-6 rounded-xl shadow-lg border border-orange-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-400 to-orange-600"></div>
                
                <h2 class="font-bold text-xl text-slate-800 mb-6">Seguimiento Comercial</h2>
                
                <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">

                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Estado del Lead</label>
                        <select name="estado" class="w-full border border-slate-300 rounded-lg p-3 bg-slate-50 focus:ring-2 focus:ring-orange-500 outline-none">
                            <?php $st = $cliente['estado'] ?? 'Nuevo'; ?>
                            <option value="Nuevo" <?php echo $st=='Nuevo'?'selected':''; ?>>✨ Nuevo</option>
                            <option value="Contactado" <?php echo $st=='Contactado'?'selected':''; ?>>📞 Contactado</option>
                            <option value="Presupuestado" <?php echo $st=='Presupuestado'?'selected':''; ?>>📄 Presupuesto Enviado</option>
                            <option value="En Negociación" <?php echo $st=='En Negociación'?'selected':''; ?>>🤝 En Negociación</option>
                            <option value="Ganado" <?php echo $st=='Ganado'?'selected':''; ?>>✅ Venta Cerrada</option>
                            <option value="Perdido" <?php echo $st=='Perdido'?'selected':''; ?>>❌ Perdido / No interesa</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Estado de Pago</label>
                        <select name="pago" class="w-full border border-slate-300 rounded-lg p-3 bg-slate-50 focus:ring-2 focus:ring-orange-500 outline-none">
                            <?php $pg = $cliente['pago'] ?? 'N/A'; ?>
                            <option value="N/A" <?php echo $pg=='N/A'?'selected':''; ?>>N/A</option>
                            <option value="Pendiente" <?php echo $pg=='Pendiente'?'selected':''; ?>>⏳ Pendiente</option>
                            <option value="Seña" <?php echo $pg=='Seña'?'selected':''; ?>>💳 Seña Abonada</option>
                            <option value="Total" <?php echo $pg=='Total'?'selected':''; ?>>💰 Total Saldado</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Bitácora / Notas Internas</label>
                    <textarea name="notas" rows="6" class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-orange-500 outline-none text-sm leading-relaxed" placeholder="Escribí acá tus anotaciones sobre la llamada, precios pasados, recordatorios..."><?php echo htmlspecialchars($cliente['notas'] ?? ''); ?></textarea>
                    <p class="text-xs text-slate-400 mt-2 text-right">Estas notas son privadas, el cliente no las ve.</p>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                    <button type="button" onclick="borrarCliente()" class="text-red-500 text-sm font-bold hover:text-red-700 px-4 py-2 hover:bg-red-50 rounded transition">
                        <i class="ph ph-trash"></i> Eliminar Cliente
                    </button>
                    <button type="submit" id="btnGuardar" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-orange-500/30 transition transform hover:-translate-y-1">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script>
        // GUARDAR CAMBIOS
        document.getElementById('formGestion').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('btnGuardar');
            const originalText = btn.innerHTML;
            
            btn.innerHTML = '<i class="ph ph-spinner animate-spin"></i> Guardando...';
            btn.disabled = true;

            const formData = new FormData(e.target);
            formData.append('accion', 'actualizar');

            try {
                const res = await fetch('guardar_cliente.php', { method: 'POST', body: formData });
                const data = await res.json();
                
                if (data.success) {
                    // Feedback visual sutil
                    btn.innerHTML = '<i class="ph ph-check"></i> ¡Guardado!';
                    btn.classList.remove('bg-orange-600');
                    btn.classList.add('bg-green-600');
                    
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.classList.add('bg-orange-600');
                        btn.classList.remove('bg-green-600');
                        btn.disabled = false;
                    }, 2000);
                } else {
                    alert('Error: ' + data.error);
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            } catch (err) {
                alert('Error de conexión');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });

        // ELIMINAR CLIENTE
        async function borrarCliente() {
            if(!confirm('¿Estás SEGURO de eliminar a este cliente y todo su historial? Esta acción no se puede deshacer.')) return;
            
            const formData = new FormData();
            formData.append('accion', 'eliminar');
            formData.append('id', '<?php echo $cliente['id']; ?>');

            try {
                const res = await fetch('guardar_cliente.php', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success) {
                    window.location.href = 'index.php'; // Volver al dashboard
                }
            } catch(err) {
                alert('Error al eliminar');
            }
        }
    </script>
</body>
</html>