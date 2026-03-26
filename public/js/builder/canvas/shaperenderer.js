/**
 * ArtshapeRenderer — Admin Shape Canvas Renderer
 * ------------------------------------------------
 * Mirrors EXACTLY the thumbnail rendering from:
 *   CanvasEngine.generateThumbnails()  →  100×100 canvas, translate(50,50)
 *   CanvasEngine.drawElement()         →  all shape dispatching
 *   BeadShapes  (beads.js)
 *   CubeShapes  (cubes.js)
 *
 * Radius ratios are taken verbatim from generateThumbnails():
 *   R = el.small ? 20 : shape.startsWith('cube') ? 26 : shape === 'ellipse' ? 28 : 28
 * then scaled proportionally to whatever canvas size is used.
 *
 * Place at: public/js/admin/shape-renderer.js
 */

(function (global) {
  'use strict';

  // ─── Colour helpers (matches CanvasEngine._lighten / _adj) ────────────────

  function adj(hex, a) {
    try {
      var n = parseInt((hex || '#888888').replace('#', ''), 16);
      var c = function (v) { return Math.min(255, Math.max(0, v + Math.round(255 * a))); };
      return 'rgb(' + c(n >> 16) + ',' + c((n >> 8) & 0xff) + ',' + c(n & 0xff) + ')';
    } catch (e) { return hex; }
  }

  function lighten(hex, a) { return adj(hex,  a); }

  // ─── roundRect helper (matches CanvasEngine.roundRect) ────────────────────

  function roundRect(ctx, x, y, w, h, r) {
    ctx.beginPath();
    ctx.moveTo(x + r, y);
    ctx.lineTo(x + w - r, y);     ctx.quadraticCurveTo(x + w, y,     x + w, y + r);
    ctx.lineTo(x + w, y + h - r); ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
    ctx.lineTo(x + r, y + h);     ctx.quadraticCurveTo(x,     y + h, x,     y + h - r);
    ctx.lineTo(x, y + r);         ctx.quadraticCurveTo(x,     y,     x + r, y);
    ctx.closePath();
  }

  function dot(ctx, x, y, r, color) {
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.arc(x, y, r, 0, Math.PI * 2);
    ctx.fill();
  }

  // ═══════════════════════════════════════════════════════════════════════════
  // BEAD SHAPES  — verbatim from public/js/builder/canvas/shapes/beads.js
  // Each fn: (ctx, R, color, detail, lightenFn) drawn centered at (0,0)
  // ═══════════════════════════════════════════════════════════════════════════

  var BeadShapes = {

    round: function (ctx, R, color) {
      ctx.fillStyle = color;
      ctx.beginPath();
      ctx.arc(0, 0, R, 0, Math.PI * 2);
      ctx.fill();
    },

    ellipse: function (ctx, R, color) {
      ctx.fillStyle = color;
      ctx.beginPath();
      ctx.ellipse(0, 0, R * 1.55, R * 0.78, 0, 0, Math.PI * 2);
      ctx.fill();
    },

    tube: function (ctx, R, color) {
      ctx.fillStyle = color;
      ctx.beginPath();
      ctx.ellipse(0, 0, R * 0.7, R * 1.58, 0, 0, Math.PI * 2);
      ctx.fill();
    },

    pearl: function (ctx, R, color) {
      ctx.fillStyle = color;
      ctx.beginPath();
      ctx.arc(0, 0, R, 0, Math.PI * 2);
      ctx.fill();
    },

    faceted: function (ctx, R, color) {
      ctx.fillStyle = color;
      ctx.beginPath();
      for (var i = 0; i < 6; i++) {
        ctx.lineTo(
          Math.cos(i * Math.PI / 3) * R,
          Math.sin(i * Math.PI / 3) * R
        );
      }
      ctx.closePath();
      ctx.fill();
    },

    heart: function (ctx, R, color) {
      ctx.fillStyle = color;
      ctx.beginPath();
      ctx.moveTo(0, R * 0.3);
      ctx.bezierCurveTo( R, -R * 1.2,  R * 2.2, R * 0.4, 0,  R);
      ctx.bezierCurveTo(-R * 2.2, R * 0.4, -R, -R * 1.2, 0, R * 0.3);
      ctx.fill();
    },

    star: function (ctx, R, color) {
      ctx.fillStyle = color;
      ctx.beginPath();
      for (var i = 0; i < 10; i++) {
        var rad = i % 2 === 0 ? R : R * 0.44;
        ctx.lineTo(
          Math.cos(i * Math.PI / 5 - Math.PI / 2) * rad,
          Math.sin(i * Math.PI / 5 - Math.PI / 2) * rad
        );
      }
      ctx.closePath();
      ctx.fill();
    },

    moon: function (ctx, R, color) {
      ctx.fillStyle = color;
      ctx.beginPath();
      ctx.arc(0, 0, R, Math.PI * 0.15, Math.PI * 1.85, true);
      ctx.quadraticCurveTo(
        -R * 0.4, 0,
        Math.cos(Math.PI * 0.15) * R,
        Math.sin(Math.PI * 0.15) * R
      );
      ctx.fill();
    },

    flower: function (ctx, R, color, detail) {
      for (var i = 0; i < 5; i++) {
        var a = i * Math.PI * 2 / 5;
        ctx.save();
        ctx.translate(Math.cos(a) * R * 0.56, Math.sin(a) * R * 0.56);
        ctx.fillStyle = color;
        ctx.beginPath();
        ctx.arc(0, 0, R * 0.48, 0, Math.PI * 2);
        ctx.fill();
        ctx.restore();
      }
      ctx.fillStyle = detail;
      ctx.beginPath();
      ctx.arc(0, 0, R * 0.34, 0, Math.PI * 2);
      ctx.fill();
    },

    rainbow: function (ctx, R) {
      var stripes = ['#FFB3C6', '#FFCF8B', '#FFF4A3', '#B5EDCA', '#B3D9FF', '#D9C0F5'];
      stripes.forEach(function (col, idx) {
        var oR = R * (1 - idx * 0.12);
        var iR = oR - R * 0.10;
        ctx.fillStyle = col;
        ctx.beginPath();
        ctx.arc(0, R * 0.15, oR, Math.PI, 0);
        ctx.arc(0, R * 0.15, iR, 0, Math.PI, true);
        ctx.closePath();
        ctx.fill();
      });
      ctx.fillStyle = '#FFFFFF';
      ctx.beginPath();
      ctx.arc(0, R * 0.15, R * 0.20, Math.PI, 0);
      ctx.arc(0, R * 0.35, R * 0.32, 0, Math.PI);
      ctx.closePath();
      ctx.fill();
    },

    bow: function (ctx, R, color, detail) {
      ctx.fillStyle = color;
      ctx.beginPath();
      ctx.moveTo(0, 0);
      ctx.bezierCurveTo(-R * 1.4, -R * 0.9, -R * 1.6, R * 0.4, -R * 0.2, R * 0.15);
      ctx.closePath();
      ctx.fill();
      ctx.beginPath();
      ctx.moveTo(0, 0);
      ctx.bezierCurveTo( R * 1.4, -R * 0.9,  R * 1.6, R * 0.4,  R * 0.2, R * 0.15);
      ctx.closePath();
      ctx.fill();
      ctx.fillStyle = detail;
      ctx.beginPath();
      ctx.arc(0, R * 0.06, R * 0.3, 0, Math.PI * 2);
      ctx.fill();
    },

    butterfly: function (ctx, R, color, detail) {
      ctx.fillStyle = color;
      ctx.beginPath(); ctx.ellipse(-R * .7, -R * .32, R * .7, R * .52, -0.4, 0, Math.PI * 2); ctx.fill();
      ctx.beginPath(); ctx.ellipse( R * .7, -R * .32, R * .7, R * .52,  0.4, 0, Math.PI * 2); ctx.fill();
      ctx.fillStyle = lighten(color, 0.18);
      ctx.beginPath(); ctx.ellipse(-R * .52, R * .3, R * .48, R * .36,  0.3, 0, Math.PI * 2); ctx.fill();
      ctx.beginPath(); ctx.ellipse( R * .52, R * .3, R * .48, R * .36, -0.3, 0, Math.PI * 2); ctx.fill();
      ctx.fillStyle = detail;
      ctx.beginPath(); ctx.ellipse(0, 0, R * 0.17, R * 0.78, 0, 0, Math.PI * 2); ctx.fill();
    },
  };

  // ═══════════════════════════════════════════════════════════════════════════
  // CUBE SHAPES  — verbatim from public/js/builder/canvas/shapes/cubes.js
  // ═══════════════════════════════════════════════════════════════════════════

  function drawCubeBase(ctx, R, color) {
    var s = R * 1.8;
    ctx.fillStyle = color;
    ctx.beginPath();
    roundRect(ctx, -s / 2, -s / 2, s, s, s * 0.18);
    ctx.fill();
  }

  var CubeShapes = {

    'cube': function (ctx, R, color) {
      drawCubeBase(ctx, R, color);
    },

    'cube-dice1': function (ctx, R, color, detail) {
      drawCubeBase(ctx, R, color);
      dot(ctx, 0, 0, R * 0.18, detail);
    },

    'cube-dice2': function (ctx, R, color, detail) {
      var dr = R * 0.18, h = (R * 1.8) / 2;
      drawCubeBase(ctx, R, color);
      dot(ctx, -h * 0.42,  h * 0.42, dr, detail);
      dot(ctx,  h * 0.42, -h * 0.42, dr, detail);
    },

    'cube-dice3': function (ctx, R, color, detail) {
      var dr = R * 0.18, h = (R * 1.8) / 2;
      drawCubeBase(ctx, R, color);
      dot(ctx, -h * 0.42,  h * 0.42, dr, detail);
      dot(ctx,  0,          0,        dr, detail);
      dot(ctx,  h * 0.42, -h * 0.42, dr, detail);
    },

    'cube-dice4': function (ctx, R, color, detail) {
      var dr = R * 0.18, h = (R * 1.8) / 2;
      drawCubeBase(ctx, R, color);
      [[-1,-1],[1,-1],[-1,1],[1,1]].forEach(function (p) {
        dot(ctx, p[0] * h * 0.38, p[1] * h * 0.38, dr, detail);
      });
    },

    'cube-dice5': function (ctx, R, color, detail) {
      var dr = R * 0.18, h = (R * 1.8) / 2;
      drawCubeBase(ctx, R, color);
      [[-1,-1],[1,-1],[-1,1],[1,1],[0,0]].forEach(function (p) {
        dot(ctx, p[0] * h * 0.38, p[1] * h * 0.38, dr, detail);
      });
    },

    'cube-dice6': function (ctx, R, color, detail) {
      var dr = R * 0.18, h = (R * 1.8) / 2;
      drawCubeBase(ctx, R, color);
      [[-1,-1],[1,-1],[-1,0],[1,0],[-1,1],[1,1]].forEach(function (p) {
        dot(ctx, p[0] * h * 0.38, p[1] * h * 0.38, dr, detail);
      });
    },

    'cube-heart': function (ctx, R, color, detail) {
      drawCubeBase(ctx, R, color);
      var hr = R * 0.55;
      ctx.fillStyle = detail;
      ctx.beginPath();
      ctx.moveTo(0, hr * 0.3);
      ctx.bezierCurveTo( hr, -hr * 1.2,  hr * 2.2, hr * 0.4, 0,  hr);
      ctx.bezierCurveTo(-hr * 2.2, hr * 0.4, -hr, -hr * 1.2, 0, hr * 0.3);
      ctx.fill();
    },

    'cube-star': function (ctx, R, color, detail) {
      drawCubeBase(ctx, R, color);
      var sr = R * 0.6;
      ctx.fillStyle = detail;
      ctx.beginPath();
      for (var i = 0; i < 10; i++) {
        var rad = i % 2 === 0 ? sr : sr * 0.44;
        ctx.lineTo(
          Math.cos(i * Math.PI / 5 - Math.PI / 2) * rad,
          Math.sin(i * Math.PI / 5 - Math.PI / 2) * rad
        );
      }
      ctx.closePath();
      ctx.fill();
    },

    'cube-checker': function (ctx, R, color, detail) {
      var s = R * 1.8, cs = s / 4;
      drawCubeBase(ctx, R, color);
      ctx.fillStyle = detail;
      ctx.save();
      ctx.beginPath();
      roundRect(ctx, -s / 2, -s / 2, s, s, s * 0.18);
      ctx.clip();
      for (var row = 0; row < 4; row++) {
        for (var col = 0; col < 4; col++) {
          if ((row + col) % 2 === 0) {
            ctx.fillRect(-s / 2 + col * cs, -s / 2 + row * cs, cs, cs);
          }
        }
      }
      ctx.restore();
    },

    'cube-smile': function (ctx, R, color, detail) {
      drawCubeBase(ctx, R, color);
      ctx.strokeStyle = detail;
      ctx.lineWidth   = R * 0.14;
      ctx.lineCap     = 'round';
      dot(ctx, -R * 0.35, -R * 0.2, R * 0.13, detail);
      dot(ctx,  R * 0.35, -R * 0.2, R * 0.13, detail);
      ctx.beginPath();
      ctx.arc(0, R * 0.1, R * 0.38, 0.2, Math.PI - 0.2);
      ctx.stroke();
    },
  };

  // ═══════════════════════════════════════════════════════════════════════════
  // RADIUS — mirrors generateThumbnails() base values, scaled to canvas size.
  //
  //   generateThumbnails() uses a 100×100 canvas (translate 50,50) and:
  //     small bead  → R = 20
  //     cube shape  → R = 26
  //     everything  → R = 28
  //
  //   We scale linearly so a 52×52 admin grid card looks identical,
  //   and a 120×120 form preview looks identical too.
  // ═══════════════════════════════════════════════════════════════════════════

  function calcR(shape, small, size) {
    var baseR;
    if (small) {
      baseR = 20;
    } else if (shape && shape.startsWith('cube')) {
      baseR = 26;
    } else {
      baseR = 28;
    }
    // size / 100 = scale factor relative to the builder's 100px thumbnail canvas
    return baseR * (size / 100);
  }

  // ═══════════════════════════════════════════════════════════════════════════
  // PUBLIC: draw(canvasEl, opts?)
  //
  // Reads data-* attrs; opts object overrides them.
  //   opts = { shape, color, detail, small }
  // ═══════════════════════════════════════════════════════════════════════════

  function draw(canvas, opts) {
    if (!canvas || !canvas.getContext) return;

    var shape  = (opts && opts.shape  != null ? opts.shape  : canvas.dataset.shape)  || 'round';
    var color  = (opts && opts.color  != null ? opts.color  : canvas.dataset.color)  || '#F9B8CF';
    var detail = (opts && opts.detail != null ? opts.detail : canvas.dataset.detail) || '#C0136A';
    var small  = (opts && opts.small  != null ? !!opts.small : canvas.dataset.small === '1');

    var W    = canvas.width  || 52;
    var H    = canvas.height || 52;
    var size = Math.min(W, H);
    var R    = calcR(shape, small, size);

    var ctx  = canvas.getContext('2d');
    ctx.clearRect(0, 0, W, H);
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';

    ctx.save();
    ctx.translate(W / 2, H / 2);

    if (CubeShapes[shape]) {
      CubeShapes[shape](ctx, R, color, detail, roundRect);
    } else if (BeadShapes[shape]) {
      BeadShapes[shape](ctx, R, color, detail, lighten);
    } else {
      // Fallback — plain circle (matches CanvasEngine fallback)
      ctx.fillStyle = color;
      ctx.beginPath();
      ctx.arc(0, 0, R, 0, Math.PI * 2);
      ctx.fill();
    }

    ctx.restore();
  }

  // ─── Auto-render every canvas.shape-canvas on the page ────────────────────

  function renderAll() {
    document.querySelectorAll('canvas.shape-canvas').forEach(function (c) {
      draw(c);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', renderAll);
  } else {
    renderAll();
  }

  // ─── Public API ───────────────────────────────────────────────────────────

  global.ArtshapeRenderer = {
    /** Draw one canvas. opts = { shape, color, detail, small } */
    draw: draw,
    /** Re-render every canvas.shape-canvas on the page */
    renderAll: renderAll,
  };

}(window));