/**
 * ArtsyCrate — Unified Shape Renderer
 * ─────────────────────────────────────────────────────────────────────────────
 * Single source of truth for all bead/figure canvas drawing.
 * Used by:
 *   • admin/elements/beads.blade.php    (list thumbnails)
 *   • admin/elements/figures.blade.php  (list thumbnails)
 *   • admin/elements/_form.blade.php    (live preview)
 *
 * Include ONCE in each page, before any inline script that calls drawShape().
 *
 * Usage:
 *   ArtshapeRenderer.draw(canvas, { shape, color, detail, small });
 *   ArtshapeRenderer.drawToCanvas(ctx, shape, R, color, detail);
 * ─────────────────────────────────────────────────────────────────────────────
 */
window.ArtshapeRenderer = (() => {

  /* ── Colour helpers ─────────────────────────────────────────────────────── */
  function hexToRgb(hex) {
    const r = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return r ? [parseInt(r[1],16), parseInt(r[2],16), parseInt(r[3],16)] : [200,200,200];
  }
  function lighten(hex, amt) {
    const [r,g,b] = hexToRgb(hex);
    return `rgb(${Math.min(255,r+amt)},${Math.min(255,g+amt)},${Math.min(255,b+amt)})`;
  }
  function darken(hex, amt) {
    const [r,g,b] = hexToRgb(hex);
    return `rgb(${Math.max(0,r-amt)},${Math.max(0,g-amt)},${Math.max(0,b-amt)})`;
  }
  function hexAlpha(hex, a) {
    const [r,g,b] = hexToRgb(hex);
    return `rgba(${r},${g},${b},${a})`;
  }

  /* ── roundRect polyfill ─────────────────────────────────────────────────── */
  function roundRect(ctx, x, y, w, h, r) {
    ctx.beginPath();
    ctx.moveTo(x+r, y);
    ctx.lineTo(x+w-r, y); ctx.quadraticCurveTo(x+w, y, x+w, y+r);
    ctx.lineTo(x+w, y+h-r); ctx.quadraticCurveTo(x+w, y+h, x+w-r, y+h);
    ctx.lineTo(x+r, y+h); ctx.quadraticCurveTo(x, y+h, x, y+h-r);
    ctx.lineTo(x, y+r); ctx.quadraticCurveTo(x, y, x+r, y);
    ctx.closePath();
  }

  /* ── Cube / Figure shapes ───────────────────────────────────────────────── */
  function drawCube(ctx, shape, R, color, detail) {
    const s = R * 1.75;

    // Base face
    ctx.fillStyle = color;
    ctx.beginPath(); roundRect(ctx, -s/2, -s/2, s, s, s*0.18); ctx.fill();

    // Top highlight
    ctx.fillStyle = 'rgba(255,255,255,.22)';
    ctx.beginPath(); roundRect(ctx, -s/2+2, -s/2+2, s-4, s*.40, s*0.12); ctx.fill();

    // Bottom shadow
    ctx.fillStyle = 'rgba(0,0,0,.10)';
    ctx.beginPath(); roundRect(ctx, -s/2+2, s/2-s*.22, s-4, s*.20, s*0.10); ctx.fill();

    if (shape === 'cube') return;

    ctx.fillStyle   = detail;
    ctx.strokeStyle = detail;

    if (shape === 'cube-heart') {
      const hr = R * .50;
      ctx.beginPath();
      ctx.moveTo(0, hr*.3);
      ctx.bezierCurveTo( hr, -hr*1.2,  hr*2.2, hr*.4, 0, hr);
      ctx.bezierCurveTo(-hr*2.2, hr*.4, -hr, -hr*1.2, 0, hr*.3);
      ctx.fill();

    } else if (shape === 'cube-star') {
      const sr = R * .52;
      ctx.beginPath();
      for (let i = 0; i < 10; i++) {
        const r = i%2===0 ? sr : sr*.42;
        ctx.lineTo(Math.cos(i*Math.PI/5 - Math.PI/2)*r, Math.sin(i*Math.PI/5 - Math.PI/2)*r);
      }
      ctx.closePath(); ctx.fill();

    } else if (shape === 'cube-checker') {
      ctx.save();
      ctx.beginPath(); roundRect(ctx, -s/2, -s/2, s, s, s*.18); ctx.clip();
      const cs = s/4;
      for (let row = 0; row < 4; row++)
        for (let col = 0; col < 4; col++)
          if ((row+col)%2 === 0)
            ctx.fillRect(-s/2+col*cs, -s/2+row*cs, cs, cs);
      ctx.restore();

    } else if (shape === 'cube-smile') {
      ctx.beginPath(); ctx.arc(-R*.32, -R*.18, R*.11, 0, Math.PI*2); ctx.fill();
      ctx.beginPath(); ctx.arc( R*.32, -R*.18, R*.11, 0, Math.PI*2); ctx.fill();
      ctx.lineWidth = R*.13; ctx.lineCap = 'round';
      ctx.beginPath(); ctx.arc(0, R*.10, R*.34, 0.22, Math.PI-0.22); ctx.stroke();

    } else {
      // Dice dots
      const diceMap = {
        'cube-dice1': [[0,0]],
        'cube-dice2': [[-1,1],[1,-1]],
        'cube-dice3': [[-1,1],[0,0],[1,-1]],
        'cube-dice4': [[-1,-1],[1,-1],[-1,1],[1,1]],
        'cube-dice5': [[-1,-1],[1,-1],[0,0],[-1,1],[1,1]],
        'cube-dice6': [[-1,-1],[1,-1],[-1,0],[1,0],[-1,1],[1,1]],
      };
      const dots = diceMap[shape] || [];
      const h = (s/2)*.35, dr = R*.15;
      dots.forEach(([dx,dy]) => {
        ctx.beginPath(); ctx.arc(dx*h, dy*h, dr, 0, Math.PI*2); ctx.fill();
      });
    }
  }

  /* ── Bead shapes ────────────────────────────────────────────────────────── */
  function drawBead(ctx, shape, R, color, detail) {
    ctx.fillStyle = color;

    switch(shape) {

      case 'round':
      default: {
        ctx.beginPath(); ctx.arc(0, 0, R, 0, Math.PI*2); ctx.fill();
        // subtle inner shine
        const shine = ctx.createRadialGradient(-R*.3, -R*.3, R*.05, 0, 0, R);
        shine.addColorStop(0, 'rgba(255,255,255,.35)');
        shine.addColorStop(.5, 'rgba(255,255,255,0)');
        ctx.fillStyle = shine;
        ctx.beginPath(); ctx.arc(0, 0, R, 0, Math.PI*2); ctx.fill();
        break;
      }

      case 'pearl': {
        // Pearl gradient sheen
        const grad = ctx.createRadialGradient(-R*.28, -R*.28, R*.05, 0, 0, R);
        grad.addColorStop(0,   lighten(color, 52));
        grad.addColorStop(.4,  lighten(color, 18));
        grad.addColorStop(.75, color);
        grad.addColorStop(1,   darken(color, 22));
        ctx.fillStyle = grad;
        ctx.beginPath(); ctx.arc(0, 0, R, 0, Math.PI*2); ctx.fill();
        // Tiny specular dot
        ctx.fillStyle = 'rgba(255,255,255,.65)';
        ctx.beginPath(); ctx.arc(-R*.3, -R*.3, R*.16, 0, Math.PI*2); ctx.fill();
        break;
      }

      case 'ellipse': {
        ctx.beginPath();
        ctx.ellipse(0, 0, R*1.55, R*0.78, 0, 0, Math.PI*2);
        ctx.fill();
        const eShine = ctx.createRadialGradient(-R*.4, -R*.2, 0, 0, 0, R*1.55);
        eShine.addColorStop(0, 'rgba(255,255,255,.28)');
        eShine.addColorStop(.5, 'rgba(255,255,255,0)');
        ctx.fillStyle = eShine;
        ctx.beginPath(); ctx.ellipse(0, 0, R*1.55, R*0.78, 0, 0, Math.PI*2); ctx.fill();
        break;
      }

      case 'tube': {
        ctx.beginPath();
        ctx.ellipse(0, 0, R*0.7, R*1.58, 0, 0, Math.PI*2);
        ctx.fill();
        ctx.fillStyle = lighten(color, 28);
        ctx.beginPath();
        ctx.ellipse(-R*.1, -R*.5, R*.2, R*.6, 0, 0, Math.PI*2);
        ctx.fill();
        break;
      }

      case 'faceted': {
        // Draw hexagon with gradient facets
        const pts = [];
        for (let i = 0; i < 6; i++) pts.push([Math.cos(i*Math.PI/3)*R, Math.sin(i*Math.PI/3)*R]);
        ctx.beginPath();
        pts.forEach(([x,y],i) => i===0 ? ctx.moveTo(x,y) : ctx.lineTo(x,y));
        ctx.closePath(); ctx.fill();
        // Facet lines for depth
        ctx.save();
        ctx.strokeStyle = darken(color, 16);
        ctx.lineWidth = 0.8;
        ctx.globalAlpha = .5;
        for (let i = 0; i < 6; i++) {
          ctx.beginPath(); ctx.moveTo(0,0);
          ctx.lineTo(pts[i][0], pts[i][1]); ctx.stroke();
        }
        ctx.globalAlpha = 1;
        // Top facet shine
        ctx.fillStyle = 'rgba(255,255,255,.22)';
        ctx.beginPath();
        ctx.moveTo(pts[5][0], pts[5][1]);
        ctx.lineTo(pts[0][0], pts[0][1]);
        ctx.lineTo(0, 0); ctx.closePath(); ctx.fill();
        ctx.restore();
        break;
      }

      case 'heart': {
        ctx.beginPath();
        ctx.moveTo(0, R*0.3);
        ctx.bezierCurveTo( R, -R*1.2,  R*2.2, R*0.4, 0, R);
        ctx.bezierCurveTo(-R*2.2, R*0.4, -R, -R*1.2, 0, R*0.3);
        ctx.fill();
        // Shine
        ctx.fillStyle = lighten(color, 30);
        ctx.beginPath();
        ctx.moveTo(-R*.45, -R*.18);
        ctx.bezierCurveTo(-R*.3, -R*.55, -R*.1, -R*.48, -R*.15, -R*.2);
        ctx.bezierCurveTo(-R*.3, -R*.1, -R*.5, -R*.05, -R*.45, -R*.18);
        ctx.fill();
        break;
      }

      case 'star': {
        ctx.beginPath();
        for (let i = 0; i < 10; i++) {
          const r = i%2===0 ? R : R*0.44;
          ctx.lineTo(Math.cos(i*Math.PI/5 - Math.PI/2)*r, Math.sin(i*Math.PI/5 - Math.PI/2)*r);
        }
        ctx.closePath(); ctx.fill();
        ctx.fillStyle = lighten(color, 28);
        ctx.beginPath();
        ctx.arc(-R*.12, -R*.28, R*.2, 0, Math.PI*2);
        ctx.fill();
        break;
      }

      case 'moon': {
        ctx.beginPath();
        ctx.arc(0, 0, R, Math.PI*0.15, Math.PI*1.85, true);
        ctx.quadraticCurveTo(-R*0.4, 0, Math.cos(Math.PI*0.15)*R, Math.sin(Math.PI*0.15)*R);
        ctx.fill();
        ctx.fillStyle = lighten(color, 26);
        ctx.beginPath();
        ctx.arc(R*.15, -R*.35, R*.18, 0, Math.PI*2);
        ctx.fill();
        break;
      }

      case 'flower': {
        for (let i = 0; i < 5; i++) {
          const a = i * Math.PI*2/5 - Math.PI/2;
          ctx.fillStyle = color;
          ctx.beginPath();
          ctx.ellipse(Math.cos(a)*R*.55, Math.sin(a)*R*.55, R*.42, R*.26, a, 0, Math.PI*2);
          ctx.fill();
        }
        ctx.fillStyle = detail || '#FFE07A';
        ctx.beginPath(); ctx.arc(0, 0, R*.30, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = lighten(detail || '#FFE07A', 24);
        ctx.beginPath(); ctx.arc(-R*.07, -R*.07, R*.12, 0, Math.PI*2); ctx.fill();
        break;
      }

      case 'rainbow': {
        const stripes = ['#FFB3C6','#FFCF8B','#FFF4A3','#B5EDCA','#B3D9FF','#D9C0F5'];
        stripes.forEach((col, idx) => {
          const oR = R * (1 - idx * 0.12);
          const iR = oR - R * 0.10;
          ctx.fillStyle = col;
          ctx.beginPath();
          ctx.arc(0, R*.15, oR, Math.PI, 0);
          ctx.arc(0, R*.15, iR, 0, Math.PI, true);
          ctx.closePath(); ctx.fill();
        });
        ctx.fillStyle = '#FFFFFF';
        ctx.beginPath();
        ctx.arc(0, R*.15, R*.18, Math.PI, 0);
        ctx.arc(0, R*.32, R*.30, 0, Math.PI);
        ctx.closePath(); ctx.fill();
        break;
      }

      case 'bow': {
        // Left wing
        ctx.fillStyle = color;
        ctx.beginPath(); ctx.moveTo(0, 0);
        ctx.bezierCurveTo(-R*1.4,-R*0.9,-R*1.6,R*0.4,-R*0.2,R*0.15);
        ctx.closePath(); ctx.fill();
        // Right wing
        ctx.beginPath(); ctx.moveTo(0, 0);
        ctx.bezierCurveTo( R*1.4,-R*0.9, R*1.6,R*0.4, R*0.2,R*0.15);
        ctx.closePath(); ctx.fill();
        // Wing shines
        ctx.fillStyle = lighten(color, 22);
        ctx.beginPath();
        ctx.moveTo(-R*.3, -R*.32);
        ctx.bezierCurveTo(-R*.7,-R*.6,-R*.9,-R*.1,-R*.4,-R*.05);
        ctx.bezierCurveTo(-R*.25,-R*.02,-R*.28,-R*.3,-R*.3,-R*.32);
        ctx.fill();
        // Center knot
        ctx.fillStyle = detail || darken(color, 14);
        ctx.beginPath(); ctx.arc(0, R*0.06, R*0.28, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = lighten(detail || darken(color, 14), 20);
        ctx.beginPath(); ctx.arc(-R*.07, R*.0, R*.1, 0, Math.PI*2); ctx.fill();
        break;
      }

      case 'butterfly': {
        const wColor = color;
        const wColor2 = lighten(color, 14);
        // Upper wings
        ctx.fillStyle = wColor;
        ctx.beginPath(); ctx.ellipse(-R*.68, -R*.30, R*.7, R*.52, -0.4, 0, Math.PI*2); ctx.fill();
        ctx.beginPath(); ctx.ellipse( R*.68, -R*.30, R*.7, R*.52,  0.4, 0, Math.PI*2); ctx.fill();
        // Lower wings
        ctx.fillStyle = wColor2;
        ctx.beginPath(); ctx.ellipse(-R*.50,  R*.30, R*.48, R*.36,  0.3, 0, Math.PI*2); ctx.fill();
        ctx.beginPath(); ctx.ellipse( R*.50,  R*.30, R*.48, R*.36, -0.3, 0, Math.PI*2); ctx.fill();
        // Wing shine
        ctx.fillStyle = 'rgba(255,255,255,.22)';
        ctx.beginPath(); ctx.ellipse(-R*.52, -R*.42, R*.28, R*.18, -0.4, 0, Math.PI*2); ctx.fill();
        ctx.beginPath(); ctx.ellipse( R*.52, -R*.42, R*.28, R*.18,  0.4, 0, Math.PI*2); ctx.fill();
        // Body
        ctx.fillStyle = detail || darken(color, 18);
        ctx.beginPath(); ctx.ellipse(0, 0, R*0.17, R*0.78, 0, 0, Math.PI*2); ctx.fill();
        break;
      }
    }
  }

  /* ── Main draw dispatcher ───────────────────────────────────────────────── */
  function drawToCanvas(ctx, shape, R, color, detail) {
    if (!shape) shape = 'round';
    ctx.save();
    if (shape.startsWith('cube')) {
      drawCube(ctx, shape, R, color || '#F9B8CF', detail || '#C0136A');
    } else {
      drawBead(ctx, shape, R, color || '#F9B8CF', detail || '#C0136A');
    }
    ctx.restore();
  }

  /* ── Render a <canvas> element ──────────────────────────────────────────── */
  function draw(canvas, opts = {}) {
    const {
      shape  = canvas.dataset.shape  || 'round',
      color  = canvas.dataset.color  || '#F9B8CF',
      detail = canvas.dataset.detail || '#C0136A',
      small  = (canvas.dataset.small === '1') || opts.small || false,
    } = opts;

    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    const displayW = parseInt(canvas.getAttribute('width'))  || canvas.offsetWidth  || 52;
    const displayH = parseInt(canvas.getAttribute('height')) || canvas.offsetHeight || 52;

    canvas.width  = displayW * dpr;
    canvas.height = displayH * dpr;
    canvas.style.width  = displayW + 'px';
    canvas.style.height = displayH + 'px';

    const ctx = canvas.getContext('2d');
    ctx.scale(dpr, dpr);
    ctx.clearRect(0, 0, displayW, displayH);
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';

    // Drop shadow
    ctx.shadowColor   = 'rgba(0,0,0,.15)';
    ctx.shadowBlur    = 5;
    ctx.shadowOffsetY = 2;
    ctx.shadowOffsetX = 0;

    ctx.save();
    ctx.translate(displayW/2, displayH/2);

    let R;
    if (small) {
      R = displayW * .24;
    } else if (shape === 'ellipse') {
      R = displayW * .28;
    } else if (shape === 'tube') {
      R = displayW * .24;
    } else if (shape === 'butterfly' || shape === 'rainbow' || shape === 'bow') {
      R = displayW * .26;
    } else {
      R = displayW * .34;
    }

    drawToCanvas(ctx, shape, R, color, detail);
    ctx.restore();
  }

  /* ── Auto-render all .shape-canvas elements ─────────────────────────────── */
  function renderAll(root = document) {
    root.querySelectorAll('canvas.shape-canvas').forEach(canvas => draw(canvas));
  }

  return { draw, drawToCanvas, renderAll, lighten, darken };

})();

/* Auto-run on DOMContentLoaded */
document.addEventListener('DOMContentLoaded', () => ArtshapeRenderer.renderAll());