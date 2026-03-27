// ─── BEAD SHAPES ─────────────────────────────────────────────────────────────
// Each function receives (ctx, R, color, detail) and draws centered at (0,0).
// canvasengine.js dispatches here after translate/rotate.

export const BeadShapes = {

  round(ctx, R, color) {
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.arc(0, 0, R, 0, Math.PI * 2);
    ctx.fill();
  },

  ellipse(ctx, R, color) {
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.ellipse(0, 0, R * 1.55, R * 0.78, 0, 0, Math.PI * 2);
    ctx.fill();
  },

  tube(ctx, R, color) {
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.ellipse(0, 0, R * 0.7, R * 1.58, 0, 0, Math.PI * 2);
    ctx.fill();
  },

  pearl(ctx, R, color) {
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.arc(0, 0, R, 0, Math.PI * 2);
    ctx.fill();
  },

  faceted(ctx, R, color) {
    ctx.fillStyle = color;
    ctx.beginPath();
    for (let i = 0; i < 6; i++) {
      ctx.lineTo(Math.cos(i * Math.PI / 3) * R, Math.sin(i * Math.PI / 3) * R);
    }
    ctx.closePath();
    ctx.fill();
  },


};