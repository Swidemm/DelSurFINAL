<?php
// Archivo planificador-lite.php - Tool completo sin cambios dinámicos
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Planificador Espacial — Lite (v9.6)</title>
<style>
  :root{
    --ui-scale:1;
    --accent:#6ee7ff;
    --bg:#0f172a; --panel:#1c2330; --ink:#e8ecf1; --muted:#aab4c0; --grid:#1f2b36; --grid-strong:#294256;
    --shadow: 0 8px 24px rgba(0,0,0,.35);
  }
  *{box-sizing:border-box}
  html,body{height:100%;margin:0;font-family:Inter,system-ui,Segoe UI,Roboto,Helvetica,Arial;color:var(--ink);background:var(--bg);font-size:calc(16px * var(--ui-scale))}
  .app{display:grid;grid-template-rows:auto 1fr;min-height:100%}
  header{display:flex;align-items:center;gap:.5rem;padding:.6rem .8rem;background:#121726;border-bottom:1px solid #1f2433;position:sticky;top:0;z-index:5}
  .title{font-weight:700}.badge{font-size:.75rem;color:#7dd3fc;background:rgba(125,211,252,.12);padding:.1rem .45rem;border:1px solid rgba(125,211,252,.25);border-radius:.5rem}
  .toolbar{display:flex;flex-wrap:wrap;gap:.6rem;margin-left:auto;align-items:center}
  .toolgroup{display:flex;gap:.35rem;align-items:center;padding:.3rem;border:1px solid #1f2433;border-radius:.7rem;background:#0f1422}
  .toolgroup .title{font-size:.72rem;color:#9fb2c9;margin-right:.3rem}
  .toolbtn{appearance:none;border:1px solid #27314a;background:#151b2c;color:var(--ink);padding:.45rem .6rem;border-radius:.6rem;cursor:pointer;display:inline-flex;align-items:center;gap:.4rem;box-shadow:var(--shadow);transition:.15s;line-height:1}
  .toolbtn:hover{transform:translateY(-1px);background:#1a2033}
  .toolbtn[data-active="true"]{border-color:#5eead4;background:rgba(94,234,212,.1)}
  .row{display:grid;grid-template-columns:260px 1fr 300px;gap:10px;padding:10px}
  .panel{background:var(--panel);border:1px solid #1c2130;border-radius:16px;box-shadow:var(--shadow);min-height:200px;overflow:hidden}
  .panel h3{margin:0;padding:.6rem .9rem;border-bottom:1px solid #1f2433;background:#121726;font-size:.95rem;color:#cdd6e3}
  .library{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.5rem;padding:10px}
  .lib-item{border:1px dashed #2a3146;border-radius:12px;padding:.55rem;background:#111525;display:grid;grid-template-columns:26px 1fr;align-items:center;gap:.4rem;cursor:grab}
  .lib-item svg{width:22px;height:22px;opacity:.95}
  .canvas-wrap{position:relative;height:clamp(420px, 70vh, 900px)}
  #plan2d{width:100%;height:100%;display:block;background:radial-gradient(circle at 10% 0%, #131827 0%, #10131c 55%);touch-action:none}
  .overlays{position:absolute;inset:0;pointer-events:none}
  .hud{position:absolute;left:10px;bottom:10px;background:rgba(17,21,37,.85);border:1px solid #2b3247;border-radius:10px;padding:.5rem .6rem;font-size:.82rem;color:#cdd6e3}
  .controls{display:flex;flex-wrap:wrap;gap:.5rem;padding:.5rem 10px;background:#101425;border-top:1px solid #1f2433}
  .controls .group{display:flex;align-items:center;gap:.4rem;background:#0f1425;border:1px solid #1f2235;border-radius:12px;padding:.35rem .5rem}
  input[type="number"]{background:#0e1324;border:1px solid #26304a;color:#e6edf7;border-radius:8px;padding:.35rem .5rem;min-width:70px}
  /* Mini HUD contextual */
  .mini-hud{position:absolute;transform-origin:top left; pointer-events:auto; z-index:6;
    background:rgba(17,21,37,.92); border:1px solid #2b3247; border-radius:10px; box-shadow:0 10px 24px rgba(0,0,0,.35);
    display:flex; gap:.25rem; padding:.25rem; opacity:0; transform:translateY(-4px) scale(.98); transition:.15s ease; }
  .mini-hud.show{opacity:1; transform:translateY(0) scale(1);}
  .mini-hud .mh-btn{appearance:none;border:1px solid #2a3146;background:#111525;color:#dbe7f5;border-radius:.5rem;
    padding:.3rem .45rem; cursor:pointer; font-size:.9rem; display:inline-flex; align-items:center; gap:.35rem}
  .mini-hud .mh-btn:hover{background:#172036; transform:translateY(-1px)}
  /* Tour */
  .tour-mask{position:fixed; inset:0; background:rgba(8,12,22,.6); backdrop-filter:saturate(120%) blur(1px);
    z-index:20; opacity:0; pointer-events:none; transition:.15s}
  .tour-mask.show{opacity:1; pointer-events:auto;}
  .tour-spotlight{position:absolute; border:2px solid #7dd3fc; border-radius:8px; background:rgba(125,211,252,.05); pointer-events:none; transition:.2s;}
  .tour-step{display:none; position:fixed; z-index:21; background:var(--panel); border:1px solid var(--muted); border-radius:12px; padding:1.2rem; max-width:320px; color:var(--ink); box-shadow:var(--shadow);}
  .tour-step.show{display:block;}
  .tour-step h4{margin:0 0 .5rem 0; font-size:1.1rem; color:var(--accent);}
  .tour-step p{margin:0 0 .8rem 0; line-height:1.4;}
  .tour-step .actions{display:flex; gap:.5rem; justify-content:flex-end;}
  .tour-step .tour-btn{background:var(--accent); color:#0f172a; border:none; padding:.4rem .8rem; border-radius:6px; cursor:pointer; font-weight:500;}
  .tour-step .tour-btn.secondary{background:transparent; color:var(--accent); border:1px solid var(--accent);}
  .tour-arrow{position:absolute; width:0; height:0; border:8px solid transparent; z-index:22; pointer-events:none;}
  .tour-arrow.top{top:-16px; left:50%; transform:translateX(-50%); border-bottom-color:var(--panel);}
  .tour-arrow.bottom{bottom:-16px; left:50%; transform:translateX(-50%); border-top-color:var(--panel);}
  .tour-arrow.left{left:-16px; top:50%; transform:translateY(-50%); border-right-color:var(--panel);}
  .tour-arrow.right{right:-16px; top:50%; transform:translateY(-50%); border-left-color:var(--panel);}
  /* Responsive */
  @media (max-width: 1024px){
    .row{grid-template-columns:1fr; gap:8px; padding:8px;}
    .panel{min-height:180px;}
  }
  @media (max-width: 768px){
    .toolbar{flex-direction:column; align-items:stretch; gap:.4rem;}
    .toolgroup{justify-content:center;}
    .canvas-wrap{height:clamp(300px,60vh,600px);}
    .hud{left:50%; bottom:8px; transform:translateX(-50%); font-size:.75rem; padding:.4rem;}
    .controls{flex-direction:column; gap:.4rem;}
    .controls .group{justify-content:center;}
    input[type="number"]{min-width:60px;}
  }
</style>
</head>
<body>
<div class="app">
  <header>
    <h1 class="title">Planificador Espacial <span class="badge">Lite v9.6</span></h1>
    <div class="toolbar">
      <div class="toolgroup">
        <span class="title">Vista:</span>
        <button id="tool-view-2d" class="toolbtn" data-active="true" title="Vista 2D">2D</button>
        <button id="tool-view-3d" class="toolbtn" title="Vista 3D (WIP)">3D</button>
      </div>
      <div class="toolgroup">
        <span class="title">Herramientas:</span>
        <button id="tool-wall" class="toolbtn" title="Dibujar pared">🧱</button>
        <button id="tool-door" class="toolbtn" title="Agregar puerta">🚪</button>
        <button id="tool-window" class="toolbtn" title="Agregar ventana">🪟</button>
        <button id="tool-item" class="toolbtn" title="Agregar mueble">📦</button>
      </div>
      <div class="toolgroup">
        <span class="title">Acciones:</span>
        <button id="tool-undo" class="toolbtn" title="Deshacer (Ctrl+Z)">↶</button>
        <button id="tool-redo" class="toolbtn" title="Rehacer (Ctrl+Y)">↷</button>
        <button id="tool-clear" class="toolbtn" title="Limpiar todo">🗑️</button>
      </div>
      <div class="toolgroup">
        <span class="title">Tema:</span>
        <input id="theme-brand" type="color" value="#6ee7ff" title="Color principal">
        <button id="tool-theme-load" class="toolbtn" title="Cargar tema">📁</button>
        <button id="tool-theme-save" class="toolbtn" title="Guardar tema">💾</button>
      </div>
      <div class="toolgroup">
        <span class="title">UI:</span>
        <button id="tool-text-plus" class="toolbtn" title="Aumentar texto (+10%)">+</button>
        <button id="tool-text-minus" class="toolbtn" title="Reducir texto (-10%)">−</button>
        <button id="tool-tour" class="toolbtn" title="Tour guiado">ℹ️</button>
      </div>
    </div>
  </header>
  <div class="row">
    <!-- Panel izquierdo: Biblioteca -->
    <div class="panel">
      <h3>Biblioteca de elementos</h3>
      <div class="library" id="library">
        <!-- Elementos se cargan dinámicamente -->
      </div>
    </div>
    <!-- Canvas central -->
    <div class="canvas-wrap">
      <canvas id="plan2d"></canvas>
      <div class="overlays">
        <svg class="grid" id="grid-svg"></svg>
        <div class="hud" id="hud">
          <span id="hud-coords">X:0 Y:0</span> | <span id="hud-scale">Escala: 1:50</span>
        </div>
        <div class="mini-hud" id="mini-hud"></div>
      </div>
    </div>
    <!-- Panel derecho: Propiedades -->
    <div class="panel">
      <h3>Propiedades</h3>
      <div id="properties" style="padding:10px;">
        <p style="text-align:center; color:var(--muted);">Selecciona un elemento para editar</p>
      </div>
      <div class="controls">
        <div class="group">
          <label>Zoom:</label>
          <input type="number" id="zoom-ctrl" min="0.1" max="5" step="0.1" value="1">
        </div>
        <div class="group">
          <label>Grid:</label>
          <input type="number" id="grid-size" min="0.05" max="1" step="0.05" value="0.2">
        </div>
        <div class="group">
          <button id="export-pdf" class="tour-btn">Exportar PDF</button>
          <button id="export-json" class="tour-btn secondary">Exportar JSON</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Tour steps (ocultos por defecto) -->
<div id="tour-step-1" class="tour-step">
  <h4>¡Bienvenido al Planificador!</h4>
  <p>Este es un tool lite para diseñar espacios en 2D. Usa las herramientas arriba para empezar.</p>
  <div class="actions">
    <button class="tour-btn" onclick="nextTourStep()">Siguiente</button>
  </div>
</div>
<div id="tour-step-2" class="tour-step">
  <h4>Dibuja paredes</h4>
  <p>Selecciona 🧱 y haz clic+arrastrar en el canvas para crear paredes.</p>
  <div class="actions">
    <button class="tour-btn secondary" onclick="prevTourStep()">Anterior</button>
    <button class="tour-btn" onclick="nextTourStep()">Siguiente</button>
  </div>
</div>
<div id="tour-step-3" class="tour-step">
  <h4>Agrega elementos</h4>
  <p>Elige de la biblioteca izquierda y colócalos. Usa Q/E para rotar, flechas para mover.</p>
  <div class="actions">
    <button class="tour-btn secondary" onclick="prevTourStep()">Anterior</button>
    <button class="tour-btn" onclick="endTour()">Finalizar</button>
  </div>
</div>

<script>
// ===== Estado global =====
let state = {
  // Configuración
  zoom: 1,
  offsetX: 0,
  offsetY: 0,
  gridSize: 0.2,
  snapToGrid: true,
  unit: 'm', // metros

  // Elementos
  walls: [], // {id, a:{x,y}, b:{x,y}, thick:0.1}
  openings: [], // {id, wallId, pos:0-1, width:0.8, type:'door'|'window', angle:90}
  items: [], // {id, type:'chair' etc., x,y, w:1, d:1, rot:0, asset:'svg-path-or-url'}

  // UI
  tool: 'select', // 'wall', 'door', 'window', 'item'
  selection: null, // {type:'wall'|'opening'|'item', id}
  history: [{walls: [], openings: [], items: []}],
  historyIndex: 0,

  // Render
  canvas: null,
  ctx: null,
  gridSvg: null,
  nextId: 1
};

// Biblioteca de elementos (muebles, etc.)
const library = [
  {type: 'silla', w:0.6, d:0.6, svg: '<path d="M0 0h.6v.4h-.2v.8h-.2V.4H0z"/>', label: 'Silla'},
  {type: 'mesa', w:1.2, d:0.8, svg: '<rect x="0" y="0" width="1.2" height="0.8" rx="0.1"/>', label: 'Mesa'},
  {type: 'cama', w:2, d:1.8, svg: '<rect x="0" y="0" width="2" height="1.8" rx="0.2"/>', label: 'Cama doble'},
  {type: 'sofa', w:2.5, d:0.9, svg: '<rect x="0" y="0" width="2.5" height="0.9" rx="0.15"/>', label: 'Sofá'},
  {type: 'armario', w:1, d:0.6, svg: '<rect x="0" y="0" width="1" height="2" rx="0.05"/><rect x="0.05" y="0.05" width="0.9" height="1.9" fill="none" stroke="#aaa" stroke-width="0.02"/>', label: 'Armario'}
];

// ===== Inicialización =====
document.addEventListener('DOMContentLoaded', () => {
  state.canvas = document.getElementById('plan2d');
  state.ctx = state.canvas.getContext('2d');
  state.gridSvg = document.getElementById('grid-svg');

  // Config canvas
  state.canvas.width = state.canvas.offsetWidth;
  state.canvas.height = state.canvas.offsetHeight;
  resizeCanvas();
  window.addEventListener('resize', resizeCanvas);

  // Cargar biblioteca
  loadLibrary();

  // Event listeners
  setupEventListeners();

  // Inicializar historia
  pushHist();

  // Dibujar inicial
  draw();
  renderProperties();
  renderMiniHUD();

  // Cargar tema guardado
  applyThemeFromStorage();

  // Tour inicial si es primera vez
  if (!localStorage.getItem('tour-seen')) startTour();
});

// ===== Funciones de utilidad =====
function resizeCanvas() {
  state.canvas.width = state.canvas.offsetWidth * window.devicePixelRatio;
  state.canvas.height = state.canvas.offsetHeight * window.devicePixelRatio;
  state.ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
  draw();
}

function worldToScreen(x, y) {
  return {
    x: (x - state.offsetX) * state.zoom * 50 + state.canvas.width / 2, // 50px por metro
    y: (y - state.offsetY) * state.zoom * 50 + state.canvas.height / 2
  };
}

function screenToWorld(sx, sy) {
  return {
    x: (sx - state.canvas.width / 2) / (state.zoom * 50) + state.offsetX,
    y: (sy - state.canvas.height / 2) / (state.zoom * 50) + state.offsetY
  };
}

function snapToGrid(x, y) {
  if (!state.snapToGrid) return {x, y};
  return {
    x: Math.round(x / state.gridSize) * state.gridSize,
    y: Math.round(y / state.gridSize) * state.gridSize
  };
}

// ===== Renderizado =====
function draw() {
  const ctx = state.ctx;
  const w = state.canvas.width / window.devicePixelRatio;
  const h = state.canvas.height / window.devicePixelRatio;

  // Limpiar
  ctx.clearRect(0, 0, w, h);

  // Grid
  drawGrid(ctx, w, h);

  // Paredes
  state.walls.forEach(wall => drawWall(ctx, wall));

  // Aperturas
  state.openings.forEach(opening => drawOpening(ctx, opening));

  // Elementos
  state.items.forEach(item => drawItem(ctx, item));

  // Selección
  if (state.selection) drawSelection(ctx, state.selection);

  // Actualizar HUD
  updateHud();
}

function drawGrid(ctx, w, h) {
  const step = state.gridSize / state.zoom;
  const startX = Math.floor((state.offsetX - w / (2 * 50 / state.zoom)) / step) * step;
  const startY = Math.floor((state.offsetY - h / (2 * 50 / state.zoom)) / step) * step;
  const cols = Math.ceil(w / (50 * step)) + 1;
  const rows = Math.ceil(h / (50 * step)) + 1;

  ctx.strokeStyle = 'rgba(125,211,252,0.1)';
  ctx.lineWidth = 1;
  for (let i = 0; i < cols; i++) {
    const x = startX + i * step;
    const screenX = worldToScreen(x, 0).x;
    ctx.beginPath();
    ctx.moveTo(screenX, 0);
    ctx.lineTo(screenX, h);
    ctx.stroke();
  }
  for (let j = 0; j < rows; j++) {
    const y = startY + j * step;
    const screenY = worldToScreen(0, y).y;
    ctx.beginPath();
    ctx.moveTo(0, screenY);
    ctx.lineTo(w, screenY);
    ctx.stroke();
  }

  // Líneas fuertes cada 1m
  ctx.strokeStyle = 'rgba(125,211,252,0.3)';
  ctx.setLineDash([5, 5]);
  for (let i = 0; i < cols; i += 1 / state.gridSize) {
    const x = startX + i * step * state.gridSize;
    const screenX = worldToScreen(x, 0).x;
    ctx.beginPath();
    ctx.moveTo(screenX, 0);
    ctx.lineTo(screenX, h);
    ctx.stroke();
  }
  ctx.setLineDash([]);
}

function drawWall(ctx, wall) {
  const a = worldToScreen(wall.a.x, wall.a.y);
  const b = worldToScreen(wall.b.x, wall.b.y);
  const dx = b.x - a.x;
  const dy = b.y - a.y;
  const len = Math.sqrt(dx*dx + dy*dy);
  const thick = wall.thick * state.zoom * 50;

  // Pared principal
  ctx.fillStyle = '#334155';
  ctx.beginPath();
  ctx.moveTo(a.x, a.y);
  ctx.lineTo(b.x, b.y);
  ctx.lineTo(b.x - dy * thick / len, b.y + dx * thick / len);
  ctx.lineTo(a.x - dy * thick / len, a.y + dx * thick / len);
  ctx.closePath();
  ctx.fill();

  // Bordes
  ctx.strokeStyle = '#475569';
  ctx.lineWidth = 2;
  ctx.beginPath();
  ctx.moveTo(a.x, a.y);
  ctx.lineTo(b.x, b.y);
  ctx.stroke();

  // Aperturas en pared
  state.openings.filter(o => o.wallId === wall.id).forEach(opening => {
    const posX = a.x + (b.x - a.x) * opening.pos;
    const posY = a.y + (b.y - a.y) * opening.pos;
    const openW = opening.width * len;
    const perpX = -dy / len * openW / 2;
    const perpY = dx / len * openW / 2;

    if (opening.type === 'door') {
      ctx.fillStyle = '#f1f5f9';
      ctx.beginPath();
      ctx.arc(posX, posY, thick / 2, 0, Math.PI * 2);
      ctx.fill();
    } else if (opening.type === 'window') {
      ctx.strokeStyle = '#e2e8f0';
      ctx.lineWidth = 4;
      ctx.beginPath();
      ctx.moveTo(posX - perpX, posY - perpY);
      ctx.lineTo(posX + perpX, posY + perpY);
      ctx.stroke();
    }
  });
}

function drawOpening(ctx, opening) {
  // Ya dibujado en drawWall; aquí solo si necesita extra (ej: 3D)
}

function drawItem(ctx, item) {
  const pos = worldToScreen(item.x, item.y);
  const sizeW = item.w * state.zoom * 50;
  const sizeD = item.d * state.zoom * 50;
  const rotRad = (item.rot || 0) * Math.PI / 180;

  ctx.save();
  ctx.translate(pos.x, pos.y);
  ctx.rotate(rotRad);
  ctx.fillStyle = '#64748b';
  ctx.fillRect(-sizeW / 2, -sizeD / 2, sizeW, sizeD);
  ctx.strokeStyle = '#94a3b8';
  ctx.lineWidth = 1;
  ctx.strokeRect(-sizeW / 2, -sizeD / 2, sizeW, sizeD);
  ctx.restore();
}

function drawSelection(ctx, sel) {
  if (sel.type === 'item') {
    const item = state.items.find(i => i.id === sel.id);
    if (!item) return;
    const pos = worldToScreen(item.x, item.y);
    const size = Math.max(item.w, item.d) * state.zoom * 50 * 1.1;
    ctx.strokeStyle = '#3b82f6';
    ctx.lineWidth = 2;
    ctx.setLineDash([5, 5]);
    ctx.beginPath();
    ctx.arc(pos.x, pos.y, size / 2, 0, Math.PI * 2);
    ctx.stroke();
    ctx.setLineDash([]);
  }
  // Similar para walls y openings
}

function updateHud() {
  const mousePos = screenToWorld(state.canvas.width / 2, state.canvas.height / 2); // Centro por ahora
  document.getElementById('hud-coords').textContent = `X:${mousePos.x.toFixed(1)} Y:${mousePos.y.toFixed(1)}`;
  document.getElementById('hud-scale').textContent = `Escala: 1:${Math.round(50 / state.zoom)}`;
}

// ===== Interacciones =====
function setupEventListeners() {
  // Tool buttons
  document.getElementById('tool-wall').onclick = () => setTool('wall');
  document.getElementById('tool-door').onclick = () => setTool('door');
  document.getElementById('tool-window').onclick = () => setTool('window');
  document.getElementById('tool-item').onclick = () => setTool('item');
  document.getElementById('tool-view-2d').onclick = () => { /* 2D active */ };
  document.getElementById('tool-undo').onclick = undo;
  document.getElementById('tool-redo').onclick = redo;
  document.getElementById('tool-clear').onclick = clearAll;
  document.getElementById('tool-tour').onclick = startTour;

  // Controles
  document.getElementById('zoom-ctrl').oninput = (e) => { state.zoom = parseFloat(e.target.value); draw(); };
  document.getElementById('grid-size').oninput = (e) => { state.gridSize = parseFloat(e.target.value); draw(); };

  // Canvas events
  let isDragging = false;
  let dragStart = {x:0, y:0};

  state.canvas.onmousedown = (e) => {
    const rect = state.canvas.getBoundingClientRect();
    const sx = (e.clientX - rect.left) * (state.canvas.width / rect.width) / window.devicePixelRatio;
    const sy = (e.clientY - rect.top) * (state.canvas.height / rect.height) / window.devicePixelRatio;
    const pos = screenToWorld(sx, sy);
    const snapped = snapToGrid(pos.x, pos.y);

    state.selection = getElementAt(pos); // Seleccionar si hay

    if (state.tool === 'wall') {
      if (!isDragging) {
        // Iniciar nueva pared
        const newWall = {id: state.nextId++, a: {...snapped}, b: {...snapped}, thick: 0.1};
        state.walls.push(newWall);
        dragStart = snapped;
        isDragging = true;
      }
    } else if (state.tool === 'item' && state.librarySelection) {
      // Colocar item de biblioteca
      const newItem = {
        id: state.nextId++,
        type: state.librarySelection.type,
        x: snapped.x,
        y: snapped.y,
        w: state.librarySelection.w,
        d: state.librarySelection.d,
        rot: 0
      };
      state.items.push(newItem);
      state.librarySelection = null;
      document.querySelectorAll('.lib-item').forEach(el => el.classList.remove('selected'));
    }
    // ... similar para door/window en paredes

    if (isDragging) {
      // Actualizar b de pared
      const currentWall = state.walls[state.walls.length - 1];
      currentWall.b = {...snapped};
    }

    pushHist();
    draw();
    renderProperties();
  };

  state.canvas.onmousemove = (e) => {
    if (isDragging && state.tool === 'wall') {
      const rect = state.canvas.getBoundingClientRect();
      const sx = (e.clientX - rect.left) * (state.canvas.width / rect.width) / window.devicePixelRatio;
      const sy = (e.clientY - rect.top) * (state.canvas.height / rect.height) / window.devicePixelRatio;
      const pos = snapToGrid(screenToWorld(sx, sy).x, screenToWorld(sx, sy).y);
      state.walls[state.walls.length - 1].b = pos;
      draw();
    }
  };

  state.canvas.onmouseup = () => { isDragging = false; };

  // Wheel zoom
  state.canvas.onwheel = (e) => {
    e.preventDefault();
    const delta = e.deltaY > 0 ? 0.9 : 1.1;
    state.zoom *= delta;
    state.zoom = Math.max(0.1, Math.min(5, state.zoom));
    document.getElementById('zoom-ctrl').value = state.zoom;
    draw();
  };

  // Pan con middle mouse
  let isPanning = false;
  let panStart = {x:0, y:0};
  state.canvas.onmousedown = (e) => {
    if (e.button === 1) { // Middle
      isPanning = true;
      panStart = {x: e.clientX, y: e.clientY};
      e.preventDefault();
    }
  };
  state.canvas.onmousemove = (e) => {
    if (isPanning) {
      const dx = (e.clientX - panStart.x) / (state.zoom * 50);
      const dy = (e.clientY - panStart.y) / (state.zoom * 50);
      state.offsetX -= dx;
      state.offsetY -= dy;
      panStart = {x: e.clientX, y: e.clientY};
      draw();
    }
  };
  state.canvas.onmouseup = () => { isPanning = false; };
}

function getElementAt(pos) {
  // Detectar hit en items, walls, etc. (implementar lógica de colisión)
  return null; // Placeholder
}

function setTool(tool) {
  state.tool = tool;
  document.querySelectorAll('.toolbtn').forEach(btn => btn.removeAttribute('data-active'));
  document.getElementById(`tool-${tool}`).setAttribute('data-active', 'true');
  if (tool === 'item') {
    // Activar drag desde library
    document.querySelectorAll('.lib-item').forEach(el => {
      el.style.cursor = 'grab';
      el.ondragstart = (e) => {
        const idx = parseInt(e.target.dataset.idx);
        state.librarySelection = library[idx];
      };
    });
  }
}

// ===== Biblioteca =====
function loadLibrary() {
  const libEl = document.getElementById('library');
  library.forEach((item, idx) => {
    const el = document.createElement('div');
    el.className = 'lib-item';
    el.dataset.idx = idx;
    el.innerHTML = `
      <svg viewBox="0 0 1 1">${item.svg}</svg>
      <span>${item.label}</span>
    `;
    el.onclick = () => {
      if (state.tool === 'item') {
        document.querySelectorAll('.lib-item').forEach(e => e.classList.remove('selected'));
        el.classList.add('selected');
        state.librarySelection = item;
      }
    };
    libEl.appendChild(el);
  });
}

// ===== Propiedades =====
function renderProperties() {
  const propsEl = document.getElementById('properties');
  if (!state.selection) {
    propsEl.innerHTML = '<p style="text-align:center; color:var(--muted);">Selecciona un elemento para editar</p>';
    return;
  }

  let html = '<div class="prop-group">';
  if (state.selection.type === 'item') {
    const item = state.items.find(i => i.id === state.selection.id);
    html += `
      <label>X: <input type="number" value="${item.x.toFixed(2)}" onchange="updateItemProp('x', parseFloat(this.value))"></label>
      <label>Y: <input type="number" value="${item.y.toFixed(2)}" onchange="updateItemProp('y', parseFloat(this.value))"></label>
      <label>Ancho: <input type="number" value="${item.w.toFixed(1)}" onchange="updateItemProp('w', parseFloat(this.value))"></label>
      <label>Profundidad: <input type="number" value="${item.d.toFixed(1)}" onchange="updateItemProp('d', parseFloat(this.value))"></label>
      <label>Rotación: <input type="number" value="${item.rot}" onchange="updateItemProp('rot', parseFloat(this.value))">°</label>
    `;
  } // Similar para walls/openings
  html += '</div>';
  propsEl.innerHTML = html;
}

function updateItemProp(prop, value) {
  if (state.selection?.type === 'item') {
    const item = state.items.find(i => i.id === state.selection.id);
    if (item) {
      item[prop] = value;
      pushHist();
      draw();
      renderMiniHUD();
    }
  }
}

// ===== Mini HUD contextual =====
function renderMiniHUD() {
  const hud = document.getElementById('mini-hud');
  if (!state.selection) {
    hud.innerHTML = '';
    hud.classList.remove('show');
    return;
  }

  let html = '';
  if (state.selection.type === 'item') {
    const item = state.items.find(i => i.id === state.selection.id);
    html = `
      <button class="mh-btn" onclick="deleteSelection()">🗑️ Eliminar</button>
      <button class="mh-btn" onclick="duplicateSelection()">📋 Duplicar</button>
      <button class="mh-btn" onclick="bringToFront()">⬆️ Al frente</button>
    `;
  }
  hud.innerHTML = html;
  hud.classList.add('show');
  // Posicionar sobre selección
  const pos = worldToScreen(item.x, item.y);
  hud.style.left = `${pos.x}px`;
  hud.style.top = `${pos.y - 40}px`; // Arriba del item
}

function deleteSelection() {
  if (state.selection?.type === 'item') {
    state.items = state.items.filter(i => i.id !== state.selection.id);
  } // Similar para otros
  state.selection = null;
  pushHist();
  draw();
  renderProperties();
  renderMiniHUD();
}

function duplicateSelection() {
  if (state.selection?.type === 'item') {
    const item = state.items.find(i => i.id === state.selection.id);
    const dup = {...item, id: state.nextId++, x: item.x + 1, y: item.y + 1};
    state.items.push(dup);
    state.selection = {type: 'item', id: dup.id};
    pushHist();
    draw();
    renderProperties();
    renderMiniHUD();
  }
}

function bringToFront() {
  // Reordenar array para render en orden
  if (state.selection?.type === 'item') {
    const idx = state.items.findIndex(i => i.id === state.selection.id);
    const [item] = state.items.splice(idx, 1);
    state.items.push(item);
    draw();
  }
}

// ===== Historia =====
function pushHist() {
  state.history = state.history.slice(0, state.historyIndex + 1);
  state.history.push({
    walls: [...state.walls],
    openings: [...state.openings],
    items: [...state.items],
    zoom: state.zoom,
    offsetX: state.offsetX,
    offsetY: state.offsetY
  });
  state.historyIndex++;
  if (state.history.length > 50) state.history.shift(); // Límite
}

function undo() {
  if (state.historyIndex > 0) {
    state.historyIndex--;
    const hist = state.history[state.historyIndex];
    state.walls = [...hist.walls];
    state.openings = [...hist.openings];
    state.items = [...hist.items];
    state.zoom = hist.zoom;
    state.offsetX = hist.offsetX;
    state.offsetY = hist.offsetY;
    document.getElementById('zoom-ctrl').value = state.zoom;
    draw();
    renderProperties();
    renderMiniHUD();
  }
}

function redo() {
  if (state.historyIndex < state.history.length - 1) {
    state.historyIndex++;
    const hist = state.history[state.historyIndex];
    state.walls = [...hist.walls];
    state.openings = [...hist.openings];
    state.items = [...hist.items];
    state.zoom = hist.zoom;
    state.offsetX = hist.offsetX;
    state.offsetY = hist.offsetY;
    document.getElementById('zoom-ctrl').value = state.zoom;
    draw();
    renderProperties();
    renderMiniHUD();
  }
}

function clearAll() {
  if (confirm('¿Limpiar todo el plano?')) {
    state.walls = [];
    state.openings = [];
    state.items = [];
    state.offsetX = 0;
    state.offsetY = 0;
    pushHist();
    draw();
    renderProperties();
  }
}

// ===== Export =====
document.getElementById('export-json').onclick = () => {
  const data = {
    version: '9.6',
    state: {
      walls: state.walls,
      openings: state.openings,
      items: state.items,
      zoom: state.zoom,
      offsetX: state.offsetX,
      offsetY: state.offsetY
    }
  };
  const blob = new Blob([JSON.stringify(data, null, 2)], {type: 'application/json'});
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'plano.json';
  a.click();
  URL.revokeObjectURL(url);
};

document.getElementById('export-pdf').onclick = () => {
  // Placeholder: usar jsPDF o similar
  alert('Export PDF en desarrollo. Usa JSON por ahora.');
};

// ===== Tema =====
function persistTheme(theme) {
  localStorage.setItem('planner-theme', JSON.stringify(theme));
}

function applyThemeFromStorage() {
  const saved = localStorage.getItem('planner-theme');
  if (saved) {
    const theme = JSON.parse(saved);
    if (theme.brand) {
      document.documentElement.style.setProperty('--accent', theme.brand);
      document.getElementById('theme-brand').value = theme.brand;
    }
  }
}

function importThemeFromFile(file) {
  const reader = new FileReader();
  reader.onload = (e) => {
    try {
      const theme = JSON.parse(e.target.result);
      persistTheme(theme);
      applyThemeFromStorage();
      draw();
    } catch (err) {
      alert('Tema inválido');
    }
  };
  reader.readAsText(file);
}

document.getElementById('tool-theme-save').onclick = () => {
  const theme = {brand: getComputedStyle(document.documentElement).getPropertyValue('--accent').trim()};
  const blob = new Blob([JSON.stringify(theme, null, 2)], {type: 'application/json'});
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'tema.json';
  a.click();
  URL.revokeObjectURL(url);
};

document.getElementById('tool-theme-load').onclick = () => {
  const inp = document.createElement('input'); 
  inp.type = 'file'; 
  inp.accept = '.json,application/json';
  inp.onchange = () => { 
    if (inp.files && inp.files[0]) importThemeFromFile(inp.files[0]); 
  };
  inp.click();
};

document.getElementById('theme-brand').addEventListener('input', (e) => {
  const val = e.target.value || '#6ee7ff';
  document.documentElement.style.setProperty('--accent', val);
  persistTheme({brand: val});
  draw(); 
  renderMiniHUD();
});

document.getElementById('tool-text-plus').onclick = () => adjustUiScale(0.1);
document.getElementById('tool-text-minus').onclick = () => adjustUiScale(-0.1);

function adjustUiScale(delta) {
  const root = document.documentElement;
  let scale = parseFloat(root.style.getPropertyValue('--ui-scale') || 1);
  scale = Math.max(0.5, Math.min(2, scale + delta));
  root.style.setProperty('--ui-scale', scale);
  localStorage.setItem('ui-scale', scale);
  // Re-render si es necesario
}

// Cargar escala UI
const savedScale = localStorage.getItem('ui-scale');
if (savedScale) document.documentElement.style.setProperty('--ui-scale', savedScale);

// ===== Tour =====
let currentTourStep = 0;
const tourSteps = ['tour-step-1', 'tour-step-2', 'tour-step-3'];

function startTour() {
  currentTourStep = 0;
  showTourStep(0);
  document.body.classList.add('tour-mode');
}

function nextTourStep() {
  if (currentTourStep < tourSteps.length - 1) {
    hideTourStep();
    currentTourStep++;
    showTourStep(currentTourStep);
  } else {
    endTour();
  }
}

function prevTourStep() {
  if (currentTourStep > 0) {
    hideTourStep();
    currentTourStep--;
    showTourStep(currentTourStep);
  }
}

function showTourStep(step) {
  const stepEl = document.getElementById(tourSteps[step]);
  const rect = stepEl.getBoundingClientRect(); // Ajustar a elemento objetivo, ej canvas para step 2
  let targetRect;
  switch (step) {
    case 0: targetRect = document.querySelector('.toolbar').getBoundingClientRect(); break;
    case 1: targetRect = state.canvas.getBoundingClientRect(); break;
    case 2: targetRect = document.querySelector('.library').getBoundingClientRect(); break;
  }
  stepEl.style.left = `${targetRect.left + targetRect.width / 2}px`;
  stepEl.style.top = `${targetRect.top - 10}px`; // Arriba
  stepEl.classList.add('show');
  // Spotlight
  const spotlight = document.querySelector('.tour-spotlight') || document.createElement('div');
  spotlight.className = 'tour-spotlight';
  spotlight.style.width = `${targetRect.width}px`;
  spotlight.style.height = `${targetRect.height}px`;
  spotlight.style.left = `${targetRect.left}px`;
  spotlight.style.top = `${targetRect.top}px`;
  document.body.appendChild(spotlight);
  // Mask
  const mask = document.querySelector('.tour-mask') || document.createElement('div');
  mask.className = 'tour-mask show';
  document.body.appendChild(mask);
  // Arrow
  const arrow = document.querySelector('.tour-arrow') || document.createElement('div');
  arrow.className = 'tour-arrow bottom'; // Para arriba
  stepEl.appendChild(arrow);
}

function hideTourStep() {
  document.querySelectorAll('.tour-step.show, .tour-spotlight, .tour-mask').forEach(el => {
    el.classList.remove('show');
    if (el.classList.contains('tour-spotlight') || el.classList.contains('tour-mask')) {
      el.remove();
    }
  });
}

function endTour() {
  hideTourStep();
  document.body.classList.remove('tour-mode');
  localStorage.setItem('tour-seen', 'true');
  currentTourStep = 0;
}

// ===== Keyboard: move/rotate/scale selection =====
function isTypingTarget(el) {
  return el && (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA' || el.isContentEditable || el.tagName === 'SELECT');
}

window.addEventListener('keydown', (e) => {
  if (isTypingTarget(e.target)) return;
  const sel = state.selection;

  // Global UI text scaling
  if ((e.ctrlKey || e.metaKey) && (e.key === '=' || e.key === '+')) { 
    adjustUiScale(0.1); 
    e.preventDefault(); 
    return; 
  }
  if ((e.ctrlKey || e.metaKey) && (e.key === '-')) { 
    adjustUiScale(-0.1); 
    e.preventDefault(); 
    return; 
  }

  // Undo/Redo
  if (e.ctrlKey || e.metaKey) {
    if (e.key === 'z' && !e.shiftKey) { undo(); e.preventDefault(); return; }
    if ((e.key === 'z' && e.shiftKey) || e.key === 'y') { redo(); e.preventDefault(); return; }
  }

  if (!sel) return;
  const fine = e.altKey, coarse = e.shiftKey;
  const step = fine ? 0.01 : (coarse ? 0.5 : 0.1);
  const rotStep = coarse ? 15 : 5;

  // Move with arrows
  if (e.key.startsWith('Arrow')) {
    if (sel.type === 'item') {
      const it = state.items.find(x => x.id === sel.id); 
      if (!it) return;
      if (e.ctrlKey || e.metaKey) {
        // Scale with Ctrl+Arrows: width (left/right) and depth (up/down)
        if (e.key === 'ArrowLeft') { it.w = Math.max(0.1, (it.w - step)); }
        if (e.key === 'ArrowRight') { it.w = it.w + step; }
        if (e.key === 'ArrowUp') { it.d = it.d - step > 0.1 ? it.d - step : 0.1; }
        if (e.key === 'ArrowDown') { it.d = it.d + step; }
      } else {
        if (e.key === 'ArrowLeft') { it.x = it.x - step; }
        if (e.key === 'ArrowRight') { it.x = it.x + step; }
        if (e.key === 'ArrowUp') { it.y = it.y - step; }
        if (e.key === 'ArrowDown') { it.y = it.y + step; }
      }
      pushHist(); 
      draw(); 
      renderMiniHUD(); 
      e.preventDefault(); 
      return;
    }
    if (sel.type === 'opening') {
      const op = state.openings.find(x => x.id === sel.id); 
      if (!op) return;
      // Move along wall with left/right; adjust width with Ctrl+left/right
      if (e.ctrlKey || e.metaKey) {
        if (e.key === 'ArrowLeft') { op.width = Math.max(0.3, op.width - step); }
        if (e.key === 'ArrowRight') { op.width = op.width + step; }
      } else {
        if (e.key === 'ArrowLeft') { op.pos = Math.max(0.0, op.pos - step / 2); }
        if (e.key === 'ArrowRight') { op.pos = Math.min(1.0, op.pos + step / 2); }
      }
      pushHist(); 
      draw(); 
      renderMiniHUD(); 
      e.preventDefault(); 
      return;
    }
    if (sel.type === 'wall') {
      const w = state.walls.find(x => x.id === sel.id); 
      if (!w) return;
      // Move whole wall (translate both endpoints), Ctrl+Up/Down adjust thickness
      if (e.ctrlKey || e.metaKey) {
        if (e.key === 'ArrowUp') { w.thick = Math.max(0.05, w.thick - step / 5); }
        if (e.key === 'ArrowDown') { w.thick = w.thick + step / 5; }
      } else {
        if (e.key === 'ArrowLeft') { w.a.x -= step; w.b.x -= step; }
        if (e.key === 'ArrowRight') { w.a.x += step; w.b.x += step; }
        if (e.key === 'ArrowUp') { w.a.y -= step; w.b.y -= step; }
        if (e.key === 'ArrowDown') { w.a.y += step; w.b.y += step; }
      }
      pushHist(); 
      draw(); 
      renderMiniHUD(); 
      e.preventDefault(); 
      return;
    }
  }

  // Rotate with Q/E
  if (e.key.toLowerCase() === 'q' || e.key.toLowerCase() === 'e') {
    if (sel.type === 'item') {
      const it = state.items.find(x => x.id === sel.id); 
      if (!it) return;
      it.rot = ((it.rot || 0) + (e.key.toLowerCase() === 'q' ? -rotStep : rotStep)) % 360;
      if (it.rot < 0) it.rot += 360;
      pushHist(); 
      draw(); 
      renderMiniHUD(); 
      e.preventDefault(); 
      return;
    }
    if (sel.type === 'opening') {
      const op = state.openings.find(x => x.id === sel.id); 
      if (!op || op.type !== 'door') return;
      op.angle = Math.max(0, Math.min(180, (op.angle || 90) + (e.key.toLowerCase() === 'q' ? -rotStep : rotStep)));
      pushHist(); 
      draw(); 
      renderMiniHUD(); 
      e.preventDefault(); 
      return;
    }
  }

  // Delete with Del
  if (e.key === 'Delete') {
    deleteSelection();
    e.preventDefault();
  }
});

// ===== Fin del script =====
</script>
</body>
</html>