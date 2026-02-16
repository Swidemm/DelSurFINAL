<!doctype html>
<html lang="es-AR" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nuestros Proyectos — Del Sur Construcciones</title>
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
          }
        }
      }
    };
  </script>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
  
  <style>
      /* Preloader */
      @keyframes loading {
        0% { transform: translateX(-100%); }
        50% { transform: translateX(0); }
        100% { transform: translateX(100%); }
      }
      #preloader { transition: opacity 0.6s ease-out, visibility 0.6s; }

      /* Animaciones */
      .modal-enter { opacity: 0; transform: scale(0.95); }
      .modal-enter-active { opacity: 1; transform: scale(1); transition: opacity 0.3s, transform 0.3s; }
      .modal-exit-active { opacity: 0; transform: scale(0.95); transition: opacity 0.2s, transform 0.2s; }
      
      body.modal-open { overflow: hidden; padding-right: 15px; } /* Evita salto por scrollbar */
      
      .line-clamp-2 {
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
          overflow: hidden;
      }
      
      /* Animación de entrada para tarjetas */
      @keyframes fadeInUp {
          from { opacity: 0; transform: translateY(20px); }
          to { opacity: 1; transform: translateY(0); }
      }
      .animate-fade-in-up {
          animation: fadeInUp 0.6s ease-out forwards;
      }
  </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans selection:bg-delsur-orange selection:text-white">

  <div id="preloader" class="fixed inset-0 z-[100] bg-white flex items-center justify-center">
    <div class="flex flex-col items-center gap-6">
        <img src="./imagenes/logo.webp" alt="Cargando..." class="h-20 w-auto animate-pulse" />
        <div class="w-32 h-1.5 bg-slate-100 rounded-full overflow-hidden relative">
            <div class="h-full bg-delsur-orange w-full absolute top-0 left-0 animate-[loading_1.5s_infinite_linear]"></div>
        </div>
    </div>
  </div>

  <nav id="navbar" class="fixed w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <a href="index.php" class="flex-shrink-0 group">
            <img src="./imagenes/logo.webp" alt="Del Sur" class="h-10 w-auto group-hover:scale-105 transition-transform" />
        </a>
        <div class="hidden md:flex space-x-8 items-center">
          <a href="index.php" class="text-slate-600 hover:text-delsur-orange font-medium transition-colors">Inicio</a>
          <a href="proceso.php" class="text-slate-600 hover:text-delsur-orange font-medium transition-colors">Proceso</a>
          <a href="proyectos.php" class="text-delsur-orange font-bold transition-colors">Proyectos</a>
          <a href="pagos.php" class="text-slate-600 hover:text-delsur-orange font-medium transition-colors">Planes</a>
          <a href="index.php#contacto" class="bg-delsur-blue text-white px-5 py-2.5 rounded-full font-bold hover:bg-slate-800 transition-all shadow-lg shadow-blue-900/20 hover:shadow-blue-900/40 transform hover:-translate-y-0.5">
            Pedir Presupuesto
          </a>
        </div>
        <button class="md:hidden text-slate-600 focus:outline-none p-2">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
      </div>
    </div>
  </nav>

  <header class="pt-32 pb-16 bg-delsur-light border-b border-slate-200">
      <div class="max-w-7xl mx-auto px-4 text-center">
          <span class="text-delsur-orange font-bold tracking-widest uppercase text-sm mb-2 block animate-fade-in-up">Portfolio</span>
          <h1 class="text-4xl md:text-5xl font-display font-bold text-delsur-blue mb-4 animate-fade-in-up" style="animation-delay: 100ms">
              Nuestras Obras
          </h1>
          <p class="text-slate-500 max-w-2xl mx-auto text-lg animate-fade-in-up" style="animation-delay: 200ms">
              Explorá nuestra galería de proyectos recientes. Desde viviendas unifamiliares hasta locales comerciales y reformas integrales.
          </p>
      </div>
  </header>

  <section class="py-16 bg-white min-h-screen">
      <div class="max-w-7xl mx-auto px-4">
          
          <div class="flex flex-wrap justify-center gap-3 mb-12 animate-fade-in-up" style="animation-delay: 300ms">
              <button onclick="filterProjects('all')" class="filter-btn px-6 py-2 rounded-full border border-delsur-blue bg-delsur-blue text-white shadow-lg transition-all font-medium" data-category="todos">
                  Todos
              </button>
              <button onclick="filterProjects('vivienda')" class="filter-btn px-6 py-2 rounded-full border border-slate-200 bg-white text-slate-500 hover:bg-slate-50 transition-all font-medium" data-category="vivienda">
                  Vivienda
              </button>
              <button onclick="filterProjects('comercial')" class="filter-btn px-6 py-2 rounded-full border border-slate-200 bg-white text-slate-500 hover:bg-slate-50 transition-all font-medium" data-category="comercial">
                  Comercial
              </button>
              <button onclick="filterProjects('refacción')" class="filter-btn px-6 py-2 rounded-full border border-slate-200 bg-white text-slate-500 hover:bg-slate-50 transition-all font-medium" data-category="refacción">
                  Refacción
              </button>
              <button onclick="filterProjects('industrial')" class="filter-btn px-6 py-2 rounded-full border border-slate-200 bg-white text-slate-500 hover:bg-slate-50 transition-all font-medium" data-category="industrial">
                  Industrial
              </button>
          </div>

          <div id="projects-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              </div>

      </div>
  </section>

  <div id="project-modal" class="fixed inset-0 z-[100] hidden">
      <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
      
      <div class="flex items-center justify-center min-h-screen p-4">
          <div id="modal-content" class="bg-white rounded-2xl w-full max-w-5xl shadow-2xl relative overflow-hidden flex flex-col md:flex-row max-h-[90vh] md:h-auto modal-enter transition-all duration-300">
              
              <button onclick="closeModal()" class="absolute top-4 right-4 z-20 bg-white/10 backdrop-blur-md hover:bg-white/20 p-2 rounded-full text-white transition-colors">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
              </button>

              <div class="w-full md:w-3/5 bg-slate-900 relative group h-64 md:h-auto">
                  <div class="absolute inset-0 flex transition-transform duration-500 ease-out" id="carousel-track">
                      </div>
                  
                  <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-2 z-10" id="carousel-dots"></div>
                  
                  <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 p-3 rounded-full text-white backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all transform -translate-x-2 group-hover:translate-x-0">
                      <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                  </button>
                  <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 p-3 rounded-full text-white backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                      <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                  </button>
              </div>

              <div class="w-full md:w-2/5 p-8 md:p-10 overflow-y-auto bg-white flex flex-col h-full">
                  <div class="mb-6">
                      <span id="modal-category" class="inline-block px-3 py-1 bg-orange-50 text-delsur-orange text-xs font-bold uppercase tracking-wider rounded-full mb-3">Vivienda</span>
                      <h2 id="modal-title" class="text-3xl font-display font-bold text-delsur-blue leading-tight mb-4">Nombre Proyecto</h2>
                      <p id="modal-desc" class="text-slate-600 text-sm leading-relaxed">Descripción detallada del proyecto...</p>
                  </div>

                  <div class="grid grid-cols-3 gap-4 py-6 border-y border-slate-100 mb-6">
                      <div class="text-center">
                          <span class="block text-slate-400 text-xs uppercase font-bold mb-1">Superficie</span>
                          <span id="modal-size" class="block text-delsur-blue font-bold">240m²</span>
                      </div>
                      <div class="text-center border-l border-slate-100">
                          <span class="block text-slate-400 text-xs uppercase font-bold mb-1">Ubicación</span>
                          <span id="modal-location" class="block text-delsur-blue font-bold">Canning</span>
                      </div>
                      <div class="text-center border-l border-slate-100">
                          <span class="block text-slate-400 text-xs uppercase font-bold mb-1">Año</span>
                          <span id="modal-year" class="block text-delsur-blue font-bold">2023</span>
                      </div>
                  </div>

                  <div class="mb-8 flex-grow">
                      <h4 id="modal-features-title" class="font-bold text-slate-800 mb-3 text-sm uppercase">Servicios Incluidos</h4>
                      <ul id="modal-features" class="space-y-2 text-sm text-slate-600">
                          </ul>
                  </div>

                  <div class="mt-auto pt-4">
                      <p class="text-center text-xs text-slate-400 mb-3">¿Te gusta este estilo?</p>
                      <a href="#" id="modal-action-btn" class="block w-full py-4 bg-delsur-blue text-white font-bold text-center rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-blue-900/20 group relative overflow-hidden">
                          <span class="relative z-10 flex items-center justify-center gap-2">
                              COTIZAR PROYECTO SIMILAR
                              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                          </span>
                          <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                      </a>
                  </div>
              </div>

          </div>
      </div>
  </div>

  <footer class="bg-delsur-dark text-slate-400 text-sm py-8 text-center border-t border-slate-800">
      <div class="max-w-7xl mx-auto px-4">
        <p>© 2024 Del Sur Construcciones. Todos los derechos reservados.</p>
      </div>
  </footer>

  <script>
    // ----------------------------
    // LOGICA DEL PRELOADER Y TRANSICIONES
    // ----------------------------
    window.addEventListener('load', () => {
        setTimeout(() => {
            const loader = document.getElementById('preloader');
            if(loader) loader.classList.add('opacity-0', 'invisible');
        }, 1500);
    });

    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (href && !href.startsWith('#') && !href.startsWith('javascript') && link.target !== '_blank') {
                e.preventDefault();
                const loader = document.getElementById('preloader');
                if(loader) loader.classList.remove('opacity-0', 'invisible');
                setTimeout(() => window.location.href = href, 400); 
            }
        });
    });

    // ==========================================
    // 1. CARGA DE DATOS DINÁMICA (PHP -> JS)
    // ==========================================
    const projectsRaw = <?php 
        $jsonFile = 'proyectos.json';
        echo file_exists($jsonFile) ? file_get_contents($jsonFile) : '[]';
    ?>;

    // Adaptador: Convierte datos del Admin (español) al formato Frontend (inglés/mixto)
    const projects = projectsRaw.map(p => {
        // Asegurar formato de imágenes
        let imgs = Array.isArray(p.imagenes) ? p.imagenes : [p.imagenes];
        if (imgs.length === 0 || !imgs[0]) imgs = ['./imagenes/logo.webp'];

        return {
            id: p.id,
            title: p.titulo,
            category: p.categoria.toLowerCase(),
            description: p.descripcion,
            // Campos Dinámicos Nuevos
            location: p.ubicacion || "Consultar",
            size: p.medidas || "Consultar",
            year: p.anio || new Date().getFullYear(),
            // Lista y Título Personalizable
            featuresTitle: p.titulo_features || "Servicios Incluidos",
            features: (Array.isArray(p.features) && p.features.length > 0) 
                      ? p.features 
                      : ["Proyecto Ejecutivo", "Dirección de Obra", "Llave en mano"],
            images: imgs
        };
    });

    // Placeholder por si no hay nada cargado
    if (projects.length === 0) {
        projects.push({
            id: 'demo',
            title: 'Proyecto Ejemplo',
            category: 'vivienda',
            size: '150m²',
            location: 'Muestra',
            year: '2024',
            description: 'No hay proyectos cargados. Ingresá al Panel Admin para subir el primero.',
            featuresTitle: 'Características',
            features: ['Ejemplo', 'Admin Panel'],
            images: ['./imagenes/logo.webp']
        });
    }

    // ==========================================
    // 2. RENDERIZADO GRID
    // ==========================================
    const grid = document.getElementById('projects-grid');
    const filterBtns = document.querySelectorAll('.filter-btn');

    function renderProjects(filter = 'all') {
        if(!grid) return;
        grid.innerHTML = '';
        
        const filtered = filter === 'all' 
            ? projects 
            : projects.filter(p => p.category === filter);

        if (filtered.length === 0) {
            grid.innerHTML = '<div class="col-span-3 text-center py-20"><p class="text-slate-400 text-lg">No hay proyectos en esta categoría.</p></div>';
            return;
        }

        filtered.forEach((p, index) => {
            const card = document.createElement('div');
            card.className = "group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 cursor-pointer border border-slate-100 flex flex-col animate-fade-in-up";
            card.style.animationDelay = `${index * 100}ms`;
            card.onclick = () => openModal(p.id);

            card.innerHTML = `
                <div class="h-64 overflow-hidden relative">
                    <img src="${p.images[0]}" alt="${p.title}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        <span class="bg-white text-delsur-orange px-4 py-2 rounded-full text-xs font-bold shadow-lg flex items-center gap-2">
                            Ver Proyecto <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </span>
                    </div>
                </div>
                <div class="p-6 flex-grow flex flex-col">
                    <span class="text-xs font-bold text-delsur-orange uppercase tracking-wider mb-1 block">${p.category}</span>
                    <h3 class="text-xl font-bold text-delsur-blue mb-2 group-hover:text-delsur-orange transition-colors leading-tight">${p.title}</h3>
                    <p class="text-slate-500 text-sm line-clamp-2">${p.description}</p>
                    
                    <div class="mt-auto pt-4 border-t border-slate-100 text-xs text-slate-400 flex flex-wrap gap-3">
                         <span class="flex items-center gap-1"><i class="ph ph-map-pin"></i> ${p.location}</span>
                         <span class="flex items-center gap-1"> ${p.size}</span>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    function filterProjects(cat) {
        filterBtns.forEach(btn => {
            const btnCat = btn.getAttribute('data-category') || btn.textContent.toLowerCase().trim();
            const targetCat = cat === 'all' ? 'todos' : cat;
            
            if(btn.textContent.toLowerCase().includes(targetCat)) {
                btn.classList.add('bg-delsur-blue', 'text-white', 'border-delsur-blue', 'shadow-lg');
                btn.classList.remove('bg-white', 'text-slate-500', 'border-slate-200');
            } else {
                btn.classList.remove('bg-delsur-blue', 'text-white', 'border-delsur-blue', 'shadow-lg');
                btn.classList.add('bg-white', 'text-slate-500', 'border-slate-200');
            }
        });
        renderProjects(cat);
    }

    // ==========================================
    // 3. MODAL DINÁMICO
    // ==========================================
    const modal = document.getElementById('project-modal');
    const modalContent = document.getElementById('modal-content');
    let currentProject = null;
    let currentSlide = 0;
    let autoPlayInterval = null;

    function openModal(id) {
        currentProject = projects.find(p => p.id === id);
        if(!currentProject) return;

        // Llenar Textos Principales
        setText('modal-title', currentProject.title);
        setText('modal-category', currentProject.category);
        setText('modal-desc', currentProject.description);
        
        // Llenar Datos Técnicos
        setText('modal-size', currentProject.size);
        setText('modal-location', currentProject.location);
        setText('modal-year', currentProject.year);

        // Llenar Lista Dinámica
        const featsList = document.getElementById('modal-features');
        if(featsList) {
            featsList.innerHTML = '';
            currentProject.features.forEach(f => {
                const li = document.createElement('li');
                li.className = "flex items-center gap-2";
                li.innerHTML = `<span class="text-delsur-orange text-lg">•</span> ${f}`;
                featsList.appendChild(li);
            });
        }
        
        // Cambiar título de la lista ("Servicios" vs "Amenities")
        const featsTitle = document.getElementById('modal-features-title');
        if(featsTitle) {
            featsTitle.textContent = currentProject.featuresTitle;
        }

        // Configurar Botón Cotizar
        const actionBtn = document.getElementById('modal-action-btn');
        if(actionBtn) actionBtn.href = `comenzar.php?ref_proyecto=${encodeURIComponent(currentProject.title)}`;

        // Carrusel
        setupCarousel(currentProject.images);

        // Mostrar Modal
        if(modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('modal-open');
            setTimeout(() => {
                if(modalContent) {
                    modalContent.classList.remove('modal-enter');
                    modalContent.classList.add('modal-enter-active');
                }
            }, 10);
        }
        startAutoPlay();
    }

    function setText(id, text) {
        const el = document.getElementById(id);
        if(el) el.textContent = text;
    }

    function closeModal() {
        if(!modalContent) return;
        modalContent.classList.remove('modal-enter-active');
        modalContent.classList.add('modal-exit-active');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modalContent.classList.remove('modal-exit-active');
            document.body.classList.remove('modal-open');
            stopAutoPlay();
        }, 200);
    }

    // --- Carrusel Logic ---
    function setupCarousel(images) {
        currentSlide = 0;
        const track = document.getElementById('carousel-track');
        const dots = document.getElementById('carousel-dots');
        if(!track || !dots) return;

        track.innerHTML = '';
        dots.innerHTML = '';

        images.forEach((img, index) => {
            const imgContainer = document.createElement('div');
            imgContainer.className = "min-w-full h-full flex-shrink-0"; 
            const imgEl = document.createElement('img');
            imgEl.src = img;
            imgEl.className = "w-full h-full object-cover";
            imgContainer.appendChild(imgEl);
            track.appendChild(imgContainer);

            const dot = document.createElement('button');
            dot.className = `w-2 h-2 rounded-full transition-all ${index === 0 ? 'bg-white w-6' : 'bg-white/50'}`;
            dot.onclick = (e) => { e.stopPropagation(); goToSlide(index); };
            dots.appendChild(dot);
        });
        updateCarousel();
    }

    function updateCarousel() {
        const track = document.getElementById('carousel-track');
        if(track) track.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        const dots = document.getElementById('carousel-dots');
        if(dots) {
            Array.from(dots.children).forEach((d, i) => {
                d.className = `w-2 h-2 rounded-full transition-all ${i === currentSlide ? 'bg-white w-6' : 'bg-white/50'}`;
            });
        }
    }

    function nextSlide() {
        if(!currentProject) return;
        currentSlide = (currentSlide + 1) % currentProject.images.length;
        updateCarousel();
    }
    function prevSlide() {
        if(!currentProject) return;
        currentSlide = (currentSlide - 1 + currentProject.images.length) % currentProject.images.length;
        updateCarousel();
    }
    function goToSlide(n) {
        currentSlide = n;
        updateCarousel();
        stopAutoPlay(); 
        startAutoPlay(); 
    }
    function startAutoPlay() {
        stopAutoPlay();
        if(currentProject && currentProject.images.length > 1) {
            autoPlayInterval = setInterval(nextSlide, 3000); 
        }
    }
    function stopAutoPlay() {
        if(autoPlayInterval) clearInterval(autoPlayInterval);
    }

    const trackContainer = document.getElementById('carousel-track');
    if(trackContainer) {
        trackContainer.parentElement.addEventListener('mouseenter', stopAutoPlay);
        trackContainer.parentElement.addEventListener('mouseleave', startAutoPlay);
    }

    if(modal) {
        modal.addEventListener('click', (e) => {
            if(e.target === modal) closeModal();
        });
    }

    // Inicializar
    renderProjects();
  </script>
</body>
</html>