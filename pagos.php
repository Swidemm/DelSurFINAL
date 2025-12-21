<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Planes y Precios — Del Sur Construcciones</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            delsur: { blue: '#1e2952', dark: '#0f172a', orange: '#f97316', light: '#f8fafc' }
          },
          fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
          animation: { 'bounce-slow': 'bounce 3s infinite' }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
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
        <p class="text-xs text-slate-400 font-medium tracking-widest uppercase">Procesando</p>
    </div>
  </div>

  <nav class="bg-white border-b border-slate-200 py-4 sticky top-0 z-40">
    <div class="max-w-5xl mx-auto px-4 flex justify-between items-center">
        <a href="index.php" class="flex-shrink-0">
            <img src="./imagenes/logo.webp" alt="Del Sur" class="h-10 w-auto" />
        </a>
        <a href="index.php" class="text-sm font-medium text-slate-500 hover:text-delsur-blue">← Volver al inicio</a>
    </div>
  </nav>

  <main class="flex-grow max-w-5xl mx-auto px-4 py-12 w-full">
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-bold text-delsur-blue mb-4">Invertí en Tranquilidad</h1>
        <p class="text-slate-600 max-w-2xl mx-auto">Elegí el plan que mejor se adapte a la etapa de tu proyecto. Sin letras chicas.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto items-start">
        <div class="bg-white p-8 rounded-2xl shadow-lg border border-slate-100 hover:border-delsur-blue/30 transition-all">
            <h3 class="text-xl font-bold text-slate-700 mb-2">Asesoría General</h3>
            <div class="flex items-baseline gap-1 mb-6">
                <span class="text-4xl font-bold text-delsur-blue">$3.500</span>
                <span class="text-slate-400">/ único</span>
            </div>
            <p class="text-sm text-slate-500 mb-6 min-h-[40px]">Perfecto si tenés dudas sobre un terreno, materiales o viabilidad técnica.</p>
            <a href="https://mpago.la/LINK_BASICO_AQUI" target="_blank" class="block w-full py-3 rounded-xl border-2 border-delsur-blue text-delsur-blue font-bold text-center hover:bg-blue-50 transition-colors mb-6">Elegir Asesoría</a>
            <ul class="space-y-3 text-sm text-slate-600">
                <li class="flex gap-3"><span class="text-green-500 font-bold">✓</span> Videollamada de 30 min con Arquitecto</li>
                <li class="flex gap-3"><span class="text-green-500 font-bold">✓</span> Diagnóstico preliminar</li>
                <li class="flex gap-3"><span class="text-green-500 font-bold">✓</span> Estimación de costos de obra</li>
            </ul>
        </div>

        <div class="bg-delsur-blue p-8 rounded-2xl shadow-xl shadow-blue-900/20 text-white relative overflow-hidden transform md:-translate-y-4">
            <div class="absolute top-0 right-0 bg-delsur-orange text-xs font-bold px-3 py-1 rounded-bl-lg">MÁS ELEGIDO</div>
            <h3 class="text-xl font-bold text-orange-100 mb-2">Pack Premium</h3>
            <div class="flex items-baseline gap-1 mb-6">
                <span class="text-4xl font-bold text-white">$4.500</span>
                <span class="text-blue-200">/ único</span>
            </div>
            <p class="text-sm text-blue-100 mb-6 min-h-[40px]">La solución completa. Asesoría experta + Herramientas de diseño para visualizar tu casa.</p>
            <a href="exito.php" class="block w-full py-4 rounded-xl bg-delsur-orange text-white font-bold text-center hover:bg-orange-600 transition-all shadow-lg shadow-orange-900/30 animate-pulse-fast">CONTRATAR AHORA</a>
            <p class="text-xs text-center text-blue-200 mt-2 mb-6">Pago seguro con Mercado Pago</p>
            <ul class="space-y-3 text-sm text-blue-50">
                <li class="flex gap-3"><span class="text-delsur-orange font-bold">✓</span> Videollamada de 45 min con Arquitecto</li>
                <li class="flex gap-3"><span class="text-delsur-orange font-bold">✓</span> <strong class="text-white">Licencia Planificador 2D</strong></li>
                <li class="flex gap-3"><span class="text-delsur-orange font-bold">✓</span> Prioridad en agenda de obra</li>
                <li class="flex gap-3"><span class="text-delsur-orange font-bold">✓</span> Descuento si contratás la obra</li>
            </ul>
        </div>
    </div>
    <div class="text-center mt-12 text-sm text-slate-500"><p>¿Tenés dudas antes de pagar? <a href="https://wa.me/5491123941812" target="_blank" class="text-delsur-orange hover:underline">Escribinos por WhatsApp</a></p></div>
  </main>

  <script>
    // PRELOADER 2 SEG
    window.addEventListener('load', () => {
        setTimeout(() => {
            const loader = document.getElementById('preloader');
            loader.classList.add('opacity-0', 'invisible');
        }, 2000);
    });

    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (href && !href.startsWith('#') && !href.startsWith('http') && link.target !== '_blank') {
                e.preventDefault();
                const loader = document.getElementById('preloader');
                loader.classList.remove('opacity-0', 'invisible');
                setTimeout(() => window.location.href = href, 400);
            }
        });
    });
  </script>
</body>
</html>