<?php
// index.php - Del Sur Construcciones
// 1. Cargar proyectos desde el JSON
$jsonFile = 'proyectos.json';
$proyectosTodo = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// 2. Filtrar solo los destacados (los de la estrella en el admin)
$slides = array_filter($proyectosTodo, function($p) {
    return isset($p['destacado']) && $p['destacado'] === true;
});

// 3. Fallback: Si no hay destacados, mostramos los últimos 3 cargados
if (empty($slides)) {
    $slides = array_slice($proyectosTodo, 0, 3);
}

// 4. Adaptar imágenes (por si vienen como array o string)
foreach ($slides as &$s) {
    if (is_array($s['imagenes'])) {
        $s['image'] = $s['imagenes'][0];
    } else {
        $s['image'] = $s['imagenes'];
    }
}
unset($s); // Limpiar referencia
?>
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
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
  
  <style>
    .glass-nav {
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
    }
    
    .text-gradient {
      background: linear-gradient(135deg, #1e2952 0%, #f97316 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .carousel-track {
      display: flex;
      transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Ocultar scrollbar */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Estilo para imágenes del carrusel index */
    .carrusel-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
  </style>
</head>
<body class="bg-white text-slate-800 font-sans selection:bg-delsur-orange selection:text-white">

  <nav id="navbar" class="fixed w-full z-50 transition-all duration-300 py-4 bg-white/90 backdrop-blur-md border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex-shrink-0 flex items-center">
          <img src="./imagenes/logo.webp" alt="Del Sur" class="h-10 md:h-12 w-auto" />
        </div>
        
        <div class="hidden md:flex space-x-8 items-center">
          <a href="#proyectos" class="text-slate-600 hover:text-delsur-orange font-medium transition-colors">Obras</a>
          <a href="proceso.php" class="text-slate-600 hover:text-delsur-orange font-medium transition-colors">Nuestro Proceso</a>
          <a href="proyectos.php" class="text-slate-600 hover:text-delsur-orange font-medium transition-colors">Portfolio</a>
          <a href="pagos.php" class="text-slate-600 hover:text-delsur-orange font-medium transition-colors">Planes</a>
          <a href="#contacto" class="bg-delsur-blue text-white px-6 py-2.5 rounded-full font-bold hover:bg-slate-800 transition-all shadow-glow transform hover:-translate-y-0.5">
            Presupuesto Gratis
          </a>
        </div>

        <div class="md:hidden">
          <button type="button" class="text-slate-600 p-2">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m4 18h16"/></svg>
          </button>
        </div>
      </div>
    </div>
  </nav>

  <header class="relative pt-32 pb-20 md:pt-48 md:pb-32 overflow-hidden">
    <div class="absolute top-0 right-0 -translate-y-1/4 translate-x-1/4 w-[600px] h-[600px] bg-delsur-orange/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 translate-y-1/4 -translate-x-1/4 w-[400px] h-[400px] bg-delsur-blue/5 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 relative z-10">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
          <span class="inline-block py-1 px-4 rounded-full bg-orange-100 text-delsur-orange text-xs font-bold uppercase tracking-widest mb-6">
            Construcción & Arquitectura
          </span>
          <h1 class="text-5xl md:text-7xl font-display font-extrabold text-delsur-blue leading-tight mb-6">
            Diseñamos <br/><span class="text-delsur-orange">Construimos</span> <br/>Tu Hogar.
          </h1>
          <p class="text-lg text-slate-500 mb-10 max-w-lg leading-relaxed">
            Especialistas en obras llave en mano y Steel Framing. Convertimos tus ideas en estructuras sólidas, modernas y eficientes.
          </p>
          <div class="flex flex-col sm:flex-row gap-4">
            <a href="comenzar.php" class="inline-flex justify-center items-center px-8 py-4 bg-delsur-blue text-white rounded-2xl font-bold text-lg hover:bg-delsur-dark transition-all shadow-xl hover:shadow-delsur-blue/20 transform hover:-translate-y-1">
              Cotizar Mi Proyecto
              <svg class="ml-2 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <a href="proyectos.php" class="inline-flex justify-center items-center px-8 py-4 bg-white text-delsur-blue border-2 border-slate-100 rounded-2xl font-bold text-lg hover:border-delsur-orange transition-all">
              Ver Galería
            </a>
          </div>
        </div>
        <div class="relative group">
          <div class="absolute -inset-4 bg-delsur-orange/10 rounded-[2rem] blur-2xl group-hover:bg-delsur-orange/20 transition-all"></div>
          <img src="./imagenes/hero.webp" alt="Obra Del Sur" class="relative rounded-[2rem] shadow-2xl w-full object-cover h-[500px] transform group-hover:scale-[1.02] transition-all duration-500" />
        </div>
      </div>
    </div>
  </header>

  <section id="proyectos" class="py-24 bg-delsur-light relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 mb-16 flex justify-between items-end">
      <div>
        <h2 class="text-3xl md:text-5xl font-display font-extrabold text-delsur-blue mb-4">Proyectos Destacados</h2>
        <p class="text-slate-500">Conocé algunas de nuestras últimas obras finalizadas.</p>
      </div>
      <div class="hidden md:flex gap-4">
        <button id="prevBtn" class="w-12 h-12 rounded-full border-2 border-slate-200 flex items-center justify-center text-slate-400 hover:border-delsur-orange hover:text-delsur-orange transition-all">
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button id="nextBtn" class="w-12 h-12 rounded-full border-2 border-slate-200 flex items-center justify-center text-slate-400 hover:border-delsur-orange hover:text-delsur-orange transition-all">
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
      </div>
    </div>

    <div class="relative px-4 overflow-hidden md:px-0">
      <div id="carousel" class="carousel-track">
        <?php foreach ($slides as $index => $slide): ?>
          <div class="min-w-full md:min-w-[800px] px-4 transition-all duration-500">
            <div class="bg-white rounded-[2rem] overflow-hidden shadow-card flex flex-col md:flex-row border border-slate-50">
              <div class="md:w-1/2 h-72 md:h-[450px]">
                <img src="<?php echo $slide['image']; ?>" alt="<?php echo htmlspecialchars($slide['titulo']); ?>" class="carrusel-img" />
              </div>
              <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                <span class="text-delsur-orange font-bold text-xs uppercase tracking-widest mb-2"><?php echo htmlspecialchars($slide['categoria']); ?></span>
                <h3 class="text-2xl md:text-4xl font-display font-extrabold text-delsur-blue mb-4 leading-tight">
                  <?php echo htmlspecialchars($slide['titulo']); ?>
                </h3>
                <p class="text-slate-500 mb-8 leading-relaxed line-clamp-3">
                  <?php echo htmlspecialchars($slide['descripcion']); ?>
                </p>
                <div>
                    <a href="proyectos.php" class="inline-flex items-center text-delsur-blue font-bold group">
                        Ver detalles del proyecto 
                        <span class="ml-2 transform group-hover:translate-x-2 transition-transform">→</span>
                    </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="flex justify-center mt-12 gap-2">
      <?php foreach ($slides as $index => $slide): ?>
        <button class="carousel-dot w-2 h-2 rounded-full transition-all bg-slate-200" data-index="<?php echo $index; ?>"></button>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="py-24">
    <div class="max-w-7xl mx-auto px-4">
      <div class="text-center max-w-3xl mx-auto mb-20">
        <h2 class="text-3xl md:text-5xl font-display font-extrabold text-delsur-blue mb-6">Soluciones Integrales</h2>
        <p class="text-slate-500 text-lg">Nos encargamos de todo el proceso, desde el primer boceto hasta la entrega de llaves.</p>
      </div>

      <div class="grid md:grid-cols-3 gap-8">
        <div class="p-10 rounded-3xl bg-white border border-slate-100 shadow-card hover:border-delsur-orange/30 transition-all group">
          <div class="w-16 h-16 rounded-2xl bg-orange-50 flex items-center justify-center text-delsur-orange mb-8 group-hover:bg-delsur-orange group-hover:text-white transition-all">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m0 10V4m-4 6h4m-4 4h4m1 4h1m-7 4h1"/></svg>
          </div>
          <h3 class="text-2xl font-bold text-delsur-blue mb-4">Arquitectura Comercial</h3>
          <p class="text-slate-500 leading-relaxed">Diseño de locales, oficinas y espacios corporativos que potencian tu marca y optimizan la operatividad.</p>
        </div>

        <div class="p-10 rounded-3xl bg-delsur-blue text-white shadow-xl transform md:-translate-y-4">
          <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center text-delsur-orange mb-8">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
          </div>
          <h3 class="text-2xl font-bold mb-4 text-white">Viviendas Unifamiliares</h3>
          <p class="text-blue-100 leading-relaxed">Proyectos residenciales personalizados. Especialistas en Steel Framing para una construcción rápida, limpia y eficiente.</p>
        </div>

        <div class="p-10 rounded-3xl bg-white border border-slate-100 shadow-card hover:border-delsur-orange/30 transition-all group">
          <div class="w-16 h-16 rounded-2xl bg-orange-50 flex items-center justify-center text-delsur-orange mb-8 group-hover:bg-delsur-orange group-hover:text-white transition-all">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
          </div>
          <h3 class="text-2xl font-bold text-delsur-blue mb-4">Reformas & Ampliaciones</h3>
          <p class="text-slate-500 leading-relaxed">Renovamos tus espacios existentes con soluciones creativas que mejoran la calidad de vida y el valor de tu propiedad.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="py-20 bg-delsur-blue relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
      <h2 class="text-3xl md:text-5xl font-display font-extrabold text-white mb-8">¿Tenés un terreno? Construyamos.</h2>
      <p class="text-blue-100 text-lg mb-10 max-w-2xl mx-auto">Nuestro equipo técnico está listo para asesorarte en la factibilidad de tu proyecto sin cargo.</p>
      <a href="comenzar.php" class="inline-flex items-center px-10 py-5 bg-delsur-orange text-white rounded-2xl font-bold text-xl hover:bg-white hover:text-delsur-blue transition-all shadow-2xl">
        Iniciar Mi Cotización Ahora
      </a>
    </div>
  </section>

  <section id="contacto" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4">
      <div class="grid md:grid-cols-2 gap-16">
        <div>
          <h2 class="text-3xl md:text-5xl font-display font-extrabold text-delsur-blue mb-8">Hablemos de tu idea</h2>
          <p class="text-slate-500 text-lg mb-12">Estamos en Berazategui, Buenos Aires. Atendemos proyectos en toda la zona sur y Capital Federal.</p>
          
          <div class="space-y-8">
            <div class="flex items-center gap-6">
              <div class="w-14 h-14 rounded-2xl bg-orange-50 text-delsur-orange flex items-center justify-center shadow-sm">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
              </div>
              <div>
                <span class="block text-slate-400 text-sm font-bold uppercase tracking-wider">Llamanos</span>
                <span class="text-xl font-bold text-delsur-blue">11 6245 4432</span>
              </div>
            </div>
            
            <div class="flex items-center gap-6">
              <div class="w-14 h-14 rounded-2xl bg-blue-50 text-delsur-blue flex items-center justify-center shadow-sm">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
              </div>
              <div>
                <span class="block text-slate-400 text-sm font-bold uppercase tracking-wider">Escribinos</span>
                <span class="text-xl font-bold text-delsur-blue">hola@delsurconstrucciones.com.ar</span>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-slate-50 p-8 md:p-12 rounded-[2.5rem] border border-slate-100 relative">
          <form id="contactForm" class="space-y-6">
            <input type="text" name="honeypot" style="display:none">
            <div class="grid md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Nombre</label>
                <input type="text" name="nombre" required class="w-full bg-white border-transparent focus:border-delsur-orange focus:ring-0 rounded-xl px-5 py-4 transition-all shadow-sm" placeholder="Tu nombre">
              </div>
              <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Teléfono</label>
                <input type="tel" name="telefono" required class="w-full bg-white border-transparent focus:border-delsur-orange focus:ring-0 rounded-xl px-5 py-4 transition-all shadow-sm" placeholder="Tu WhatsApp">
              </div>
            </div>
            <div>
              <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Email</label>
              <input type="email" name="email" required class="w-full bg-white border-transparent focus:border-delsur-orange focus:ring-0 rounded-xl px-5 py-4 transition-all shadow-sm" placeholder="Correo electrónico">
            </div>
            <div>
              <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Mensaje</label>
              <textarea name="mensaje" rows="4" required class="w-full bg-white border-transparent focus:border-delsur-orange focus:ring-0 rounded-xl px-5 py-4 transition-all shadow-sm" placeholder="¿En qué podemos ayudarte?"></textarea>
            </div>
            <button type="submit" class="w-full py-5 bg-delsur-orange text-white font-bold rounded-xl text-lg hover:bg-delsur-blue transition-all shadow-lg hover:shadow-delsur-blue/30">
              Enviar Consulta
            </button>
            <div id="formMessage"></div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-delsur-dark text-white py-12 border-t border-white/5">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <img src="./imagenes/logo.webp" alt="Del Sur" class="h-12 mx-auto mb-8 brightness-0 invert opacity-50" />
      <p class="text-slate-500 max-w-md mx-auto mb-8 leading-relaxed">Arquitectura y Construcción con compromiso y calidad en cada detalle.</p>
      <div class="text-slate-600 text-sm">
        © <?php echo date('Y'); ?> Del Sur Construcciones. Todos los derechos reservados.
      </div>
    </div>
  </footer>

  <script>
    // --- LOGICA DEL CARRUSEL DINÁMICO ---
    const track = document.getElementById('carousel');
    const dots = document.querySelectorAll('.carousel-dot');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let currentIndex = 0;
    const totalSlides = <?php echo count($slides); ?>;

    function updateCarousel() {
      if (!track) return;
      const slideWidth = track.querySelector('div').offsetWidth;
      track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
      
      // Actualizar dots
      dots.forEach((dot, i) => {
        if (i === currentIndex) {
          dot.classList.add('bg-delsur-orange', 'w-8');
          dot.classList.remove('bg-slate-200', 'w-2');
        } else {
          dot.classList.remove('bg-delsur-orange', 'w-8');
          dot.classList.add('bg-slate-200', 'w-2');
        }
      });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
          currentIndex = (currentIndex + 1) % totalSlides;
          updateCarousel();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
          currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
          updateCarousel();
        });
    }

    dots.forEach(dot => {
      dot.addEventListener('click', () => {
        currentIndex = parseInt(dot.dataset.index);
        updateCarousel();
      });
    });

    window.addEventListener('resize', updateCarousel);
    updateCarousel();

    // CONTACT FORM
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