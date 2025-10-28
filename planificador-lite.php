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
        <div class="library" id="library" style="padding:10px; color: var(--muted); font-size:0.9rem;">
          Herramientas de mobiliario no disponibles en esta versión.
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