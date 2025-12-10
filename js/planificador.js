/*
 * planificador.js
 *
 * This script implements a minimal 2D planificador with basic drawing,
 * selection and navigation functionality. The user can draw walls by
 * clicking and dragging, snap to a grid, pan and zoom the view, select
 * and delete individual walls, and undo/redo changes. The project
 * state persists automatically in localStorage between sessions.
 */

(() => {
  // Retrieve elements once the DOM is ready
  window.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('plan2d');
    const wrap = document.getElementById('canvasWrap');
    const ctx = canvas.getContext('2d');
    const hudStatus = document.getElementById('hudStatus') || document.querySelector('#hud .status');
    const inspectorContent = document.getElementById('inspectorContent');

    // Toolbar buttons
    const btnSelect = document.getElementById('tool-select');
    const btnPan    = document.getElementById('tool-pan');
    const btnWall   = document.getElementById('tool-wall');
    const btnRoom   = document.getElementById('tool-room');
    const btnDoor   = document.getElementById('tool-door');
    const btnWindow = document.getElementById('tool-window');
    const btnUndo   = document.getElementById('tool-undo');
    const btnRedo   = document.getElementById('tool-redo');
    const btnErase  = document.getElementById('tool-erase');
    const btnReset  = document.getElementById('tool-reset');

    // Controls
    const scaleInput = document.getElementById('scaleInput');
    const snapCheckbox = document.getElementById('snap');
    const gridToggle = document.getElementById('gridToggle');
    const wallHeightInput = document.getElementById('wallH');
    const wallThickInput  = document.getElementById('wallT');

    // Application state
    const state = {
      tool: 'select',
      scale: parseFloat(scaleInput?.value) || 40, // px per metre
      snap: snapCheckbox?.checked ?? true,
      showGrid: gridToggle?.checked ?? true,
      pan: { x: 80, y: 80 },
      zoom: 1,
      dpr: window.devicePixelRatio || 1,
      // entities
      walls: [],
      rooms: [], // rectangular rooms with area labels
      doors: [], // doors attached to walls
      windows: [], // windows attached to walls
      items: [], // furniture and arrows
      selection: null,
      drawing: null,
      // first corner when drawing a room; null if not active
      roomStart: null,
      // currently selected library item (for placement)
      currentItem: null,
      hist: [],
      fut: []
    };

    // Helper: deep clone walls
    function cloneWalls(walls) {
      return walls.map(w => ({ id: w.id, a: { x: w.a.x, y: w.a.y }, b: { x: w.b.x, y: w.b.y } }));
    }

    // Clone the full state for history (walls, rooms, doors, windows, items, pan, zoom, scale)
    function cloneState() {
      return {
        walls: cloneWalls(state.walls),
        rooms: state.rooms.map(r => ({ id: r.id, corners: r.corners.map(p => ({ x: p.x, y: p.y })), area: r.area })),
        doors: state.doors.map(d => ({ id: d.id, wallId: d.wallId, offset: d.offset, width: d.width, hingeLeft: d.hingeLeft })),
        windows: state.windows.map(w => ({ id: w.id, wallId: w.wallId, offset: w.offset, width: w.width })),
        items: state.items.map(i => ({ id: i.id, type: i.type, x: i.x, y: i.y, w: i.w, d: i.d, rot: i.rot })),
        pan: { x: state.pan.x, y: state.pan.y },
        zoom: state.zoom,
        scale: state.scale
      };
    }

    // Persistence: save current state to localStorage
    function saveLocal() {
      try {
        const data = {
          walls: state.walls,
          rooms: state.rooms,
          doors: state.doors,
          windows: state.windows,
          items: state.items,
          pan: state.pan,
          zoom: state.zoom,
          scale: state.scale
        };
        localStorage.setItem('planificador-lite', JSON.stringify(data));
      } catch (err) {
        console.error('No se pudo guardar el proyecto:', err);
      }
    }

    // Load from localStorage if present
    function loadLocal() {
      try {
        const saved = localStorage.getItem('planificador-lite');
        if (saved) {
          const data = JSON.parse(saved);
          state.walls = data.walls || [];
          state.rooms = data.rooms || [];
          state.doors = data.doors || [];
          state.windows = data.windows || [];
          state.items = data.items || [];
          state.pan = data.pan || state.pan;
          state.zoom = data.zoom || state.zoom;
          state.scale = data.scale || state.scale;
          if (scaleInput) scaleInput.value = state.scale;
          if (snapCheckbox) snapCheckbox.checked = state.snap;
          if (gridToggle) gridToggle.checked = state.showGrid;
        }
      } catch (err) {
        console.warn('No se pudo cargar el proyecto guardado:', err);
      }
    }

    // Coordinate transforms
    function worldToScreen(p) {
      return {
        x: (p.x * state.scale * state.zoom) + state.pan.x,
        y: (p.y * state.scale * state.zoom) + state.pan.y
      };
    }
    function screenToWorld(p) {
      return {
        x: (p.x - state.pan.x) / (state.scale * state.zoom),
        y: (p.y - state.pan.y) / (state.scale * state.zoom)
      };
    }

    // Snap a world coordinate to the grid (0.1 m)
    function snapCoord(v) {
      return state.snap ? Math.round(v * 10) / 10 : v;
    }

    // Push current state to history
    function pushHist() {
      state.hist.push(cloneState());
      // Límite de historial para optimizar memoria
      if (state.hist.length > 50) {
        state.hist.shift();
      }
      state.fut = [];
      saveLocal();
    }

    // Undo last action
    function undo() {
      if (state.hist.length === 0) return;
      // Push current full state to future stack
      state.fut.push(cloneState());
      const prev = state.hist.pop();
      // Restore previous state
      state.walls = cloneWalls(prev.walls);
      state.rooms = prev.rooms.map(r => ({ id: r.id, corners: r.corners.map(p => ({ x: p.x, y: p.y })), area: r.area }));
      state.doors = prev.doors.map(d => ({ id: d.id, wallId: d.wallId, offset: d.offset, width: d.width, hingeLeft: d.hingeLeft }));
      state.windows = prev.windows.map(w => ({ id: w.id, wallId: w.wallId, offset: w.offset, width: w.width }));
      state.items = prev.items.map(i => ({ id: i.id, type: i.type, x: i.x, y: i.y, w: i.w, d: i.d, rot: i.rot }));
      state.pan = { x: prev.pan.x, y: prev.pan.y };
      state.zoom = prev.zoom;
      state.scale = prev.scale;
      state.selection = null;
      saveLocal();
      draw();
      updateInspector();
    }

    // Redo undone action
    function redo() {
      if (state.fut.length === 0) return;
      state.hist.push(cloneState());
      const next = state.fut.pop();
      state.walls = cloneWalls(next.walls);
      state.rooms = next.rooms.map(r => ({ id: r.id, corners: r.corners.map(p => ({ x: p.x, y: p.y })), area: r.area }));
      state.doors = next.doors.map(d => ({ id: d.id, wallId: d.wallId, offset: d.offset, width: d.width, hingeLeft: d.hingeLeft }));
      state.windows = next.windows.map(w => ({ id: w.id, wallId: w.wallId, offset: w.offset, width: w.width }));
      state.items = next.items.map(i => ({ id: i.id, type: i.type, x: i.x, y: i.y, w: i.w, d: i.d, rot: i.rot }));
      state.pan = { x: next.pan.x, y: next.pan.y };
      state.zoom = next.zoom;
      state.scale = next.scale;
      state.selection = null;
      saveLocal();
      draw();
      updateInspector();
    }

    // Update Inspector Panel content
    function updateInspector() {
      if (!inspectorContent) return;
      if (!state.selection) {
        inspectorContent.innerHTML = '<div class="muted">Seleccioná una pared u objeto.</div>';
        return;
      }
      
      const sel = state.selection;
      let html = '';
      
      if (sel.type === 'wall') {
        const w = state.walls.find(x => x.id === sel.id);
        if (w) {
          const dist = distance(w.a, w.b).toFixed(2);
          html = `
            <div style="color:#cdd6e3; font-weight:600; margin-bottom:5px;">Pared</div>
            <div class="muted" style="font-size:0.85rem;">Longitud: <span style="color:#e8ecf1">${dist} m</span></div>
            <div class="muted" style="font-size:0.8rem; margin-top:8px;">[SUPR] para borrar</div>
          `;
        }
      } else if (sel.type === 'door') {
        const d = state.doors.find(x => x.id === sel.id);
        if (d) {
           html = `
            <div style="color:#cdd6e3; font-weight:600; margin-bottom:5px;">Puerta</div>
            <div class="muted" style="font-size:0.85rem;">Ancho: ${d.width} m</div>
            <div class="muted" style="font-size:0.8rem; margin-top:8px;">[R] para invertir apertura</div>
            <div class="muted" style="font-size:0.8rem;">[SUPR] para borrar</div>
          `;
        }
      } else if (sel.type === 'window') {
        const w = state.windows.find(x => x.id === sel.id);
         if (w) {
           html = `
            <div style="color:#cdd6e3; font-weight:600; margin-bottom:5px;">Ventana</div>
            <div class="muted" style="font-size:0.85rem;">Ancho: ${w.width} m</div>
            <div class="muted" style="font-size:0.8rem; margin-top:8px;">[SUPR] para borrar</div>
          `;
        }
      } else if (sel.type === 'item') {
         const it = state.items.find(x => x.id === sel.id);
         if (it) {
           html = `
            <div style="color:#cdd6e3; font-weight:600; margin-bottom:5px;">Objeto: ${it.type}</div>
            <div class="muted" style="font-size:0.85rem;">Rotación: ${it.rot || 0}°</div>
            <div class="muted" style="font-size:0.8rem; margin-top:8px;">[R] para rotar</div>
            <div class="muted" style="font-size:0.8rem;">[SUPR] para borrar</div>
          `;
        }
      }
      inspectorContent.innerHTML = html;
    }

    // Helpers to set active tool button
    function setActiveTool(toolName) {
      state.tool = toolName;
      // List of all tool buttons; include room
      [btnSelect, btnPan, btnWall, btnRoom, btnDoor, btnWindow].forEach(btn => {
        if (!btn) return;
        const id = btn.id.replace('tool-', '');
        btn.classList.toggle('active', id === toolName);
      });
      // Update cursor based on tool
      if (toolName === 'pan') {
        canvas.style.cursor = 'grab';
      } else if (toolName === 'wall' || toolName === 'room' || toolName === 'door' || toolName === 'window' || toolName === 'item') {
        canvas.style.cursor = 'crosshair';
      } else {
        canvas.style.cursor = 'default';
      }
      drawHUD();
      // Clear inspector on tool change
      if (toolName !== 'select') {
         state.selection = null;
         updateInspector();
         draw();
      }
    }

    // Distance between two points
    function distance(a, b) {
      return Math.hypot(a.x - b.x, a.y - b.y);
    }

    // Distance from point p to segment ab in world coordinates
    function distancePointToSegment(p, a, b) {
      const px = p.x;
      const py = p.y;
      const ax = a.x;
      const ay = a.y;
      const bx = b.x;
      const by = b.y;
      const dx = bx - ax;
      const dy = by - ay;
      const lengthSq = dx * dx + dy * dy;
      if (lengthSq === 0) return Math.hypot(px - ax, py - ay);
      let t = ((px - ax) * dx + (py - ay) * dy) / lengthSq;
      t = Math.max(0, Math.min(1, t));
      const projX = ax + t * dx;
      const projY = ay + t * dy;
      return Math.hypot(px - projX, py - projY);
    }

    // Snap a world coordinate to the nearest existing wall endpoint if within threshold.
    // Returns a new point if a snap occurs, otherwise returns the original point.
    function snapToEndpoints(point) {
      let closest = null;
      let minDist = 0.15; // metres; if within 0.15 m, snap to existing endpoint
      for (const w of state.walls) {
        const da = distance(point, w.a);
        if (da < minDist) {
          minDist = da;
          closest = w.a;
        }
        const db = distance(point, w.b);
        if (db < minDist) {
          minDist = db;
          closest = w.b;
        }
      }
      if (closest) {
        return { x: closest.x, y: closest.y };
      }
      return point;
    }

    // Draw grid lines
    function drawGrid() {
      if (!state.showGrid) return;
      const w = canvas.width;
      const h = canvas.height;
      const spacing = state.scale * state.zoom * 0.5; // 0.5 m spacing
      const majorEvery = 4; // every 4 lines (2 m)
      const offX = state.pan.x % spacing;
      const offY = state.pan.y % spacing;
      ctx.save();
      ctx.lineWidth = 1;
      for (let x = offX; x < w; x += spacing) {
        const idx = Math.round((x - offX) / spacing);
        ctx.strokeStyle = idx % majorEvery === 0 ? 'rgba(41, 66, 86, 0.5)' : 'rgba(31, 43, 54, 0.5)';
        ctx.beginPath();
        ctx.moveTo(x + 0.5, 0);
        ctx.lineTo(x + 0.5, h);
        ctx.stroke();
      }
      for (let y = offY; y < h; y += spacing) {
        const idy = Math.round((y - offY) / spacing);
        ctx.strokeStyle = idy % majorEvery === 0 ? 'rgba(41, 66, 86, 0.5)' : 'rgba(31, 43, 54, 0.5)';
        ctx.beginPath();
        ctx.moveTo(0, y + 0.5);
        ctx.lineTo(w, y + 0.5);
        ctx.stroke();
      }
      ctx.restore();
    }

    // Draw all content
    let currentPointer = { x: 0, y: 0 }; // world coords for preview
    function draw() {
      // resize canvas to match wrapper dimensions * device pixel ratio
      const rect = wrap.getBoundingClientRect();
      const pixelRatio = state.dpr;
      const width = Math.floor(rect.width * pixelRatio);
      const height = Math.floor(rect.height * pixelRatio);
      if (canvas.width !== width || canvas.height !== height) {
        canvas.width = width;
        canvas.height = height;
      }
      ctx.save();
      ctx.scale(pixelRatio, pixelRatio);
      // Clear background (grid is drawn separately)
      ctx.clearRect(0, 0, rect.width, rect.height);
      // Draw grid
      drawGrid();
      // Draw walls
      ctx.lineWidth = 2;
      state.walls.forEach(w => {
        const a = worldToScreen(w.a);
        const b = worldToScreen(w.b);
        const isSelected = (state.selection && state.selection.type === 'wall' && state.selection.id === w.id);
        ctx.strokeStyle = isSelected ? '#5eead4' : '#6ee7ff';
        ctx.beginPath();
        ctx.moveTo(a.x / pixelRatio, a.y / pixelRatio);
        ctx.lineTo(b.x / pixelRatio, b.y / pixelRatio);
        ctx.stroke();
        // Draw length label at midpoint
        const midX = (a.x + b.x) * 0.5 / pixelRatio;
        const midY = (a.y + b.y) * 0.5 / pixelRatio;
        const dist = distance(w.a, w.b).toFixed(2);
        ctx.fillStyle = '#cdd6e3';
        ctx.font = '12px Inter, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(`${dist} m`, midX, midY - 6);
      });
      // Draw preview line if drawing a single wall
      if (state.drawing) {
        const a = worldToScreen(state.drawing.a);
        const b = worldToScreen(currentPointer);
        ctx.save();
        ctx.setLineDash([6, 6]);
        ctx.strokeStyle = '#93c5fd';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(a.x / pixelRatio, a.y / pixelRatio);
        ctx.lineTo(b.x / pixelRatio, b.y / pixelRatio);
        ctx.stroke();
        ctx.setLineDash([]);
        // Label for preview distance
        const dist = distance(state.drawing.a, currentPointer).toFixed(2);
        const midX = (a.x + b.x) * 0.5 / pixelRatio;
        const midY = (a.y + b.y) * 0.5 / pixelRatio;
        ctx.fillStyle = '#93c5fd';
        ctx.font = '12px Inter, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(`${dist} m`, midX, midY - 6);
        ctx.restore();
      }
      // Draw preview rectangle if drawing a room
      if (state.roomStart) {
        const s = state.roomStart;
        const e = currentPointer;
        // Snap preview to world coordinates; compute corners
        const x1 = s.x;
        const y1 = s.y;
        const x2 = e.x;
        const y2 = e.y;
        const corners = [
          { x: x1, y: y1 },
          { x: x2, y: y1 },
          { x: x2, y: y2 },
          { x: x1, y: y2 }
        ];
        ctx.save();
        ctx.setLineDash([6, 6]);
        ctx.strokeStyle = '#93c5fd';
        ctx.lineWidth = 2;
        ctx.beginPath();
        for (let i = 0; i < corners.length; i++) {
          const pA = worldToScreen(corners[i]);
          const pB = worldToScreen(corners[(i + 1) % corners.length]);
          if (i === 0) {
            ctx.moveTo(pA.x / pixelRatio, pA.y / pixelRatio);
          }
          ctx.lineTo(pB.x / pixelRatio, pB.y / pixelRatio);
        }
        ctx.stroke();
        ctx.setLineDash([]);
        // Draw width and height labels
        const width = Math.abs(x2 - x1).toFixed(2);
        const height = Math.abs(y2 - y1).toFixed(2);
        const midTop = worldToScreen({ x: (x1 + x2) * 0.5, y: y1 });
        const midRight = worldToScreen({ x: x2, y: (y1 + y2) * 0.5 });
        ctx.fillStyle = '#93c5fd';
        ctx.font = '12px Inter, sans-serif';
        ctx.textAlign = 'center';
        // width label on top edge
        ctx.fillText(`${width} m`, midTop.x / pixelRatio, midTop.y / pixelRatio - 6);
        // height label on right edge
        ctx.fillText(`${height} m`, midRight.x / pixelRatio + 30, midRight.y / pixelRatio);
        // Draw area label at center
        const areaVal = (Math.abs(x2 - x1) * Math.abs(y2 - y1)).toFixed(2);
        const centerPt = worldToScreen({ x: (x1 + x2) * 0.5, y: (y1 + y2) * 0.5 });
        ctx.fillText(`${areaVal} m²`, centerPt.x / pixelRatio, centerPt.y / pixelRatio + 6);
        ctx.restore();
      }
      // Draw stored rooms (area labels)
      state.rooms.forEach(r => {
        // compute center of the rectangle
        let cx = 0;
        let cy = 0;
        r.corners.forEach(pt => {
          cx += pt.x;
          cy += pt.y;
        });
        cx /= r.corners.length;
        cy /= r.corners.length;
        const sc = worldToScreen({ x: cx, y: cy });
        ctx.fillStyle = '#94a3b8';
        ctx.font = '13px Inter, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(`${r.area.toFixed(2)} m²`, sc.x / pixelRatio, sc.y / pixelRatio);
      });
      // Draw doors
      state.doors.forEach(d => {
        const wall = state.walls.find(w => w.id === d.wallId);
        if (!wall) return;
        const wallVec = { x: wall.b.x - wall.a.x, y: wall.b.y - wall.a.y };
        const wallLen = distance(wall.a, wall.b);
        const tStart = d.offset;
        const tEnd = d.offset + d.width / wallLen;
        const startPt = { x: wall.a.x + wallVec.x * tStart, y: wall.a.y + wallVec.y * tStart };
        const endPt   = { x: wall.a.x + wallVec.x * tEnd, y: wall.a.y + wallVec.y * tEnd };
        const pS = worldToScreen(startPt);
        const pE = worldToScreen(endPt);
        const color = (state.selection && state.selection.type === 'door' && state.selection.id === d.id) ? '#5eead4' : '#fbbf24';
        ctx.strokeStyle = color;
        ctx.lineWidth = 3;
        ctx.beginPath();
        ctx.moveTo(pS.x / pixelRatio, pS.y / pixelRatio);
        ctx.lineTo(pE.x / pixelRatio, pE.y / pixelRatio);
        ctx.stroke();
        // Draw hinge arc
        // pivot at one end based on hingeLeft
        const pivot = d.hingeLeft ? startPt : endPt;
        const pivotScr = worldToScreen(pivot);
        // angle of wall direction
        const ang = Math.atan2(wallVec.y, wallVec.x);
        const radiusPx = (d.width * state.scale * state.zoom) / pixelRatio;
        // start and end angles for arc
        // if hingeLeft, draw arc outside to left (counter-clockwise); else right (clockwise)
        const startAngle = ang + (d.hingeLeft ? -Math.PI / 2 : Math.PI / 2);
        const endAngle   = startAngle + (d.hingeLeft ? -Math.PI / 2 : Math.PI / 2);
        ctx.beginPath();
        ctx.strokeStyle = color;
        ctx.lineWidth = 1.5;
        ctx.arc(pivotScr.x / pixelRatio, pivotScr.y / pixelRatio, radiusPx, startAngle, endAngle, d.hingeLeft);
        ctx.stroke();
      });
      // Draw windows
      state.windows.forEach(wdw => {
        const wall = state.walls.find(w => w.id === wdw.wallId);
        if (!wall) return;
        const wallVec = { x: wall.b.x - wall.a.x, y: wall.b.y - wall.a.y };
        const wallLen = distance(wall.a, wall.b);
        const tStart = wdw.offset;
        const tEnd   = wdw.offset + wdw.width / wallLen;
        const startPt = { x: wall.a.x + wallVec.x * tStart, y: wall.a.y + wallVec.y * tStart };
        const endPt   = { x: wall.a.x + wallVec.x * tEnd, y: wall.a.y + wallVec.y * tEnd };
        const pS = worldToScreen(startPt);
        const pE = worldToScreen(endPt);
        const color = (state.selection && state.selection.type === 'window' && state.selection.id === wdw.id) ? '#5eead4' : '#f87171';
        ctx.strokeStyle = color;
        ctx.lineWidth = 3;
        ctx.beginPath();
        ctx.moveTo(pS.x / pixelRatio, pS.y / pixelRatio);
        ctx.lineTo(pE.x / pixelRatio, pE.y / pixelRatio);
        ctx.stroke();
        // cross line to indicate window opening perpendicular to wall
        const mid = { x: (startPt.x + endPt.x) / 2, y: (startPt.y + endPt.y) / 2 };
        // perpendicular unit vector
        const perpX = -wallVec.y / wallLen;
        const perpY = wallVec.x / wallLen;
        const lineLen = 0.4; // 0.4 m window depth indicator
        const midStart = { x: mid.x - perpX * lineLen / 2, y: mid.y - perpY * lineLen / 2 };
        const midEnd   = { x: mid.x + perpX * lineLen / 2, y: mid.y + perpY * lineLen / 2 };
        const pM0 = worldToScreen(midStart);
        const pM1 = worldToScreen(midEnd);
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(pM0.x / pixelRatio, pM0.y / pixelRatio);
        ctx.lineTo(pM1.x / pixelRatio, pM1.y / pixelRatio);
        ctx.stroke();
      });
      // Draw items (furniture, arrow)
      state.items.forEach(it => {
        const color = (state.selection && state.selection.type === 'item' && state.selection.id === it.id) ? '#5eead4' : '#cba5ff';
        const angle = (it.rot || 0) * Math.PI / 180;
        const hw = it.w / 2;
        const hd = it.d / 2;
        // Define points in local coordinates based on type
        let shape = [];
        if (it.type === 'flecha') {
          // arrow shape pointing to positive x-axis in local coords
          shape = [
            { x: -hw, y: -hd * 0.6 },
            { x: hw, y: 0 },
            { x: -hw, y: hd * 0.6 }
          ];
        } else {
          // rectangle shape for other items
          shape = [
            { x: -hw, y: -hd },
            { x: hw, y: -hd },
            { x: hw, y: hd },
            { x: -hw, y: hd }
          ];
        }
        // Compute rotated world points
        const worldPts = shape.map(pt => {
          const rx = pt.x * Math.cos(angle) - pt.y * Math.sin(angle);
          const ry = pt.x * Math.sin(angle) + pt.y * Math.cos(angle);
          return { x: it.x + rx, y: it.y + ry };
        });
        // Draw filled shape
        ctx.fillStyle = color;
        ctx.beginPath();
        worldPts.forEach((pt, idx) => {
          const p = worldToScreen(pt);
          if (idx === 0) {
            ctx.moveTo(p.x / pixelRatio, p.y / pixelRatio);
          } else {
            ctx.lineTo(p.x / pixelRatio, p.y / pixelRatio);
          }
        });
        if (worldPts.length > 0) {
          ctx.closePath();
        }
        ctx.fill();
      });
      // Restore context
      ctx.restore();
      drawHUD();
    }

    // Draw heads-up display with tool and zoom info
    function drawHUD() {
      if (!hudStatus) return;
      let toolName;
      if (state.tool === 'select') {
        toolName = 'Seleccionar';
      } else if (state.tool === 'pan') {
        toolName = 'Mover';
      } else if (state.tool === 'wall') {
        toolName = 'Pared';
      } else if (state.tool === 'room') {
        toolName = 'Habitación';
      } else if (state.tool === 'door') {
        toolName = 'Puerta';
      } else if (state.tool === 'window') {
        toolName = 'Ventana';
      } else if (state.tool === 'item') {
        toolName = 'Objeto';
      } else {
        toolName = state.tool;
      }
      hudStatus.textContent = `Herramienta: ${toolName} | Zoom: ${state.zoom.toFixed(2)}× | Escala: ${state.scale.toFixed(1)} px/m`;
    }

    // Handle pointer down
    let isPanning = false;
    let panStart = { x: 0, y: 0 };
    let panOffsetStart = { x: 0, y: 0 };
    canvas.addEventListener('mousedown', (e) => {
      const rect = canvas.getBoundingClientRect();
      const px = (e.clientX - rect.left) * state.dpr;
      const py = (e.clientY - rect.top) * state.dpr;
      const world = screenToWorld({ x: px, y: py });
      if (state.tool === 'room') {
        // Drawing a rectangular room
        const startPt = snapToEndpoints({ x: snapCoord(world.x), y: snapCoord(world.y) });
        if (!state.roomStart) {
          // first corner
          state.roomStart = startPt;
        } else {
          // second corner; build four walls
          const endPt = snapToEndpoints({ x: snapCoord(world.x), y: snapCoord(world.y) });
          if (Math.abs(endPt.x - state.roomStart.x) > 0 && Math.abs(endPt.y - state.roomStart.y) > 0) {
            const x1 = state.roomStart.x;
            const y1 = state.roomStart.y;
            const x2 = endPt.x;
            const y2 = endPt.y;
            // generate corners in order
            const p1 = { x: x1, y: y1 };
            const p2 = { x: x2, y: y1 };
            const p3 = { x: x2, y: y2 };
            const p4 = { x: x1, y: y2 };
            const newWalls = [
              { id: Math.random().toString(36).slice(2, 9), a: p1, b: p2 },
              { id: Math.random().toString(36).slice(2, 9), a: p2, b: p3 },
              { id: Math.random().toString(36).slice(2, 9), a: p3, b: p4 },
              { id: Math.random().toString(36).slice(2, 9), a: p4, b: p1 },
            ];
            state.walls.push(...newWalls);
            // also record the room for area labeling
            const corners = [p1, p2, p3, p4];
            const area = Math.abs((x2 - x1) * (y2 - y1));
            state.rooms.push({ id: Math.random().toString(36).slice(2, 9), corners, area });
            pushHist();
          }
          // reset
          state.roomStart = null;
        }
      } else if (state.tool === 'wall') {
        if (!state.drawing) {
          // Start drawing a new wall
          // Snap starting point to existing endpoints
          const start = snapToEndpoints({ x: snapCoord(world.x), y: snapCoord(world.y) });
          state.drawing = { a: start };
        } else {
          // Finish current wall
          let end = { x: snapCoord(world.x), y: snapCoord(world.y) };
          // snap end to existing endpoints
          end = snapToEndpoints(end);
          if (distance(state.drawing.a, end) > 0) {
            const newWall = { id: Math.random().toString(36).slice(2, 9), a: state.drawing.a, b: end };
            state.walls.push(newWall);
            pushHist();
            state.drawing = { a: end };
          }
        }
      } else if (state.tool === 'pan') {
        isPanning = true;
        panStart = { x: e.clientX, y: e.clientY };
        panOffsetStart = { x: state.pan.x, y: state.pan.y };
        canvas.style.cursor = 'grabbing';
      } else if (state.tool === 'select') {
        // Perform hit test on walls
        let found = null;
        // Check items first (highest priority)
        for (const item of state.items) {
          // Convert world point to item's local coordinates based on rotation
          const angle = (item.rot || 0) * Math.PI / 180;
          const dx = world.x - item.x;
          const dy = world.y - item.y;
          // rotation: localX = dx*cos + dy*sin; localY = -dx*sin + dy*cos
          const localX = dx * Math.cos(angle) + dy * Math.sin(angle);
          const localY = -dx * Math.sin(angle) + dy * Math.cos(angle);
          if (Math.abs(localX) <= (item.w / 2) && Math.abs(localY) <= (item.d / 2)) {
            found = { type: 'item', id: item.id };
            break;
          }
        }
        if (!found) {
          // Check doors
          const thresh = 0.15;
          for (const d of state.doors) {
            const wall = state.walls.find(w => w.id === d.wallId);
            if (!wall) continue;
            const wallLen = distance(wall.a, wall.b);
            const tStart = d.offset;
            const tEnd = d.offset + (d.width / wallLen);
            // compute projection of point onto wall
            const dx = wall.b.x - wall.a.x;
            const dy = wall.b.y - wall.a.y;
            const lengthSq = dx * dx + dy * dy;
            if (lengthSq === 0) continue;
            let t = ((world.x - wall.a.x) * dx + (world.y - wall.a.y) * dy) / lengthSq;
            if (t >= tStart - 0.05 && t <= tEnd + 0.05) {
              const projX = wall.a.x + t * dx;
              const projY = wall.a.y + t * dy;
              const dist = Math.hypot(world.x - projX, world.y - projY);
              if (dist < thresh) {
                found = { type: 'door', id: d.id };
                break;
              }
            }
          }
        }
        if (!found) {
          // Check windows
          const thresh = 0.15;
          for (const wdw of state.windows) {
            const wall = state.walls.find(w => w.id === wdw.wallId);
            if (!wall) continue;
            const wallLen = distance(wall.a, wall.b);
            const tStart = wdw.offset;
            const tEnd = wdw.offset + (wdw.width / wallLen);
            const dx = wall.b.x - wall.a.x;
            const dy = wall.b.y - wall.a.y;
            const lengthSq = dx * dx + dy * dy;
            if (lengthSq === 0) continue;
            let t = ((world.x - wall.a.x) * dx + (world.y - wall.a.y) * dy) / lengthSq;
            if (t >= tStart - 0.05 && t <= tEnd + 0.05) {
              const projX = wall.a.x + t * dx;
              const projY = wall.a.y + t * dy;
              const dist = Math.hypot(world.x - projX, world.y - projY);
              if (dist < thresh) {
                found = { type: 'window', id: wdw.id };
                break;
              }
            }
          }
        }
        if (!found) {
          // Check walls
          let closestWall = null;
          let minDistWall = 0.1;
          for (const w of state.walls) {
            const d = distancePointToSegment(world, w.a, w.b);
            if (d < minDistWall) {
              closestWall = w;
              minDistWall = d;
            }
          }
          if (closestWall) {
            found = { type: 'wall', id: closestWall.id };
          }
        }
        state.selection = found;
        updateInspector();
      }
      else if (state.tool === 'door') {
        // Place door on nearest wall
        const DOOR_WIDTH = 0.8; // metres
        let bestWall = null;
        let bestT = 0;
        let bestDist = 0.15;
        for (const w of state.walls) {
          // compute projection factor t along wall
          const dx = w.b.x - w.a.x;
          const dy = w.b.y - w.a.y;
          const lengthSq = dx * dx + dy * dy;
          if (lengthSq === 0) continue;
          let t = ((world.x - w.a.x) * dx + (world.y - w.a.y) * dy) / lengthSq;
          t = Math.max(0, Math.min(1, t));
          const projX = w.a.x + t * dx;
          const projY = w.a.y + t * dy;
          const dist = Math.hypot(world.x - projX, world.y - projY);
          if (dist < bestDist) {
            bestDist = dist;
            bestWall = w;
            bestT = t;
          }
        }
        if (bestWall) {
          const wallLen = distance(bestWall.a, bestWall.b);
          const halfW = DOOR_WIDTH / 2;
          const offset = Math.max(0, Math.min(1 - DOOR_WIDTH / wallLen, bestT - halfW / wallLen));
          // Determine hinge side: use cross product to decide left vs right
          const cross = (bestWall.b.x - bestWall.a.x) * (world.y - bestWall.a.y) - (bestWall.b.y - bestWall.a.y) * (world.x - bestWall.a.x);
          const hingeLeft = cross < 0;
          state.doors.push({ id: Math.random().toString(36).slice(2, 9), wallId: bestWall.id, offset, width: DOOR_WIDTH, hingeLeft });
          pushHist();
          draw();
        }
      }
      else if (state.tool === 'window') {
        const WINDOW_WIDTH = 1.2; // metres
        let bestWall = null;
        let bestT = 0;
        let bestDist = 0.15;
        for (const w of state.walls) {
          const dx = w.b.x - w.a.x;
          const dy = w.b.y - w.a.y;
          const lengthSq = dx * dx + dy * dy;
          if (lengthSq === 0) continue;
          let t = ((world.x - w.a.x) * dx + (world.y - w.a.y) * dy) / lengthSq;
          t = Math.max(0, Math.min(1, t));
          const projX = w.a.x + t * dx;
          const projY = w.a.y + t * dy;
          const dist = Math.hypot(world.x - projX, world.y - projY);
          if (dist < bestDist) {
            bestDist = dist;
            bestWall = w;
            bestT = t;
          }
        }
        if (bestWall) {
          const wallLen = distance(bestWall.a, bestWall.b);
          const halfW = WINDOW_WIDTH / 2;
          const offset = Math.max(0, Math.min(1 - WINDOW_WIDTH / wallLen, bestT - halfW / wallLen));
          state.windows.push({ id: Math.random().toString(36).slice(2, 9), wallId: bestWall.id, offset, width: WINDOW_WIDTH });
          pushHist();
          draw();
        }
      }
      else if (state.tool === 'item') {
        // place furniture or arrow
        if (state.currentItem) {
          const ix = snapCoord(world.x);
          const iy = snapCoord(world.y);
          const { type, w, d, rot } = state.currentItem;
          state.items.push({ id: Math.random().toString(36).slice(2, 9), type, x: ix, y: iy, w, d, rot });
          pushHist();
          draw();
        }
      }
      draw();
    });

    // Handle pointer move
    canvas.addEventListener('mousemove', (e) => {
      const rect = canvas.getBoundingClientRect();
      const px = (e.clientX - rect.left) * state.dpr;
      const py = (e.clientY - rect.top) * state.dpr;
      const world = screenToWorld({ x: px, y: py });
      currentPointer = { x: snapCoord(world.x), y: snapCoord(world.y) };
      if (isPanning) {
        const dx = e.clientX - panStart.x;
        const dy = e.clientY - panStart.y;
        state.pan.x = panOffsetStart.x + dx;
        state.pan.y = panOffsetStart.y + dy;
        draw();
      } else if (state.drawing) {
        draw();
      } else if (state.roomStart) {
        // update preview for room drawing
        draw();
      }
    });

    // Handle pointer up
    canvas.addEventListener('mouseup', () => {
      if (isPanning) {
        isPanning = false;
        canvas.style.cursor = 'grab';
      }
    });
    canvas.addEventListener('mouseleave', () => {
      if (isPanning) {
        isPanning = false;
        canvas.style.cursor = 'grab';
      }
    });

    // Handle wheel for zoom
    canvas.addEventListener('wheel', (e) => {
      e.preventDefault();
      const delta = -e.deltaY;
      const zoomFactor = delta > 0 ? 1.1 : 0.9;
      const oldZoom = state.zoom;
      let newZoom = state.zoom * zoomFactor;
      // Clamp zoom
      newZoom = Math.max(0.25, Math.min(4, newZoom));
      const rect = canvas.getBoundingClientRect();
      const px = (e.clientX - rect.left) * state.dpr;
      const py = (e.clientY - rect.top) * state.dpr;
      const wx = (px - state.pan.x) / (state.scale * oldZoom);
      const wy = (py - state.pan.y) / (state.scale * oldZoom);
      state.zoom = newZoom;
      // Adjust pan to zoom at cursor
      state.pan.x = px - wx * state.scale * newZoom;
      state.pan.y = py - wy * state.scale * newZoom;
      draw();
    }, { passive: false });

    // Keyboard shortcuts for undo/redo and delete
    document.addEventListener('keydown', (e) => {
      if (e.ctrlKey && !e.shiftKey && e.key.toLowerCase() === 'z') {
        e.preventDefault();
        undo();
      } else if ((e.ctrlKey && e.key.toLowerCase() === 'y') || (e.ctrlKey && e.shiftKey && e.key.toLowerCase() === 'z')) {
        e.preventDefault();
        redo();
      } else if (e.key === 'Delete' || e.key === 'Backspace') {
        if (state.selection) {
          pushHist();
          const sel = state.selection;
          if (sel.type === 'wall') {
            state.walls = state.walls.filter(w => w.id !== sel.id);
          } else if (sel.type === 'door') {
            state.doors = state.doors.filter(d => d.id !== sel.id);
          } else if (sel.type === 'window') {
            state.windows = state.windows.filter(w => w.id !== sel.id);
          } else if (sel.type === 'item') {
            state.items = state.items.filter(i => i.id !== sel.id);
          }
          state.selection = null;
          saveLocal();
          draw();
          updateInspector();
        }
      } else if (e.key.toLowerCase() === 'r') {
        // Rotate items or toggle door hinge when selected
        if (state.selection) {
          const sel = state.selection;
          if (sel.type === 'door') {
            const door = state.doors.find(d => d.id === sel.id);
            if (door) {
              pushHist();
              door.hingeLeft = !door.hingeLeft;
              saveLocal();
              draw();
              updateInspector();
            }
          } else if (sel.type === 'item') {
            const item = state.items.find(i => i.id === sel.id);
            if (item) {
              pushHist();
              item.rot = ((item.rot || 0) + 90) % 360;
              saveLocal();
              draw();
              updateInspector();
            }
          }
        }
      } else if (e.key === 'Escape') {
        // Cancel current drawing (wall or room)
        if (state.drawing || state.roomStart) {
          state.drawing = null;
          state.roomStart = null;
          draw();
        }
      }
    });

    // UI control handlers
    if (btnSelect) btnSelect.addEventListener('click', () => setActiveTool('select'));
    if (btnPan)    btnPan.addEventListener('click', () => setActiveTool('pan'));
    if (btnWall)   btnWall.addEventListener('click', () => setActiveTool('wall'));
    if (btnRoom)   btnRoom.addEventListener('click', () => setActiveTool('room'));
    if (btnDoor)   btnDoor.addEventListener('click', () => setActiveTool('door'));
    if (btnWindow) btnWindow.addEventListener('click', () => setActiveTool('window'));
    if (btnUndo)   btnUndo.addEventListener('click', () => undo());
    if (btnRedo)   btnRedo.addEventListener('click', () => redo());
    if (btnErase)  btnErase.addEventListener('click', () => {
      if (state.selection) {
        pushHist();
        const sel = state.selection;
        if (sel.type === 'wall') {
          state.walls = state.walls.filter(w => w.id !== sel.id);
        } else if (sel.type === 'door') {
          state.doors = state.doors.filter(d => d.id !== sel.id);
        } else if (sel.type === 'window') {
          state.windows = state.windows.filter(w => w.id !== sel.id);
        } else if (sel.type === 'item') {
          state.items = state.items.filter(i => i.id !== sel.id);
        }
        state.selection = null;
        saveLocal();
        draw();
        updateInspector();
      }
    });
    if (btnReset)  btnReset.addEventListener('click', () => {
      pushHist();
      state.walls = [];
      state.rooms = [];
      state.doors = [];
      state.windows = [];
      state.items = [];
      state.selection = null;
      state.drawing = null;
      state.roomStart = null;
      state.pan = { x: 80, y: 80 };
      state.zoom = 1;
      state.scale = parseFloat(scaleInput?.value) || 40;
      saveLocal();
      draw();
      updateInspector();
    });
    if (scaleInput) scaleInput.addEventListener('change', () => {
      const val = parseFloat(scaleInput.value);
      if (!isNaN(val) && val > 0) {
        state.scale = val;
        saveLocal();
        draw();
      }
    });
    if (snapCheckbox) snapCheckbox.addEventListener('change', () => {
      state.snap = snapCheckbox.checked;
    });
    if (gridToggle) gridToggle.addEventListener('change', () => {
      state.showGrid = gridToggle.checked;
      draw();
    });

    // Setup library item click handlers
    const libItems = document.querySelectorAll('.lib-item');
    libItems.forEach(itemEl => {
      itemEl.addEventListener('click', () => {
        // Remove active from all library items
        libItems.forEach(el => el.classList.remove('active'));
        // Mark this one as active
        itemEl.classList.add('active');
        // Store current item for placement
        const type = itemEl.dataset.type;
        const w = parseFloat(itemEl.dataset.w || '0');
        const d = parseFloat(itemEl.dataset.d || '0');
        state.currentItem = { type, w, d, rot: 0 };
        setActiveTool('item');
      });
    });

    // Initialize
    loadLocal();
    setActiveTool(state.tool);
    draw();
  });
})();