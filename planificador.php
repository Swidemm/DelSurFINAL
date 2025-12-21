<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Acceso Clientes — Del Sur Construcciones</title>
  <meta name="robots" content="noindex" />
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { delsur: { blue: '#1e2952', dark: '#0f172a', orange: '#f97316' } },
          fontFamily: { sans: ['Inter', 'sans-serif'] }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    .glass {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    @keyframes loading {
        0% { transform: translateX(-100%); }
        50% { transform: translateX(0); }
        100% { transform: translateX(100%); }
    }
    #preloader { transition: opacity 0.6s ease-out, visibility 0.6s; }
  </style>
</head>
<body class="bg-slate-900 text-white font-sans min-h-screen flex items-center justify-center relative overflow-hidden">

  <div id="preloader" class="fixed inset-0 z-[100] bg-slate-900 flex items-center justify-center">
    <div class="flex flex-col items-center gap-6">
        <img src="./imagenes/logo.webp" alt="Cargando..." class="h-20 w-auto animate-pulse brightness-0 invert" />
        <div class="w-32 h-1.5 bg-slate-800 rounded-full overflow-hidden relative">
            <div class="h-full bg-delsur-orange w-full absolute top-0 left-0 animate-[loading_1.5s_infinite_linear]"></div>
        </div>
        <p class="text-xs text-slate-500 font-medium tracking-widest uppercase">Iniciando Sistema</p>
    </div>
  </div>

  <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTAgNDBMMDQgMEgwIiBmaWxsPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDUpIi8+PC9zdmc+')] opacity-20"></div>
  <div class="absolute top-0 right-0 w-96 h-96 bg-delsur-orange opacity-10 rounded-full blur-[100px]"></div>

  <div id="loginScreen" class="relative z-10 w-full max-w-md p-4">
      <div class="glass rounded-2xl p-8 shadow-2xl text-center">
          <img src="./imagenes/logo.webp" alt="Del Sur" class="h-16 w-auto mx-auto mb-6 brightness-0 invert" />
          <h1 class="text-2xl font-bold mb-2">Planificador Studio 2D</h1>
          <p class="text-slate-400 text-sm mb-8">Área exclusiva para clientes con Pack Premium.</p>
          <form id="loginForm" class="space-y-4">
              <div>
                  <input type="password" id="accessCode" placeholder="Ingresá tu Clave de Acceso" 
                      class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-center text-white focus:ring-2 focus:ring-delsur-orange focus:outline-none transition-all placeholder:text-slate-600"
                  >
              </div>
              <button type="submit" class="w-full py-3 bg-delsur-orange hover:bg-orange-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-orange-900/20">INGRESAR AL SISTEMA</button>
              <p id="errorMsg" class="text-red-400 text-xs h-4 mt-2"></p>
          </form>
          <div class="mt-6 pt-6 border-t border-white/10">
              <p class="text-xs text-slate-500">¿No tenés clave?</p>
              <a href="pagos.php" class="text-delsur-orange text-xs font-bold hover:underline">Adquirir Pack Premium</a>
          </div>
          <div class="mt-4"><a href="index.php" class="text-slate-500 text-xs hover:text-white transition-colors">← Volver al inicio</a></div>
      </div>
  </div>

  <div id="appContainer" class="fixed inset-0 z-50 bg-slate-900 hidden">
      <iframe src="planificador-lite.php" class="w-full h-full border-0" allowfullscreen></iframe>
      
      <button id="btnExit" class="absolute bottom-4 left-4 bg-red-500/80 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-xs font-bold backdrop-blur-sm transition-colors shadow-lg flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
          Salir y Volver al Inicio
      </button>
  </div>

  <script>
    // 1. PRELOADER
    window.addEventListener('load', () => {
        setTimeout(() => {
            const loader = document.getElementById('preloader');
            loader.classList.add('opacity-0', 'invisible');
        }, 2000);
    });
    
    // 2. LÓGICA DE LOGIN
    const loginForm = document.getElementById('loginForm');
    const loginScreen = document.getElementById('loginScreen');
    const appContainer = document.getElementById('appContainer');
    const errorMsg = document.getElementById('errorMsg');
    const SECRET_CODE = "DELSUR24"; 

    // Verificar si ya estaba logueado
    if (sessionStorage.getItem('isLogged') === 'true') { showApp(); }

    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const input = document.getElementById('accessCode').value;
        if (input === SECRET_CODE) {
            sessionStorage.setItem('isLogged', 'true');
            showApp();
        } else {
            errorMsg.textContent = "Clave incorrecta. Revisá tu comprobante.";
            document.getElementById('accessCode').classList.add('border-red-500');
            setTimeout(() => {
                document.getElementById('accessCode').classList.remove('border-red-500');
                errorMsg.textContent = "";
            }, 2000);
        }
    });

    function showApp() {
        loginScreen.classList.add('hidden');
        appContainer.classList.remove('hidden');
    }

    // 3. LÓGICA DEL BOTÓN SALIR (NUEVO)
    document.getElementById('btnExit').addEventListener('click', () => {
        // Mostrar pantalla de carga para transición suave
        document.getElementById('preloader').classList.remove('opacity-0', 'invisible');
        
        // Limpiar la sesión para que si vuelve, le pida clave de nuevo
        sessionStorage.removeItem('isLogged');
        
        // Redirigir al Index después de un breve delay
        setTimeout(() => {
            window.location.href = 'index.php';
        }, 800);
    });

    // 4. TRANSICIONES DE LINKS NORMALES (Login screen)
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (href && !href.startsWith('#')) {
                e.preventDefault();
                document.getElementById('preloader').classList.remove('opacity-0', 'invisible');
                setTimeout(() => window.location.href = href, 400);
            }
        });
    });
  </script>
</body>
</html>