<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Planificador Espacial — Lite 2D</title>
  <!-- Base site styles -->
  <link rel="stylesheet" href="css/styles.css">
  <!-- Planificador specific styles -->
  <link rel="stylesheet" href="css/planificador.css">
</head>
<body>
  <div class="app">
    <!-- Header with toolbars -->
    <header>
      <div class="title">Planificador Espacial <span class="badge">Lite • 2D</span></div>
      <div class="toolbar">
        <div class="toolgroup" id="grp-nav"><span class="title">Navegación</span>
          <button class="toolbtn" id="tool-select">👆 Seleccionar</button>
          <button class="toolbtn" id="tool-pan">✋ Mover</button>
        </div>
        <div class="toolgroup" id="grp-draw"><span class="title">Dibujo</span>
          <button class="toolbtn" id="tool-wall">🧱 Pared</button>
          <button class="toolbtn" id="tool-room">📐 Habitación</button>
          <button class="toolbtn" id="tool-door">🚪 Puerta</button>
          <button class="toolbtn" id="tool-window">🪟 Ventana</button>
        </div>
        <div class="toolgroup" id="grp-edit"><span class="title">Edición</span>
          <button class="toolbtn" id="tool-undo" title="Deshacer">↶</button>
          <button class="toolbtn" id="tool-redo" title="Rehacer">↷</button>
          <button class="toolbtn" id="tool-erase" title="Borrar selección">🗑️</button>
          <button class="toolbtn" id="tool-reset" title="Reiniciar">🧹</button>
        </div>
      </div>
    </header>
    <!-- Main layout: library, editor, inspector -->
    <div class="row">
      <!-- Biblioteca (sin funcionalidad por ahora) -->
      <aside class="panel">
        <h3>Biblioteca</h3>
        <div class="library" id="library">
          <!-- Muebles y objetos disponibles -->
          <div class="lib-item" data-type="table" data-w="1.4" data-d="0.8">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="7" width="18" height="10" rx="2" fill="#2b3a52"/><rect x="5" y="9" width="2" height="6" fill="#0f1422"/><rect x="17" y="9" width="2" height="6" fill="#0f1422"/></svg>
            <div><strong>Mesa</strong><br/><span>1.4 × 0.8 m</span></div>
          </div>
          <div class="lib-item" data-type="mesada" data-w="2.0" data-d="0.6">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="7" width="18" height="10" rx="2" fill="#263348"/><rect x="6" y="9" width="6" height="6" rx="1" fill="#0d1526"/><rect x="12" y="9" width="6" height="6" rx="1" fill="#0d1526"/></svg>
            <div><strong>Mesada</strong><br/><span>2.0 × 0.6 m</span></div>
          </div>
          <div class="lib-item" data-type="bacha" data-w="0.8" data-d="0.6">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="6" width="16" height="12" rx="2" fill="#223047"/><rect x="7" y="9" width="10" height="6" rx="1" fill="#31455f"/></svg>
            <div><strong>Bacha</strong><br/><span>0.8 × 0.6 m</span></div>
          </div>
          <div class="lib-item" data-type="horno" data-w="0.6" data-d="0.6">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="5" width="14" height="14" rx="2" fill="#1e2a42"/><rect x="7" y="7" width="10" height="10" rx="1" fill="#0c1424"/></svg>
            <div><strong>Horno</strong><br/><span>0.6 × 0.6 m</span></div>
          </div>
          <div class="lib-item" data-type="mesita" data-w="0.5" data-d="0.5">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="6" y="9" width="12" height="6" rx="1" fill="#1f2937"/><rect x="6" y="7" width="12" height="2" fill="#2b3a52"/></svg>
            <div><strong>Mesita</strong><br/><span>0.5 × 0.5 m</span></div>
          </div>
          <div class="lib-item" data-type="tv" data-w="1.2" data-d="0.2">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="6" width="18" height="12" rx="2" fill="#0a0f18"/><rect x="5" y="8" width="14" height="8" fill="#0c111b"/></svg>
            <div><strong>TV</strong><br/><span>1.2 × 0.2 m</span></div>
          </div>
          <div class="lib-item" data-type="heladera" data-w="0.7" data-d="0.7">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="4" width="14" height="16" rx="2" fill="#1c2640"/><line x1="5" y1="12" x2="19" y2="12" stroke="#6b7c96"/></svg>
            <div><strong>Heladera</strong><br/><span>0.7 × 0.7 m</span></div>
          </div>
          <div class="lib-item" data-type="flecha" data-w="0.5" data-d="0.2">
            <svg viewBox="0 0 24 24" aria-hidden="true"><polygon points="6,12 18,12 12,6" fill="#2a3a4f"/></svg>
            <div><strong>Flecha</strong><br/><span>0.5 × 0.2 m</span></div>
          </div>
        </div>
      </aside>
      <!-- Editor 2D -->
      <section class="panel" style="display:grid; grid-template-rows:auto 1fr auto;">
        <h3>Editor 2D</h3>
        <div class="canvas-wrap" id="canvasWrap">
          <canvas id="plan2d"></canvas>
          <div class="overlays">
            <div class="hud"><div class="status" id="hudStatus"></div></div>
          </div>
        </div>
        <div class="controls">
          <div class="group"><label>Escala</label> <input id="scaleInput" type="number" step="0.1" min="0.1" value="40"> <span class="muted">px/m</span></div>
          <div class="group"><label>Altura muro</label> <input id="wallH" type="number" step="0.1" value="2.7"> <span class="muted">m</span></div>
          <div class="group"><label>Espesor muro</label> <input id="wallT" type="number" step="0.01" value="0.15"> <span class="muted">m</span></div>
          <div class="group"><label><input id="snap" type="checkbox" checked> Snap</label></div>
          <div class="group"><label><input id="gridToggle" type="checkbox" checked> Grilla</label></div>
        </div>
      </section>
      <!-- Inspector (no funcional en MVP) -->
      <aside class="panel" id="inspectorPanel">
        <h3>Inspector</h3>
        <div id="inspectorContent" style="padding:10px; display:grid; gap:.6rem; align-content:start;">
          <div class="muted">Seleccioná una pared para ver sus propiedades.</div>
        </div>
      </aside>
    </div>
  </div>
  <!-- Planificador JS -->
  <script src="js/planificador.js"></script>
</body>
</html>