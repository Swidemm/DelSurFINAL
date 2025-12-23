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

      /* Animaciones del Modal */
      .modal-enter { opacity: 0; transform: scale(0.95); }
      .modal-enter-active { opacity: 1; transform: scale(1); transition: all 0.3s ease-out; }
      .modal-exit { opacity: 1; transform: scale(1); }
      .modal-exit-active { opacity: 0; transform: scale(0.95); transition: all 0.2s ease-in; }
      body.modal-open { overflow: hidden; }
      .carousel-track { display: flex; transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1); }
      .carousel-slide { min-width: 100%; height: 100%; object-fit: cover; }
      .no-scrollbar::-webkit-scrollbar { display: none; }
      .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  </style>
</head>

<body class="bg-slate-50 font-sans text-slate-700">

  <div id="preloader" class="fixed inset-0 z-[100] bg-white flex items-center justify-center">
    <div class="flex flex-col items-center gap-6">
        <img src="./imagenes/logo.webp" alt="Cargando..." class="h-20 w-auto animate-pulse" />
        <div class="w-32 h-1.5 bg-slate-100 rounded-full overflow-hidden relative">
            <div class="h-full bg-delsur-orange w-full absolute top-0 left-0 animate-[loading_1.5s_infinite_linear]"></div>
        </div>
    </div>
  </div>

  <nav class="bg-white border-b border-slate-200 py-4 sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
        <a href="index.php" class="flex-shrink-0">
            <img src="./imagenes/logo.webp" alt="Del Sur" class="h-10 w-auto" />
        </a>
        <a href="index.php" class="text-sm font-bold text-slate-500 hover:text-delsur-blue flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver al Inicio
        </a>
    </div>
  </nav>

  <header class="bg-delsur-blue text-white py-16 relative overflow-hidden">
      <div class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmYiLz48L3N2Zz4=')]"></div>
      <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
          <span class="text-delsur-orange font-bold tracking-widest text-xs uppercase mb-2 block">Portfolio</span>
          <h1 class="font-display text-4xl md:text-5xl font-bold mb-4">Nuestra Galería de Obras</h1>
          <p class="text-slate-300 max-w-2xl mx-auto text-lg">Explorá cada detalle de nuestros trabajos. Desde los cimientos hasta las terminaciones finales.</p>
      </div>
  </header>

  <section class="py-8 border-b border-slate-200 bg-white sticky top-[73px] z-30 shadow-sm">
      <div class="max-w-7xl mx-auto px-4 flex justify-center gap-4 overflow-x-auto no-scrollbar">
          <button onclick="filterProjects('all')" class="filter-btn active px-6 py-2 rounded-full text-sm font-bold transition-all border border-delsur-blue bg-delsur-blue text-white shadow-lg">Todos</button>
          <button onclick="filterProjects('vivienda')" class="filter-btn px-6 py-2 rounded-full text-sm font-bold transition-all border border-slate-200 text-slate-500 hover:border-delsur-orange hover:text-delsur-orange bg-white">Viviendas</button>
          <button onclick="filterProjects('comercial')" class="filter-btn px-6 py-2 rounded-full text-sm font-bold transition-all border border-slate-200 text-slate-500 hover:border-delsur-orange hover:text-delsur-orange bg-white">Comerciales</button>
          <button onclick="filterProjects('reforma')" class="filter-btn px-6 py-2 rounded-full text-sm font-bold transition-all border border-slate-200 text-slate-500 hover:border-delsur-orange hover:text-delsur-orange bg-white">Reformas</button>
      </div>
  </section>

  <main class="py-16 bg-slate-50 min-h-screen">
      <div id="projects-grid" class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          </div>
  </main>

  <footer class="bg-delsur-dark text-slate-400 text-sm py-8 text-center border-t border-slate-800">
      <p>© 2024 Del Sur Construcciones.</p>
  </footer>

  <div id="project-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 sm:p-6">
      <div class="absolute inset-0 bg-slate-900/90 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
      
      <div id="modal-content" class="relative bg-white w-full max-w-5xl rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row max-h-[90vh]">
          
          <button onclick="closeModal()" class="absolute top-4 right-4 z-50 bg-black/50 hover:bg-black/80 text-white rounded-full p-2 backdrop-blur transition-colors">
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>

          <div class="w-full md:w-2/3 bg-black relative group h-64 md:h-auto">
              <div class="overflow-hidden h-full relative">
                  <div id="carousel-track" class="carousel-track h-full"></div>
              </div>

              <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/30 backdrop-blur text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-all">
                  <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
              </button>
              <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/30 backdrop-blur text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-all">
                  <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </button>

              <div id="carousel-dots" class="absolute bottom-4 left-0 right-0 flex justify-center gap-2"></div>
          </div>

          <div class="w-full md:w-1/3 p-8 overflow-y-auto bg-white flex flex-col">
              <span id="modal-category" class="text-xs font-bold tracking-widest text-delsur-orange uppercase mb-2 block">Categoría</span>
              <h2 id="modal-title" class="text-3xl font-display font-bold text-delsur-blue mb-4 leading-tight">Título del Proyecto</h2>
              
              <div class="flex flex-wrap gap-2 mb-6">
                  <span id="modal-size" class="px-3 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg border border-slate-200">0 m²</span>
                  <span id="modal-location" class="px-3 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg border border-slate-200">Ubicación</span>
                  <span id="modal-year" class="px-3 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg border border-slate-200">Año</span>
              </div>

              <div class="prose prose-sm text-slate-600 mb-8 flex-grow">
                  <p id="modal-desc">Descripción del proyecto...</p>
                  
                  <div class="border-t border-slate-100 pt-6 mt-6">
                      <h4 class="font-bold text-delsur-blue mb-3 text-sm">Servicios Incluidos:</h4>
                      <ul id="modal-features" class="space-y-2 text-sm text-slate-500">
                          </ul>
                  </div>
              </div>

              <div class="mt-4 pt-4 border-t border-slate-100">
                  <a id="modal-action-btn" href="#" class="block w-full py-3 rounded-xl bg-delsur-blue text-white font-bold text-center hover:bg-delsur-dark transition-all shadow-lg">
                      ¡Quiero algo similar!
                  </a>
              </div>
          </div>
      </div>
  </div>

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

    // Interceptar clicks para mostrar loader al navegar
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            // Ignoramos si es #, javascript o el botón de acción del modal (ya que ese tiene logica dinamica)
            // o si abre en nueva pestaña
            if (href && !href.startsWith('#') && !href.startsWith('javascript') && link.target !== '_blank') {
                e.preventDefault();
                document.getElementById('preloader').classList.remove('opacity-0', 'invisible');
                setTimeout(() => window.location.href = href, 400); 
            }
        });
    });


    // ==========================================
    // 1. BASE DE DATOS DE PROYECTOS (EDITAR ACÁ)
    // ==========================================
    const projects = [
        {
            id: 1,
            title: "Residencia Los Álamos",
            category: "vivienda",
            size: "240m²",
            location: "Canning, Bs As",
            year: "2023",
            description: "Una vivienda unifamiliar de estilo minimalista que prioriza la conexión con el exterior. Se utilizaron materiales nobles como hormigón a la vista y madera para generar calidez.",
            features: ["Proyecto Ejecutivo", "Dirección de Obra", "Interiorismo", "Parquización"],
            images: [
                'https://images.unsplash.com/photo-1600596542815-2495db98dada?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=800&q=80'
            ]
        },
        {
            id: 2,
            title: "Oficinas Tech Center",
            category: "comercial",
            size: "500m²",
            location: "Puerto Madero",
            year: "2022",
            description: "Reforma integral de planta libre para empresa de tecnología. Espacios colaborativos, salas de reunión acústicas y zonas de relax.",
            features: ["Diseño 3D", "Mobiliario a medida", "Instalaciones de red", "Iluminación técnica"],
            images: [
                'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=800&q=80'
            ]
        },
        {
            id: 3,
            title: "Renovación Palermo",
            category: "reforma",
            size: "120m²",
            location: "Palermo Soho",
            year: "2024",
            description: "Reciclaje total de PH antiguo. Se recuperaron los pisos de pinotea y se modernizó la cocina y baños integrándolos al patio central.",
            features: ["Albañilería general", "Instalaciones sanitarias", "Restauración", "Pintura"],
            images: [
                'https://images.unsplash.com/photo-1556912173-3db9963ee790?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=800&q=80'
            ]
        },
        {
            id: 4,
            title: "Casa del Lago",
            category: "vivienda",
            size: "320m²",
            location: "Nordelta",
            year: "2023",
            description: "Diseño exclusivo con vistas panorámicas al lago. Grandes ventanales y estructura metálica para lograr luces amplias sin columnas.",
            features: ["Llave en mano", "Piscina sin fin", "Domótica", "Sustentabilidad"],
            images: [
                'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1600573472592-401b489a3cdc?auto=format&fit=crop&w=800&q=80'
            ]
        },
        {
            id: 5,
            title: "Local Gastronómico",
            category: "comercial",
            size: "85m²",
            location: "San Telmo",
            year: "2023",
            description: "Identidad de marca aplicada a la arquitectura. Cocina a la vista y barra de tragos diseñada en microcemento.",
            features: ["Habilitación municipal", "Gas industrial", "Diseño de marca", "Fachada"],
            images: [
                'https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=800&q=80'
            ]
        }
    ];

    // ==========================================
    // 2. LÓGICA DE RENDERIZADO Y FILTROS
    // ==========================================
    const grid = document.getElementById('projects-grid');
    const filterBtns = document.querySelectorAll('.filter-btn');

    function renderProjects(filter = 'all') {
        grid.innerHTML = ''; // Limpiar grid
        
        const filtered = filter === 'all' 
            ? projects 
            : projects.filter(p => p.category === filter);

        filtered.forEach(p => {
            // Creamos la tarjeta
            const card = document.createElement('div');
            card.className = "group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 cursor-pointer border border-slate-100";
            card.onclick = () => openModal(p.id);

            card.innerHTML = `
                <div class="h-64 overflow-hidden relative">
                    <img src="${p.images[0]}" alt="${p.title}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        <span class="bg-white text-delsur-orange px-4 py-2 rounded-full text-xs font-bold shadow-lg flex items-center gap-2">
                            Ver Proyecto
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-delsur-orange uppercase tracking-wider mb-1 block">${p.category}</span>
                    <h3 class="text-xl font-bold text-delsur-blue mb-2 group-hover:text-delsur-orange transition-colors">${p.title}</h3>
                    <p class="text-slate-500 text-sm line-clamp-2">${p.description}</p>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    function filterProjects(cat) {
        // Actualizar botones
        filterBtns.forEach(btn => {
            if(btn.textContent.toLowerCase().includes(cat === 'all' ? 'todos' : cat)) {
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
    // 3. LÓGICA DEL MODAL Y CARRUSEL
    // ==========================================
    const modal = document.getElementById('project-modal');
    const modalContent = document.getElementById('modal-content');
    let currentProject = null;
    let currentSlide = 0;
    let autoPlayInterval = null;

    function openModal(id) {
        currentProject = projects.find(p => p.id === id);
        if(!currentProject) return;

        // Llenar datos
        document.getElementById('modal-title').textContent = currentProject.title;
        document.getElementById('modal-category').textContent = currentProject.category;
        document.getElementById('modal-desc').textContent = currentProject.description;
        document.getElementById('modal-size').textContent = currentProject.size;
        document.getElementById('modal-location').textContent = currentProject.location;
        document.getElementById('modal-year').textContent = currentProject.year;

        // Llenar features
        const featsList = document.getElementById('modal-features');
        featsList.innerHTML = '';
        currentProject.features.forEach(f => {
            const li = document.createElement('li');
            li.className = "flex items-center gap-2";
            li.innerHTML = `<span class="text-delsur-orange text-lg">•</span> ${f}`;
            featsList.appendChild(li);
        });

        // Configurar Botón de Acción para llevar el nombre del proyecto
        const actionBtn = document.getElementById('modal-action-btn');
        actionBtn.href = `comenzar.php?ref=${encodeURIComponent(currentProject.title)}`;

        // Configurar Carrusel
        setupCarousel(currentProject.images);

        // Mostrar Modal con animación
        modal.classList.remove('hidden');
        document.body.classList.add('modal-open');
        setTimeout(() => {
            modalContent.classList.remove('modal-enter');
            modalContent.classList.add('modal-enter-active');
        }, 10);

        startAutoPlay();
    }

    function closeModal() {
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
        track.innerHTML = '';
        dots.innerHTML = '';

        images.forEach((img, index) => {
            // Slide
            const imgEl = document.createElement('img');
            imgEl.src = img;
            imgEl.className = "carousel-slide";
            track.appendChild(imgEl);

            // Dot
            const dot = document.createElement('button');
            dot.className = `w-2 h-2 rounded-full transition-all ${index === 0 ? 'bg-white w-6' : 'bg-white/50'}`;
            dot.onclick = () => goToSlide(index);
            dots.appendChild(dot);
        });
        
        updateCarousel();
    }

    function updateCarousel() {
        const track = document.getElementById('carousel-track');
        track.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        // Update dots
        const dots = document.getElementById('carousel-dots').children;
        Array.from(dots).forEach((d, i) => {
            d.className = `w-2 h-2 rounded-full transition-all ${i === currentSlide ? 'bg-white w-6' : 'bg-white/50'}`;
        });
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
        stopAutoPlay(); // Si el usuario toca, frenamos el auto
        startAutoPlay(); // Y reiniciamos el timer
    }

    function startAutoPlay() {
        stopAutoPlay();
        autoPlayInterval = setInterval(nextSlide, 3000); // 3 segundos
    }

    function stopAutoPlay() {
        if(autoPlayInterval) clearInterval(autoPlayInterval);
    }

    // Pausar autoplay al hacer hover sobre la imagen
    document.getElementById('carousel-track').parentElement.addEventListener('mouseenter', stopAutoPlay);
    document.getElementById('carousel-track').parentElement.addEventListener('mouseleave', startAutoPlay);

    // Inicializar
    renderProjects();

  </script>
</body>
</html>