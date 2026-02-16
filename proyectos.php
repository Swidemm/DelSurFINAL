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
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="font-bold text-lg">Mis Proyectos</h1>
            <a href="index.php" class="text-sm text-slate-300 hover:text-white flex items-center gap-1"><i class="ph ph-arrow-left"></i> Volver</a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4">
        
        <div class="bg-white p-8 rounded-xl shadow-sm mb-10 border border-slate-200 relative">
            
            <div class="flex justify-between items-center mb-6">
                <h2 id="formTitle" class="font-bold text-xl flex items-center gap-2 text-slate-800">
                    <i class="ph ph-plus-circle text-orange-500"></i> Nuevo Proyecto
                </h2>
                <button id="btnCancel" onclick="resetForm()" class="hidden text-xs bg-slate-200 hover:bg-slate-300 px-3 py-1 rounded text-slate-600 font-bold">
                    Cancelar Edición
                </button>
            </div>

            <form id="formProyecto">
                <input type="hidden" name="accion" id="accionInput" value="crear">
                <input type="hidden" name="id" id="idInput" value="">

                <div class="grid md:grid-cols-3 gap-6 mb-6">
                    
                    <div class="space-y-4">
                        <label class="block text-xs font-bold uppercase text-slate-400">1. Info Principal</label>
                        <input type="text" id="titulo" name="titulo" required class="w-full border p-2.5 rounded bg-slate-50 focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Título (ej: Casa Lote 44)">
                        <select id="categoria" name="categoria" class="w-full border p-2.5 rounded bg-slate-50">
                            <option value="Vivienda">Vivienda</option>
                            <option value="Comercial">Comercial / Oficina</option>
                            <option value="Refacción">Refacción</option>
                            <option value="Industrial">Industrial</option>
                        </select>
                        <textarea id="descripcion" name="descripcion" required rows="4" class="w-full border p-2.5 rounded bg-slate-50" placeholder="Descripción corta del proyecto..."></textarea>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-xs font-bold uppercase text-slate-400">2. Detalles Técnicos</label>
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" id="ubicacion" name="ubicacion" class="w-full border p-2.5 rounded bg-slate-50" placeholder="Ubicación (ej: Canning)">
                            <input type="text" id="anio" name="anio" class="w-full border p-2.5 rounded bg-slate-50" placeholder="Año" value="<?php echo date('Y'); ?>">
                        </div>
                        <input type="text" id="medidas" name="medidas" class="w-full border p-2.5 rounded bg-slate-50" placeholder="Superficie (ej: 240m²)">
                        
                        <div class="pt-2">
                            <label class="block text-xs font-bold text-slate-500 mb-1">Título de la Lista</label>
                            <input type="text" id="titulo_features" name="titulo_features" class="w-full border p-2.5 rounded bg-slate-50" placeholder="Ej: Servicios Incluidos" value="Servicios Incluidos">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-xs font-bold uppercase text-slate-400">3. Contenido Extra</label>
                        <div>
                            <textarea id="features" name="features" rows="4" class="w-full border p-2.5 rounded bg-slate-50 text-sm font-mono" placeholder="Item 1&#10;Item 2&#10;Item 3"></textarea>
                            <p class="text-xs text-slate-400 mt-1">Escribí un ítem por renglón.</p>
                        </div>
                        
                        <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 text-center hover:bg-slate-50 cursor-pointer relative transition-colors">
                            <input type="file" name="imagenes[]" multiple accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewFiles(this)">
                            <div id="prevArea" class="text-slate-400 text-sm pointer-events-none">
                                <i class="ph ph-images text-2xl mb-1"></i><br>
                                <span id="fileLabel">Subir fotos</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6 flex justify-end">
                    <button type="submit" id="btnSave" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-8 rounded-lg transition shadow-lg flex items-center gap-2">
                        <i class="ph ph-upload-simple"></i> <span id="btnText">Publicar Proyecto</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <?php foreach($proyectos as $p): 
                // Asegurar compatibilidad con datos viejos/nuevos
                $imgPortada = is_array($p['imagenes']) ? $p['imagenes'][0] : $p['imagenes'];
            ?>
            <div class="bg-white rounded-xl shadow-sm overflow-hidden group border border-slate-200 relative flex flex-col">
                <div class="h-48 overflow-hidden relative">
                    <img src="../<?php echo htmlspecialchars($imgPortada); ?>" class="w-full h-full object-cover">
                    
                    <div class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button onclick='editar(<?php echo json_encode($p); ?>)' class="bg-white text-slate-700 p-2 rounded-full shadow hover:text-orange-600 transition-colors" title="Editar">
                            <i class="ph ph-pencil-simple"></i>
                        </button>
                        <button onclick="borrar('<?php echo $p['id']; ?>')" class="bg-red-600 text-white p-2 rounded-full shadow hover:bg-red-700 transition-colors" title="Eliminar">
                            <i class="ph ph-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="p-4 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-xs font-bold text-orange-500 uppercase"><?php echo htmlspecialchars($p['categoria']); ?></span>
                        <span class="text-xs text-slate-400 bg-slate-100 px-2 py-1 rounded"><?php echo htmlspecialchars($p['anio'] ?? '-'); ?></span>
                    </div>
                    <h3 class="font-bold text-slate-800 text-lg leading-tight mb-2"><?php echo htmlspecialchars($p['titulo']); ?></h3>
                    
                    <div class="mt-auto pt-4 border-t border-slate-100 text-xs text-slate-400 flex flex-wrap gap-2">
                        <span class="flex items-center gap-1"><i class="ph ph-map-pin"></i> <?php echo htmlspecialchars($p['ubicacion'] ?? 'Consultar'); ?></span>
                        <span class="flex items-center gap-1"><i class="ph ph-ruler"></i> <?php echo htmlspecialchars($p['medidas'] ?? '-'); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
    function previewFiles(input) {
        const count = input.files.length;
        const label = document.getElementById('fileLabel');
        if(count > 0) {
            label.innerText = `${count} foto(s) seleccionada(s)`;
            label.className = "text-orange-600 font-bold";
        }
    }

    // --- FUNCIÓN EDITAR ---
    function editar(p) {
        // Rellenar campos ocultos
        document.getElementById('idInput').value = p.id;
        document.getElementById('accionInput').value = 'editar';

        // Rellenar campos de texto
        document.getElementById('titulo').value = p.titulo;
        document.getElementById('categoria').value = p.categoria;
        document.getElementById('descripcion').value = p.descripcion;
        
        // Rellenar campos nuevos (con fallback por si son viejos)
        document.getElementById('ubicacion').value = p.ubicacion || '';
        document.getElementById('anio').value = p.anio || '';
        document.getElementById('medidas').value = p.medidas || '';
        document.getElementById('titulo_features').value = p.titulo_features || 'Servicios Incluidos';

        // Convertir array de features a texto con saltos de línea
        let feats = p.features;
        if(Array.isArray(feats)) feats = feats.join('\n');
        document.getElementById('features').value = feats || '';

        // Cambiar estado visual del formulario
        document.getElementById('formTitle').innerHTML = '<i class="ph ph-pencil-simple text-orange-500"></i> Editando Proyecto';
        document.getElementById('btnText').innerText = 'Guardar Cambios';
        document.getElementById('btnCancel').classList.remove('hidden');
        document.getElementById('btnSave').classList.replace('bg-orange-600', 'bg-blue-600');
        document.getElementById('btnSave').classList.replace('hover:bg-orange-700', 'hover:bg-blue-700');
        document.getElementById('fileLabel').innerText = "Subir fotos nuevas (se agregan)";

        // Scroll suave hacia arriba
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // --- FUNCIÓN RESET ---
    function resetForm() {
        document.getElementById('formProyecto').reset();
        document.getElementById('idInput').value = '';
        document.getElementById('accionInput').value = 'crear';
        
        document.getElementById('formTitle').innerHTML = '<i class="ph ph-plus-circle text-orange-500"></i> Nuevo Proyecto';
        document.getElementById('btnText').innerText = 'Publicar Proyecto';
        document.getElementById('btnCancel').classList.add('hidden');
        
        document.getElementById('btnSave').classList.replace('bg-blue-600', 'bg-orange-600');
        document.getElementById('btnSave').classList.replace('hover:bg-blue-700', 'hover:bg-orange-700');
        document.getElementById('fileLabel').innerText = "Subir fotos";
    }

    // --- ENVÍO DEL FORMULARIO ---
    document.getElementById('formProyecto').addEventListener('submit', async e => {
        e.preventDefault();
        const btn = document.getElementById('btnSave');
        const ogText = document.getElementById('btnText').innerText;
        
        btn.disabled = true; 
        document.getElementById('btnText').innerText = 'Procesando...';
        
        const formData = new FormData(e.target);
        
        try {
            const res = await fetch('guardar_proyecto.php', { method: 'POST', body: formData });
            const data = await res.json();
            if(data.success) location.reload();
            else alert('Error: ' + data.error);
        } catch(err) { 
            alert('Error de conexión'); 
        }
        
        btn.disabled = false; 
        document.getElementById('btnText').innerText = ogText;
    });

    async function borrar(id) {
        if(!confirm('¿Borrar este proyecto definitivamente?')) return;
        const fd = new FormData(); fd.append('accion','eliminar'); fd.append('id', id);
        await fetch('guardar_proyecto.php', { method: 'POST', body: fd });
        location.reload();
    }
    </script>
</body>
</html>