<!doctype html>
<html lang="es-AR" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cómo Trabajamos — Del Sur Construcciones</title>
  <meta name="theme-color" content="#1e2952" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            delsur: { blue: '#1e2952', dark: '#0f172a', orange: '#f97316', light: '#f8fafc' }
          },
          fontFamily: {
            sans: ['Inter', 'system-ui', 'sans-serif'],
            display: ['Montserrat', 'system-ui', 'sans-serif'],
          },
          animation: {
            'bounce-slow': 'bounce 3s infinite',
            'draw-line': 'drawLine 1s forwards'
          }
        }
      }
    };
  </script>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
  
  <style>
      /* Preloader */
      #preloader { transition: opacity 0.6s ease-out, visibility 0.6s; }
      @keyframes loading {
        0% { transform: translateX(-100%); }
        50% { transform: translateX(0); }
        100% { transform: translateX(100%); }
      }

      /* Estilos de la Línea de Tiempo */
      .step-content {
          max-height: 0;
          opacity: 0;
          overflow: hidden;
          transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
      }
      .step.active .step-content {
          max-height: 500px; /* Altura suficiente */
          opacity: 1;
          margin-top: 1rem;
      }
      .step-circle {
          transition: all 0.3s ease;
      }
      .step.active .step-circle {
          background-color: #f97316; /* Orange */
          border-color: #f97316;
          color: white;
          transform: scale(1.1);
          box-shadow: 0 0 15px rgba(249, 115, 22, 0.5);
      }
      .connector {
          transition: background-color 0.5s ease;
      }
      .step.active + .connector-container .connector {
          background-color: #f97316;
      }

      /* Sección Final (Hook) */
      #final-hook {
          opacity: 0;
          transform: translateY(20px);
          transition: all 1s ease;
      }
      #final-hook.visible {
          opacity: 1;
          transform: translateY(0);
      }
  </style>
