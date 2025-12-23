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
    </div>
  </div>

  <nav class="bg-white border-b border-slate-200 py-4 sticky top-0 z-40 shadow-sm">
    <div class="max-w-5xl mx-auto px-4 flex justify-between items-center">
        <a href="index.php" class="flex-shrink-0">
            <img src="./imagenes/logo.webp" alt="Del Sur" class="h-10 w-auto" />
        </a>
        <a href="index.php" class="text-sm font-bold text-slate-500 hover:text-delsur-blue flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver
        </a>
    </div>
  </nav>

  <main class="flex-grow max-w-5xl mx-auto px-4 py-12 w-full">
    <div class="text-center max-w-2xl mx-auto mb-12">
        <h1 class="text-3xl md:text-4xl font-bold text-delsur-blue mb-4">Inversión Transparente</h1>
        <p class="text-slate-600">Elegí cómo querés comenzar tu proyecto. Sin letras chicas ni costos ocultos.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-8 items-start">
        
        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all relative overflow-hidden group">
            <h3 class="text-xl font-bold text-slate-700 mb-2">Asesoría General</h3>
            <div class="flex items-baseline gap-1 my-4">
                <span class="text-4xl font-bold text-delsur-blue">$3.500</span>
                <span class="text-slate-400 text-sm">/ única vez</span>
            </div>
            <p class="text-sm text-slate-500 mb-8 pb-8 border-b border-slate-100">
                Ideal si tenés el terreno y querés saber qué se puede construir y cuánto va a costar realmente.
            </p>
            
            <a href="https://www.youtube.com/shorts/PTUKD9vGH-U" class="block w-full py-3 rounded-xl border-2 border-slate-200 text-slate-600 font-bold text-center hover:border-delsur-blue hover:text-delsur-blue transition-all mb-8">
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

            <a href="https://www.youtube.com/shorts/PTUKD9vGH-U" class="block w-full py-4 rounded-xl bg-delsur-orange text-white font-bold text-center hover:bg-orange-600 hover:shadow-lg hover:shadow-orange-500/50 transition-all mb-8 relative overflow-hidden group">
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
            // Ignoramos el click si es el placeholder de MP o javascript
            if (href && href.startsWith('mpago://')) return;

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