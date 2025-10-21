<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Del Sur Construcciones — Obras llave en mano, refacciones y diseño</title>
  <meta name="description" content="Del Sur Construcciones: viviendas, locales y obras comerciales en el AMBA. Proyectos, dirección y ejecución. Pedí tu presupuesto sin cargo." />
  <meta name="theme-color" content="#0f4c5c" />

  <!-- Open Graph -->
  <meta property="og:type" content="website" />
  <meta property="og:title" content="Del Sur Construcciones" />
  <meta property="og:description" content="Obras llave en mano, refacciones y diseño. Pedí tu presupuesto sin cargo." />
  <meta property="og:image" content="./images/og-cover.webp" />
  <meta property="og:url" content="https://delsurconstrucciones.example/" />

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="Del Sur Construcciones" />
  <meta name="twitter:description" content="Obras llave en mano, refacciones y diseño." />
  <meta name="twitter:image" content="./images/og-cover.webp" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config = { theme: { extend: {
    colors: {
      brand: {
        50:'#e6f0f2',100:'#cfe2e6',200:'#9fc4cd',300:'#6ea6b3',400:'#3e889a',500:'#0f6a81',600:'#0d5a6d',700:'#0b4a59',800:'#083945',900:'#062f3a'
      },
      accent: {  // Rojo del logo para highlights/botones
        50:'#fef2f2',100:'#fee2e2',200:'#fecaca',300:'#fca5a5',400:'#f87171',500:'#ef4444',600:'#dc2626',700:'#b91c1c',800:'#991b1b',900:'#7f1d1d'
      },
      neutral: {  // Neutros para fondos/textos
        50: '#f8fafc',100: '#f1f5f9',200: '#e2e8f0',300: '#cbd5e1',400: '#94a3b8',500: '#64748b',600: '#475569',700: '#334155',800: '#1e293b',900: '#0f172a'
      }
    },
    fontFamily:{ sans:['Inter', 'system-ui', 'Roboto', 'Helvetica', 'Arial', 'sans-serif'] }
  }}};</script>

  <link rel="icon" href="./favicon/favicon.ico" />
  <link rel="manifest" href="./favicon/site.webmanifest" />
  <!-- External stylesheet for custom styles -->
  <link rel="stylesheet" href="./css/styles.css" />

  <style>
    /* Welcome Splash styles */
    #welcome-splash {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, var(--brand-50) 0%, var(--neutral-50) 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      z-index: 9999;
      transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
      text-align: center;
      padding: 2rem;
    }
    #welcome-splash.hidden {
      opacity: 0;
      visibility: hidden;
    }
    .splash-logo {
      width: 140px;
      height: 140px;
      margin-bottom: 2rem;
      animation: fadeIn 1s ease-out;
    }
    .splash-drawing {
      width: 200px;
      height: 200px;
      margin-bottom: 2rem;
    }
    .splash-drawing path {
      stroke-dasharray: 1000;
      stroke-dashoffset: 1000;
      animation: drawLines 5s linear forwards;
    }
    .splash-title {
      font-size: 2rem;
      font-weight: 700;
      color: var(--brand-700);
      margin-bottom: 1rem;
      animation: fadeInUp 0.8s ease-out 4.5s both;  /* Aparece al final de la anim */
    }
    .skip-btn {
      position: absolute;
      top: 1rem;
      right: 1rem;
      background: rgba(239, 68, 68, 0.1);
      border: 1px solid var(--accent-500);
      color: var(--accent-500);
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      font-size: 0.875rem;
      cursor: pointer;
      transition: background 0.2s, color 0.2s;
    }
    .skip-btn:hover {
      background: var(--accent-500);
      color: white;
    }
    @keyframes drawLines {
      to { stroke-dashoffset: 0; }
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>

</head>
<body class="font-sans text-neutral-800">
  <!-- Welcome Splash -->
  <div id="welcome-splash">
    <button class="skip-btn" onclick="skipWelcome()">Saltar</button>
    <svg class="splash-drawing" viewBox="0 0 200 200" fill="none" stroke="var(--brand-700)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <!-- Simple house blueprint animation: lines drawing -->
      <path d="M50 150 L50 50 L150 50 L150 150 L50 150" />  <!-- Walls -->
      <path d="M50 50 L100 10 L150 50" />  <!-- Roof -->
      <path d="M100 150 L100 50" />  <!-- Door line -->
      <path d="M75 100 L75 130 L125 130 L125 100" />  <!-- Window -->
    </svg>
    <h1 class="splash-title">Del Sur Construcciones</h1>
  </div>

  <!-- Barra superior -->
  <div class="bg-brand-900 text-white text-sm">
    <div class="max-w-7xl mx-auto px-3 py-2 flex items-center justify-between">
      <p>Atendemos AMBA · Lun–Vie 9–18 h</p>
      <a href="https://wa.me/5491123941812" class="underline hover:no-underline">WhatsApp: +54 9 11 2394-1812</a>
    </div>
  </div>

  <!-- Header sticky -->
  <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-neutral-200">
    <div class="max-w-7xl mx-auto px-3 py-3 flex items-center gap-4">
      <a href="#inicio" class="flex items-center gap-3 mr-auto">
        <img src="./images/logo.webp" alt="Del Sur Construcciones" class="h-14 w-auto logo-slide" />
        <span class="sr-only">Del Sur Construcciones</span>
      </a>
      <nav class="hidden md:flex gap-6 text-neutral-700 nav-drop">
        <a class="hover:text-brand-700 focus-ring" href="#servicios">Servicios</a>
        <a class="hover:text-brand-700 focus-ring" href="#proyectos">Proyectos</a>
        <a class="hover:text-brand-700 focus-ring" href="#proceso">Proceso</a>
        <a class="hover:text-brand-700 focus-ring" href="#faq">Preguntas</a>
        <!-- Enlaces a secciones adicionales -->
        <a class="hover:text-brand-700 focus-ring" href="pages/planificador.php">Planificador</a>
        <a class="hover:text-brand-700 focus-ring" href="pages/pagos.php">Pagos</a>
        <a class="hover:text-brand-700 focus-ring" href="#contacto">Contacto</a>
      </nav>
      <a href="#contacto" class="ml-4 inline-flex items-center rounded-xl bg-brand-700 px-4 py-2 text-white hover:bg-brand-600 focus-ring btn-anim nav-drop">Solicitar presupuesto</a>
    </div>
  </header>

  <!-- Hero -->
  <section id="inicio" class="relative isolate">
    <video autoplay muted loop playsinline class="absolute inset-0 -z-10 h-full w-full object-cover">
      <source src="./videos/hero.mp4" type="video/mp4" />
    </video>
    <!-- Blueprint overlay with subtle architectural lines -->
    <div class="absolute inset-0 arch-overlay"></div>
    <!-- Dark overlay for contrast (más oscuro: brand-900/70) -->
    <div class="absolute inset-0 -z-10 bg-brand-900/70"></div>
    <div class="max-w-7xl mx-auto px-3 py-24 md:py-36 text-white">
      <h1 class="text-4xl md:text-6xl font-bold leading-tight">Obras llave en mano, refacciones y diseño</h1>
      <p class="mt-4 max-w-2xl text-lg md:text-xl text-neutral-100">Viviendas, locales y espacios comerciales. Dirección técnica, ejecución y entrega en tiempo y forma.</p>
      <div class="mt-8 flex gap-3">
        <a href="#proyectos" class="rounded-xl bg-white/10 px-5 py-3 hover:bg-white/20 focus-ring btn-anim">Ver proyectos</a>
        <a href="https://wa.me/5491123941812" class="rounded-xl bg-brand-500 px-5 py-3 hover:bg-brand-400 focus-ring btn-anim">Hablar por WhatsApp</a>
      </div>
    </div>
  </section>

  <!-- Servicios -->
  <section id="servicios" class="py-16 bg-brand-50">
    <div class="max-w-7xl mx-auto px-3">
      <h2 class="text-3xl font-semibold">Servicios</h2>
      <p class="text-neutral-600 mt-2">Acompañamos todo el ciclo: anteproyecto, obra y posventa.</p>
      <div class="mt-8 grid md:grid-cols-3 gap-6">
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-neutral-200">
          <h3 class="text-xl font-medium mb-2">Viviendas</h3>
          <ul class="list-disc list-inside text-neutral-600 space-y-1">
            <li>Llave en mano</li>
            <li>Ampliaciones y refacciones</li>
            <li>Diseño interior</li>
          </ul>
        </div>
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-neutral-200">
          <h3 class="text-xl font-medium mb-2">Locales y oficinas</h3>
          <ul class="list-disc list-inside text-neutral-600 space-y-1">
            <li>Adecuación comercial</li>
            <li>Instalaciones técnicas</li>
            <li>Entrega rápida</li>
          </ul>
        </div>
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-neutral-200">
          <h3 class="text-xl font-medium mb-2">Mantenimiento</h3>
          <p class="text-neutral-600">Mantenimiento preventivo y correctivo para obras terminadas.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Proyectos -->
  <section id="proyectos" class="py-16">
    <div class="max-w-7xl mx-auto px-3">
      <h2 class="text-3xl font-semibold mb-4">Proyectos</h2>
      <p class="text-neutral-600 mb-8">Algunos de nuestros trabajos recientes en el AMBA. Cada proyecto es único, con enfoque en calidad y plazos.</p>
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Proyecto 1 -->
        <div class="group relative overflow-hidden rounded-2xl bg-white shadow-sm hover:shadow-lg transition-shadow border border-neutral-200">
          <img src="./images/proyecto-1.webp" alt="Casa en Palermo" class="w-full h-48 object-cover group-hover:scale-105 transition-transform" />
          <div class="p-6">
            <h3 class="text-xl font-medium mb-2">Casa en Palermo</h3>
            <p class="text-neutral-600 mb-4">Ampliación llave en mano de 120m², con diseño interior integrado. Entrega en 4 meses.</p>
            <a href="#" class="inline-flex items-center text-brand-700 hover:text-brand-500 font-medium">Ver detalles →</a>
          </div>
        </div>
        <!-- Proyecto 2 -->
        <div class="group relative overflow-hidden rounded-2xl bg-white shadow-sm hover:shadow-lg transition-shadow border border-neutral-200">
          <img src="./images/proyecto-2.webp" alt="Local en Recoleta" class="w-full h-48 object-cover group-hover:scale-105 transition-transform" />
          <div class="p-6">
            <h3 class="text-xl font-medium mb-2">Local en Recoleta</h3>
            <p class="text-neutral-600 mb-4">Adecuación comercial de 80m², instalaciones eléctricas y plomería. Listo en 6 semanas.</p>
            <a href="#" class="inline-flex items-center text-brand-700 hover:text-brand-500 font-medium">Ver detalles →</a>
          </div>
        </div>
        <!-- Proyecto 3 -->
        <div class="group relative overflow-hidden rounded-2xl bg-white shadow-sm hover:shadow-lg transition-shadow border border-neutral-200">
          <img src="./images/proyecto-3.webp" alt="Oficina en Belgrano" class="w-full h-48 object-cover group-hover:scale-105 transition-transform" />
          <div class="p-6">
            <h3 class="text-xl font-medium mb-2">Oficina en Belgrano</h3>
            <p class="text-neutral-600 mb-4">Reforma integral de 200m², con foco en sostenibilidad y eficiencia energética.</p>
            <a href="#" class="inline-flex items-center text-brand-700 hover:text-brand-500 font-medium">Ver detalles →</a>
          </div>
        </div>
        <!-- Proyecto 4 -->
        <div class="group relative overflow-hidden rounded-2xl bg-white shadow-sm hover:shadow-lg transition-shadow border border-neutral-200 lg:col-span-2">
          <img src="./images/proyecto-4.webp" alt="Vivienda en Caballito" class="w-full h-48 object-cover group-hover:scale-105 transition-transform" />
          <div class="p-6">
            <h3 class="text-xl font-medium mb-2">Vivienda en Caballito</h3>
            <p class="text-neutral-600 mb-4">Construcción nueva de 150m², jardín integrado y materiales ecológicos.</p>
            <a href="#" class="inline-flex items-center text-brand-700 hover:text-brand-500 font-medium">Ver detalles →</a>
          </div>
        </div>
      </div>
      <div class="mt-8 text-center">
        <a href="https://wa.me/5491123941812" class="inline-flex items-center rounded-xl bg-brand-700 px-6 py-3 text-white hover:bg-brand-600 focus-ring btn-anim">Ver todos los proyectos</a>
      </div>
    </div>
  </section>

  <!-- Proceso -->
  <section id="proceso" class="py-16 bg-brand-50">
    <div class="max-w-7xl mx-auto px-3">
      <h2 class="text-3xl font-semibold mb-4">Nuestro proceso</h2>
      <p class="text-neutral-600 mb-8">De la idea al llave en mano: un flujo claro y transparente para tu tranquilidad.</p>
      <div class="grid md:grid-cols-4 gap-6">
        <!-- Step 1 -->
        <div class="text-center">
          <div class="mx-auto w-16 h-16 rounded-full bg-accent-500 text-white flex items-center justify-center text-2xl font-bold mb-4">1</div>
          <h3 class="text-xl font-medium mb-2">Anteproyecto</h3>
          <p class="text-neutral-600">Escuchamos tu visión, levantamos planos iniciales y definimos el scope. Gratuito y sin compromiso.</p>
        </div>
        <!-- Step 2 -->
        <div class="text-center">
          <div class="mx-auto w-16 h-16 rounded-full bg-accent-500 text-white flex items-center justify-center text-2xl font-bold mb-4">2</div>
          <h3 class="text-xl font-medium mb-2">Presupuesto</h3>
          <p class="text-neutral-600">Cotización detallada con materiales, plazos y costos. Ajustes hasta que quede perfecto.</p>
        </div>
        <!-- Step 3 -->
        <div class="text-center">
          <div class="mx-auto w-16 h-16 rounded-full bg-accent-500 text-white flex items-center justify-center text-2xl font-bold mb-4">3</div>
          <h3 class="text-xl font-medium mb-2">Ejecución</h3>
          <p class="text-neutral-600">Dirección técnica diaria, equipo calificado y avances semanales. Sin sorpresas.</p>
        </div>
        <!-- Step 4 -->
        <div class="text-center">
          <div class="mx-auto w-16 h-16 rounded-full bg-accent-500 text-white flex items-center justify-center text-2xl font-bold mb-4">4</div>
          <h3 class="text-xl font-medium mb-2">Entrega</h3>
          <p class="text-neutral-600">Inspección final, documentación y garantía. Tu obra lista para disfrutar.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section id="faq" class="py-16">
    <div class="max-w-7xl mx-auto px-3">
      <h2 class="text-3xl font-semibold">Preguntas frecuentes</h2>
      <dl id="faq-list" class="mt-8 space-y-4">
        <!-- Ejemplo; agregá las tuyas -->
        <details class="bg-white rounded-2xl p-6 shadow-sm border border-neutral-200">
          <summary class="cursor-pointer font-medium flex items-center justify-between">
            ¿Cuánto tiempo tarda una obra?
            <span>＋</span>
          </summary>
          <div class="faq-answer mt-4 text-neutral-600">
            Depende del proyecto, pero típicamente 3-6 meses.
          </div>
        </details>
      </dl>
    </div>
  </section>

  <!-- Contacto -->
  <section id="contacto" class="py-16 bg-brand-50">
    <div class="max-w-7xl mx-auto px-3">
      <div class="grid md:grid-cols-2 gap-8">
        <div>
          <h3 class="text-xl font-medium mb-2">Visítanos o contáctanos</h3>
          <p class="text-neutral-600">Estamos en Buenos Aires (AMBA). Atendemos lunes a viernes de 9 a 18 h.</p>
          <p class="mt-2"><strong>Teléfono:</strong> +54 9 11 2394-1812</p>
          <p><strong>Email:</strong> lauti.seid@gmail.com</p>
          <p><strong>Dirección:</strong> Calle Falsa 123, Buenos Aires</p>
          <div class="mt-4">
            <a href="https://wa.me/5491123941812" class="inline-flex items-center rounded-xl bg-brand-600 px-5 py-3 text-white hover:bg-brand-500 focus-ring btn-anim">Hablar por WhatsApp</a>
          </div>
        </div>
        <form id="contactForm" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-neutral-700" for="nombre">Nombre y apellido</label>
            <input type="text" id="nombre" name="nombre" required class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-500" />
          </div>
          <div>
            <label class="block text-sm font-medium text-neutral-700" for="email">Email</label>
            <input type="email" id="email" name="email" required class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-500" />
          </div>
          <div>
            <label class="block text-sm font-medium text-neutral-700" for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="telefono" required class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-500" />
          </div>
          <div>
            <label class="block text-sm font-medium text-neutral-700" for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="mensaje" rows="4" required class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-500"></textarea>
          </div>
          <button type="submit" class="rounded-xl bg-brand-700 px-5 py-3 text-white hover:bg-brand-600 focus-ring btn-anim">Enviar</button>
          <p id="formMessage" class="text-sm mt-2"></p>
        </form>
      </div>
      <!-- Google Map embed (placeholder coordinates, replace with actual) -->
      <div class="mt-12">
        <iframe class="w-full h-64 border-0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13126.492675264348!2d-58.381592!3d-34.603684!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bccb2d72152cdb%3A0x0!2sBuenos+Aires!5e0!3m2!1ses-419!2sar!4v1670000000000!5m2!1ses-419!2sar" allowfullscreen="" loading="lazy"></iframe>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-neutral-900 text-neutral-400 text-sm">
    <div class="max-w-7xl mx-auto px-3 py-10 grid md:grid-cols-3 gap-8">
      <div>
        <img src="./images/logo.webp" alt="Del Sur Construcciones" class="h-12 w-auto mb-3" />
        <p>© <span id="year"><?php echo date('Y'); ?></span> Del Sur Construcciones. Todos los derechos reservados.</p>
      </div>
      <div>
        <h3 class="font-semibold text-white mb-2">Secciones</h3>
        <ul class="space-y-1">
          <li><a href="#servicios" class="hover:text-white">Servicios</a></li>
          <li><a href="#proyectos" class="hover:text-white">Proyectos</a></li>
          <li><a href="#proceso" class="hover:text-white">Proceso</a></li>
          <li><a href="#faq" class="hover:text-white">Preguntas</a></li>
          <!-- Enlace a la nueva página del planificador en el pie -->
          <li><a href="pages/planificador.php" class="hover:text-white">Planificador</a></li>
          <li><a href="pages/pagos.php" class="hover:text-white">Pagos</a></li>
          <li><a href="#contacto" class="hover:text-white">Contacto</a></li>
        </ul>
      </div>
      <div>
        <h3 class="font-semibold text-white mb-2">Contacto</h3>
        <p>WhatsApp: +54 9 11 2394-1812</p>
        <p>Email: lauti.seid@gmail.com</p>
      </div>
    </div>
  </footer>

  <!-- External JS -->
  <script src="./scripts/scripts.js"></script>

  <script>
    function skipWelcome() {
      document.getElementById('welcome-splash').classList.add('hidden');
    }
    // Auto-hide after 5s
    setTimeout(skipWelcome, 5000);
  </script>
</body>
</html>