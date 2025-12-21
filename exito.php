<!doctype html>
<html lang="es-AR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>¡Pago Exitoso! — Del Sur Construcciones</title>
  <meta name="robots" content="noindex" />
  
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
          },
          animation: {
            'bounce-slow': 'bounce 3s infinite',
            'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
            'pulse-once': 'pulse 0.5s ease-in-out',
          },
          keyframes: {
            fadeInUp: {
              '0%': { opacity: '0', transform: 'translateY(20px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' },
            }
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col">

  <nav class="bg-white border-b border-slate-200 py-4">
    <div class="max-w-3xl mx-auto px-4 flex justify-center">
        <img src="./imagenes/logo.webp" alt="Del Sur" class="h-12 w-auto" />
    </div>
  </nav>

  <main class="flex-grow max-w-3xl mx-auto px-4 py-10 w-full">
    
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden animate-fade-in-up">
        
        <div class="bg-green-50 p-8 text-center border-b border-green-100">
            <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-500/30 animate-bounce-slow">
                <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">¡Pago Iniciado con Éxito!</h1>
            <p class="text-slate-600">Muchas gracias por confiar en nosotros. Ya estamos procesando tu solicitud.</p>
        </div>

        <div class="px-8 py-6 bg-slate-50 border-b border-slate-200">
            <div class="flex items-center justify-between text-xs sm:text-sm font-medium text-slate-500 relative">
                <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-200 -z-10 -mt-0.5 rounded-full"></div>
                
                <div class="flex flex-col items-center gap-2 bg-slate-50 px-2 z-10">
                    <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center font-bold">✓</div>
                    <span class="text-green-600 font-bold">Pago</span>
                </div>

                <div class="flex flex-col items-center gap-2 bg-slate-50 px-2 z-10 transition-all duration-500" id="step2Container">
                    <div id="step2Icon" class="w-8 h-8 rounded-full bg-delsur-blue text-white flex items-center justify-center font-bold ring-4 ring-blue-100 transition-all duration-500">2</div>
                    <span id="step2Text" class="text-delsur-blue font-bold transition-colors duration-500">Validar</span>
                </div>

                <div class="flex flex-col items-center gap-2 bg-slate-50 px-2 z-10">
                    <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center font-bold">3</div>
                    <span>Agendar</span>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="mb-10 text-center transition-opacity duration-500" id="actionSection">
                <h2 class="text-xl font-bold text-delsur-blue mb-4">Paso Final: Validar Pago</h2>
                <p class="text-slate-600 mb-6 text-sm">
                    Para activar tu servicio y agendar la reunión, necesitamos que nos envíes el comprobante o nos avises por WhatsApp.
                </p>
                
                <a id="btnWhatsapp" href="https://wa.me/5491123941812?text=Hola,%20acabo%20de%20realizar%20el%20pago%20del%20servicio.%20Quisiera%20validar%20y%20coordinar%20la%20agenda.%20Mi%20nombre%20es:" target="_blank" class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-8 py-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-500/30 transition-all transform hover:-translate-y-1 text-lg group cursor-pointer">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.463 1.065 2.876 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    <span id="btnText">Enviar Comprobante</span>
                </a>
            </div>

            <hr class="border-slate-100 my-8">

            <div>
                <h3 class="font-bold text-slate-700 mb-2">🚀 ¿Querés ganar tiempo?</h3>
                <p class="text-sm text-slate-500 mb-6">Contanos un poco sobre tu proyecto mientras validamos el pago.</p>

                <form id="detailsForm" class="space-y-4">
                    <input type="text" name="honeypot" style="display:none;" tabindex="-1" autocomplete="off">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tu Nombre</label>
                            <input type="text" name="nombre" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-delsur-blue focus:outline-none" placeholder="Ej: Juan Pérez">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tu Email</label>
                            <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-delsur-blue focus:outline-none" placeholder="juan@email.com">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">¿Qué tenés en mente?</label>
                        <select name="tipo_proyecto" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-delsur-blue focus:outline-none text-slate-600">
                            <option value="Obra Nueva">Obra Nueva (Casa desde cero)</option>
                            <option value="Refacción">Refacción / Ampliación</option>
                            <option value="Local Comercial">Local / Oficina</option>
                            <option value="Solo Consulta">Solo consulta técnica</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Detalles breves</label>
                        <textarea name="mensaje" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-delsur-blue focus:outline-none" placeholder="Ej: Terreno en Berazategui, aprox 120m2..."></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 bg-delsur-blue text-white font-bold rounded-xl hover:bg-slate-800 transition-colors">
                        Enviar detalles del proyecto
                    </button>
                    <p id="formStatus" class="text-center text-xs mt-2 min-h-[1.25rem]"></p>
                </form>
            </div>
        </div>
    </div>

    <div class="text-center mt-8">
        <a href="index.php" class="text-sm text-slate-400 hover:text-delsur-orange transition-colors">Volver al inicio</a>
    </div>

  </main>

  <script>
    // 1. Efecto visual al hacer clic en WhatsApp
    const btnWhatsapp = document.getElementById('btnWhatsapp');
    const btnText = document.getElementById('btnText');
    const step2Icon = document.getElementById('step2Icon');
    const step2Text = document.getElementById('step2Text');
    const actionSection = document.getElementById('actionSection');

    btnWhatsapp.addEventListener('click', () => {
        // A) Cambiar estado inmediato del botón
        btnText.textContent = "¡Abriendo WhatsApp...";
        btnWhatsapp.classList.add('opacity-75', 'pointer-events-none'); // Evitar doble clic
        
        // B) Simular "Listo" en la barra de progreso (1 segundo)
        setTimeout(() => {
            btnText.textContent = "¡Listo! Esperamos tu mensaje";
            
            // Cambiar el paso 2 a verde (Check)
            step2Icon.textContent = "✓";
            step2Icon.classList.remove('bg-delsur-blue', 'ring-blue-100');
            step2Icon.classList.add('bg-green-500', 'ring-green-100');
            step2Text.classList.remove('text-delsur-blue');
            step2Text.classList.add('text-green-600');

            // C) Mensaje Final Definitivo (8 segundos)
            setTimeout(() => {
                // Desvanecer la sección actual
                actionSection.style.opacity = '0';

                // Esperar a que se desvanezca y cambiar el contenido
                setTimeout(() => {
                    actionSection.innerHTML = `
                        <div class="bg-green-50 p-6 rounded-xl border border-green-200 animate-fade-in-up">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                            </div>
                            <h3 class="text-xl font-bold text-green-700 mb-2">¡Todo listo!</h3>
                            <p class="text-green-800 font-medium leading-relaxed">
                                Perfecto, validaremos el pago y nos estaremos contactando en la inmediatez.
                                <br><br>Muchas gracias.
                            </p>
                        </div>
                    `;
                    actionSection.style.opacity = '1';
                }, 500); // Tiempo que tarda el fade-out css
                
            }, 8000); // 8 segundos de espera

        }, 1000);
    });

    // 2. Lógica del formulario
    const detailsForm = document.getElementById('detailsForm');
    const formStatus = document.getElementById('formStatus');

    detailsForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        formStatus.textContent = 'Guardando información...';
        formStatus.className = 'text-center text-xs mt-2 text-slate-500';

        const data = new FormData(detailsForm);
        const mensajeCompleto = `[INFO PREVIA PAGO] Tipo: ${data.get('tipo_proyecto')}. Detalles: ${data.get('mensaje')}`;

        const payload = {
            nombre: data.get('nombre'),
            email: data.get('email'),
            mensaje: mensajeCompleto,
            honeypot: data.get('honeypot')
        };

        try {
            const res = await fetch('api/contact.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload),
            });

            if (res.ok) {
                formStatus.textContent = '¡Recibido! Ya tenemos los detalles de tu proyecto.';
                formStatus.className = 'text-center text-xs mt-2 text-green-600 font-bold';
                detailsForm.reset();
            } else {
                throw new Error('Error al guardar');
            }
        } catch (err) {
            formStatus.textContent = 'Hubo un error. Por favor envianos la info por WhatsApp.';
            formStatus.className = 'text-center text-xs mt-2 text-red-500';
        }
    });
  </script>

</body>
</html>