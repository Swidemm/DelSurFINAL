<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Elegí tu Plan — Del Sur Construcciones</title>
  <meta name="description" content="Elegí el plan de asesoría que mejor se adapte a tu proyecto." />
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            delsur: {
              blue: '#1e2952',
              dark: '#0f172a',
              orange: '#f97316',
              light: '#f1f5f9'
            }
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          animation: {
            'fade-in': 'fadeIn 0.5s ease-out forwards',
            'bounce-slow': 'bounce 3s infinite',
          },
          keyframes: {
            fadeIn: {
              '0%': { opacity: '0', transform: 'translateY(10px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' },
            }
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css"> 
</head>
<body class="bg-slate-50 text-slate-800 font-sans flex flex-col min-h-screen">

  <div id="redirectOverlay" class="fixed inset-0 bg-delsur-blue/95 z-50 hidden flex-col items-center justify-center text-center px-4 backdrop-blur-sm transition-opacity duration-500">
    <div class="mb-6 bg-green-500 rounded-full p-4 shadow-lg shadow-green-500/50 animate-bounce-slow">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
    </div>
    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 animate-fade-in">¡Excelente elección!</h2>
    <p class="text-xl text-blue-100 max-w-lg animate-fade-in" style="animation-delay: 0.2s;">
      Estamos procesando tu solicitud. <br>
      <span class="text-sm mt-4 block text-blue-300">Te estamos redirigiendo a Mercado Pago...</span>
    </p>
    <div class="mt-8">
        <div class="w-12 h-12 border-4 border-blue-200 border-t-delsur-orange rounded-full animate-spin mx-auto"></div>
    </div>
  </div>

  <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-40 border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <a href="index.php" class="flex-shrink-0 flex items-center gap-2">
          <img src="./imagenes/logo.webp" alt="Del Sur" class="h-16 w-auto transition-transform duration-300 hover:scale-105" />
        </a>
        <a href="index.php" class="text-sm font-medium text-slate-500 hover:text-delsur-blue transition">
          &larr; Volver al inicio
        </a>
      </div>
    </div>
  </nav>

  <main class="flex-grow py-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden flex flex-col items-center justify-center">
    <div class="absolute inset-0 bg-slate-50 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiNjY2MiIG9wYWNpdHk9IjAuMiIvPjwvc3ZnPg==')] opacity-50 pointer-events-none"></div>

    <div class="relative z-10 max-w-7xl w-full mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-3xl md:text-5xl font-bold text-delsur-blue mb-4">Invertí en certeza</h1>
            <p class="text-lg text-slate-600">Elegí la opción que mejor se adapte a la etapa de tu proyecto. Ambos planes incluyen garantía de satisfacción.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto items-center">
            
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8 relative overflow-hidden transition-transform hover:-translate-y-1">
                <h3 class="text-xl font-bold text-slate-500 uppercase tracking-wider mb-2">Asesoría General</h3>
                <div class="flex items-baseline gap-2 mb-6">
                    <span class="text-4xl font-extrabold text-delsur-blue">$3.500</span>
                    <span class="text-slate-400">ARS</span>
                </div>
                <p class="text-slate-600 mb-6 text-sm leading-relaxed">Ideal si solo necesitás despejar dudas técnicas, costos y viabilidad antes de empezar.</p>
                
                <ul class="space-y-4 mb-8 text-sm text-slate-700">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Reunión 1 a 1 con Arquitecto</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Análisis de viabilidad y terreno</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Estimación de presupuesto de obra</span>
                    </li>
                    <li class="flex items-start gap-3 opacity-40">
                        <svg class="w-5 h-5 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span class="line-through">Licencia Planificador 2D</span>
                    </li>
                </ul>

                <button onclick="procesarPago('basic')" class="w-full py-4 rounded-xl border-2 border-delsur-blue text-delsur-blue font-bold hover:bg-blue-50 transition-colors">
                    Elegir Asesoría
                </button>
            </div>

            <div class="bg-delsur-blue rounded-2xl shadow-2xl border border-delsur-blue p-8 relative overflow-hidden transform md:scale-105 z-10">
                <div class="absolute top-0 right-0 bg-delsur-orange text-white text-xs font-bold px-3 py-1 rounded-bl-lg uppercase tracking-wider">
                    Más Elegido
                </div>

                <h3 class="text-xl font-bold text-orange-200 uppercase tracking-wider mb-2">Pack Premium</h3>
                <div class="flex items-baseline gap-2 mb-6">
                    <span class="text-5xl font-extrabold text-white">$4.500</span>
                    <span class="text-blue-200">ARS</span>
                </div>
                <p class="text-blue-100 mb-6 text-sm leading-relaxed">La solución completa. Asesoramiento experto + herramientas de diseño para que visualices tu idea.</p>
                
                <ul class="space-y-4 mb-8 text-sm text-white">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-delsur-orange flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span><strong>Todo lo de la Asesoría General</strong></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-delsur-orange flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="font-bold text-delsur-orange">Licencia Planificador 2D (Acceso ilimitado)</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-delsur-orange flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Exportación de planos</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-delsur-orange flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Prioridad en agenda</span>
                    </li>
                </ul>

                <button onclick="procesarPago('premium')" class="group w-full py-4 bg-delsur-orange hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                    <span>CONTRATAR PACK</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </button>
            </div>

        </div>

        <div class="mt-12 text-center">
            <div class="flex justify-center items-center gap-4 mb-4">
                <img src="https://logotipoz.com/wp-content/uploads/2021/10/version-horizontal-large-logo-mercado-pago.webp" alt="Mercado Pago" class="h-6 object-contain grayscale opacity-60">
            </div>
            <p class="text-xs text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Tus pagos están protegidos por tecnología SSL de Mercado Pago. Aceptamos Tarjetas y Dinero en cuenta.
            </p>
        </div>
    </div>
  </main>

  <footer class="bg-white border-t border-slate-200 py-6 text-center text-slate-400 text-sm">
    <p>© <span id="year"></span> Del Sur Construcciones. Todos los derechos reservados.</p>
  </footer>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();

    const overlay = document.getElementById('redirectOverlay');
    
    // ==========================================
    // CONFIGURACIÓN DE LINKS (¡CAMBIAR ACÁ!)
    // ==========================================
    const links = {
        basic: 'https://mpago.la/2AUARcL',     // Link de $3.500
        premium: '#LINK_PREMIUM_AQUI'          // <-- PEGAR ACÁ EL LINK DE $4.500
    };

    function procesarPago(plan) {
        // 1. Mostrar el overlay
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        
        // 2. Esperar 3.5 segundos y redirigir
        setTimeout(() => {
            if(links[plan] && links[plan] !== '#LINK_PREMIUM_AQUI') {
                window.location.href = links[plan];
            } else {
                alert("¡Atención! El link de pago Premium aún no ha sido configurado en el código.");
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
            }
        }, 3000);
    }
  </script>
</body>
</html>l