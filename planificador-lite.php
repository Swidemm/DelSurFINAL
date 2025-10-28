r"""<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Planificador Espacial — Lite (v9.6)</title>
<style>
  :root{
    --bg:#0f172a; --panel:#1c2330; --ink:#e8ecf1; --muted:#aab4c0; --grid:#1f2b36; --grid-strong:#294256;
    --shadow: 0 8px 24px rgba(0,0,0,.35);
  }
  *{box-sizing:border-box}
  html,body{height:100%;margin:0;font-family:Inter,system-ui,Segoe UI,Roboto,Helvetica,Arial;color:var(--ink);background:var(--bg)}
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
  .tour-spotlight{position:absolute; border:2px solid #7dd3fc; border-radius:10px; box-shadow:0 0 0 200vmax rgba(0,0,0,.45); transition:.15s; }
  .tour-pop{position:absolute; max-width:280px; background:#0f172a; color:#e6edf7; border:1px solid #2b3247; border-radius:12px;
    padding:.75rem; z-index:21; box-shadow:0 12px 30px rgba(0,0,0,.38)}
  .tour-pop h4{margin:.1rem 0 .35rem 0; font-size:.95rem}
  .tour-pop p{margin:0 0 .5rem 0; font-size:.9rem; color:#c9d5e6}
  .tour-actions{display:flex; gap:.5rem; justify-content:flex-end}
  .tour-btn{appearance:none;border:1px solid #2a3146;background:#111525;color:#dbe7f5;border-radius:.5rem;
    padding:.35rem .55rem; cursor:pointer; font-size:.85rem}
  .tour-btn.primary{border-color:#7dd3fc; background:#0b2336}
  .prop{display:grid;grid-template-columns:1fr 110px;gap:.4rem;align-items:center}
  .prop input,.prop select{background:#0e1324;border:1px solid #26304a;color:#e6edf7;border-radius:8px;padding:.35rem .5rem}
  .muted{color:#93a0b3;font-size:.88rem}
</style>
</head>
<body>
<div class="app">
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
        <button class="toolbtn" id="tool-undo">↶</button>
        <button class="toolbtn" id="tool-redo">↷</button>
        <button class="toolbtn" id="tool-erase">🗑️ Borrar</button>
        <button class="toolbtn" id="tool-reset">🧹 Reset</button>
      </div>
      <div class="toolgroup" id="grp-file"><span class="title">Proyecto</span>
        <button class="toolbtn" id="tool-export">⬇️ Exportar</button>
        <button class="toolbtn" id="tool-import">⬆️ Importar</button>
        <button class="toolbtn" id="tool-tour">❓ Tour</button>
        <button class="toolbtn" id="tool-demo">🧩 Demo</button>
      </div>
    </div>
  </header>

  <div class="row">
    <aside class="panel">
      <h3>Biblioteca</h3>
      <div class="library" id="library">
        <div class="lib-item" draggable="true" data-type="sofa" data-w="2" data-d="0.9">
          <svg viewBox="0 0 24 24"><rect x="2" y="10" width="20" height="7" rx="2" fill="#2a3a4f"/><rect x="4" y="8" width="16" height="3" fill="#31455f"/></svg>
          <div><strong>Sofá</strong><br/><span>2.0 × 0.9 m</span></div>
        </div>
        <div class="lib-item" draggable="true" data-type="bed" data-w="2" data-d="1.6">
          <svg viewBox="0 0 24 24"><rect x="2" y="8" width="20" height="10" rx="2" fill="#26354a"/><rect x="3" y="9" width="8" height="4" fill="#cbd5e1"/><rect x="13" y="9" width="8" height="4" fill="#cbd5e1"/></svg>
          <div><strong>Cama</strong><br/><span>2.0 × 1.6 m</span></div>
        </div>
        <div class="lib-item" draggable="true" data-type="table" data-w="1.4" data-d="0.8">
          <svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="10" rx="2" fill="#2b3a52"/><rect x="5" y="9" width="2" height="6" fill="#0f1422"/><rect x="17" y="9" width="2" height="6" fill="#0f1422"/></svg>
          <div><strong>Mesa</strong><br/><span>1.4 × 0.8 m</span></div>
        </div>
        <div class="lib-item" draggable="true" data-type="wardrobe" data-w="1.2" data-d="0.6">
          <svg viewBox="0 0 24 24"><rect x="4" y="5" width="16" height="14" rx="1" fill="#223047"/><line x1="12" y1="5" x2="12" y2="19" stroke="#6b7c96" /></svg>
          <div><strong>Placard</strong><br/><span>1.2 × 0.6 m</span></div>
        </div>
        <div class="lib-item" draggable="true" data-type="chair" data-w="0.5" data-d="0.5">
          <svg viewBox="0 0 24 24"><rect x="6" y="9" width="12" height="6" rx="1" fill="#1f2937"/><rect x="6" y="7" width="12" height="2" fill="#2b3a52"/></svg>
          <div><strong>Silla</strong><br/><span>0.5 × 0.5 m</span></div>
        </div>
        <div class="lib-item" draggable="true" data-type="fridge" data-w="0.70" data-d="0.70">
          <svg viewBox="0 0 24 24"><rect x="5" y="4" width="14" height="16" rx="2" fill="#1c2640"/><line x1="5" y1="12" x2="19" y2="12" stroke="#6b7c96"/></svg>
          <div><strong>Heladera</strong><br/><span>0.70 × 0.70 m</span></div>
        </div>
        <div class="lib-item" draggable="true" data-type="counter" data-w="2.00" data-d="0.60">
          <svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="10" rx="2" fill="#263348"/><rect x="6" y="9" width="6" height="6" rx="1" fill="#0d1526"/><rect x="12" y="9" width="6" height="6" rx="1" fill="#0d1526"/></svg>
          <div><strong>Mesada</strong><br/><span>2.00 × 0.60 m</span></div>
        </div>
        <div class="lib-item" draggable="true" data-type="tv" data-w="1.20" data-d="0.20">
          <svg viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="12" rx="2" fill="#0a0f18"/><rect x="5" y="8" width="14" height="8" fill="#0c111b"/></svg>
          <div><strong>Televisor</strong><br/><span>1.20 × 0.20 m</span></div>
        </div>
      </div>
    </aside>

    <section class="panel" style="display:grid;grid-template-rows:auto 1fr auto;">
      <h3>Editor 2D</h3>
      <div class="canvas-wrap" id="canvasWrap">
        <canvas id="plan2d"></canvas>
        <div class="overlays">
          <div class="hud" id="hud"><div class="status"></div></div>
          <div id="miniHud" class="mini-hud" style="display:none"></div>
        </div>
      </div>
      <div class="controls">
        <div class="group"><label>Escala</label> <input id="scaleInput" type="number" step="0.1" min="0.1" value="40"> <span class="muted">px/m</span></div>
        <div class="group"><label>Altura muro</label> <input id="wallH" type="number" step="0.1" value="2.7"> m</div>
        <div class="group"><label>Espesor muro</label> <input id="wallT" type="number" step="0.01" value="0.15"> m</div>
        <div class="group"><label><input id="snap" type="checkbox" checked> Snap</label></div>
        <div class="group"><label><input id="gridToggle" type="checkbox" checked> Grilla</label></div>
      </div>
    </section>

    <aside class="panel" id="inspectorPanel">
      <h3>Inspector</h3>
      <div id="inspectorContent" style="padding:10px; display:grid; gap:.6rem; align-content:start;">
        <div class="muted">Seleccioná un elemento para ver y editar sus propiedades.</div>
      </div>
    </aside>
  </div>
</div>

<!-- Tour containers -->
<div id="tourMask" class="tour-mask" style="display:none">
  <div id="tourSpot" class="tour-spotlight"></div>
  <div id="tourPop" class="tour-pop" style="display:none"></div>
</div>

<script>
// --------- Estado y utilidades básicas ---------
const state = {
  tool:'select', scale:40, snap:true, showGrid:true,
  wallHeight:2.7, wallThick:0.15,
  pan:{x:80,y:80}, zoom:1, dpr:1,
  walls:[], openings:[], items:[], rooms:[],
  selection:null, drawing:null, hist:[], fut:[]
};
const $ = s=>document.querySelector(s);
const plan = $('#plan2d'), wrap=$('#canvasWrap'), ctx=plan.getContext('2d');
const hud = $('#hud .status'); const miniHud = $('#miniHud');
const uid = () => Math.random().toString(36).slice(2,9);
const snapVal = v => state.snap ? Math.round(v*10)/10 : v;
const worldToScreen = p => ({x: (p.x*state.scale*state.zoom)+state.pan.x, y:(p.y*state.scale*state.zoom)+state.pan.y});
const screenToWorld = p => ({x: (p.x-state.pan.x)/(state.scale*state.zoom), y:(p.y-state.pan.y)/(state.scale*state.zoom)});

// --------- Persistencia sencilla ---------
function saveLocal(){
  try{ localStorage.setItem('planificador-lite', JSON.stringify({walls:state.walls,openings:state.openings,items:state.items,rooms:state.rooms})); }catch{}
}
function loadLocal(){
  try{ const d=JSON.parse(localStorage.getItem('planificador-lite')); if(d){ state.walls=d.walls||[]; state.openings=d.openings||[]; state.items=d.items||[]; state.rooms=d.rooms||[]; } }catch{}
}
function pushHist(){
  state.hist.push(JSON.stringify({walls:state.walls,openings:state.openings,items:state.items,rooms:state.rooms}));
  state.fut.length=0; saveLocal();
}

// --------- Layout / resize ---------
function resize(){
  const r = wrap.getBoundingClientRect();
  const dpr = Math.max(1, window.devicePixelRatio||1);
  state.dpr=dpr;
  plan.width = Math.round(r.width*dpr); plan.height=Math.round(r.height*dpr);
  plan.style.width = r.width+'px'; plan.style.height=r.height+'px';
  ctx.setTransform(dpr,0,0,dpr,0,0);
  draw(); renderMiniHUD();
}
window.addEventListener('resize', resize);

// --------- Dibujo básico (grid + items + paredes + aberturas) ---------
function drawGrid(){
  if(!state.showGrid) return;
  const r = wrap.getBoundingClientRect(); const w=r.width, h=r.height;
  const s = state.scale*state.zoom; const ox=((state.pan.x%s)+s)%s; const oy=((state.pan.y%s)+s)%s;
  ctx.save(); ctx.lineWidth=1; ctx.strokeStyle=getComputedStyle(document.documentElement).getPropertyValue('--grid').trim();
  for(let x=ox; x<w; x+=s){ ctx.beginPath(); ctx.moveTo(x,0); ctx.lineTo(x,h); ctx.stroke(); }
  for(let y=oy; y<h; y+=s){ ctx.beginPath(); ctx.moveTo(0,y); ctx.lineTo(w,y); ctx.stroke(); }
  ctx.strokeStyle=getComputedStyle(document.documentElement).getPropertyValue('--grid-strong').trim();
  const s5=s*5, ox5=((state.pan.x%s5)+s5)%s5, oy5=((state.pan.y%s5)+s5)%s5;
  for(let x=ox5; x<w; x+=s5){ ctx.beginPath(); ctx.moveTo(x,0); ctx.lineTo(x,h); ctx.stroke(); }
  for(let y=oy5; y<h; y+=s5){ ctx.beginPath(); ctx.moveTo(0,y); ctx.lineTo(w,y); ctx.stroke(); }
  ctx.restore();
}
function drawWalls(){
  ctx.save();
  for(const w of state.walls){
    const a=worldToScreen(w.a), b=worldToScreen(w.b);
    const ang = Math.atan2(b.y-a.y,b.x-a.x);
    const half=(w.thick*state.scale*state.zoom)/2;
    const nx=Math.sin(ang)*half, ny=-Math.cos(ang)*half;
    ctx.beginPath();
    ctx.moveTo(a.x+nx,a.y+ny); ctx.lineTo(b.x+nx,b.y+ny); ctx.lineTo(b.x-nx,b.y-ny); ctx.lineTo(a.x-nx,a.y-ny); ctx.closePath();
    ctx.fillStyle='#374151'; ctx.fill();
    ctx.lineWidth=2; ctx.strokeStyle=(state.selection?.type==='wall' && state.selection?.id===w.id)?'#6ee7ff':'#4b5563'; ctx.stroke();
  }
  ctx.restore();
}
function drawOpenings(){
  ctx.save();
  for(const o of state.openings){
    const w = state.walls.find(x=>x.id===o.wallId); if(!w) continue;
    const aW=w.a, bW=w.b; const P={x:aW.x+(bW.x-aW.x)*o.pos, y:aW.y+(bW.y-aW.y)*o.pos};
    const a=worldToScreen(aW), b=worldToScreen(bW), p=worldToScreen(P);
    const ang=Math.atan2(b.y-a.y,b.x-a.x); const scale=state.scale*state.zoom; const half=(w.thick*scale)/2;
    ctx.save(); ctx.translate(p.x,p.y); ctx.rotate(ang);
    if(o.type==='door'){
      const leaf=o.width*scale; const theta=(o.angle||90)*Math.PI/180; const hinge=(o.hinge==='left'?-1:1); const swing=o.swing===-1?-1:1;
      const hy=hinge*half;
      ctx.fillStyle='#0f172a'; ctx.fillRect(-leaf/2,-half,leaf,half*2);
      ctx.strokeStyle='#10b981'; ctx.lineWidth=2; ctx.beginPath(); ctx.moveTo(0,hy); ctx.lineTo(Math.cos(swing*theta)*leaf, hy+Math.sin(swing*theta)*leaf); ctx.stroke();
      ctx.lineWidth=1.5; ctx.beginPath(); ctx.arc(0,hy, leaf, 0, swing*theta, swing<0); ctx.stroke();
      ctx.fillStyle='#10b981'; ctx.beginPath(); ctx.arc(0,hy,3,0,Math.PI*2); ctx.fill();
    }else{
      const wpx=o.width*scale; ctx.fillStyle='#60a5fa'; ctx.fillRect(-wpx/2,-half/2, wpx, half);
      ctx.strokeStyle='#111827'; ctx.lineWidth=2; ctx.strokeRect(-wpx/2,-half/2, wpx, half);
    }
    ctx.restore();
  }
  ctx.restore();
}
function drawItems(){
  function drawRect(w,d){ ctx.beginPath(); ctx.rect(-w/2,-d/2,w,d); ctx.fill(); ctx.stroke(); }
  for(const it of state.items){
    const p=worldToScreen({x:it.x,y:it.y}); const w=it.w*state.scale*state.zoom; const d=it.d*state.scale*state.zoom;
    ctx.save(); ctx.translate(p.x,p.y); ctx.rotate((it.rot||0)*Math.PI/180);
    ctx.fillStyle='#0f172a'; ctx.strokeStyle=(state.selection?.type==='item'&&state.selection.id===it.id)?'#6ee7ff':'#94a3b8'; ctx.lineWidth=2;
    drawRect(w,d);
    // simple inner detail per type
    if(it.type==='bed'){ ctx.fillStyle='#cbd5e1'; ctx.fillRect(-w/2+6,-d/2+6,w*0.35,d*0.18); ctx.fillRect(w/2-6-w*0.35,-d/2+6,w*0.35,d*0.18); }
    if(it.type==='table'){ ctx.fillStyle='#223047'; ctx.fillRect(-w/2+6,-d/2+6,w-12,6); }
    if(it.type==='tv'){ ctx.fillStyle='#0a0f18'; ctx.fillRect(-w/2+6,-d/2+6,w-12,d-12); }
    ctx.restore();
  }
}
function draw(){
  const r=wrap.getBoundingClientRect();
  ctx.clearRect(0,0,r.width,r.height);
  drawGrid(); drawWalls(); drawOpenings(); drawItems();
  hud.innerHTML = `Herramienta: <b>${state.tool}</b> · zoom <code>${state.zoom.toFixed(2)}</code> · escala <code>${state.scale} px/m</code>`;
}

// --------- Mini HUD contextual ---------
function getItemAABB(it){
  const cx=it.x, cy=it.y, w=it.w, d=it.d, ang=(it.rot||0)*Math.PI/180;
  const corners=[{x:cx-w/2,y:cy-d/2},{x:cx+w/2,y:cy-d/2},{x:cx+w/2,y:cy+d/2},{x:cx-w/2,y:cy+d/2}].map(p=>{
    const dx=p.x-cx, dy=p.y-cy; return worldToScreen({x:cx+dx*Math.cos(ang)-dy*Math.sin(ang), y:cy+dx*Math.sin(ang)+dy*Math.cos(ang)});
  });
  const xs=corners.map(c=>c.x), ys=corners.map(c=>c.y);
  return {minx:Math.min(...xs), miny:Math.min(...ys), maxx:Math.max(...xs), maxy:Math.max(...ys)};
}
function placeMiniHudAtScreen(x,y){
  miniHud.style.left = Math.round(x)+'px'; miniHud.style.top = Math.round(y)+'px'; miniHud.style.display='flex';
  requestAnimationFrame(()=> miniHud.classList.add('show'));
}
function hideMiniHud(){ miniHud.classList.remove('show'); miniHud.style.display='none'; }
function rotateSelected90(){
  if(state.selection?.type==='item'){ const it=state.items.find(x=>x.id===state.selection.id); if(it){ it.rot=((it.rot||0)+90)%360; pushHist(); draw(); renderInspector(); renderMiniHUD(); } }
}
function duplicateSelected(){
  const sel=state.selection; if(!sel) return;
  if(sel.type==='item'){ const it=state.items.find(x=>x.id===sel.id); if(it){ const c=structuredClone(it); c.id=uid(); c.x+=0.2; c.y+=0.2; state.items.push(c); state.selection={type:'item',id:c.id}; pushHist(); draw(); renderInspector(); renderMiniHUD(); } }
  else if(sel.type==='opening'){ const op=state.openings.find(x=>x.id===sel.id); if(op){ const c=structuredClone(op); c.id=uid(); c.pos=Math.min(0.95,Math.max(0.05,op.pos+0.05)); state.openings.push(c); state.selection={type:'opening',id:c.id}; pushHist(); draw(); renderInspector(); renderMiniHUD(); } }
  else if(sel.type==='wall'){ const w=state.walls.find(x=>x.id===sel.id); if(w){ const ang=Math.atan2(w.b.y-w.a.y,w.b.x-w.a.x); const nx=Math.sin(ang)*0.2, ny=-Math.cos(ang)*0.2; const c={id:uid(),a:{x:w.a.x+nx,y:w.a.y+ny},b:{x:w.b.x+nx,y:w.b.y+ny},thick:w.thick,height:w.height}; state.walls.push(c); state.selection={type:'wall',id:c.id}; pushHist(); draw(); renderInspector(); renderMiniHUD(); } }
}
function deleteSelected(){
  const sel=state.selection; if(!sel) return; pushHist();
  if(sel.type==='item'){ const i=state.items.findIndex(x=>x.id===sel.id); if(i>-1) state.items.splice(i,1); }
  if(sel.type==='opening'){ const i=state.openings.findIndex(x=>x.id===sel.id); if(i>-1) state.openings.splice(i,1); }
  if(sel.type==='wall'){ const i=state.walls.findIndex(x=>x.id===sel.id); if(i>-1) state.walls.splice(i,1); }
  state.selection=null; renderInspector(); draw(); renderMiniHUD();
}
function renderMiniHUD(){
  if(!state.selection){ hideMiniHud(); return; }
  let pos=null, rotate=false;
  if(state.selection.type==='item'){
    const it=state.items.find(x=>x.id===state.selection.id); if(!it){ hideMiniHud(); return; }
    const aabb=getItemAABB(it); pos={x:aabb.maxx+8, y:aabb.miny-8}; rotate=true;
  } else if(state.selection.type==='opening'){
    const op=state.openings.find(x=>x.id===state.selection.id); const w=state.walls.find(x=>x.id===op?.wallId);
    if(!op || !w){ hideMiniHud(); return; }
    const P={x:w.a.x+(w.b.x-w.a.x)*op.pos, y:w.a.y+(w.b.y-w.a.y)*op.pos}; const p=worldToScreen(P);
    pos={x:p.x+10,y:p.y-36};
  } else if(state.selection.type==='wall'){
    const w=state.walls.find(x=>x.id===state.selection.id); if(!w){ hideMiniHud(); return; }
    const a=worldToScreen(w.a), b=worldToScreen(w.b); pos={x:(a.x+b.x)/2+10, y:(a.y+b.y)/2-36};
  }
  let html=''; if(rotate) html+='<button class="mh-btn" id="mh-rot">🔄 90°</button>';
  html+='<button class="mh-btn" id="mh-dup">📑 Duplicar</button><button class="mh-btn" id="mh-del">🗑️ Borrar</button>';
  miniHud.innerHTML=html;
  if($('#mh-rot')) $('#mh-rot').onclick=rotateSelected90;
  $('#mh-dup').onclick=duplicateSelected; $('#mh-del').onclick=deleteSelected;
  placeMiniHudAtScreen(pos.x,pos.y);
}

// --------- Hit testing mínimo ---------
function hitTest(p){
  // items
  for(let i=state.items.length-1;i>=0;i--){
    const it=state.items[i];
    const w=it.w*state.scale*state.zoom, d=it.d*state.scale*state.zoom;
    const c=worldToScreen({x:it.x,y:it.y});
    const ang=(it.rot||0)*Math.PI/180;
    const dx=p.x-c.x, dy=p.y-c.y;
    const rx= dx*Math.cos(-ang) - dy*Math.sin(-ang);
    const ry= dx*Math.sin(-ang) + dy*Math.cos(-ang);
    if(Math.abs(rx)<=w/2 && Math.abs(ry)<=d/2) return {type:'item', id:it.id};
  }
  // walls (near segment)
  for(const w of state.walls){
    const a=worldToScreen(w.a), b=worldToScreen(w.b);
    // distance point-line segment
    const A=b.x-a.x, B=b.y-a.y, L2=A*A+B*B;
    let t=((p.x-a.x)*A+(p.y-a.y)*B)/L2; t=Math.max(0,Math.min(1,t));
    const proj={x:a.x+t*A,y:a.y+t*B}; const dist=Math.hypot(p.x-proj.x,p.y-proj.y);
    if(dist<6) return {type:'wall', id:w.id};
  }
  // openings (point near center)
  for(const o of state.openings){
    const w=state.walls.find(x=>x.id===o.wallId); if(!w) continue;
    const P={x:w.a.x+(w.b.x-w.a.x)*o.pos, y:w.a.y+(w.b.y-w.a.y)*o.pos}; const s=worldToScreen(P);
    if(Math.hypot(p.x-s.x,p.y-s.y)<8) return {type:'opening', id:o.id};
  }
  return null;
}

// --------- Inspector ---------
const insp = $('#inspectorContent');
function renderInspector(){
  if(!insp) return;
  const sel=state.selection;
  if(!sel){ insp.innerHTML='<div class="muted">Seleccioná un elemento para ver y editar sus propiedades.</div>'; return; }
  if(sel.type==='item'){
    const it=state.items.find(x=>x.id===sel.id); if(!it){ insp.innerHTML='<div class="muted">Elemento no encontrado.</div>'; return;}
    insp.innerHTML = `
      <div class="muted"><b>Mueble</b> — ${it.type}</div>
      <div class="prop"><label>X (m)</label><input id="ip-it-x" type="number" step="0.01" value="${it.x.toFixed(2)}"></div>
      <div class="prop"><label>Y (m)</label><input id="ip-it-y" type="number" step="0.01" value="${it.y.toFixed(2)}"></div>
      <div class="prop"><label>Ancho (m)</label><input id="ip-it-w" type="number" step="0.01" value="${it.w}"></div>
      <div class="prop"><label>Fondo (m)</label><input id="ip-it-d" type="number" step="0.01" value="${it.d}"></div>
      <div class="prop"><label>Rotación</label><input id="ip-it-rot" type="number" step="1" value="${it.rot||0}"></div>
      <button class="toolbtn" id="ip-commit">Aplicar</button>`;
    const num=(id,def)=>{const e=$('#'+id);const v=parseFloat(e.value);return isNaN(v)?def:v;};
    const commit=()=>{ it.x=num('ip-it-x',it.x); it.y=num('ip-it-y',it.y); it.w=num('ip-it-w',it.w); it.d=num('ip-it-d',it.d); it.rot=num('ip-it-rot',it.rot||0); pushHist(); draw(); renderMiniHUD(); };
    $('#ip-commit').onclick=commit; ['ip-it-x','ip-it-y','ip-it-w','ip-it-d','ip-it-rot'].forEach(id=>$('#'+id).addEventListener('keydown',e=>{if(e.key==='Enter')commit();}));
    return;
  }
  if(sel.type==='opening'){
    const op=state.openings.find(x=>x.id===sel.id); if(!op){ insp.innerHTML='<div class="muted">Abertura no encontrada.</div>'; return; }
    const isDoor=op.type==='door';
    insp.innerHTML = `
      <div class="muted"><b>${isDoor?'Puerta':'Ventana'}</b></div>
      <div class="prop"><label>Ancho (m)</label><input id="ip-op-w" type="number" step="0.01" value="${op.width}"></div>
      ${isDoor?`<div class="prop"><label>Ángulo (°)</label><input id="ip-op-a" type="number" step="1" min="0" max="180" value="${op.angle||90}"></div>
      <div class="prop"><label>Bisagra</label><select id="ip-op-h"><option value="left" ${op.hinge==='left'?'selected':''}>Izquierda</option><option value="right" ${op.hinge==='right'?'selected':''}>Derecha</option></select></div>
      <div class="prop"><label>Sentido</label><select id="ip-op-s"><option value="1" ${op.swing===1?'selected':''}>Hacia afuera</option><option value="-1" ${op.swing===-1?'selected':''}>Hacia adentro</option></select></div>`:''}
      <button class="toolbtn" id="ip-commit">Aplicar</button>`;
    const commit=()=>{ op.width=parseFloat($('#ip-op-w').value)||op.width; if(isDoor){ op.angle=Math.max(0,Math.min(180,parseFloat($('#ip-op-a').value)||op.angle||90)); op.hinge=$('#ip-op-h').value==='right'?'right':'left'; op.swing=parseInt($('#ip-op-s').value,10)===-1?-1:1; } pushHist(); draw(); renderMiniHUD(); };
    $('#ip-commit').onclick=commit; ['ip-op-w','ip-op-a','ip-op-h','ip-op-s'].forEach(id=>{const e=$('#'+id); if(e) e.addEventListener('keydown',ev=>{if(ev.key==='Enter')commit();});});
    return;
  }
  if(sel.type==='wall'){
    const w=state.walls.find(x=>x.id===sel.id); if(!w){ insp.innerHTML='<div class="muted">Muro no encontrado.</div>'; return; }
    const len = Math.hypot(w.b.x-w.a.x, w.b.y-w.a.y).toFixed(2);
    insp.innerHTML = `
      <div class="muted"><b>Pared</b> — ${len} m</div>
      <div class="prop"><label>Espesor (m)</label><input id="ip-wa-t" type="number" step="0.01" value="${w.thick}"></div>
      <div class="prop"><label>Altura (m)</label><input id="ip-wa-h" type="number" step="0.01" value="${w.height||state.wallHeight}"></div>
      <button class="toolbtn" id="ip-commit">Aplicar</button>`;
    const commit=()=>{ w.thick=parseFloat($('#ip-wa-t').value)||w.thick; w.height=parseFloat($('#ip-wa-h').value)||w.height||state.wallHeight; pushHist(); draw(); renderMiniHUD(); };
    $('#ip-commit').onclick=commit; ['ip-wa-t','ip-wa-h'].forEach(id=>$('#'+id).addEventListener('keydown',e=>{if(e.key==='Enter')commit();}));
    return;
  }
  insp.innerHTML='<div class="muted">Elemento seleccionado.</div>';
}

// --------- Interacción mínima (select + mover items + abrir duplicado con Alt) ---------
let isPanning=false, drag=null;
function updateCursor(){ plan.style.cursor = state.tool==='pan' ? 'grab' : 'default'; }

plan.addEventListener('mousedown', (e)=>{
  const rect=plan.getBoundingClientRect(); const p={x:e.clientX-rect.left, y:e.clientY-rect.top}; const w=screenToWorld(p);
  if(state.tool==='pan'){ isPanning=true; plan.style.cursor='grabbing'; window.__panStart={x:e.clientX,y:e.clientY, panX:state.pan.x, panY:state.pan.y}; return; }
  const hit=hitTest(p);
  if(hit){
    state.selection={type:hit.type, id:hit.id}; renderInspector(); draw(); renderMiniHUD();
    if(hit.type==='item' && e.button===0){ const it=state.items.find(x=>x.id===hit.id);
      if(e.altKey){ const c=structuredClone(it); c.id=uid(); state.items.push(c); state.selection={type:'item',id:c.id}; }
      drag={id:state.selection.id, dx:w.x-it.x, dy:w.y-it.y};
    }
  }else{
    state.selection=null; renderInspector(); draw(); renderMiniHUD();
  }
});
plan.addEventListener('mousemove', (e)=>{
  const rect=plan.getBoundingClientRect(); const p={x:e.clientX-rect.left, y:e.clientY-rect.top}; const w=screenToWorld(p);
  if(isPanning && window.__panStart){ const dx=e.clientX-window.__panStart.x, dy=e.clientY-window.__panStart.y; state.pan.x=window.__panStart.panX+dx; state.pan.y=window.__panStart.panY+dy; draw(); renderMiniHUD(); return; }
  if(drag){ const it=state.items.find(x=>x.id===drag.id); if(it){ it.x=snapVal(w.x-drag.dx); it.y=snapVal(w.y-drag.dy); draw(); renderMiniHUD(); } }
});
plan.addEventListener('mouseup', ()=>{ if(isPanning){isPanning=false; plan.style.cursor='grab';} if(drag){ pushHist(); drag=null; } });

plan.addEventListener('wheel', (e)=>{
  e.preventDefault();
  const delta = Math.sign(e.deltaY)*-0.1;
  const oldZoom = state.zoom;
  state.zoom = Math.max(0.2, Math.min(4, state.zoom + delta));
  // zoom towards cursor
  const rect=plan.getBoundingClientRect(); const mx=e.clientX-rect.left, my=e.clientY-rect.top;
  const before=screenToWorld({x:mx,y:my});
  const after=screenToWorld({x:mx,y:my});
  state.pan.x += (mx - (after.x*state.scale*state.zoom + state.pan.x));
  state.pan.y += (my - (after.y*state.scale*state.zoom + state.pan.y));
  draw(); renderMiniHUD();
}, {passive:false});

// --------- Controles básicos ---------
$('#tool-select').onclick=()=>{state.tool='select'; updateCursor();};
$('#tool-pan').onclick=()=>{state.tool='pan'; updateCursor();};
$('#gridToggle').onchange=(e)=>{state.showGrid=e.target.checked; draw(); renderMiniHUD();};
$('#scaleInput').onchange=(e)=>{state.scale=parseFloat(e.target.value)||40; draw(); renderMiniHUD();};
$('#wallH').onchange=(e)=>{state.wallHeight=parseFloat(e.target.value)||2.7;};
$('#wallT').onchange=(e)=>{state.wallThick=parseFloat(e.target.value)||0.15;};
$('#tool-reset').onclick=()=>{ if(confirm('¿Borrar TODO el proyecto actual?')){ state.walls=[]; state.openings=[]; state.items=[]; state.rooms=[]; state.selection=null; state.hist=[]; state.fut=[]; localStorage.removeItem('planificador-lite'); draw(); renderMiniHUD(); } };

// --------- Biblioteca (drag-drop simple) ---------
$('#library').addEventListener('dragstart', (e)=>{
  const t = e.target.closest('.lib-item'); if(!t) return;
  e.dataTransfer.setData('text/plain', JSON.stringify({type:t.dataset.type, w:parseFloat(t.dataset.w), d:parseFloat(t.dataset.d)}));
});
wrap.addEventListener('dragover', (e)=>{ e.preventDefault(); });
wrap.addEventListener('drop', (e)=>{
  e.preventDefault();
  const rect=plan.getBoundingClientRect(); const p={x:e.clientX-rect.left, y:e.clientY-rect.top}; const w=screenToWorld(p);
  try{
    const d = JSON.parse(e.dataTransfer.getData('text/plain'));
    state.items.push({id:uid(), type:d.type, x:snapVal(w.x), y:snapVal(w.y), w:d.w, d:d.d, rot:0});
    pushHist(); draw(); renderMiniHUD();
  }catch{}
});

// --------- Tour + Demo ---------
function loadDemoState(){
  state.rooms=[{id:uid(),x1:0,y1:0,x2:4,y2:3,name:'Dormitorio'}];
  state.walls=[{id:uid(),a:{x:0,y:0},b:{x:4,y:0},thick:state.wallThick,height:state.wallHeight},
               {id:uid(),a:{x:4,y:0},b:{x:4,y:3},thick:state.wallThick,height:state.wallHeight},
               {id:uid(),a:{x:4,y:3},b:{x:0,y:3},thick:state.wallThick,height:state.wallHeight},
               {id:uid(),a:{x:0,y:3},b:{x:0,y:0},thick:state.wallThick,height:state.wallHeight}];
  state.openings=[{id:uid(),wallId:state.walls[2].id,type:'door',width:0.8,pos:0.5,hinge:'left',swing:1,angle:90},
                  {id:uid(),wallId:state.walls[0].id,type:'window',width:1.2,pos:0.5}];
  state.items=[{id:uid(),type:'bed',x:1.0,y:1.5,w:2.0,d:1.6,rot:0},
               {id:uid(),type:'table',x:3.0,y:1.5,w:1.4,d:0.8,rot:90},
               {id:uid(),type:'tv',x:2.0,y:0.25,w:1.2,d:0.2,rot:0}];
  state.pan.x=80; state.pan.y=80; state.zoom=1;
  saveLocal(); pushHist(); draw(); renderMiniHUD();
}
const tourMask = $('#tourMask'), tourSpot=$('#tourSpot'), tourPop=$('#tourPop');
const tourSteps=[
  { sel:'#grp-draw', title:'Elegí una herramienta', text:'Usá las herramientas para dibujar: pared, habitación, puerta, ventana.' },
  { sel:'#plan2d',   title:'Dibujá una habitación', text:'Con la herramienta Habitación o Paredes, hacé clic y arrastrá en el lienzo.' },
  { sel:'#library',  title:'Agregá un mueble',       text:'Arrastrá un mueble desde la biblioteca de la izquierda hasta el plano.' },
  { sel:'#plan2d',   title:'Mové y rotá',            text:'Seleccioná el mueble para moverlo. Con la tecla R lo rotás. También podés usar la mini-toolbar.' },
];
let tourIndex=0;
function placeSpotAndPop(target){
  const r=target.getBoundingClientRect(); tourSpot.style.left=(r.left-6)+'px'; tourSpot.style.top=(r.top-6)+'px';
  tourSpot.style.width=(r.width+12)+'px'; tourSpot.style.height=(r.height+12)+'px';
  tourPop.style.display='block';
  const viewportW=innerWidth, viewportH=innerHeight; let x=r.right+12, y=r.top;
  if(x+300>viewportW){ x=r.left; y=r.bottom+12; } if(y+160>viewportH){ y=Math.max(12, viewportH-180); }
  tourPop.style.left=x+'px'; tourPop.style.top=y+'px';
}
function showStep(i){
  const step=tourSteps[i]; const target=document.querySelector(step.sel); if(!target){ endTour(); return; }
  tourPop.innerHTML=`<h4>${step.title}</h4><p>${step.text}</p>
    <div class="tour-actions"><button class="tour-btn" id="tour-skip">Saltar</button>
    <button class="tour-btn primary" id="tour-next">${i===tourSteps.length-1?'Terminar':'Siguiente'}</button></div>`;
  placeSpotAndPop(target); tourMask.style.display='block'; requestAnimationFrame(()=>tourMask.classList.add('show'));
  $('#tour-skip').onclick=endTour; $('#tour-next').onclick=()=>{ tourIndex++; if(tourIndex>=tourSteps.length) endTour(); else showStep(tourIndex); };
  window.addEventListener('resize', ()=>placeSpotAndPop(target), {once:true});
}
function startTour(force=false){ const done=localStorage.getItem('planificador-tourDone')==='1'; if(done && !force) return; tourIndex=0; showStep(tourIndex); }
function endTour(){ tourMask.classList.remove('show'); tourMask.style.display='none'; tourPop.style.display='none'; localStorage.setItem('planificador-tourDone','1'); }

$('#tool-tour').onclick=()=>startTour(true);
$('#tool-demo').onclick=()=>{ if(confirm('Cargar ejemplo demo (se perderán los cambios no guardados). ¿Continuar?')) loadDemoState(); };

// --------- Init ---------
loadLocal(); resize(); updateCursor(); draw(); renderMiniHUD(); renderInspector();
window.addEventListener('DOMContentLoaded', ()=>{ startTour(false); });
</script>
</body>
</html>