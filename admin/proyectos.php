<?php
// admin/proyectos.php
require_once 'auth.php';
requireLogin();

$jsonFile = '../proyectos.json';
$proyectos = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Proyectos - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-slate-100 text-slate-800 font-sans pb-20">
    <nav class="bg-slate-900 text-white p-4 mb-6">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <h1 class="font-bold text-lg">Mis Proyectos</h1>
            <a href="index.php" class="text-sm text-slate-300 hover:text-white flex items-center gap-1"><i class="ph ph-arrow-left"></i> Volver</a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-slate-200">
            <h2 class="font-bold text-lg mb-4 flex items-center gap-2"><i class="ph ph-plus-circle text-orange-500"></i> Nuevo Proyecto</h2>
            <form id="formProyecto" class="grid md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <input type="text" name="titulo" required class="w-full border p-2 rounded focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Título (ej: Casa Lote 44)">
                    <select name="categoria" class="w-full border p-2 rounded bg-white">
                        <option value="Vivienda">Vivienda</option>
                        <option value="Comercial">Comercial / Oficina</option>
                        <option value="Refacción">Refacción</option>
                    </select>
                    <input type="text" name="descripcion" required class="w-full border p-2 rounded" placeholder="Detalle (ej: 120m² • Llave en mano)">
                </div>
                <div class="space-y-4">
                    <div class="border-2 border-dashed border-slate-300 rounded p-6 text-center hover:bg-slate-50 cursor-pointer relative">
                        <input type="file" name="imagen" required accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="preview(this)">
                        <div id="prevArea" class="text-slate-400 text-sm">
                            <i class="ph ph-image text-2xl"></i><br>Click para subir foto
                        </div>
                    </div>
                    <button type="submit" id="btnSave" class="w-full bg-orange-600 text-white font-bold py-2 rounded hover:bg-orange-700 transition">Publicar Proyecto</button>
                </div>
            </form>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <?php foreach($proyectos as $p): ?>
            <div class="bg-white rounded-xl shadow-sm overflow-hidden group border border-slate-200 relative">
                <div class="h-48 overflow-hidden">
                    <img src="../<?php echo htmlspecialchars($p['imagen']); ?>" class="w-full h-full object-cover">
                </div>
                <button onclick="borrar('<?php echo $p['id']; ?>')" class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full shadow hover:bg-red-700 opacity-0 group-hover:opacity-100 transition-opacity">
                    <i class="ph ph-trash"></i>
                </button>
                <div class="p-4">
                    <span class="text-xs font-bold text-orange-500 uppercase"><?php echo htmlspecialchars($p['categoria']); ?></span>
                    <h3 class="font-bold text-slate-800"><?php echo htmlspecialchars($p['titulo']); ?></h3>
                    <p class="text-sm text-slate-500"><?php echo htmlspecialchars($p['descripcion']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if(empty($proyectos)): ?><p class="text-slate-400 col-span-3 text-center">No hay proyectos cargados.</p><?php endif; ?>
        </div>
    </div>

    <script>
    function preview(input) {
        if(input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => document.getElementById('prevArea').innerHTML = `<img src="${e.target.result}" class="h-20 mx-auto rounded">`;
            reader.readAsDataURL(input.files[0]);
        }
    }
    document.getElementById('formProyecto').addEventListener('submit', async e => {
        e.preventDefault();
        const btn = document.getElementById('btnSave');
        btn.disabled = true; btn.innerText = 'Subiendo...';
        const formData = new FormData(e.target);
        formData.append('accion', 'crear');
        
        try {
            const res = await fetch('guardar_proyecto.php', { method: 'POST', body: formData });
            const data = await res.json();
            if(data.success) location.reload();
            else alert('Error: ' + data.error);
        } catch(err) { alert('Error de conexión'); }
        btn.disabled = false; btn.innerText = 'Publicar Proyecto';
    });
    async function borrar(id) {
        if(!confirm('¿Borrar este proyecto?')) return;
        const fd = new FormData(); fd.append('accion','eliminar'); fd.append('id', id);
        await fetch('guardar_proyecto.php', { method: 'POST', body: fd });
        location.reload();
    }
    </script>
</body>
</html>