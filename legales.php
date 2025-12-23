<!doctype html>
<html lang="es-AR" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Términos Legales — Del Sur Construcciones</title>
  <meta name="robots" content="noindex, nofollow" /> <meta name="theme-color" content="#1e2952" />

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
          }
        }
      }
    };
  </script>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
  
  <style>
      /* Estilos básicos de tipografía legal */
      .prose h3 { color: #1e2952; font-weight: 700; margin-top: 2rem; margin-bottom: 0.5rem; font-size: 1.25rem; }
      .prose p { margin-bottom: 1rem; color: #475569; line-height: 1.6; font-size: 0.95rem; }
      .prose ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; color: #475569; }
      .prose li { margin-bottom: 0.5rem; }
      .prose strong { color: #0f172a; font-weight: 600; }
  </style>
</head>

<body class="bg-slate-50 font-sans text-slate-700 antialiased flex flex-col min-h-screen">

  <nav class="bg-white border-b border-slate-200 py-4 sticky top-0 z-40">
    <div class="max-w-5xl mx-auto px-4 flex justify-between items-center">
        <a href="index.php" class="flex-shrink-0">
            <img src="./imagenes/logo.webp" alt="Del Sur" class="h-10 w-auto" />
        </a>
        <a href="index.php" class="text-sm font-bold text-slate-500 hover:text-delsur-blue flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver al Inicio
        </a>
    </div>
  </nav>

  <header class="bg-delsur-blue text-white py-12">
      <div class="max-w-4xl mx-auto px-4 text-center">
          <h1 class="font-display text-3xl md:text-4xl font-bold mb-4">Información Legal</h1>
          <p class="text-slate-300">Última actualización: <?php echo date("d/m/Y"); ?></p>
      </div>
  </header>

  <main class="flex-grow max-w-4xl mx-auto px-4 py-12 w-full">
      
      <div class="flex flex-col sm:flex-row gap-4 mb-12 border-b border-slate-200 pb-4">
          <a href="#terminos" class="text-delsur-orange font-bold border-b-2 border-delsur-orange pb-2">Términos y Condiciones</a>
          <a href="#privacidad" class="text-slate-500 hover:text-delsur-blue font-medium transition-colors">Política de Privacidad</a>
      </div>

      <section id="terminos" class="bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-slate-100 mb-12 prose">
          <h2 class="font-display text-2xl font-bold text-delsur-blue mb-6 border-b border-slate-100 pb-4">Términos y Condiciones de Uso</h2>
          
          <p>Bienvenido a Del Sur Construcciones. Al acceder a nuestro sitio web, utilizar nuestro "Planificador 2D" o contratar nuestros servicios de asesoría, usted acepta cumplir con los siguientes términos y condiciones. Si no está de acuerdo, le solicitamos que no utilice nuestros servicios.</p>

          <h3>1. Servicios Ofrecidos</h3>
          <p>Del Sur Construcciones ofrece servicios de arquitectura, construcción y herramientas digitales. Los servicios digitales incluyen, pero no se limitan a:</p>
          <ul>
              <li><strong>Asesoría General:</strong> Reunión técnica consultiva.</li>
              <li><strong>Pack Premium:</strong> Acceso a software de planificación visual y asesoría prioritaria.</li>
          </ul>

          <h3>2. Política de Pagos y Reembolsos (IMPORTANTE)</h3>
          <p>Todos los pagos realizados a través de la plataforma son <strong>definitivos y no reembolsables</strong>. Al adquirir el "Pack Premium" o la "Asesoría General", el usuario reconoce que:</p>
          <ul>
              <li>Está adquiriendo un servicio digital o de consultoría de ejecución inmediata o agendada.</li>
              <li>Al recibir las credenciales de acceso al software o al bloquearse un horario en nuestra agenda, el servicio se considera entregado o iniciado.</li>
              <li><strong>No se admiten devoluciones</strong> por arrepentimiento, errores en la compra por parte del usuario, o falta de uso de la herramienta.</li>
              <li>En caso de fuerza mayor por parte de Del Sur Construcciones que impida brindar la asesoría, se ofrecerá una reprogramación, pero no un reembolso monetario.</li>
          </ul>

          <h3>3. Uso del Planificador 2D</h3>
          <p>La herramienta "Planificador Studio 2D" se provee con fines exclusivamente <strong>ilustrativos y recreativos</strong>.</p>
          <ul>
              <li>Los planos generados son esquemáticos y <strong>no constituyen documentación técnica válida</strong> para presentaciones municipales, obras civiles ni trámites legales.</li>
              <li>Del Sur Construcciones <strong>no se hace responsable</strong> por errores de construcción, cálculo estructural o diferencias de medidas derivados del uso exclusivo de esta herramienta sin la supervisión de un profesional matriculado en obra.</li>
              <li>El usuario es responsable de verificar las medidas reales en sitio.</li>
          </ul>

          <h3>4. Propiedad Intelectual</h3>
          <p>Todo el contenido de este sitio, incluyendo el código fuente del planificador, logotipos, textos, imágenes y videos, es propiedad exclusiva de Del Sur Construcciones. Está prohibida su reproducción, distribución o ingeniería inversa sin autorización expresa.</p>

          <h3>5. Limitación de Responsabilidad</h3>
          <p>Del Sur Construcciones no será responsable por daños directos, indirectos, incidentales o consecuentes que resulten del uso o la imposibilidad de uso de nuestros servicios digitales. No garantizamos que el sitio web esté libre de errores o interrupciones, aunque trabajamos para mantener la máxima calidad.</p>
      </section>

      <section id="privacidad" class="bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-slate-100 prose">
          <h2 class="font-display text-2xl font-bold text-delsur-blue mb-6 border-b border-slate-100 pb-4">Política de Privacidad</h2>
          
          <p>En Del Sur Construcciones, valoramos su privacidad. Esta política detalla cómo recopilamos y protegemos su información.</p>

          <h3>1. Información que Recopilamos</h3>
          <p>Podemos recopilar información personal como su nombre, dirección de correo electrónico, número de teléfono y detalles del proyecto cuando usted:</p>
          <ul>
              <li>Completa formularios de contacto.</li>
              <li>Realiza una compra o pago.</li>
              <li>Utiliza nuestro Planificador 2D (guardamos los diseños asociados a su usuario).</li>
          </ul>

          <h3>2. Uso de la Información</h3>
          <p>Utilizamos sus datos exclusivamente para:</p>
          <ul>
              <li>Procesar sus pedidos y gestionar su acceso a los servicios Premium.</li>
              <li>Contactarlo vía WhatsApp o Email para coordinar reuniones o enviar presupuestos.</li>
              <li>Mejorar nuestros servicios y sitio web.</li>
          </ul>
          <p><strong>No vendemos ni compartimos sus datos con terceros</strong> con fines comerciales ajenos a nuestra operación.</p>

          <h3>3. Seguridad de los Datos</h3>
          <p>Implementamos medidas de seguridad estándar para proteger su información. Sin embargo, ninguna transmisión por Internet es 100% segura. El usuario asume el riesgo inherente al proveer información en línea.</p>

          <h3>4. Cookies</h3>
          <p>Este sitio puede utilizar cookies propias y de terceros para mejorar la experiencia de navegación y analizar el tráfico. Al continuar navegando, usted acepta su uso.</p>

          <h3>5. Contacto Legal</h3>
          <p>Para consultas sobre estos términos, puede escribirnos a lauti.seid@gmail.com.</p>
      </section>

  </main>

  <footer class="bg-delsur-dark text-slate-400 text-sm py-8 text-center border-t border-slate-800 mt-auto">
      <div class="max-w-4xl mx-auto px-4">
        <p>© 2024 Del Sur Construcciones. Todos los derechos reservados.</p>
      </div>
  </footer>

</body>
</html>