Este paquete contiene la versión estática en PHP del sitio "Del Sur Construcciones".

Estructura:
- index.php, pagos.php, planificador.php, planificador-lite.php: páginas estáticas convertidas directamente de sus homónimos .html. El contenido y diseño se mantienen sin cambios.
- css/, favicon/, imagenes/, videos/: recursos estáticos copiados del proyecto original.
- contacts.json: archivo JSON que almacenará mensajes de contacto recibidos.
- api/contact.php: script PHP que recibe peticiones POST en formato JSON para el endpoint `/api/contact`. Se encarga de añadir un timestamp, almacenar los datos en `contacts.json` y retornar un JSON con `success:true`.
- .htaccess: reglas para redirigir `/api/contact` a `api/contact.php` y definir tipos MIME para archivos JSON.

Para desplegar:
1. Subir todo el contenido al directorio público de su hosting (por ejemplo, `public_html`).
2. Asegurarse de que el servidor tenga soporte para PHP y mod_rewrite habilitado.
3. Opcionalmente ajustar permisos de escritura para `contacts.json` si se requiere almacenar envíos de formularios.

Luego de desplegar, el sitio debería comportarse igual que la versión original en Node, con la ventaja de que ahora es puramente estático y gestionado por PHP para el API de contacto.
