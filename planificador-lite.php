<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Planificador Lite v9.7.1</title>
<style>
  :root{
    --bg:#0b1220; --panel:#0f172a; --ink:#dbe7f5; --muted:#8aa0b8;
    --line:#2b3347; --grid:#1a2236; --grid-strong:#23304a; --accent:#6ee7ff;
  }
  html,body{height:100%;margin:0;font-family:Inter,system-ui,Segoe UI,Roboto,Helvetica,Arial;color:var(--ink);background:var(--bg)}
  .app{display:grid; grid-template-rows:auto 1fr auto; height:100%}

  /* Topbar */
  .topbar{display:flex; gap:.75rem; align-items:center; padding:.6rem .8rem; background:linear-gradient(180deg,#0f172a,#0f172a00)}
  .toolgroup{display:flex; gap:.4rem; align-items:center; padding:.35rem .5rem; background:#0e1626; border:1px solid #1e2740; border-radius:.8rem}
  .toolgroup .title{font-size:.8rem; color:var(--muted); margin-right:.25rem}
  .toolbtn{appearance:none; border:1px solid #2a3146; background:#11192a; color:var(--ink); border-radius:.55rem; padding:.4rem .6rem; cursor:pointer}
  .toolbtn[data-active="true"]{border-color:var(--accent); box-shadow:0 0 0 2px rgba(110,231,255,.2) inset}
  .toolbtn:focus-visible{outline:2px solid var(--accent); outline-offset:2px}

  /* Main area */
  .main{display:grid; grid-template-columns: 300px 1fr 320px; gap:.6rem; padding:.6rem}
  .panel{background:var(--panel); border:1px solid #1e2740; border-radius:.9rem; overflow:auto}
  .panel h3{margin:.9rem; margin-bottom:.5rem; color:#cdd6e3; font-size:.95rem}
  .panel .content{padding:.6rem .9rem}
  #wrap{position:relative; background:#0a1325; border:1px solid #1d2743; border-radius:.9rem; overflow:hidden}
  #plan{display:block; width:100%; height:100%}

  /* Library */
  .lib-grid{display:grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap:.5rem}
  .lib-item{display:flex; gap:.6rem; align-items:center; border:1px solid #22304a; padding:.45rem .55rem; border-radius:.6rem; cursor:grab; user-select:none}
  .lib-item:hover{background:#0f1a2f; border-color:#2b3d61}
  .lib-svg{width:28px; height:28px}

  /* Inspector */
  .field{display:grid; grid-template-columns: 1fr 120px; gap:.5rem; align-items:center; margin:.4rem 0}
  .field input, .field select{width:100%; padding:.35rem .4rem; border-radius:.5rem; border:1px solid #2a3146; background:#0e1626; color:var(--ink)}
  .hint{color:var(--muted); font-size:.8rem; margin-top:.35rem}

  /* Bottom bar */
  .bottombar{display:flex; justify-content:space-between; padding:.45rem .8rem; background:#0e1626; border-top:1px solid #1e2740; font-size:.9rem}
  .hud code{background:#0b1220; border:1px solid #1e2740; padding:.1rem .3rem; border-radius:.35rem}

  /* Mini HUD contextual */
  #miniHUD{position:absolute; pointer-events:auto; transform-origin:top left; display:none}
  .hudbox{display:flex; gap:.35rem; background:#0d162a; border:1px solid #203054; border-radius:.65rem; padding:.25rem .3rem; box-shadow:0 6px 22px rgba(0,0,0,.35)}
  .hudbox button{border:1px solid #2a3146; background:#131e34; color:var(--ink); border-radius:.45rem; padding:.25rem .45rem; cursor:pointer; font-size:.85rem}
  .hudbox button:hover{border-color:#38507a}

  /* Focus */
  *:focus-visible{outline:2px solid var(--accent); outline-offset:2px}
</style>
</head>
<body>
<div class="app">
  <!-- TOPBAR -->
  <div class="topbar">
    <div class="toolgroup" id="grp-file">
      <span class="title">Proyecto</span>
      <button class="toolbtn" id="tool-new">🆕 Nuevo</button>
      <button class="toolbtn" id="tool-save">💾 Guardar</button>
      <button class="toolbtn" id="tool-import">⬆️ Importar</button>
      <button class="toolbtn" id="tool-reset">♻️ Reset</button>
    </div>
    <div class="toolgroup">
      <span class="title">Dibujo</span>
      <button class="toolbtn" id="tool-select" data-active="true">🖱️ Seleccionar</button>
      <button class="toolbtn" id="tool-pan">✋ Mover</button>
      <button class="toolbtn" id="tool-wall">📐 Pared</button>
      <button class="toolbtn" id="tool-room">⬛ Habitación</button>
      <button class="toolbtn" id="tool-door">🚪 Puerta</button>
      <button class="toolbtn" id="tool-window">🪟 Ventana</button>
    </div>
    <div class="toolgroup">
      <span class="title">Parámetros</span>
      <span style="color:var(--muted);font-size:.85rem">Espesor</span><input id="inp-thick" type="number" step="0.01" value="0.15" style="width:80px"/>
      <span style="color:var(--muted);font-size:.85rem">Altura</span><input id="inp-height" type="number" step="0.1" value="2.70" style="width:80px"/>
      <span style="color:var(--muted);font-size:.85rem">Escala</span><input id="inp-scale" type="number" step="5" value="60" style="width:80px"/>
    </div>
  </div>

  <!-- MAIN -->
  <div class="main">
    <!-- BIBLIOTECA -->
    <div class="panel">
      <h3>Biblioteca</h3>
      <div class="content lib-grid" id="library">
        <!-- Cada item: data-type, w,d m por defecto -->
        <div class="lib-item" draggable="true" data-type="bed" data-w="2.0" data-d="1.6" title="Cama 2.0×1.6">
          <svg class="lib-svg" viewBox="0 0 64 64"><rect x="6" y="10" width="52" height="44" rx="8" fill="#2e3b54"/><rect x="8" y="12" width="48" height="20" rx="6" fill="#223047"/><rect x="10" y="34" width="20" height="14" rx="4" fill="#dbe6f3"/><rect x="34" y="34" width="20" height="14" rx="4" fill="#dbe6f3"/></svg>
          <div>Cama</div>
        </div>
        <div class="lib-item" draggable="true" data-type="sofa" data-w="2.0" data-d="0.9" title="Sofá 2.0×0.9">
          <svg class="lib-svg" viewBox="0 0 64 64"><rect x="6" y="18" width="52" height="28" rx="8" fill="#32415b"/><rect x="10" y="22" width="20" height="20" rx="6" fill="#283447"/><rect x="34" y="22" width="20" height="20" rx="6" fill="#283447"/></svg>
          <div>Sofá</div>
        </div>
        <div class="lib-item" draggable="true" data-type="table" data-w="1.2" data-d="0.8" title="Mesa 1.2×0.8">
          <svg class="lib-svg" viewBox="0 0 64 64"><rect x="8" y="18" width="48" height="28" rx="6" fill="#253243"/></svg>
          <div>Mesa</div>
        </div>
        <div class="lib-item" draggable="true" data-type="wardrobe" data-w="1.8" data-d="0.6" title="Placard 1.8×0.6">
          <svg class="lib-svg" viewBox="0 0 64 64"><rect x="10" y="14" width="44" height="36" rx="4" fill="#1f2b3e"/><line x1="32" y1="18" x2="32" y2="50" stroke="#64748b"/></svg>
          <div>Placard</div>
        </div>
        <div class="lib-item" draggable="true" data-type="chair" data-w="0.5" data-d="0.5" title="Silla 0.5×0.5">
          <svg class="lib-svg" viewBox="0 0 64 64"><rect x="16" y="24" width="32" height="16" rx="6" fill="#2e3b54"/><rect x="18" y="16" width="28" height="8" rx="4" fill="#32415b"/></svg>
          <div>Silla</div>
        </div>
        <div class="lib-item" draggable="true" data-type="fridge" data-w="0.7" data-d="0.7" title="Heladera 0.7×0.7">
          <svg class="lib-svg" viewBox="0 0 64 64"><rect x="16" y="12" width="32" height="40" rx="6" fill="#182238"/><line x1="18" y1="32" x2="46" y2="32" stroke="#6b7c96"/></svg>
          <div>Heladera</div>
        </div>
        <div class="lib-item" draggable="true" data-type="counter" data-w="1.6" data-d="0.6" title="Mesada 1.6×0.6">
          <svg class="lib-svg" viewBox="0 0 64 64"><rect x="8" y="18" width="48" height="28" rx="6" fill="#253348"/></svg>
          <div>Mesada</div>
        </div>
        <div class="lib-item" draggable="true" data-type="tv" data-w="1.2" data-d="0.2" title="TV 1.2×0.2">
          <svg class="lib-svg" viewBox="0 0 64 64"><rect x="10" y="18" width="44" height="28" rx="4" fill="#0a0f18"/></svg>
          <div>Televisor</div>
        </div>
      </div>
    </div>

    <!-- CANVAS -->
    <div id="wrap" class="panel" aria-label="Superficie de dibujo">
      <canvas id="plan"></canvas>
      <div id="miniHUD"><div class="hudbox">
        <button id="hud-rot">↻ Rotar 90°</button>
        <button id="hud-dup">📑 Duplicar</button>
        <button id="hud-del">🗑️ Borrar</button>
      </div></div>
    </div>

    <!-- INSPECTOR -->
    <div class="panel">
      <h3>Inspector</h3>
      <div class="content" id="inspector">
        <div class="hint">Seleccioná un elemento para editar sus propiedades.</div>
      </div>
    </div>
  </div>

  <!-- BOTTOM -->
  <div class="bottombar">
    <div class="hud" id="hudtext">Listo</div>
    <div class="hint">Mover: arrastrar · Pan: “Mover” · Zoom: rueda · Rotar: Q/E · Duplicar: Alt+arrastrar</div>
  </div>
</div>

<script>
/* ============ Estado ============ */
const plan = document.getElementById('plan');
const wrap = document.getElementById('wrap');
const hud  = document.getElementById('hudtext');
const mini = document.getElementById('miniHUD');

const state = {
  scale: 60,             // px por metro
  zoom: 1,
  pan: {x:0, y:0},
  tool: 'select',        // select | pan | wall | room | door | window
  wallThick: 0.15,
  wallHeight: 2.7,
  walls: [],
  openings: [],          // {id, wallId, type:'door'|'window', width, pos(0..1), hinge:'left'|'right', swing:1|-1, angle}
  rooms: [],             // {id, x1,y1,x2,y2, name}
  items: [],             // {id, type, x,y, w,d, rot}
  selection: null,       // {type:'item'|'wall'|'opening', id}
  drawing: null          // {mode:'wall'|'room'|'opening', ...}
};

function uid(){ return Math.random().toString(36).slice(2,10); }

function saveLocal(){
  const d = {walls:state.walls, openings:state.openings, rooms:state.rooms, items:state.items, wallThick:state.wallThick, wallHeight:state.wallHeight, scale:state.scale};
  localStorage.setItem('planificador-lite', JSON.stringify(d));
}
function loadLocal(){
  try{
    const j = localStorage.getItem('planificador-lite');
    if(!j) return;
    const d = JSON.parse(j);
    state.walls = d.walls||[];
    state.openings = d.openings||[];
    state.rooms = d.rooms||[];
    state.items = d.items||[];
    state.wallThick = d.wallThick ?? state.wallThick;
    state.wallHeight = d.wallHeight ?? state.wallHeight;
    state.scale = d.scale ?? state.scale;
  }catch{}
}

/* ============ Geometría ============ */
function worldToScreen(p){ return { x: p.x*state.scale*state.zoom + state.pan.x, y: p.y*state.scale*state.zoom + state.pan.y }; }
function screenToWorld(p){ return { x: (p.x - state.pan.x)/(state.scale*state.zoom), y: (p.y - state.pan.y)/(state.scale*state.zoom) }; }
function snapVal(v){ return Math.round(v*100)/100; } // 1cm

/* ============ Render ============ */
const ctx = plan.getContext('2d');

function drawGrid(){
  const w=plan.width, h=plan.height;
  ctx.fillStyle='#0a1325'; ctx.fillRect(0,0,w,h);
  const step = state.scale*state.zoom;
  const ox = state.pan.x % step, oy = state.pan.y % step;
  ctx.beginPath();
  ctx.strokeStyle = getComputedStyle(document.documentElement).getPropertyValue('--grid');
  for(let x=ox; x<w; x+=step){ ctx.moveTo(x,0); ctx.lineTo(x,h); }
  for(let y=oy; y<h; y+=step){ ctx.moveTo(0,y); ctx.lineTo(w,y); }
  ctx.stroke();
  ctx.beginPath();
  ctx.strokeStyle = getComputedStyle(document.documentElement).getPropertyValue('--grid-strong');
  for(let x=ox; x<w; x+=step*5){ ctx.moveTo(x,0); ctx.lineTo(x,h); }
  for(let y=oy; y<h; y+=step*5){ ctx.moveTo(0,y); ctx.lineTo(w,y); }
  ctx.stroke();
}

function drawRooms(){
  for(const r of state.rooms){
    const a = worldToScreen({x:Math.min(r.x1,r.x2), y:Math.min(r.y1,r.y2)});
    const b = worldToScreen({x:Math.max(r.x1,r.x2), y:Math.max(r.y1,r.y2)});
    ctx.fillStyle='#0e1a2e';
    ctx.strokeStyle='#22324d'; ctx.lineWidth=1.5;
    ctx.beginPath(); ctx.rect(a.x,a.y,b.x-a.x,b.y-a.y); ctx.fill(); ctx.stroke();
    // etiqueta m2
    const w=(Math.abs(r.x2-r.x1)), d=(Math.abs(r.y2-r.y1));
    const m2 = (w*d).toFixed(2);
    ctx.fillStyle='#9fb2c9'; ctx.font='12px Inter,system-ui';
    ctx.fillText(`${r.name||'Habitación'} • ${m2} m²`, a.x+8, a.y+16);
  }
}

function drawWalls(){
  for(const w of state.walls){
    const a=worldToScreen(w.a), b=worldToScreen(w.b);
    // eje
    ctx.strokeStyle=(state.selection?.type==='wall' && state.selection.id===w.id)?'#6ee7ff':'#4b5563';
    ctx.lineWidth=2;
    ctx.beginPath(); ctx.moveTo(a.x,a.y); ctx.lineTo(b.x,b.y); ctx.stroke();
    // espesor (simple línea offset visual)
    ctx.strokeStyle='#1f2937'; ctx.lineWidth=6*(w.thick||state.wallThick);
    ctx.lineCap='butt';
    ctx.beginPath(); ctx.moveTo(a.x,a.y); ctx.lineTo(b.x,b.y); ctx.stroke();
  }
}

function drawOpenings(){
  for(const o of state.openings){
    const w = state.walls.find(x=>x.id===o.wallId); if(!w) continue;
    const ax=w.a.x, ay=w.a.y, bx=w.b.x, by=w.b.y;
    const cx = ax + (bx-ax)*o.pos, cy = ay + (by-ay)*o.pos;
    const ang = Math.atan2(by-ay, bx-ax);
    const half = (o.width||1)/2;

    // puntos extremos de abertura sobre el eje de muro
    const A = {x: cx - Math.cos(ang)*half, y: cy - Math.sin(ang)*half};
    const B = {x: cx + Math.cos(ang)*half, y: cy + Math.sin(ang)*half};
    const As = worldToScreen(A), Bs = worldToScreen(B);

    if(o.type==='window'){
      // ventana: tramo azul
      ctx.strokeStyle=(state.selection?.type==='opening'&&state.selection.id===o.id)?'#6ee7ff':'#8dd9ff';
      ctx.lineWidth=4; ctx.beginPath(); ctx.moveTo(As.x,As.y); ctx.lineTo(Bs.x,Bs.y); ctx.stroke();
    }else{
      // puerta: bisagra y barrido
      ctx.strokeStyle=(state.selection?.type==='opening'&&state.selection.id===o.id)?'#6ee7ff':'#22c55e';
      ctx.lineWidth=2.5;

      // lado bisagra según hinge + swing (1 abre hacia "interior" del vector)
      const hingeLeft = (o.hinge||'left')==='left';
      const hPoint = hingeLeft ? A : B;
      const dir = hingeLeft ? 1 : -1;
      const swing = (o.swing??1) * dir;

      // hoja (línea)
      const leafLen = Math.min(o.width||0.8, 1.1);
      const baseAng = ang + (hingeLeft ? 0 : Math.PI);
      const openedAng = baseAng + (swing)*((o.angle||90)*Math.PI/180);

      const Hs = worldToScreen(hPoint);
      // hoja a medio abrir
      const leafEnd = {x: hPoint.x + Math.cos(openedAng)*leafLen, y: hPoint.y + Math.sin(openedAng)*leafLen};
      const Ls = worldToScreen(leafEnd);
      ctx.beginPath(); ctx.moveTo(Hs.x,Hs.y); ctx.lineTo(Ls.x,Ls.y); ctx.stroke();

      // arco de barrido
      ctx.beginPath();
      ctx.arc(Hs.x,Hs.y, leafLen*state.scale*state.zoom, baseAng, openedAng, openedAng<baseAng);
      ctx.stroke();
    }
  }
}

function drawItems(){
  function rect(w,d){ ctx.beginPath(); ctx.rect(-w/2,-d/2,w,d); ctx.fill(); ctx.stroke(); }
  function roundRect(x,y,w,h,r){ ctx.beginPath(); const rr=Math.min(r, Math.abs(w)/2, Math.abs(h)/2);
    ctx.moveTo(x+rr,y); ctx.arcTo(x+w,y,x+w,y+h,rr); ctx.arcTo(x+w,y+h,x,y+h,rr); ctx.arcTo(x,y+h,x,y,rr); ctx.arcTo(x,y,x+w,y,rr); ctx.closePath(); }

  for(const it of state.items){
    const p=worldToScreen({x:it.x,y:it.y}); const w=it.w*state.scale*state.zoom; const d=it.d*state.scale*state.zoom;
    ctx.save(); ctx.translate(p.x,p.y); ctx.rotate((it.rot||0)*Math.PI/180);
    const selStroke = (state.selection?.type==='item'&&state.selection.id===it.id)?'#6ee7ff':'#94a3b8';
    ctx.lineWidth=2; ctx.strokeStyle=selStroke;

    if(it.type==='bed'){
      ctx.fillStyle = '#0f172a'; rect(w,d);
      ctx.fillStyle = '#dbe6f3'; roundRect(-w/2+6,-d/2+6,w-12,d-12,8); ctx.fill(); ctx.strokeStyle='#b2c3d6'; ctx.stroke();
      ctx.fillStyle = '#223047'; roundRect(-w/2+6,-d/2+6, w-12, Math.min(18,d*0.22), 6); ctx.fill();
      const pw=Math.min( w*0.38, 70), ph=Math.min(d*0.2, 22);
      ctx.fillStyle='#ffffff';
      roundRect(-w/2+12, -d/2+10, pw, ph, 6); ctx.fill(); ctx.strokeStyle='#c3cfdb'; ctx.stroke();
      roundRect(w/2-12-pw, -d/2+10, pw, ph, 6); ctx.fill(); ctx.strokeStyle='#c3cfdb'; ctx.stroke();
    } else if(it.type==='sofa'){
      ctx.fillStyle='#0f172a'; rect(w,d);
      ctx.fillStyle='#283447'; roundRect(-w/2+6,-d/2+6,w-12,Math.min(d*0.28,22),6); ctx.fill();
      const seatH = Math.max(18, d*0.45);
      ctx.fillStyle='#33435a'; roundRect(-w/2+6,-d/2+6+Math.min(d*0.3,24), (w-14)/2-2, seatH, 6); ctx.fill();
      roundRect(2, -d/2+6+Math.min(d*0.3,24), (w-14)/2-2, seatH, 6); ctx.fill();
      const armW = Math.min(16, w*0.08);
      ctx.fillStyle='#253348'; roundRect(-w/2+6, -d/2+6, armW, d-12, 6); ctx.fill();
      roundRect(w/2-6-armW, -d/2+6, armW, d-12, 6); ctx.fill();
      ctx.strokeStyle=selStroke;
    } else if(it.type==='table'){
      ctx.fillStyle='#253243'; roundRect(-w/2,-d/2,w,d,8); ctx.fill(); ctx.stroke();
      ctx.fillStyle='#1a2333';
      const leg = Math.max(6, Math.min(w,d)*0.12);
      roundRect(-w/2+8, -d/2+8, leg, leg, 3); ctx.fill();
      roundRect(w/2-8-leg, -d/2+8, leg, leg, 3); ctx.fill();
      roundRect(-w/2+8, d/2-8-leg, leg, leg, 3); ctx.fill();
      roundRect(w/2-8-leg, d/2-8-leg, leg, leg, 3); ctx.fill();
      ctx.strokeStyle=selStroke;
    } else if(it.type==='wardrobe'){
      ctx.fillStyle='#1f2b3e'; rect(w,d);
      ctx.strokeStyle='#64748b'; ctx.beginPath(); ctx.moveTo(0, -d/2+6); ctx.lineTo(0, d/2-6); ctx.stroke();
      ctx.fillStyle='#9fb2c9'; ctx.beginPath(); ctx.arc(-w*0.2, 0, 3, 0, Math.PI*2); ctx.fill();
      ctx.beginPath(); ctx.arc(w*0.2, 0, 3, 0, Math.PI*2); ctx.fill();
      ctx.strokeStyle=selStroke;
    } else if(it.type==='chair'){
      ctx.fillStyle='#222c3f'; rect(w,d);
      ctx.fillStyle='#2e3b54'; roundRect(-w/2+8, -d*0.1, w-16, d*0.4, 8); ctx.fill();
      ctx.fillStyle='#32415b'; roundRect(-w/2+10, -d/2+8, w-20, d*0.18, 6); ctx.fill();
      ctx.fillStyle='#182032';
      const pw=Math.max(5, w*0.1), ph=Math.max(5, d*0.12);
      roundRect(-w/2+10, d/2-8-ph, pw, ph, 2); ctx.fill();
      roundRect(w/2-10-pw, d/2-8-ph, pw, ph, 2); ctx.fill();
    } else if(it.type==='fridge'){
      ctx.fillStyle='#182238'; roundRect(-w/2,-d/2,w,d,6); ctx.fill(); ctx.stroke();
      ctx.strokeStyle='#6b7c96'; ctx.beginPath(); ctx.moveTo(-w/2+6, 0); ctx.lineTo(w/2-6, 0); ctx.stroke();
      ctx.fillStyle='#a8b7cc';
      roundRect(-w/2+8, -d*0.35, 6, d*0.25, 3); ctx.fill();
      roundRect(w/2-14, d*0.15, 6, d*0.25, 3); ctx.fill();
      ctx.strokeStyle=selStroke;
    } else if(it.type==='counter'){
      ctx.fillStyle='#253348'; roundRect(-w/2,-d/2,w,d,6); ctx.fill(); ctx.stroke();
      // bacha + anafe
      ctx.fillStyle='#0d1526'; roundRect(-w/2+10, -d/2+8, Math.min(60, w-20), d-16, 6); ctx.fill();
      ctx.strokeStyle='#8aa0b8';
      const ax = w/2 - Math.min(16+w*0.15, 60), ay = -d/2 + 10, s = Math.min(16, d*0.35);
      for(let r=0;r<2;r++) for(let c=0;c<2;c++){
        ctx.beginPath(); ctx.arc(ax + c*(s+8), ay + r*(s+8), s/2, 0, Math.PI*2); ctx.stroke();
      }
      ctx.strokeStyle=selStroke;
    } else if(it.type==='tv'){
      ctx.fillStyle='#0a0f18'; roundRect(-w/2,-d/2,w,d,4); ctx.fill();
      ctx.strokeStyle='#1f2937'; ctx.stroke();
      ctx.fillStyle='#0c111b'; roundRect(-w/2+6,-d/2+6,w-12,d-12,3); ctx.fill();
      ctx.fillStyle='#1a2435'; roundRect(-Math.min(40,w*0.3), d/2-8, Math.min(80,w*0.6), 6, 3); ctx.fill();
      ctx.strokeStyle=selStroke;
    } else {
      ctx.fillStyle='#0f172a'; rect(w,d);
    }
    ctx.restore();
  }
}

function renderMiniHUD(){
  const sel = state.selection;
  if(!sel){ mini.style.display='none'; return; }
  let bb=null;

  if(sel.type==='item'){
    const it = state.items.find(x=>x.id===sel.id); if(!it) return;
    const p=worldToScreen({x:it.x,y:it.y}); const w=it.w*state.scale*state.zoom, d=it.d*state.scale*state.zoom;
    bb = {x:p.x+w/2+8, y:p.y-d/2-8};
  } else if(sel.type==='wall'){
    const w = state.walls.find(x=>x.id===sel.id); if(!w) return;
    const a=worldToScreen(w.a), b=worldToScreen(w.b); const x=(a.x+b.x)/2, y=(a.y+b.y)/2;
    bb = {x:x+10, y:y-10};
  } else if(sel.type==='opening'){
    const o = state.openings.find(x=>x.id===sel.id); if(!o) return;
    const w = state.walls.find(x=>x.id===o.wallId); if(!w) return;
    const x = w.a.x + (w.b.x-w.a.x)*o.pos, y = w.a.y+(w.b.y-w.a.y)*o.pos;
    const s=worldToScreen({x,y}); bb={x:s.x+10, y:s.y-10};
  }

  if(!bb){ mini.style.display='none'; return; }
  mini.style.display='block';
  mini.style.left = `${bb.x}px`;
  mini.style.top  = `${bb.y}px`;
}

function draw(){
  plan.width = wrap.clientWidth; plan.height = wrap.clientHeight;
  drawGrid();
  drawRooms();
  drawWalls();
  drawOpenings();
  drawItems();
  hud.innerHTML = `Herramienta: <b>${state.tool}</b> · zoom <code>${state.zoom.toFixed(2)}</code> · escala <code>${state.scale} px/m</code>`;
}

/* ============ Inspector ============ */
const insp = document.getElementById('inspector');
function renderInspector(){
  const sel=state.selection;
  if(!sel){ insp.innerHTML = '<div class="hint">Seleccioná un elemento para editar sus propiedades.</div>'; return; }

  if(sel.type==='item'){
    const it = state.items.find(x=>x.id===sel.id); if(!it) return;
    insp.innerHTML = `
      <div class="field"><label>Tipo</label><input disabled value="${it.type}"/></div>
      <div class="field"><label>Ancho (m)</label><input id="fi-w" type="number" step="0.01" value="${it.w}"/></div>
      <div class="field"><label>Fondo (m)</label><input id="fi-d" type="number" step="0.01" value="${it.d}"/></div>
      <div class="field"><label>Rotación (°)</label><input id="fi-r" type="number" step="1" value="${it.rot||0}"/></div>
      <div class="field"><label>X (m)</label><input id="fi-x" type="number" step="0.01" value="${it.x}"/></div>
      <div class="field"><label>Y (m)</label><input id="fi-y" type="number" step="0.01" value="${it.y}"/></div>
      <div class="hint">Enter aplica cambios.</div>
    `;
    ['fi-w','fi-d','fi-r','fi-x','fi-y'].forEach(id=>{
      const el=document.getElementById(id); el.addEventListener('change', ()=>{
        it.w=parseFloat(document.getElementById('fi-w').value)||it.w;
        it.d=parseFloat(document.getElementById('fi-d').value)||it.d;
        it.rot=parseFloat(document.getElementById('fi-r').value)||0;
        it.x=parseFloat(document.getElementById('fi-x').value)||it.x;
        it.y=parseFloat(document.getElementById('fi-y').value)||it.y;
        saveLocal(); draw(); renderMiniHUD();
      });
    });
  } else if(sel.type==='wall'){
    const w = state.walls.find(x=>x.id===sel.id); if(!w) return;
    const len = Math.hypot(w.b.x-w.a.x, w.b.y-w.a.y).toFixed(2);
    insp.innerHTML = `
      <div class="field"><label>Largo (m)</label><input disabled value="${len}"/></div>
      <div class="field"><label>Espesor (m)</label><input id="fw-t" type="number" step="0.01" value="${w.thick||state.wallThick}"/></div>
      <div class="field"><label>Altura (m)</label><input id="fw-h" type="number" step="0.1" value="${w.height||state.wallHeight}"/></div>
      <div class="hint">Arrastrá el muro para moverlo. Alt+arrastrar para duplicar.</div>
    `;
    document.getElementById('fw-t').addEventListener('change', e=>{ w.thick=parseFloat(e.target.value)||w.thick; saveLocal(); draw(); });
    document.getElementById('fw-h').addEventListener('change', e=>{ w.height=parseFloat(e.target.value)||w.height; saveLocal(); draw(); });
  } else if(sel.type==='opening'){
    const o = state.openings.find(x=>x.id===sel.id); if(!o) return;
    insp.innerHTML = `
      <div class="field"><label>Tipo</label><input disabled value="${o.type}"/></div>
      <div class="field"><label>Ancho (m)</label><input id="fo-w" type="number" step="0.01" value="${o.width||1}"/></div>
      <div class="field"><label>Posición (0-1)</label><input id="fo-p" type="number" step="0.01" value="${o.pos||0.5}"/></div>
      ${o.type==='door'?`
      <div class="field"><label>Bisagra</label>
        <select id="fo-hinge">
          <option value="left" ${o.hinge!=='right'?'selected':''}>Izquierda</option>
          <option value="right" ${o.hinge==='right'?'selected':''}>Derecha</option>
        </select>
      </div>
      <div class="field"><label>Sentido</label>
        <select id="fo-swing">
          <option value="1" ${(o.swing??1)==1?'selected':''}>Hacia adentro</option>
          <option value="-1" ${(o.swing??1)==-1?'selected':''}>Hacia afuera</option>
        </select>
      </div>
      <div class="field"><label>Ángulo (°)</label><input id="fo-ang" type="number" step="1" value="${o.angle||90}"/></div>
      `:''}
      <div class="hint">Arrastrá para reubicar sobre el muro. Alt+arrastrar duplica.</div>
    `;
    const $ = id=>document.getElementById(id);
    $('#fo-w').onchange = e=>{ o.width=parseFloat(e.target.value)||o.width; saveLocal(); draw(); };
    $('#fo-p').onchange = e=>{ o.pos=Math.max(0,Math.min(1,parseFloat(e.target.value)||o.pos)); saveLocal(); draw(); };
    if(o.type==='door'){
      $('#fo-hinge').onchange = e=>{ o.hinge=e.target.value; saveLocal(); draw(); };
      $('#fo-swing').onchange = e=>{ o.swing=parseInt(e.target.value)||1; saveLocal(); draw(); };
      $('#fo-ang').onchange   = e=>{ o.angle=parseFloat(e.target.value)||90; saveLocal(); draw(); };
    }
  }
}

/* ============ HUD acciones ============ */
document.getElementById('hud-rot').onclick = ()=>{
  const s=state.selection; if(!s) return;
  if(s.type==='item'){
    const it=state.items.find(x=>x.id===s.id); if(it){ it.rot=((it.rot||0)+90)%360; saveLocal(); draw(); renderMiniHUD(); renderInspector(); }
  }else if(s.type==='opening'){
    const o=state.openings.find(x=>x.id===s.id); if(o && o.type==='door'){ o.angle=Math.max(0,Math.min(180,(o.angle||90)+90)); saveLocal(); draw(); renderMiniHUD(); renderInspector(); }
  }
};
document.getElementById('hud-dup').onclick = ()=>{
  const s=state.selection; if(!s) return;
  if(s.type==='item'){ const it=state.items.find(x=>x.id===s.id); if(it){ const c=structuredClone(it); c.id=uid(); c.x+=0.2; c.y+=0.2; state.items.push(c); state.selection={type:'item',id:c.id}; saveLocal(); draw(); renderMiniHUD(); renderInspector(); } }
  if(s.type==='wall'){ const w=state.walls.find(x=>x.id===s.id); if(w){ const c=structuredClone(w); c.id=uid(); c.a.x+=0.2; c.a.y+=0.2; c.b.x+=0.2; c.b.y+=0.2; state.walls.push(c); state.selection={type:'wall',id:c.id}; saveLocal(); draw(); renderMiniHUD(); renderInspector(); } }
  if(s.type==='opening'){ const o=state.openings.find(x=>x.id===s.id); if(o){ const c=structuredClone(o); c.id=uid(); c.pos=Math.min(1, (c.pos||0.5)+0.05); state.openings.push(c); state.selection={type:'opening',id:c.id}; saveLocal(); draw(); renderMiniHUD(); renderInspector(); } }
};
document.getElementById('hud-del').onclick = ()=>{
  const s=state.selection; if(!s) return;
  if(s.type==='item') state.items = state.items.filter(x=>x.id!==s.id);
  if(s.type==='wall') state.walls = state.walls.filter(x=>x.id!==s.id);
  if(s.type==='opening') state.openings = state.openings.filter(x=>x.id!==s.id);
  state.selection=null; saveLocal(); draw(); renderMiniHUD(); renderInspector();
};

/* ============ Interacción ============ */
let isPanning=false, drag=null;

function setTool(t){
  state.tool=t;
  ['select','pan','wall','room','door','window'].forEach(id=>{
    const btn=document.getElementById('tool-'+id); if(btn) btn.setAttribute('data-active', id===t?'true':'false');
  });
  updateCursor();
}
document.getElementById('tool-select').onclick=()=>setTool('select');
document.getElementById('tool-pan').onclick   =()=>setTool('pan');
document.getElementById('tool-wall').onclick  =()=>setTool('wall');
document.getElementById('tool-room').onclick  =()=>setTool('room');
document.getElementById('tool-door').onclick  =()=>setTool('door');
document.getElementById('tool-window').onclick=()=>setTool('window');

function updateCursor(){
  if(state.tool==='pan'){ plan.style.cursor='grab'; }
  else if(state.tool==='select'){ plan.style.cursor='default'; }
  else { plan.style.cursor='crosshair'; }
}

function hitTest(p){ // p: world
  // openings first (más chico)
  for(let i=state.openings.length-1;i>=0;i--){
    const o=state.openings[i];
    const w=state.walls.find(x=>x.id===o.wallId); if(!w) continue;
    const ax=w.a.x, ay=w.a.y, bx=w.b.x, by=w.b.y;
    const A=bx-ax, B=by-ay, L2=A*A+B*B || 1;
    const t = ((p.x-ax)*A + (p.y-ay)*B)/L2; const tt=Math.max(0,Math.min(1,t));
    const qx=ax+tt*A, qy=ay+tt*B;
    const dist=Math.hypot(p.x-qx, p.y-qy);
    if(dist<0.15 && Math.abs(tt - (o.pos||0.5))<0.08) return {type:'opening', id:o.id};
  }
  // items
  for(let i=state.items.length-1;i>=0;i--){
    const it=state.items[i];
    // invertir rotación para caja axis-aligned en sistema local
    const s = Math.sin(-(it.rot||0)*Math.PI/180), c=Math.cos(-(it.rot||0)*Math.PI/180);
    const lx = c*(p.x-it.x)-s*(p.y-it.y), ly = s*(p.x-it.x)+c*(p.y-it.y);
    if(Math.abs(lx)<=it.w/2 && Math.abs(ly)<=it.d/2) return {type:'item', id:it.id};
  }
  // walls (distancia punto-segmento)
  for(let i=state.walls.length-1;i>=0;i--){
    const w=state.walls[i]; const ax=w.a.x, ay=w.a.y, bx=w.b.x, by=w.b.y;
    const A=bx-ax, B=by-ay, L2=A*A+B*B || 1;
    const t = ((p.x-ax)*A + (p.y-ay)*B)/L2; const tt=Math.max(0,Math.min(1,t));
    const qx=ax+tt*A, qy=ay+tt*B; const dist=Math.hypot(p.x-qx, p.y-qy);
    if(dist<= (w.thick||state.wallThick)/2 + 0.1) return {type:'wall', id:w.id};
  }
  return null;
}

/* DnD librería */
document.querySelectorAll('.lib-item').forEach(el=>{
  el.addEventListener('dragstart', e=>{
    e.dataTransfer.setData('text/plain', JSON.stringify({
      type: el.dataset.type, w: parseFloat(el.dataset.w), d: parseFloat(el.dataset.d)
    }));
  });
});
wrap.addEventListener('dragover', e=>{ e.preventDefault(); });
wrap.addEventListener('drop', e=>{
  e.preventDefault();
  const rect=plan.getBoundingClientRect();
  const p = {x:e.clientX-rect.left,y:e.clientY-rect.top};
  const w = screenToWorld(p);
  try{
    const d = JSON.parse(e.dataTransfer.getData('text/plain'));
    const it = {id:uid(), type:d.type, x:snapVal(w.x), y:snapVal(w.y), w:d.w, d:d.d, rot:0};
    state.items.push(it); state.selection={type:'item', id:it.id}; saveLocal(); draw(); renderMiniHUD(); renderInspector();
  }catch{}
});

/* Canvas eventos */
plan.addEventListener('mousedown', e=>{
  const rect=plan.getBoundingClientRect(); const p={x:e.clientX-rect.left, y:e.clientY-rect.top}; const w=screenToWorld(p);

  if(state.tool==='pan'){ isPanning=true; plan.style.cursor='grabbing'; window.__panStart={x:e.clientX,y:e.clientY, panX:state.pan.x, panY:state.pan.y}; return; }

  if(state.tool==='wall'){ state.drawing={mode:'wall', start:{x:w.x,y:w.y}, cur:{x:w.x,y:w.y}}; return; }
  if(state.tool==='room'){ state.drawing={mode:'room', start:{x:w.x,y:w.y}, cur:{x:w.x,y:w.y}}; return; }
  if(state.tool==='door'||state.tool==='window'){
    // pre-armar drawing opening sobre la pared más cercana
    let best=null, bestDist=12; const sp={x:e.clientX-rect.left,y:e.clientY-rect.top};
    for(const wa of state.walls){ const a=worldToScreen(wa.a), b=worldToScreen(wa.b);
      const A=b.x-a.x, B=b.y-a.y, L2=A*A+B*B||1; let t=((sp.x-a.x)*A+(sp.y-a.y)*B)/L2; t=Math.max(0,Math.min(1,t));
      const qx=a.x+t*A, qy=a.y+t*B; const d=Math.hypot(sp.x-qx, sp.y-qy);
      if(d<bestDist){ bestDist=d; best=wa; }
    }
    if(best){ state.drawing={mode:'opening', kind:(state.tool==='door'?'door':'window'), wallId:best.id, _screen:{x:sp.x,y:sp.y}}; }
    return;
  }

  // SELECT
  const hit = hitTest(w);
  if(hit){
    state.selection={type:hit.type, id:hit.id}; renderInspector(); renderMiniHUD();
    if(hit.type==='item' && e.button===0){
      const it=state.items.find(x=>x.id===hit.id);
      if(e.altKey){ const c=structuredClone(it); c.id=uid(); state.items.push(c); state.selection={type:'item',id:c.id}; }
      drag={type:'item', id:state.selection.id, dx:w.x-it.x, dy:w.y-it.y};
    }
    if(hit.type==='wall' && e.button===0){
      const wal=state.walls.find(x=>x.id===hit.id);
      let target=wal;
      if(e.altKey){ const c=structuredClone(wal); c.id=uid(); state.walls.push(c); target=c; state.selection={type:'wall',id:c.id}; }
      drag={type:'wall', id:state.selection.id, startWorld:{x:w.x,y:w.y}, a0:{x:target.a.x,y:target.a.y}, b0:{x:target.b.x,y:target.b.y}};
    }
    if(hit.type==='opening' && e.button===0){
      const op=state.openings.find(x=>x.id===hit.id);
      let target=op;
      if(e.altKey){ const c=structuredClone(op); c.id=uid(); state.openings.push(c); target=c; state.selection={type:'opening',id:c.id}; }
      drag={type:'opening', id:state.selection.id, wallId:target.wallId};
    }
  } else {
    state.selection=null; renderInspector(); renderMiniHUD();
  }
  draw();
});

plan.addEventListener('mousemove', e=>{
  const rect=plan.getBoundingClientRect(); const p={x:e.clientX-rect.left, y:e.clientY-rect.top}; const w=screenToWorld(p);

  if(isPanning && window.__panStart){
    const dx=e.clientX-window.__panStart.x, dy=e.clientY-window.__panStart.y;
    state.pan.x = window.__panStart.panX + dx;
    state.pan.y = window.__panStart.panY + dy;
    draw(); renderMiniHUD(); return;
  }

  if(state.drawing){
    if(state.drawing.mode==='wall'||state.drawing.mode==='room'){ state.drawing.cur={x:w.x,y:w.y}; draw(); return; }
    if(state.drawing.mode==='opening'){ state.drawing._screen={x:p.x,y:p.y}; draw(); return; }
  }

  if(drag){
    if(drag.type==='item'){
      const it=state.items.find(x=>x.id===drag.id); if(it){ it.x=snapVal(w.x-drag.dx); it.y=snapVal(w.y-drag.dy); draw(); renderMiniHUD(); }
    }else if(drag.type==='wall'){
      const wal=state.walls.find(x=>x.id===drag.id); if(wal){
        const dx=w.x-drag.startWorld.x, dy=w.y-drag.startWorld.y;
        wal.a.x=snapVal(drag.a0.x+dx); wal.a.y=snapVal(drag.a0.y+dy);
        wal.b.x=snapVal(drag.b0.x+dx); wal.b.y=snapVal(drag.b0.y+dy);
        draw(); renderMiniHUD();
      }
    }else if(drag.type==='opening'){
      const op=state.openings.find(x=>x.id===drag.id); const wal=state.walls.find(y=>y.id===drag.wallId);
      if(op && wal){
        const a=worldToScreen(wal.a), b=worldToScreen(wal.b);
        const A=b.x-a.x, B=b.y-a.y, L2=A*A+B*B||1;
        let t=((p.x-a.x)*A+(p.y-a.y)*B)/L2; t=Math.max(0,Math.min(1,t));
        op.pos=t; draw(); renderMiniHUD();
      }
    }
  }
});

plan.addEventListener('mouseup', ()=>{
  if(isPanning){ isPanning=false; plan.style.cursor='grab'; }
  if(state.drawing){
    const rect=plan.getBoundingClientRect(); // por si hace falta
    if(state.drawing.mode==='wall'){
      const a=state.drawing.start, b=state.drawing.cur; if(!b){ state.drawing=null; return; }
      if(Math.hypot(b.x-a.x,b.y-a.y)>0.01){
        state.walls.push({id:uid(), a:{x:a.x,y:a.y}, b:{x:b.x,y:b.y}, thick:state.wallThick, height:state.wallHeight});
      }
      state.drawing=null; saveLocal(); draw(); renderInspector(); renderMiniHUD(); return;
    }
    if(state.drawing.mode==='room'){
      const a=state.drawing.start, b=state.drawing.cur; if(!b){ state.drawing=null; return; }
      const x1=Math.min(a.x,b.x), y1=Math.min(a.y,b.y), x2=Math.max(a.x,b.x), y2=Math.max(a.y,b.y);
      if((x2-x1)>0.1 && (y2-y1)>0.1){
        state.rooms.push({id:uid(), x1,y1,x2,y2, name:'Habitación'});
        state.walls.push({id:uid(), a:{x:x1,y:y1}, b:{x:x2,y:y1}, thick:state.wallThick, height:state.wallHeight});
        state.walls.push({id:uid(), a:{x:x2,y:y1}, b:{x:x2,y:y2}, thick:state.wallThick, height:state.wallHeight});
        state.walls.push({id:uid(), a:{x:x2,y:y2}, b:{x:x1,y:y2}, thick:state.wallThick, height:state.wallHeight});
        state.walls.push({id:uid(), a:{x:x1,y:y2}, b:{x:x1,y:y1}, thick:state.wallThick, height:state.wallHeight});
      }
      state.drawing=null; saveLocal(); draw(); renderInspector(); renderMiniHUD(); return;
    }
    if(state.drawing.mode==='opening'){
      const wa = state.walls.find(x=>x.id===state.drawing.wallId);
      if(wa){
        const a=worldToScreen(wa.a), b=worldToScreen(wa.b), sp=state.drawing._screen;
        const A=b.x-a.x, B=b.y-a.y, L2=A*A+B*B||1; let t=((sp.x-a.x)*A+(sp.y-a.y)*B)/L2; t=Math.max(0,Math.min(1,t));
        const width = state.drawing.kind==='door' ? 0.8 : 1.2;
        const entry = {id:uid(), wallId:wa.id, type:state.drawing.kind, width, pos:t};
        if(state.drawing.kind==='door'){ Object.assign(entry, {hinge:'left', swing:1, angle:90}); }
        state.openings.push(entry);
      }
      state.drawing=null; saveLocal(); draw(); renderInspector(); renderMiniHUD(); return;
    }
  }
  if(drag){ saveLocal(); drag=null; }
});

/* Zoom */
wrap.addEventListener('wheel', e=>{
  if(!e.ctrlKey){ // zoom normal
    const delta = Math.sign(e.deltaY)*-0.1;
    const old = state.zoom;
    state.zoom = Math.max(0.3, Math.min(3, state.zoom + delta));
    // zoom hacia el cursor
    const rect=plan.getBoundingClientRect(); const p={x:e.clientX-rect.left, y:e.clientY-rect.top};
    const wx=(p.x-state.pan.x)/(state.scale*old), wy=(p.y-state.pan.y)/(state.scale*old);
    state.pan.x = p.x - wx*state.scale*state.zoom;
    state.pan.y = p.y - wy*state.scale*state.zoom;
    draw(); renderMiniHUD();
    e.preventDefault();
  }
}, {passive:false});

/* Teclado accesible: mover/rotar/escalar */
function isTypingTarget(el){ return el && (el.tagName==='INPUT' || el.tagName==='TEXTAREA' || el.isContentEditable || el.tagName==='SELECT'); }
window.addEventListener('keydown', e=>{
  if(isTypingTarget(e.target)) return;
  const sel=state.selection;
  const fine = e.altKey, coarse = e.shiftKey;
  const step = fine ? 0.01 : (coarse ? 0.5 : 0.1);
  const rotStep = coarse ? 15 : 5;

  if(!sel){
    // atajo rápido: 1..6 cambia herramienta
    if(e.key==='1') setTool('select');
    if(e.key==='2') setTool('pan');
    if(e.key==='3') setTool('wall');
    if(e.key==='4') setTool('room');
    if(e.key==='5') setTool('door');
    if(e.key==='6') setTool('window');
    return;
  }

  if(e.key.startsWith('Arrow')){
    if(sel.type==='item'){
      const it=state.items.find(x=>x.id===sel.id); if(!it) return;
      if(e.ctrlKey||e.metaKey){
        if(e.key==='ArrowLeft'){ it.w=Math.max(0.1,it.w-step); }
        if(e.key==='ArrowRight'){ it.w=it.w+step; }
        if(e.key==='ArrowUp'){ it.d=Math.max(0.1,it.d-step); }
        if(e.key==='ArrowDown'){ it.d=it.d+step; }
      }else{
        if(e.key==='ArrowLeft'){ it.x=it.x-step; }
        if(e.key==='ArrowRight'){ it.x=it.x+step; }
        if(e.key==='ArrowUp'){ it.y=it.y-step; }
        if(e.key==='ArrowDown'){ it.y=it.y+step; }
      }
      saveLocal(); draw(); renderMiniHUD(); e.preventDefault(); return;
    }
    if(sel.type==='opening'){
      const op=state.openings.find(x=>x.id===sel.id); if(!op) return;
      if(e.ctrlKey||e.metaKey){
        if(e.key==='ArrowLeft'){ op.width=Math.max(0.3,(op.width||1)-step); }
        if(e.key==='ArrowRight'){ op.width=(op.width||1)+step; }
      }else{
        if(e.key==='ArrowLeft'){ op.pos=Math.max(0, (op.pos||0.5)-step/2); }
        if(e.key==='ArrowRight'){ op.pos=Math.min(1, (op.pos||0.5)+step/2); }
      }
      saveLocal(); draw(); renderMiniHUD(); e.preventDefault(); return;
    }
    if(sel.type==='wall'){
      const w=state.walls.find(x=>x.id===sel.id); if(!w) return;
      if(e.ctrlKey||e.metaKey){
        if(e.key==='ArrowUp'){ w.thick=Math.max(0.05,(w.thick||state.wallThick)-step/5); }
        if(e.key==='ArrowDown'){ w.thick=(w.thick||state.wallThick)+step/5; }
      }else{
        if(e.key==='ArrowLeft'){ w.a.x-=step; w.b.x-=step; }
        if(e.key==='ArrowRight'){ w.a.x+=step; w.b.x+=step; }
        if(e.key==='ArrowUp'){ w.a.y-=step; w.b.y-=step; }
        if(e.key==='ArrowDown'){ w.a.y+=step; w.b.y+=step; }
      }
      saveLocal(); draw(); renderMiniHUD(); e.preventDefault(); return;
    }
  }

  if(e.key.toLowerCase()==='q' || e.key.toLowerCase()==='e'){
    if(sel.type==='item'){
      const it=state.items.find(x=>x.id===sel.id); if(!it) return;
      it.rot=((it.rot||0)+(e.key.toLowerCase()==='q'?-rotStep:rotStep))%360; if(it.rot<0) it.rot+=360;
      saveLocal(); draw(); renderMiniHUD(); e.preventDefault(); return;
    }
    if(sel.type==='opening'){
      const op=state.openings.find(x=>x.id===sel.id); if(!op || op.type!=='door') return;
      op.angle=Math.max(0,Math.min(180,(op.angle||90)+(e.key.toLowerCase()==='q'?-rotStep:rotStep)));
      saveLocal(); draw(); renderMiniHUD(); e.preventDefault(); return;
    }
  }
});

/* Controles de archivo */
document.getElementById('tool-new').onclick=()=>{
  if(!confirm('¿Empezar un proyecto nuevo? Se perderán los cambios no guardados.')) return;
  state.walls=[]; state.openings=[]; state.rooms=[]; state.items=[]; state.selection=null; saveLocal(); draw(); renderInspector(); renderMiniHUD();
};
document.getElementById('tool-save').onclick=()=>{
  const blob=new Blob([JSON.stringify({walls:state.walls, openings:state.openings, rooms:state.rooms, items:state.items},null,2)],{type:'application/json'});
  const a=document.createElement('a'); a.href=URL.createObjectURL(blob); a.download='planificador.json'; a.click(); setTimeout(()=>URL.revokeObjectURL(a.href),1000);
};
document.getElementById('tool-import').onclick=()=>{
  const inp=document.createElement('input'); inp.type='file'; inp.accept='.json,application/json';
  inp.onchange=()=>{ const f=inp.files?.[0]; if(!f) return;
    const r=new FileReader(); r.onload=()=>{ try{
      const d=JSON.parse(r.result); state.walls=d.walls||[]; state.openings=d.openings||[]; state.rooms=d.rooms||[]; state.items=d.items||[];
      saveLocal(); draw(); renderInspector(); renderMiniHUD();
    }catch{ alert('JSON inválido'); } }; r.readAsText(f);
  }; inp.click();
};
document.getElementById('tool-reset').onclick=()=>{
  if(!confirm('¿Borrar todo lo colocado?')) return;
  state.walls=[]; state.openings=[]; state.rooms=[]; state.items=[]; state.selection=null; saveLocal(); draw(); renderInspector(); renderMiniHUD();
};

/* Parámetros */
document.getElementById('inp-thick').onchange = e=>{ state.wallThick=parseFloat(e.target.value)||state.wallThick; saveLocal(); draw(); };
document.getElementById('inp-height').onchange= e=>{ state.wallHeight=parseFloat(e.target.value)||state.wallHeight; saveLocal(); draw(); };
document.getElementById('inp-scale').onchange = e=>{ state.scale=parseFloat(e.target.value)||state.scale; draw(); };

/* Init */
function resize(){ plan.width=wrap.clientWidth; plan.height=wrap.clientHeight; draw(); }
window.addEventListener('resize', resize);

loadLocal(); resize(); updateCursor(); draw(); renderMiniHUD(); renderInspector();
</script>
</body>
</html>
