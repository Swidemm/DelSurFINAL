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
    <style>
        /* Refuerzo para que ninguna imagen se escape de su celda */
        .img-container {
            width: 100%;
            padding-top: 56.25%; /* Relación de aspecto 16:9 */
            position: relative;
            overflow: hidden;
            background-color: #f1f5f9;
        }
        .img-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 font-sans pb-20">
    <nav class="bg-slate-900 text-white p-4 mb-6">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="font-bold text-lg">Mis Proyectos</h1>
            <a href="index.php" class="text-sm text-slate-300 hover:text-white flex items-center gap-1"><i class="ph ph-arrow-left"></i> Volver</a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4">
        
        <div class="bg-white p-8 rounded-xl shadow-sm mb-10 border border-slate-200">
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
                        <input type="text" id="titulo" name="titulo" required class="w-full border p-2.5 rounded bg-slate-50 outline-none focus:ring-2 focus:ring-orange-500" placeholder="Título">
                        <select id="categoria" name="categoria" class="w-full border p-2.5 rounded bg-slate-50">
                            <option value="Vivienda">Vivienda</option>
                            <option value="Comercial">Comercial</option>
                            <option value="Refacción">Refacción</option>
                        </select>
                        <textarea id="descripcion" name="descripcion" required rows="4" class="w-full border p-2.5 rounded bg-slate-50" placeholder="Descripción..."></textarea>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-xs font-bold uppercase text-slate-400">2. Detalles Técnicos</label>
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" id="ubicacion" name="ubicacion" class="w-full border p-2.5 rounded bg-slate-50" placeholder="Ubicación">
                            <input type="text" id="anio" name="anio" class="w-full border p-2.5 rounded bg-slate-50" placeholder="Año" value="2026">
                        </div>
                        <input type="text" id="medidas" name="medidas" class="w-full border p-2.5 rounded bg-slate-50" placeholder="m²">
                        <input type="text" id="titulo_features" name="titulo_features" class="w-full border p-2.5 rounded bg-slate-50" value="Servicios Incluidos">
                    </div>

                    <div class="space-y-4">
                        <label class="block text-xs font-bold uppercase text-slate-400">3. Items y Fotos</label>
                        <textarea id="features" name="features" rows="4" class="w-full border p-2.5 rounded bg-slate-50 text-sm" placeholder="Un ítem por línea"></textarea>
                        <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 text-center relative hover:bg-slate-50 cursor-pointer">
                            <input type="file" name="imagenes[]" multiple accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewFiles(this)">
                            <div class="text-slate-400 text-sm">
                                <i class="ph ph-images text-2xl"></i><br>
                                <span id="fileLabel">Subir fotos</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6 flex justify-end">
                    <button type="submit" id="btnSave" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg flex items-center gap-2 transition-all">
                        <i class="ph ph-upload-simple"></i> <span id="btnText">Publicar Proyecto</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <?php foreach($proyectos as $p): 
                $imgPortada = is_array($p['imagenes']) ? $p['imagenes'][0] : $p['imagenes'];
                $esDestacado = isset($p['destacado']) && $p['destacado'] === true;
            ?>
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-slate-200 flex flex-col group relative">
                
                <div class="img-container">
                    <img src="../<?php echo htmlspecialchars($imgPortada); ?>" alt="Proyecto">
                    
                    <div class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                        <button onclick="toggleDestacado('<?php echo $p['id']; ?>')" 
                                class="p-2 rounded-full shadow transition-all <?php echo $esDestacado ? 'bg-orange-500 text-white' : 'bg-white text-slate-400 hover:text-orange-500'; ?>"
                                title="<?php echo $esDestacado ? 'Quitar de la Home' : 'Mostrar en la Home'; ?>">
                            <i class="ph ph-star<?php echo $esDestacado ? '-fill' : ''; ?>"></i>
                        </button>

                        <button onclick='editar(<?php echo json_encode($p); ?>)' class="bg-white text-slate-700 p-2 rounded-full shadow hover:text-orange-600">
                            <i class="ph ph-pencil-simple"></i>
                        </button>
                        <button onclick="borrar('<?php echo $p['id']; ?>')" class="bg-red-600 text-white p-2 rounded-full shadow hover:bg-red-700">
                            <i class="ph ph-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="p-5 flex-1">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-[10px] font-bold text-orange-500 uppercase tracking-widest"><?php echo htmlspecialchars($p['categoria']); ?></span>
                        <span class="text-[10px] text-slate-400 bg-slate-100 px-2 py-0.5 rounded font-bold"><?php echo htmlspecialchars($p['anio'] ?? '2026'); ?></span>
                    </div>
                    <h3 class="font-bold text-slate-800 text-lg mb-4 leading-tight"><?php echo htmlspecialchars($p['titulo']); ?></h3>
                    <div class="flex gap-4 text-[11px] text-slate-500 font-medium">
                        <span class="flex items-center gap-1"><i class="ph ph-map-pin"></i> <?php echo htmlspecialchars($p['ubicacion'] ?? '-'); ?></span>
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
        document.getElementById('fileLabel').innerText = count + " fotos elegidas";
        document.getElementById('fileLabel').className = "text-orange-600 font-bold";
    }

    // --- NUEVA FUNCIÓN DESTACADOS ---
    async function toggleDestacado(id) {
        const fd = new FormData();
        fd.append('accion', 'toggle_destacado');
        fd.append('id', id);
        try {
            const res = await fetch('guardar_proyecto.php', { method: 'POST', body: fd });
            const data = await res.json();
            if(data.success) location.reload();
            else alert('Error al destacar');
        } catch(err) { console.error(err); }
    }

    function editar(p) {
        document.getElementById('idInput').value = p.id;
        document.getElementById('accionInput').value = 'editar';
        document.getElementById('titulo').value = p.titulo;
        document.getElementById('categoria').value = p.categoria;
        document.getElementById('descripcion').value = p.descripcion;
        document.getElementById('ubicacion').value = p.ubicacion || '';
        document.getElementById('anio').value = p.anio || '';
        document.getElementById('medidas').value = p.medidas || '';
        document.getElementById('titulo_features').value = p.titulo_features || '';
        
        let feats = p.features;
        if(Array.isArray(feats)) feats = feats.join('\n');
        document.getElementById('features').value = feats || '';

        document.getElementById('formTitle').innerText = 'Editando Proyecto';
        document.getElementById('btnText').innerText = 'Guardar Cambios';
        document.getElementById('btnCancel').classList.remove('hidden');
        document.getElementById('btnSave').classList.replace('bg-orange-600', 'bg-blue-600');
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetForm() {
        document.getElementById('formProyecto').reset();
        document.getElementById('idInput').value = '';
        document.getElementById('accionInput').value = 'crear';
        document.getElementById('formTitle').innerText = 'Nuevo Proyecto';
        document.getElementById('btnText').innerText = 'Publicar Proyecto';
        document.getElementById('btnCancel').classList.add('hidden');
        document.getElementById('btnSave').classList.replace('bg-blue-600', 'bg-orange-600');
    }

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
        } catch(err) { alert('Error de conexión'); }
        
        btn.disabled = false;
        document.getElementById('btnText').innerText = ogText;
    });

    async function borrar(id) {
        if(!confirm('¿Borrar proyecto?')) return;
        const fd = new FormData(); fd.append('accion','eliminar'); fd.append('id', id);
        await fetch('guardar_proyecto.php', { method: 'POST', body: fd });
        location.reload();
    }
    </script>
</body>
</html>