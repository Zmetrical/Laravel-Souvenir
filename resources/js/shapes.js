// resources/js/admin-shapes.js
// ─── Admin Shape Renderer ─────────────────────────────────────────────────
// Thin wrapper around the real shape files — NO shape functions copied here.
// Exposes window.ArtshapeRenderer so admin Blade pages work unchanged.

import { BeadShapes } from '@shapes/beads.js';
import { CubeShapes } from '@shapes/cubes.js';
import { FigureShapes } from '@shapes/figures.js';

// ── Helpers (same as before, but only defined ONCE now) ───────────────────

function adj(hex, a) {
    try {
        const n = parseInt((hex || '#888888').replace('#', ''), 16);
        const c = v => Math.min(255, Math.max(0, v + Math.round(255 * a)));
        return `rgb(${c(n >> 16)},${c((n >> 8) & 0xff)},${c(n & 0xff)})`;
    } catch { return hex; }
}

function lighten(hex, a) { return adj(hex, a); }

function roundRect(ctx, x, y, w, h, r) {
    ctx.beginPath();
    ctx.moveTo(x + r, y);
    ctx.lineTo(x + w - r, y);     ctx.quadraticCurveTo(x + w, y,     x + w, y + r);
    ctx.lineTo(x + w, y + h - r); ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
    ctx.lineTo(x + r, y + h);     ctx.quadraticCurveTo(x,     y + h, x,     y + h - r);
    ctx.lineTo(x, y + r);         ctx.quadraticCurveTo(x,     y,     x + r, y);
    ctx.closePath();
}

function calcR(shape, small, size) {
    const baseR = small ? 20 : (shape && shape.startsWith('cube')) ? 26 : 28;
    return baseR * (size / 100);
}

// ── draw() ────────────────────────────────────────────────────────────────

function draw(canvas, opts) {
    if (!canvas || !canvas.getContext) return;

const shape  = opts?.shape  || canvas.dataset.shape  || 'round';
    const color  = opts?.color  || canvas.dataset.color  || '#F9B8CF';
    const detail = opts?.detail || canvas.dataset.detail || '#C0136A';
    const small  = opts?.small !== undefined ? opts.small : (canvas.dataset.small === '1');

    
    const W    = canvas.width  || 52;
    const H    = canvas.height || 52;
    const size = Math.min(W, H);
    const R    = calcR(shape, small, size);

    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, W, H);
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';

    ctx.save();
    ctx.translate(W / 2, H / 2);

    if (CubeShapes[shape]) {
        CubeShapes[shape](ctx, R, color, detail, roundRect);
    } else if (FigureShapes[shape]) {
        FigureShapes[shape](ctx, R, color, detail, lighten);
    } else if (BeadShapes[shape]) {
        BeadShapes[shape](ctx, R, color, detail, lighten);
    } else {
        ctx.fillStyle = color;
        ctx.beginPath();
        ctx.arc(0, 0, R, 0, Math.PI * 2);
        ctx.fill();
    }

    ctx.restore();
}

// ── UPDATED renderAll() ───────────────────────────────────────────────────
function renderAll() {
    // 👇 This now finds ALL types of canvases used in the admin form and lists
    const selector = 'canvas.shape-canvas, canvas.shape-tile-canvas, canvas.preview-canvas, canvas.var-canvas, .shape-tile-canvas';
    document.querySelectorAll(selector).forEach(c => draw(c));
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', renderAll);
} else {
    renderAll();
}

window.ArtshapeRenderer = { draw, renderAll };
window.dispatchEvent(new CustomEvent('artshape:ready'));