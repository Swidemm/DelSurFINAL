<!doctype html>
<html lang="es-AR" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Del Sur Construcciones — Diseñamos y Construimos tu Futuro</title>
  <meta name="description" content="Empresa constructora líder en AMBA. Obras llave en mano, refacciones integrales y arquitectura comercial. Pedí tu presupuesto." />
  <meta name="theme-color" content="#1e2952" />

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
              light: '#f8fafc'
            }
          },
          fontFamily: {
            sans: ['Inter', 'system-ui', 'sans-serif'],
            display: ['Montserrat', 'system-ui', 'sans-serif'],
          },
          boxShadow: {
            'card': '0 10px 30px -10px rgba(30, 41, 82, 0.15)',
            'glow': '0 0 20px rgba(249, 115, 22, 0.4)',
          },
          animation: {
            'pulse-fast': 'pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite',
          }
        }
      }
    };
  </script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="./css/styles.css" />

  <style>
    /* 1. ANIMACIÓN DE CARGA */
    @keyframes loading {
        0% { transform: translateX(-100%); }
        50% { transform: translateX(0); }
        100% { transform: translateX(100%); }
    }
    #preloader { transition: opacity 0.6s ease-out, visibility 0.6s; }

    /* 2. TEXTO BRILLANTE (SHINE) */
    @keyframes textShine {
        0% { background-position: 0% 50%; }
        100% { background-position: 200% 50%; }
    }
    .animate-text-shine {
        background-size: 200% auto;
        animation: textShine 4s linear infinite;
    }

    /* 3. FONDO VIENTO (WIND) */
    @keyframes windDrift {
        from { background-position: 0px 0px; }
        to { background-position: 1000px 500px; }
    }
    .animate-wind-pattern {
        animation: windDrift 120s linear infinite;
        will-change: background-position;
        transition: transform 0.1s ease-out; 
    }

    /* 4. UTILS */
    .reveal {
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
    }
    .reveal.active {
      opacity: 1;
      transform: translateY(0);
    }
    .delay-100 { transition-delay: 0.1s; }
    .delay-200 { transition-delay: 0.2s; }
    .delay-300 { transition-delay: 0.3s; }
    
    .glass-panel {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .accordion-content {
        display: grid;
        grid-template-rows: 0fr;
        transition: grid-template-rows 0.4s ease-out;
    }
    details[open] .accordion-content {
        grid-template-rows: 1fr;
    }
    .accordion-inner { overflow: hidden; }
    details > summary { list-style: none; }
    details > summary::-webkit-details-marker { display: none; }
  </style>
</head>

<body class="font-sans text-slate-700 bg-slate-50 antialiased selection:bg-delsur-orange selection:text-white">

  <div id="preloader" class="fixed inset-0 z-[100] bg-white flex items-center justify-center">
    <div class="flex flex-col items-center gap-6">
        <img src="./imagenes/logo.webp" alt="Cargando..." class="h-20 w-auto animate-pulse" />
        <div class="w-32 h-1.5 bg-slate-100 rounded-full overflow-hidden relative">
            <div class="h-full bg-delsur-orange w-full absolute top-0 left-0 animate-[loading_1.5s_infinite_linear]"></div>
        </div>
        <p class="text-xs text-slate-400 font-medium tracking-widest uppercase">Cargando Experiencia</p>
    </div>
  </div>

  <nav class="fixed w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-md border-b border-slate-200 shadow-sm" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-24">
        
        <a href="#inicio" class="flex-shrink-0 group">
          <img src="./imagenes/logo.webp" alt="Del Sur Construcciones" class="h-16 w-auto transition-transform duration-300 group-hover:scale-105" />
        </a>

        <div class="hidden md:flex items-center space-x-6">
          <a href="#servicios" class="text-sm font-medium text-slate-600 hover:text-delsur-blue transition-colors">Servicios</a>
          <a href="proceso.php" class="text-sm font-medium text-slate-600 hover:text-delsur-blue transition-colors">Cómo Trabajamos</a> <a href="pagos.php" class="text-sm font-medium text-slate-600 hover:text-delsur-blue transition-colors">Precios</a>
          
          <a href="planificador.php" class="text-sm font-bold text-delsur-blue hover:text-delsur-orange transition-colors flex items-center gap-1 px-3 py-2 rounded-lg hover:bg-slate-50 border border-transparent hover:border-slate-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            Acceso Clientes
          </a>

          <a href="#contacto" class="px-6 py-2.5 rounded-full bg-delsur-orange text-white font-semibold text-sm hover:bg-orange-600 hover:shadow-glow transition-all transform hover:-translate-y-0.5 shadow-lg shadow-orange-500/30">
            Presupuesto
          </a>
        </div>

        <div class="md:hidden flex items-center">
            <button id="mobileMenuBtn" class="text-slate-600 focus:outline-none p-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </div>
      </div>
    </div>
    <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-slate-100 absolute w-full shadow-xl">
        <div class="px-4 pt-2 pb-6 space-y-2">
            <a href="#servicios" class="block py-3 text-slate-600 font-medium border-b border-slate-50">Servicios</a>
            <a href="proceso.php" class="block py-3 text-slate-600 font-medium border-b border-slate-50">Cómo Trabajamos</a> <a href="pagos.php" class="block py-3 text-slate-600 font-medium border-b border-slate-50">Planes y Precios</a>
            <a href="planificador.php" class="block py-3 text-delsur-blue font-bold border-b border-slate-50 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Ingresar al Planificador
            </a>
            <a href="#contacto" class="block mt-4 text-center py-3 bg-delsur-orange text-white rounded-lg font-bold">Solicitar Presupuesto</a>
        </div>
    </div>
  </nav>

  <section id="inicio" class="relative h-screen flex items-center justify-center overflow-hidden">
    <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
      <source src="./videos/hero.mp4" type="video/mp4" />
    </video>
    <div class="absolute inset-0 bg-gradient-to-r from-delsur-blue/90 via-delsur-blue/70 to-delsur-blue/40"></div>
    
    <div id="hero-pattern" class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImEiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTTAgNDBMMDQgMEgwIiBmaWxsPSIjZmZmIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2EpIi8+PC9zdmc+')] animate-wind-pattern"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center md:text-left pt-20">
      <div class="reveal active">
          <span class="inline-block py-1 px-3 rounded-full bg-orange-500/20 border border-orange-400/30 text-orange-300 text-xs font-bold tracking-widest uppercase mb-4 backdrop-blur-sm">
            Construcción & Diseño
          </span>
          <h1 class="font-display text-5xl md:text-7xl font-extrabold text-white leading-tight mb-6 drop-shadow-lg">
            Hacemos realidad <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-yellow-200 to-orange-400 animate-text-shine">tu visión.</span>
          </h1>
          <p class="text-lg md:text-xl text-slate-200 mb-8 max-w-2xl font-light leading-relaxed">
            Especialistas en obras llave en mano y arquitectura comercial en AMBA. 
            Desde el primer boceto hasta la entrega de llaves.
          </p>
          
          <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
            <a href="#proyectos" class="px-8 py-4 rounded-xl bg-white text-delsur-blue font-bold hover:bg-slate-100 transition shadow-lg">
              Ver Galería
            </a>
            <a href="proceso.php" class="px-8 py-4 rounded-xl bg-delsur-orange text-white font-bold hover:bg-orange-600 transition shadow-lg hover:shadow-orange-500/40">
              ¿Cómo Trabajamos?
            </a>
          </div>

          <div class="mt-8 flex items-center justify-center md:justify-start gap-2 text-sm">
            <span class="text-slate-300">¿Ya tenés tu Pack Premium?</span>
            <a href="planificador.php" class="text-delsur-orange font-bold hover:text-white transition-colors flex items-center gap-1 border-b border-delsur-orange/50 hover:border-white">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Ingresá al Planificador acá
            </a>
          </div>
      </div>
    </div>
  </section>

  <div class="bg-delsur-dark border-b border-slate-800 text-white py-6">
    <div class="max-w-7xl mx-auto px-4 flex flex-wrap justify-center md:justify-between items-center gap-8 opacity-80 text-sm md:text-base font-medium">
        <div class="flex items-center gap-3">
            <span class="text-delsur-orange text-2xl">★</span> +10 Años de Experiencia
        </div>
        <div class="flex items-center gap-3">
            <span class="text-delsur-orange text-2xl">✓</span> +50 Proyectos Entregados
        </div>
        <div class="flex items-center gap-3">
            <span class="text-delsur-orange text-2xl">🛡</span> Garantía Escrita de Obra
        </div>
    </div>
  </div>

  <section id="servicios" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-3xl mx-auto mb-16 reveal">
        <h2 class="font-display text-3xl md:text-4xl font-bold text-delsur-blue mb-4">Soluciones Integrales</h2>
        <p class="text-slate-600 text-lg">No solo construimos paredes, creamos espacios funcionales donde la vida sucede.</p>
      </div>

      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-2xl shadow-card hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-100 reveal delay-100 group">
          <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-delsur-blue transition-colors">
            <svg class="w-8 h-8 text-delsur-blue group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
          </div>
          <h3 class="font-display text-xl font-bold text-delsur-blue mb-3">Viviendas Llave en Mano</h3>
          <p class="text-slate-600 leading-relaxed mb-4">Nos encargamos de todo: diseño, materiales, mano de obra y dirección. Vos solo te mudás.</p>
        </div>
        <div class="bg-white p-8 rounded-2xl shadow-card hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-100 reveal delay-200 group">
          <div class="w-14 h-14 bg-orange-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-delsur-orange transition-colors">
            <svg class="w-8 h-8 text-delsur-orange group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
          </div>
          <h3 class="font-display text-xl font-bold text-delsur-blue mb-3">Locales y Oficinas</h3>
          <p class="text-slate-600 leading-relaxed mb-4">Reformas comerciales rápidas y de alto impacto para potenciar tu marca y ventas.</p>
        </div>
        <div class="bg-white p-8 rounded-2xl shadow-card hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-100 reveal delay-300 group">
          <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-delsur-blue transition-colors">
            <svg class="w-8 h-8 text-delsur-blue group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
          </div>
          <h3 class="font-display text-xl font-bold text-delsur-blue mb-3">Refacciones y Diseño</h3>
          <p class="text-slate-600 leading-relaxed mb-4">Modernizamos tu casa actual. Cocinas, baños, quinchos y fachadas con diseño de vanguardia.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="proceso" class="py-24 bg-delsur-light border-y border-slate-200">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="reveal">
            <h2 class="font-display text-3xl md:text-4xl font-bold text-delsur-blue mb-6">Claridad ante todo</h2>
            <p class="text-slate-600 text-lg mb-10 max-w-2xl mx-auto">
                Sabemos que una obra puede generar incertidumbre. Por eso, diseñamos un método transparente de 5 pasos para que sepas qué pasa en cada momento.
            </p>
            
            <a href="proceso.php" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-delsur-orange font-bold rounded-xl shadow-lg border border-slate-100 hover:scale-105 transition-transform group">
                Ver el paso a paso interactivo
                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            
            <div class="mt-8 flex justify-center gap-8 opacity-50">
                <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                <span class="h-2 w-2 rounded-full bg-slate-300"></span>
            </div>
        </div>
    </div>
  </section>

  <section class="py-24 bg-gradient-to-br from-delsur-dark via-delsur-blue to-slate-900 text-white relative overflow-hidden">
     <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTAgNjBMMjAgNDBNNDAgMjBMNjAgME0wIDIwTDIwIDBNMjAgNjBMNDAgNDBNNDAgNjBMNjAgNDAiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIi8+PC9zdmc+')] opacity-20"></div>
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
         <div class="text-center max-w-3xl mx-auto mb-16 reveal">
             <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/10 border border-delsur-orange/30 text-delsur-orange text-xs font-bold uppercase tracking-wider mb-4">
                Comenzá con el pie derecho
             </div>
             <h2 class="font-display text-4xl md:text-5xl font-bold mb-6">Asesoría Profesional</h2>
             <p class="text-blue-100 text-lg">
                Antes de iniciar la obra, despejá todas tus dudas con un experto. Elegí el plan que mejor se adapte a tus necesidades.
             </p>
         </div>

         <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
             <div class="glass-panel p-8 rounded-2xl border-t border-white/10 reveal delay-100 hover:bg-white/5 transition-colors">
                 <h3 class="text-xl font-bold text-slate-300 mb-2">Asesoría General</h3>
                 <div class="flex items-baseline gap-2 mb-6">
                     <span class="text-4xl font-bold text-white">$3.500</span>
                 </div>
                 <p class="text-sm text-slate-400 mb-8 h-10">Ideal para consultas puntuales, viabilidad de terreno y estimación de costos.</p>
                 <ul class="space-y-4 mb-8 text-sm text-slate-300">
                     <li class="flex items-center gap-3"><svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>Reunión técnica 1 a 1</span></li>
                     <li class="flex items-center gap-3"><svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>Presupuesto estimado de obra</span></li>
                     <li class="flex items-center gap-3 opacity-50"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg><span class="line-through">Licencia de Software 2D</span></li>
                 </ul>
                 <a href="pagos.php" class="block w-full py-3 rounded-xl border border-white/20 text-center font-bold hover:bg-white hover:text-delsur-blue transition-all">Ver detalle</a>
             </div>
             <div class="glass-panel p-8 rounded-2xl border border-delsur-orange/50 bg-delsur-orange/5 reveal delay-200 relative transform hover:-translate-y-2 transition-transform">
                 <div class="absolute top-0 right-0 bg-delsur-orange text-white text-xs font-bold px-3 py-1 rounded-bl-lg">RECOMENDADO</div>
                 <h3 class="text-xl font-bold text-orange-300 mb-2">Pack Premium</h3>
                 <div class="flex items-baseline gap-2 mb-6">
                     <span class="text-4xl font-bold text-white">$4.500</span>
                 </div>
                 <p class="text-sm text-blue-100 mb-8 h-10">La experiencia completa: Asesoría experta + Herramientas de diseño.</p>
                 <ul class="space-y-4 mb-8 text-sm text-white">
                     <li class="flex items-center gap-3"><svg class="w-5 h-5 text-delsur-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>Todo lo incluido en Asesoría</span></li>
                     <li class="flex items-center gap-3"><svg class="w-5 h-5 text-delsur-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span class="font-bold">Licencia Planificador 2D</span></li>
                     <li class="flex items-center gap-3"><svg class="w-5 h-5 text-delsur-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>Prioridad en agenda</span></li>
                 </ul>
                 <a href="pagos.php" class="block w-full py-3 rounded-xl bg-delsur-orange text-white text-center font-bold hover:bg-orange-600 transition-all shadow-glow animate-pulse-fast">CONTRATAR PACK</a>
             </div>
         </div>
     </div>
  </section>

  <section id="proyectos" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-end mb-12 reveal">
        <div>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-delsur-blue">Nuestros Proyectos</h2>
            <p class="text-slate-500 mt-2 text-lg">La mejor carta de presentación es nuestra obra terminada.</p>
        </div>
        <a href="#" class="hidden md:inline-flex items-center text-delsur-orange font-semibold hover:underline">Ver todos los proyectos &rarr;</a>
      </div>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="group rounded-2xl overflow-hidden cursor-pointer reveal delay-100 relative shadow-md hover:shadow-xl transition-all">
          <div class="overflow-hidden h-72"><img src="./imagenes/proyectos/proyecto-1.webp" alt="Casa Moderna" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" /></div>
          <div class="absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/80 to-transparent text-white pt-20 translate-y-4 group-hover:translate-y-0 transition-transform"><h3 class="text-xl font-bold">Residencia Los Álamos</h3><p class="text-sm text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity delay-100">Obra llave en mano • 240m²</p></div>
        </div>
        <div class="group rounded-2xl overflow-hidden cursor-pointer reveal delay-200 relative shadow-md hover:shadow-xl transition-all">
          <div class="overflow-hidden h-72"><img src="./imagenes/proyectos/proyecto-2.webp" alt="Oficinas" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" /></div>
          <div class="absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/80 to-transparent text-white pt-20 translate-y-4 group-hover:translate-y-0 transition-transform"><h3 class="text-xl font-bold">Oficinas Tech Center</h3><p class="text-sm text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity delay-100">Remodelación Comercial • 500m²</p></div>
        </div>
        <div class="group rounded-2xl overflow-hidden cursor-pointer reveal delay-300 relative shadow-md hover:shadow-xl transition-all">
          <div class="overflow-hidden h-72"><img src="./imagenes/proyectos/proyecto-3.webp" alt="Reforma" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" /></div>
          <div class="absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/80 to-transparent text-white pt-20 translate-y-4 group-hover:translate-y-0 transition-transform"><h3 class="text-xl font-bold">Renovación Palermo</h3><p class="text-sm text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity delay-100">Diseño Interior y Fachada</p></div>
        </div>
      </div>
    </div>
  </section>

  <section id="faq" class="py-20 bg-white">
      <div class="max-w-4xl mx-auto px-4 reveal">
          <h2 class="font-display text-3xl font-bold text-delsur-blue mb-10 text-center">Preguntas Frecuentes</h2>
          <div class="space-y-4">
            <details class="group bg-slate-50 rounded-xl overflow-hidden shadow-sm transition-all duration-300 open:bg-white open:shadow-lg open:ring-1 open:ring-slate-200">
                <summary class="flex items-center justify-between p-6 cursor-pointer font-medium text-slate-700 group-hover:text-delsur-blue select-none">
                    ¿Cuánto tiempo demora una obra promedio?
                    <span class="transition-transform duration-300 group-open:rotate-180"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></span>
                </summary>
                <div class="accordion-content">
                    <div class="accordion-inner px-6 pb-6 text-slate-600 leading-relaxed border-t border-slate-100 pt-4">El tiempo depende de la complejidad. Una refacción de baño puede tomar 2-3 semanas, mientras que una vivienda llave en mano oscila entre 8 y 12 meses.</div>
                </div>
            </details>
            <details class="group bg-slate-50 rounded-xl overflow-hidden shadow-sm transition-all duration-300 open:bg-white open:shadow-lg open:ring-1 open:ring-slate-200">
                <summary class="flex items-center justify-between p-6 cursor-pointer font-medium text-slate-700 group-hover:text-delsur-blue select-none">
                    ¿Qué incluye el servicio "Llave en Mano"?
                    <span class="transition-transform duration-300 group-open:rotate-180"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></span>
                </summary>
                <div class="accordion-content">
                    <div class="accordion-inner px-6 pb-6 text-slate-600 leading-relaxed border-t border-slate-100 pt-4">Incluye absolutamente todo: diseño, trámites municipales, materiales, dirección de obra y mano de obra completa. Te entregamos la casa limpia y lista para habitar.</div>
                </div>
            </details>
          </div>
      </div>
  </section>

  <section id="contacto" class="py-24 bg-delsur-light relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-2 gap-12 items-start">
        <div class="reveal">
          <h2 class="font-display text-4xl font-bold text-delsur-blue mb-6">Hablemos de tu Proyecto</h2>
          <p class="text-slate-600 text-lg mb-8">Estamos listos para asesorarte. Completá el formulario o contactanos directamente.</p>
          <div class="space-y-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-delsur-orange"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
                <div><h4 class="font-bold text-delsur-blue">Teléfono / WhatsApp</h4><p class="text-slate-600">+54 9 11 2394-1812</p><a href="https://wa.me/5491123941812" class="text-delsur-orange text-sm font-semibold hover:underline">Enviar mensaje ahora</a></div>
            </div>
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-delsur-orange"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                <div><h4 class="font-bold text-delsur-blue">Email</h4><p class="text-slate-600">lauti.seid@gmail.com</p></div>
            </div>
          </div>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-xl reveal delay-200">
          <form id="contactForm" class="space-y-5">
            <input type="text" name="honeypot" style="display:none;" tabindex="-1" autocomplete="off">
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-700 mb-1" for="nombre">Nombre</label><input type="text" id="nombre" name="nombre" required class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 focus:ring-2 focus:ring-delsur-orange" placeholder="Tu nombre" /></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1" for="telefono">Teléfono</label><input type="tel" id="telefono" name="telefono" required class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 focus:ring-2 focus:ring-delsur-orange" placeholder="11 1234 5678" /></div>
            </div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1" for="email">Email</label><input type="email" id="email" name="email" required class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 focus:ring-2 focus:ring-delsur-orange" placeholder="tu@email.com" /></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1" for="mensaje">¿En qué podemos ayudarte?</label><textarea id="mensaje" name="mensaje" rows="4" required class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 focus:ring-2 focus:ring-delsur-orange" placeholder="Contanos brevemente sobre tu proyecto..."></textarea></div>
            <button type="submit" class="w-full rounded-xl bg-delsur-blue py-4 text-white font-bold text-lg hover:bg-slate-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">Enviar Mensaje</button>
            <p id="formMessage" class="text-center text-sm font-medium mt-2 min-h-[20px]"></p>
          </form>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-delsur-dark text-slate-400 text-sm border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-4 gap-8">
      <div class="col-span-1 md:col-span-2">
        <img src="./imagenes/logo.webp" alt="Del Sur Construcciones" class="h-12 w-auto mb-4 opacity-90" />
        <p class="max-w-xs text-slate-500">Compromiso, calidad y diseño en cada metro cuadrado.</p>
      </div>
      <div>
        <h3 class="font-bold text-white mb-4 uppercase tracking-wider text-xs">Navegación</h3>
        <ul class="space-y-2">
          <li><a href="#servicios" class="hover:text-delsur-orange transition-colors">Servicios</a></li>
          <li><a href="#proyectos" class="hover:text-delsur-orange transition-colors">Proyectos</a></li>
          <li><a href="pagos.php" class="hover:text-delsur-orange transition-colors">Medios de Pago</a></li>
        </ul>
      </div>
      <div>
        <h3 class="font-bold text-white mb-4 uppercase tracking-wider text-xs">Legal</h3>
        <ul class="space-y-2">
          <li><a href="#" class="hover:text-white transition-colors">Términos y condiciones</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Política de privacidad</a></li>
        </ul>
      </div>
    </div>
    <div class="border-t border-slate-800 py-6 text-center">
        <p>© <span id="year"></span> Del Sur Construcciones.</p>
    </div>
  </footer>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();

    // 1. PRELOADER (2 segundos)
    window.addEventListener('load', () => {
        setTimeout(() => {
            const loader = document.getElementById('preloader');
            loader.classList.add('opacity-0', 'invisible');
        }, 2000);
    });

    // 2. EFECTO PARALLAX
    const heroSection = document.getElementById('inicio');
    const heroPattern = document.getElementById('hero-pattern');
    if (heroSection && heroPattern) {
        heroSection.addEventListener('mousemove', (e) => {
            const x = (window.innerWidth - e.clientX * 2) / 90;
            const y = (window.innerHeight - e.clientY * 2) / 90;
            heroPattern.style.transform = `translateX(${x}px) translateY(${y}px)`;
        });
    }

    // 3. TRANSICIÓN DE PÁGINA
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (href && !href.startsWith('#') && !href.startsWith('mailto') && !href.startsWith('tel') && link.target !== '_blank') {
                e.preventDefault();
                const loader = document.getElementById('preloader');
                loader.classList.remove('opacity-0', 'invisible');
                setTimeout(() => window.location.href = href, 400); 
            }
        });
    });

    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileBtn.addEventListener('click', () => { mobileMenu.classList.toggle('hidden'); });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('active'); });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    const contactForm = document.getElementById('contactForm');
    const formMessage = document.getElementById('formMessage');
    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        formMessage.textContent = 'Enviando...';
        formMessage.className = 'text-center text-sm font-medium mt-2 text-slate-500';
        const data = new FormData(contactForm);
        const payload = {
            nombre: data.get('nombre'),
            email: data.get('email'),
            telefono: data.get('telefono'),
            mensaje: data.get('mensaje'),
            honeypot: data.get('honeypot')
        };
        try {
            const res = await fetch('api/contact.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload),
            });
            if (res.ok) {
                formMessage.textContent = '¡Mensaje enviado con éxito!';
                formMessage.className = 'text-center text-sm font-bold mt-2 text-green-600';
                contactForm.reset();
            } else { throw new Error('Error'); }
        } catch (err) {
            formMessage.textContent = 'Hubo un error. Por favor escribinos por WhatsApp.';
            formMessage.className = 'text-center text-sm font-bold mt-2 text-red-500';
        }
    });

    window.addEventListener('scroll', () => {
        const nav = document.getElementById('navbar');
        if (window.scrollY > 50) {
            nav.classList.add('shadow-md', 'bg-white/95');
            nav.classList.remove('bg-white/90');
        } else {
            nav.classList.remove('shadow-md', 'bg-white/95');
            nav.classList.add('bg-white/90');
        }
    });
  </script>
</body>
</html>