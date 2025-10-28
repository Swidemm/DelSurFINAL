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

    // Toolbar buttons
    const btnSelect = document.getElementById('tool-select');
    const btnPan    = document.getElementById('tool-pan');
    const btnWall   = document.getElementById('tool-wall');
    const btnRoom   = document.getElementById('tool-room');
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
      walls: [],
      selection: null,
      drawing: null,
      // first corner when drawing a room; null if not active
      roomStart: null,
      hist: [],
      fut: []
    };

    // Helper: deep clone walls for history
    function cloneWalls(walls) {
      return walls.map(w => ({ id: w.id, a: { x: w.a.x, y: w.a.y }, b: { x: w.b.x, y: w.b.y } }));
    }

    // Persistence: save current state to localStorage
    function saveLocal() {
      try {
        const data = {
          walls: state.walls,
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

    // Push current walls to history
    function pushHist() {
      state.hist.push(cloneWalls(state.walls));
      state.fut = [];
      saveLocal();
    }

    // Undo last action
    function undo() {
      if (state.hist.length === 0) return;
      state.fut.push(cloneWalls(state.walls));
      const prev = state.hist.pop();
      state.walls = cloneWalls(prev);
      state.selection = null;
      saveLocal();
      draw();
    }

    // Redo undone action
    function redo() {
      if (state.fut.length === 0) return;
      state.hist.push(cloneWalls(state.walls));
      const next = state.fut.pop();
      state.walls = cloneWalls(next);
      state.selection = null;
      saveLocal();
      draw();
    }

    // Helpers to set active tool button
    function setActiveTool(toolName) {
      state.tool = toolName;
      // List of all tool buttons; include room
      [btnSelect, btnPan, btnWall, btnRoom].forEach(btn => {
        if (!btn) return;
        const id = btn.id.replace('tool-', '');
        btn.classList.toggle('active', id === toolName);
      });
      // Update cursor based on tool
      if (toolName === 'pan') {
        canvas.style.cursor = 'grab';
      } else if (toolName === 'wall' || toolName === 'room') {
        canvas.style.cursor = 'crosshair';
      } else {
        canvas.style.cursor = 'default';
      }
      drawHUD();
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
        ctx.strokeStyle = (state.selection && state.selection.id === w.id) ? '#5eead4' : '#6ee7ff';
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
        ctx.restore();
      }
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
        let closest = null;
        let minDist = 0.1; // selection tolerance in m
        for (const w of state.walls) {
          const d = distancePointToSegment(world, w.a, w.b);
          if (d < minDist) {
            closest = w;
            minDist = d;
          }
        }
        state.selection = closest;
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
          state.hist.push(cloneWalls(state.walls));
          state.walls = state.walls.filter(w => w.id !== state.selection.id);
          state.selection = null;
          saveLocal();
          draw();
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
    if (btnUndo)   btnUndo.addEventListener('click', () => undo());
    if (btnRedo)   btnRedo.addEventListener('click', () => redo());
    if (btnErase)  btnErase.addEventListener('click', () => {
      if (state.selection) {
        state.hist.push(cloneWalls(state.walls));
        state.walls = state.walls.filter(w => w.id !== state.selection.id);
        state.selection = null;
        saveLocal();
        draw();
      }
    });
    if (btnReset)  btnReset.addEventListener('click', () => {
      state.hist.push(cloneWalls(state.walls));
      state.walls = [];
      state.selection = null;
      state.drawing = null;
      state.pan = { x: 80, y: 80 };
      state.zoom = 1;
      state.scale = parseFloat(scaleInput?.value) || 40;
      saveLocal();
      draw();
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

    // Initialize
    loadLocal();
    setActiveTool(state.tool);
    draw();
  });
})();