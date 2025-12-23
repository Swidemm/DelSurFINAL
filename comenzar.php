<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cotizar Proyecto Similar — Del Sur Construcciones</title>
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { delsur: { blue: '#1e2952', dark: '#0f172a', orange: '#f97316', light: '#f8fafc' } },
          fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
          animation: { 'fade-in': 'fadeIn 0.8s ease-out forwards' },
          keyframes: { fadeIn: { '0%': { opacity: '0', transform: 'translateY(10px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } } }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  
  <style>
      /* Preloader */
      @keyframes loading {
        0% { transform: translateX(-100%); }
        50% { transform: translateX(0); }
        100% { transform: translateX(100%); }
      }
      #preloader { transition: opacity 0.6s ease-out, visibility 0.6s; }
  </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col">

  <div id="preloader" class="fixed inset-0 z-[100] bg-white flex items-center justify-center">
    <div class="flex flex-col items-center gap-6">
        <img src="./imagenes/logo.webp" alt="Cargando..." class="h-20 w-auto animate-pulse" />
        <div class="w-32 h-1.5 bg-slate-100 rounded-full overflow-hidden relative">
            <div class="h-full bg-delsur-orange w-full absolute top-0 left-0 animate-[loading_1.5s_infinite_linear]"></div>
        </div>
    </div>
  </div>

  <nav class="bg-white border-b border-slate-200 py-4 sticky top-0 z-40 shadow-sm">
    <div class="max-w-4xl mx-auto px-4 flex justify-between items-center">
        <a href="index.php" class="flex-shrink-0"><img src="./imagenes/logo.webp" alt="Del Sur" class="h-10 w-auto" /></a>
        <a href="javascript:history.back()" class="text-sm font-bold text-slate-500 hover:text-delsur-blue flex items-center gap-2">← Volver</a>
    </div>
  </nav>

  <main class="flex-grow max-w-4xl mx-auto px-4 py-12 w-full">

    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-delsur-blue mb-2" id="projectTitle">Cotizar Proyecto</h1>
        <p class="text-slate-600">Completá los detalles para que podamos asesorarte correctamente.</p>
    </div>

    <div id="contactSection" class="bg-white p-8 rounded-2xl shadow-lg border border-slate-100 max-w-2xl mx-auto">
        <form id="similarForm" class="space-y-6">
            
            <input type="hidden" id="refProject" name="ref_proyecto">

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nombre Completo</label>
                <input type="text" name="nombre" required class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 focus:ring-2 focus:ring-delsur-orange outline-none" placeholder="Tu nombre">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Contacto (WhatsApp o Email)</label>
                <input type="text" name="contacto" required class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 focus:ring-2 focus:ring-delsur-orange outline-none" placeholder="Ej: 11 1234 5678">
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tipo de Estructura</label>
                    <input type="text" name="estructura" required class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 focus:ring-2 focus:ring-delsur-orange outline-none" placeholder="Ej: Steel Framing, Ladrillo...">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Zona de Obra</label>
                    <input type="text" name="zona" required class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 focus:ring-2 focus:ring-delsur-orange outline-none" placeholder="Ej: Canning, Pilar...">
                </div>
            </div>

            <button type="submit" id="submitBtn" class="w-full py-4 rounded-xl bg-delsur-blue text-white font-bold text-lg hover:bg-slate-800 transition-all shadow-lg flex justify-center items-center gap-2">
                Enviar y Ver Opciones
            </button>
        </form>
    </div>

    <div id="paymentSection" class="hidden animate-fade-in">
        
        <div class="bg-green-100 border border-green-200 text-green-800 px-6 py-6 rounded-2xl mb-12 text-center max-w-2xl mx-auto">
            <div class="flex justify-center mb-2">
                <svg class="w-12 h-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-1">¡Datos de contacto enviados!</h3>
            <p>Hemos recibido tu solicitud correctamente.</p>
        </div>

        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold text-delsur-blue leading-tight">
                Adelantate y da el siguiente paso hacia tu proyecto.
            </h2>
            <p class="text-slate-500 mt-2">Asegurá tu lugar en nuestra agenda comenzando hoy mismo.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 items-start max-w-5xl mx-auto">
            
             <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all relative overflow-hidden group">
                <h3 class="text-xl font-bold text-slate-700 mb-2">Asesoría General</h3>
                <div class="flex items-baseline gap-1 my-4">
                    <span class="text-4xl font-bold text-delsur-blue">$3.500</span>
                    <span class="text-slate-400 text-sm">/ única vez</span>
                </div>
                <p class="text-sm text-slate-500 mb-8 pb-8 border-b border-slate-100">
                    Ideal si tenés el terreno y querés saber qué se puede construir y cuánto va a costar realmente.
                </p>
                
                <a href="mpago://link_va_aca" class="block w-full py-3 rounded-xl border-2 border-slate-200 text-slate-600 font-bold text-center hover:border-delsur-blue hover:text-delsur-blue transition-all mb-8">
                    Elegir Asesoría
                </a>

                <ul class="space-y-4 text-sm text-slate-600">
                    <li class="flex gap-3"><span class="text-green-500 font-bold">✓</span> Reunión de diagnóstico (Virtual/Presencial)</li>
                    <li class="flex gap-3"><span class="text-green-500 font-bold">✓</span> Análisis de viabilidad técnica</li>
                    <li class="flex gap-3"><span class="text-green-500 font-bold">✓</span> Presupuesto estimado de obra</li>
                    <li class="flex gap-3 opacity-50"><span class="text-slate-300">✕</span> Sin acceso al Planificador 2D</li>
                </ul>
            </div>

            <div class="bg-delsur-blue p-8 rounded-2xl shadow-xl text-white relative overflow-hidden transform md:-translate-y-4 md:hover:-translate-y-5 transition-all duration-300 ring-4 ring-delsur-orange/20">
                <div class="absolute top-0 right-0 bg-delsur-orange text-white text-xs font-bold px-4 py-1 rounded-bl-xl">MÁS ELEGIDO</div>
                
                <h3 class="text-xl font-bold text-white mb-2">Pack Premium</h3>
                <div class="flex items-baseline gap-1 my-4">
                    <span class="text-5xl font-bold text-delsur-orange">$4.500</span>
                    <span class="text-blue-200 text-sm">/ única vez</span>
                </div>
                <p class="text-sm text-blue-100 mb-8 pb-8 border-b border-blue-800">
                    La experiencia completa. Diseñá tu casa con nuestra herramienta exclusiva y recibí asesoramiento prioritario.
                </p>

                <a href="mpago://link_va_aca" class="block w-full py-4 rounded-xl bg-delsur-orange text-white font-bold text-center hover:bg-orange-600 hover:shadow-lg hover:shadow-orange-500/50 transition-all mb-8 relative overflow-hidden group">
                    <span class="relative z-10">CONTRATAR PACK</span>
                    <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                </a>
                
                <ul class="space-y-4 text-sm text-blue-100">
                    <li class="flex gap-3"><span class="text-delsur-orange font-bold">✓</span> Todo lo incluido en Asesoría</li>
                    <li class="flex gap-3"><span class="text-delsur-orange font-bold">✓</span> <strong class="text-white">Licencia Planificador 2D</strong></li>
                    <li class="flex gap-3"><span class="text-delsur-orange font-bold">✓</span> Prioridad en agenda de obra</li>
                    <li class="flex gap-3"><span class="text-delsur-orange font-bold">✓</span> Descuento si contratás la obra</li>
                </ul>
            </div>
        </div>
    </div>

  </main>

  <script>
    // ----------------------------
    // LOGICA DEL PRELOADER
    // ----------------------------
    window.addEventListener('load', () => {
        setTimeout(() => {
            const loader = document.getElementById('preloader');
            loader.classList.add('opacity-0', 'invisible');
        }, 2000);
    });

    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            // Ignorar links de mpago, javascript o #
            if (href && (href.startsWith('mpago') || href.startsWith('javascript') || href.startsWith('#'))) return;

            if (href && link.target !== '_blank') {
                e.preventDefault();
                document.getElementById('preloader').classList.remove('opacity-0', 'invisible');
                setTimeout(() => window.location.href = href, 400); 
            }
        });
    });

    // ----------------------------
    // LOGICA DE PÁGINA EXISTENTE
    // ----------------------------

    // 1. Configurar Referencia
    const urlParams = new URLSearchParams(window.location.search);
    const ref = urlParams.get('ref');
    if(ref) {
        document.getElementById('projectTitle').textContent = `Cotizar similar a: "${ref}"`;
        document.getElementById('refProject').value = ref;
    }

    // 2. Manejo del Formulario
    const form = document.getElementById('similarForm');
    const contactSec = document.getElementById('contactSection');
    const paymentSec = document.getElementById('paymentSection');
    const btn = document.getElementById('submitBtn');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Spinner
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Enviando...';

        const data = new FormData(form);
        const payload = {
            ref: data.get('ref_proyecto'),
            nombre: data.get('nombre'),
            contacto: data.get('contacto'),
            estructura: data.get('estructura'),
            zona: data.get('zona')
        };

        try {
            // Guardamos en similar.json usando save_similar.php
            const res = await fetch('save_similar.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload),
            });

            if (res.ok) {
                // Simular un poquito de carga para que se vea el spinner
                setTimeout(() => {
                    // Ocultar form, mostrar pagos
                    contactSec.style.display = 'none';
                    paymentSec.classList.remove('hidden');
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 1000);
            } else {
                alert("Hubo un error al enviar. Intenta de nuevo.");
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        } catch (err) {
            console.error(err);
            alert("Error de conexión.");
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    });
  </script>
</body>
</html>