</head>
<body class="bg-slate-50 text-slate-700 font-sans">

  <div id="preloader" class="fixed inset-0 z-[100] bg-white flex items-center justify-center">
    <div class="flex flex-col items-center gap-6">
        <img src="./imagenes/logo.webp" alt="Cargando..." class="h-20 w-auto animate-pulse" />
        <div class="w-32 h-1.5 bg-slate-100 rounded-full overflow-hidden relative">
            <div class="h-full bg-delsur-orange w-full absolute top-0 left-0 animate-[loading_1.5s_infinite_linear]"></div>
        </div>
    </div>
  </div>

  <nav class="bg-white border-b border-slate-200 py-4 sticky top-0 z-40">
    <div class="max-w-5xl mx-auto px-4 flex justify-between items-center">
        <a href="index.php" class="flex-shrink-0">
            <img src="./imagenes/logo.webp" alt="Del Sur" class="h-10 w-auto" />
        </a>
        <a href="index.php" class="text-sm font-medium text-slate-500 hover:text-delsur-blue flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver al inicio
        </a>
    </div>
  </nav>

  <section class="pt-16 pb-12 px-4 text-center bg-delsur-blue text-white relative overflow-hidden">
      <div class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmYiLz48L3N2Zz4=')]"></div>
      
      <div class="relative z-10 max-w-3xl mx-auto">
          <span class="text-delsur-orange font-bold tracking-widest text-xs uppercase mb-2 block">Transparencia Total</span>
          <h1 class="font-display text-3xl md:text-5xl font-bold mb-4">El Método Del Sur</h1>
          <p class="text-slate-300 text-lg md:text-xl">
              Olvidate de la incertidumbre. Hacé clic en cada etapa para descubrir cómo transformamos un plano en tu hogar.
          </p>
          <p class="mt-4 text-sm text-slate-400 animate-bounce">👇 Empezá tu recorrido haciendo clic abajo</p>
      </div>
  </section>

  <section class="py-16 max-w-3xl mx-auto px-4">
      
      <div class="relative pl-12 md:pl-20 py-2 group">
          <div class="connector-container absolute left-4 md:left-8 top-12 bottom-0 w-0.5 bg-slate-200 h-full -z-10"></div>
          
          <div class="step cursor-pointer" onclick="toggleStep(this, 1)">
              <div class="step-circle absolute left-0 md:left-4 w-8 h-8 md:w-10 md:h-10 rounded-full border-2 border-slate-300 bg-white flex items-center justify-center font-bold text-slate-500 z-10 transition-colors">1</div>
              
              <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
                  <h3 class="text-xl font-bold text-delsur-blue flex items-center justify-between">
                      Reunión y Diagnóstico
                      <span class="text-delsur-orange text-sm font-normal opacity-0 group-hover:opacity-100 transition-opacity">Ver detalle +</span>
                  </h3>
                  <div class="step-content">
                      <p class="text-slate-600 mb-3 pt-2">Nos conocemos (presencial o virtual). Visitamos tu terreno o propiedad para evaluar la viabilidad técnica y escuchamos tus ideas.</p>
                      <ul class="text-sm text-slate-500 space-y-1">
                          <li>✅ Análisis de suelo y orientación.</li>
                          <li>✅ Definición de estilo y necesidades.</li>
                          <li>✅ Sin costo ni compromiso inicial.</li>
                      </ul>
                  </div>
              </div>
          </div>
          <div class="connector-container absolute left-4 md:left-8 top-10 w-0.5 bg-slate-200 h-full -z-20">
              <div class="connector w-full h-full bg-slate-200"></div>
          </div>
      </div>

      <div class="relative pl-12 md:pl-20 py-2 group mt-4">
          <div class="step cursor-pointer" onclick="toggleStep(this, 2)">
              <div class="step-circle absolute left-0 md:left-4 w-8 h-8 md:w-10 md:h-10 rounded-full border-2 border-slate-300 bg-white flex items-center justify-center font-bold text-slate-500 z-10">2</div>
              
              <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
                  <h3 class="text-xl font-bold text-delsur-blue flex items-center justify-between">
                      Anteproyecto y Costos
                      <span class="text-delsur-orange text-sm font-normal opacity-0 group-hover:opacity-100 transition-opacity">Ver detalle +</span>
                  </h3>
                  <div class="step-content">
                      <p class="text-slate-600 mb-3 pt-2">Desarrollamos la propuesta de diseño y calculamos los costos reales. Aquí sabrás exactamente cuánto vas a invertir.</p>
                      <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 text-sm text-delsur-blue mb-2">
                          💡 <strong>Dato Clave:</strong> Acá es donde el 90% de las obras fallan por mala planificación. Nosotros lo blindamos acá.
                      </div>
                  </div>
              </div>
          </div>
           <div class="connector-container absolute left-4 md:left-8 top-10 w-0.5 bg-slate-200 h-full -z-20">
              <div class="connector w-full h-full bg-slate-200"></div>
          </div>
      </div>

      <div class="relative pl-12 md:pl-20 py-2 group mt-4">
          <div class="step cursor-pointer" onclick="toggleStep(this, 3)">
              <div class="step-circle absolute left-0 md:left-4 w-8 h-8 md:w-10 md:h-10 rounded-full border-2 border-slate-300 bg-white flex items-center justify-center font-bold text-slate-500 z-10">3</div>
              
              <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
                  <h3 class="text-xl font-bold text-delsur-blue flex items-center justify-between">
                      Firma y Planificación
                      <span class="text-delsur-orange text-sm font-normal opacity-0 group-hover:opacity-100 transition-opacity">Ver detalle +</span>
                  </h3>
                  <div class="step-content">
                      <p class="text-slate-600 mb-3 pt-2">Firmamos contrato con cronograma de obra, materiales y etapas de pago claras. Se congelan precios y se piden los permisos municipales.</p>
                  </div>
              </div>
          </div>
           <div class="connector-container absolute left-4 md:left-8 top-10 w-0.5 bg-slate-200 h-full -z-20">
              <div class="connector w-full h-full bg-slate-200"></div>
          </div>
      </div>

      <div class="relative pl-12 md:pl-20 py-2 group mt-4">
          <div class="step cursor-pointer" onclick="toggleStep(this, 4)">
              <div class="step-circle absolute left-0 md:left-4 w-8 h-8 md:w-10 md:h-10 rounded-full border-2 border-slate-300 bg-white flex items-center justify-center font-bold text-slate-500 z-10">4</div>
              
              <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
                  <h3 class="text-xl font-bold text-delsur-blue flex items-center justify-between">
                      Ejecución de Obra
                      <span class="text-delsur-orange text-sm font-normal opacity-0 group-hover:opacity-100 transition-opacity">Ver detalle +</span>
                  </h3>
                  <div class="step-content">
                      <p class="text-slate-600 mb-3 pt-2">Empieza la acción. Gestión de gremios, compra de materiales y dirección técnica. Vos recibís reportes semanales por WhatsApp con fotos y videos.</p>
                  </div>
              </div>
          </div>
           <div class="connector-container absolute left-4 md:left-8 top-10 w-0.5 bg-slate-200 h-full -z-20">
              <div class="connector w-full h-full bg-slate-200"></div>
          </div>
      </div>

      <div class="relative pl-12 md:pl-20 py-2 group mt-4">
          <div class="step cursor-pointer" onclick="toggleStep(this, 5)">
              <div class="step-circle absolute left-0 md:left-4 w-8 h-8 md:w-10 md:h-10 rounded-full border-2 border-slate-300 bg-white flex items-center justify-center font-bold text-slate-500 z-10">5</div>
              
              <div class="bg-white p-6 rounded-2xl shadow-sm border-2 border-delsur-orange/20 hover:border-delsur-orange transition-all">
                  <h3 class="text-xl font-bold text-delsur-blue flex items-center justify-between">
                      Entrega de Llaves
                      <span class="text-delsur-orange text-sm font-normal opacity-0 group-hover:opacity-100 transition-opacity">¡El final!</span>
                  </h3>
                  <div class="step-content">
                      <p class="text-slate-600 mb-3 pt-2">Limpieza final de obra, revisión de detalles y entrega oficial. Tu proyecto dejó de ser un papel y ahora es una realidad.</p>
                      <p class="font-bold text-delsur-orange text-lg">¡Bienvenido a casa!</p>
                  </div>
              </div>
          </div>
      </div>

  </section>

  <section id="final-hook" class="py-16 bg-gradient-to-b from-slate-50 to-white">
      <div class="max-w-4xl mx-auto px-4 text-center">
          <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 text-green-600 animate-bounce">
             <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"/></svg>
          </div>
          
          <h2 class="font-display text-3xl font-bold text-delsur-blue mb-4">Ya conocés el camino. Es seguro.</h2>
          <p class="text-lg text-slate-600 mb-12">Lo único que falta es dar el primer paso. Elegí cómo querés empezar:</p>
          
          <div class="grid md:grid-cols-2 gap-6 max-w-3xl mx-auto text-left">
              <div class="border border-slate-200 p-6 rounded-2xl hover:shadow-lg transition-all bg-white">
                  <h4 class="font-bold text-slate-700 text-lg">Asesoría General</h4>
                  <div class="text-2xl font-bold text-delsur-blue my-2">$3.500</div>
                  <p class="text-sm text-slate-500 mb-4">Para despejar dudas iniciales.</p>
                  <a href="pagos.php" class="block text-center w-full py-2 rounded-lg border border-delsur-blue text-delsur-blue font-bold hover:bg-slate-50">Elegir Asesoría</a>
              </div>
              
              <div class="border border-delsur-orange p-6 rounded-2xl hover:shadow-xl transition-all bg-orange-50 relative">
                  <div class="absolute -top-3 right-4 bg-delsur-orange text-white text-xs font-bold px-2 py-1 rounded">RECOMENDADO</div>
                  <h4 class="font-bold text-delsur-orange text-lg">Pack Premium</h4>
                  <div class="text-2xl font-bold text-delsur-blue my-2">$4.500</div>
                  <p class="text-sm text-slate-600 mb-4">Planificación completa + Diseño 2D.</p>
                  <a href="pagos.php" class="block text-center w-full py-2 rounded-lg bg-delsur-orange text-white font-bold hover:bg-orange-600 shadow-lg shadow-orange-500/30">Empezar Ahora</a>
              </div>
          </div>
      </div>
  </section>

  <footer class="bg-delsur-dark text-slate-400 text-sm py-8 text-center border-t border-slate-800">
      <p>© 2024 Del Sur Construcciones.</p>
  </footer>

  <script>
    // Preloader
    window.addEventListener('load', () => {
        setTimeout(() => {
            document.getElementById('preloader').classList.add('opacity-0', 'invisible');
        }, 800);
    });

    // Lógica de los Pasos
    function toggleStep(element, stepNumber) {
        // Activar visualmente el paso actual
        element.classList.toggle('active');
        
        // Si llegamos al último paso, mostrar el Hook final
        if (stepNumber === 5) {
            setTimeout(() => {
                const hook = document.getElementById('final-hook');
                hook.classList.add('visible');
                hook.scrollIntoView({ behavior: 'smooth' });
            }, 600);
        }
    }
  </script>
</body>
</html>