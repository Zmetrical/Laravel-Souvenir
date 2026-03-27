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

heart(ctx, R, color) {
    ctx.fillStyle = color;
    ctx.save();
    ctx.scale(R / 10, R / 10); // work in a normalized 10-unit space

    ctx.beginPath();
    // Start at the bottom tip
    ctx.moveTo(0, 8);

    // Up the left side
    ctx.bezierCurveTo(-10, 2, -10, -6, -5, -6);

    // Left bump to center dip
    ctx.bezierCurveTo(-2, -6, 0, -4, 0, -2);

    // Center dip to right bump
    ctx.bezierCurveTo(0, -4, 2, -6, 5, -6);

    // Down the right side to tip
    ctx.bezierCurveTo(10, -6, 10, 2, 0, 8);

    ctx.closePath();
    ctx.fill();
    ctx.restore();
},

  star(ctx, R, color) {
    ctx.fillStyle = color;
    ctx.beginPath();
    for (let i = 0; i < 10; i++) {
      const rad = i % 2 === 0 ? R : R * 0.44;
      ctx.lineTo(
        Math.cos(i * Math.PI / 5 - Math.PI / 2) * rad,
        Math.sin(i * Math.PI / 5 - Math.PI / 2) * rad
      );
    }
    ctx.closePath();
    ctx.fill();
  },

// REPLACE WITH:
moon(ctx, R, color) {
    // Two-circle crescent technique:
    // Draw full circle, punch out offset circle using destination-out
    const offscreen = document.createElement('canvas');
    offscreen.width  = R * 4;
    offscreen.height = R * 4;
    const oc = offscreen.getContext('2d');

    const cx = R * 2;
    const cy = R * 2;

    // Full circle
    oc.fillStyle = color;
    oc.beginPath();
    oc.arc(cx, cy, R, 0, Math.PI * 2);
    oc.fill();

    // Punch out offset circle → creates crescent
    oc.globalCompositeOperation = 'destination-out';
    oc.beginPath();
    oc.arc(cx + R * 0.55, cy - R * 0.1, R * 0.85, 0, Math.PI * 2);
    oc.fill();

    // Stamp result onto main canvas centered at (0,0)
    ctx.drawImage(offscreen, -cx, -cy);
},

  flower(ctx, R, color, detail) {
    for (let i = 0; i < 5; i++) {
      const a = i * Math.PI * 2 / 5;
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

  bow(ctx, R, color, detail) {
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

  butterfly(ctx, R, color, detail, lightenFn) {
    ctx.fillStyle = color;
    ctx.beginPath(); ctx.ellipse(-R * .7, -R * .32, R * .7, R * .52, -0.4, 0, Math.PI * 2); ctx.fill();
    ctx.beginPath(); ctx.ellipse( R * .7, -R * .32, R * .7, R * .52,  0.4, 0, Math.PI * 2); ctx.fill();
    ctx.fillStyle = lightenFn(color, 0.18);
    ctx.beginPath(); ctx.ellipse(-R * .52, R * .3, R * .48, R * .36,  0.3, 0, Math.PI * 2); ctx.fill();
    ctx.beginPath(); ctx.ellipse( R * .52, R * .3, R * .48, R * .36, -0.3, 0, Math.PI * 2); ctx.fill();
    ctx.fillStyle = detail;
    ctx.beginPath(); ctx.ellipse(0, 0, R * 0.17, R * 0.78, 0, 0, Math.PI * 2); ctx.fill();
  },

  sun(ctx, R, color, detail) {
    const rays    = 8;
    const innerR  = R * 0.55;   // where rays start
    const outerR  = R * 1.0;    // ray tip
    const rayW    = 0.18;       // ray half-width in radians

    // ── Rays ─────────────────────────────────────────────────────────────
    ctx.fillStyle = color;
    for (let i = 0; i < rays; i++) {
        const angle = (i / rays) * Math.PI * 2;
        ctx.beginPath();
        ctx.moveTo(
            Math.cos(angle - rayW) * innerR,
            Math.sin(angle - rayW) * innerR
        );
        ctx.lineTo(
            Math.cos(angle) * outerR,
            Math.sin(angle) * outerR
        );
        ctx.lineTo(
            Math.cos(angle + rayW) * innerR,
            Math.sin(angle + rayW) * innerR
        );
        ctx.closePath();
        ctx.fill();
    }

    // ── Center circle ─────────────────────────────────────────────────────
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.arc(0, 0, innerR, 0, Math.PI * 2);
    ctx.fill();

    // ── Face dot (uses detail color) ──────────────────────────────────────
    ctx.fillStyle = detail || color;
    ctx.globalAlpha = 0.35;
    ctx.beginPath();
    ctx.arc(0, 0, innerR * 0.45, 0, Math.PI * 2);
    ctx.fill();
    ctx.globalAlpha = 1;
},
daisy(ctx, R, color, detail) {
  for (let i = 0; i < 8; i++) {
    ctx.save();
    ctx.rotate(i * (Math.PI * 2 / 8));
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.ellipse(0, -R * 0.58, R * 0.18, R * 0.44, 0, 0, Math.PI * 2);
    ctx.fill();
    ctx.restore();
  }
  ctx.fillStyle = detail;
  ctx.beginPath();
  ctx.arc(0, 0, R * 0.28, 0, Math.PI * 2);
  ctx.fill();
  ctx.beginPath();
  ctx.arc(-R * 0.09, -R * 0.09, R * 0.12, 0, Math.PI * 2);
  ctx.fill();
},

// ── SEA LIFE ────────────────────────────────────────────────────────
shell(ctx, R, color, detail) {
    ctx.fillStyle = color;
    
    // Optional: a subtle stroke matches the fill to softly anti-alias the edges
    ctx.strokeStyle = color;
    ctx.lineWidth = R * 0.05;
    ctx.lineJoin = 'round';
    
    ctx.beginPath();
    // Start at the far left edge
    ctx.moveTo(-R * 0.9, -R * 0.1);
    
    // 5 soft, pillowy scallop humps along the top
    ctx.quadraticCurveTo(-R * 0.8, -R * 0.5, -R * 0.55, -R * 0.45); // Far left hump
    ctx.quadraticCurveTo(-R * 0.4, -R * 0.7, -R * 0.2, -R * 0.6);   // Inner left hump
    ctx.quadraticCurveTo(0, -R * 0.85, R * 0.2, -R * 0.6);          // Tall center hump
    ctx.quadraticCurveTo(R * 0.4, -R * 0.7, R * 0.55, -R * 0.45);   // Inner right hump
    ctx.quadraticCurveTo(R * 0.8, -R * 0.5, R * 0.9, -R * 0.1);     // Far right hump

    // Sweeping curve down the right wall to the bottom hinge
    ctx.bezierCurveTo(R * 1.0, R * 0.5, R * 0.6, R * 0.8, R * 0.2, R * 0.85);
    
    // Small curve across the bottom
    ctx.quadraticCurveTo(0, R * 0.95, -R * 0.2, R * 0.85);
    
    // Sweeping curve up the left wall back to the start
    ctx.bezierCurveTo(-R * 0.6, R * 0.8, -R * 1.0, R * 0.5, -R * 0.9, -R * 0.1);
    
    ctx.fill();
    ctx.stroke();

    // ─── RADIATING RIDGES ──────────────────────────────────────────────
    ctx.strokeStyle = detail;
    ctx.lineWidth = R * 0.08;
    ctx.lineCap = 'round';

    // Instead of straight lines, we use curves that fan out and 
    // connect the bottom hinge perfectly to the "valleys" between the scallops.
    
    // Far left ridge
    ctx.beginPath();
    ctx.moveTo(-R * 0.15, R * 0.75);
    ctx.quadraticCurveTo(-R * 0.4, R * 0.2, -R * 0.55, -R * 0.45);
    ctx.stroke();

    // Inner left ridge
    ctx.beginPath();
    ctx.moveTo(-R * 0.05, R * 0.78);
    ctx.quadraticCurveTo(-R * 0.15, R * 0.1, -R * 0.2, -R * 0.6);
    ctx.stroke();

    // Inner right ridge
    ctx.beginPath();
    ctx.moveTo(R * 0.05, R * 0.78);
    ctx.quadraticCurveTo(R * 0.15, R * 0.1, R * 0.2, -R * 0.6);
    ctx.stroke();

    // Far right ridge
    ctx.beginPath();
    ctx.moveTo(R * 0.15, R * 0.75);
    ctx.quadraticCurveTo(R * 0.4, R * 0.2, R * 0.55, -R * 0.45);
    ctx.stroke();

    // ─── HINGE BASE ────────────────────────────────────────────────────
    // This tiny oval at the bottom ties the whole shell geometry together
    ctx.fillStyle = detail;
    ctx.beginPath();
    ctx.ellipse(0, R * 0.83, R * 0.25, R * 0.08, 0, 0, Math.PI * 2);
    ctx.fill();
  },

fish(ctx, R, color, detail) {
    ctx.fillStyle = color;
    
    // Tail
    ctx.beginPath();
    ctx.moveTo(-R * 0.5, 0);
    ctx.quadraticCurveTo(-R * 1.2, -R * 0.8, -R * 1.4, -R * 0.6);
    ctx.lineTo(-R * 1.2, 0);
    ctx.lineTo(-R * 1.4, R * 0.6);
    ctx.quadraticCurveTo(-R * 1.2, R * 0.8, -R * 0.5, 0);
    ctx.fill();
    
    // Top & Bottom Fins
    ctx.beginPath(); ctx.moveTo(0, -R*0.5); ctx.lineTo(-R*0.3, -R*0.9); ctx.lineTo(-R*0.6, -R*0.5); ctx.fill();
    ctx.beginPath(); ctx.moveTo(0, R*0.5); ctx.lineTo(-R*0.3, R*0.9); ctx.lineTo(-R*0.6, R*0.5); ctx.fill();

    // Main Body
    ctx.beginPath();
    ctx.ellipse(0, 0, R, R * 0.65, 0, 0, Math.PI * 2);
    ctx.fill();

    // ─── UPGRADED DETAILS ─────────────────────────────────────────────
    ctx.fillStyle = detail;
    ctx.strokeStyle = detail;
    ctx.lineWidth = R * 0.08;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';

    // 1. Cute, perfectly proportioned eye
    ctx.beginPath(); 
    ctx.arc(R * 0.55, -R * 0.15, R * 0.1, 0, Math.PI * 2); 
    ctx.fill();

    // 3. Sweeping, organic gill line (instead of a stiff circle arc)
    ctx.beginPath(); 
    ctx.moveTo(R * 0.15, -R * 0.45); 
    ctx.quadraticCurveTo(-R * 0.05, 0, R * 0.15, R * 0.45); 
    ctx.stroke();

    // 4. Tail fin texture lines (radiating outward)
    ctx.beginPath();
    ctx.moveTo(-R * 0.8, 0); 
    ctx.lineTo(-R * 1.2, 0); // Center tail line
    
    ctx.moveTo(-R * 0.75, -R * 0.2); 
    ctx.lineTo(-R * 1.15, -R * 0.45); // Top tail line
    
    ctx.moveTo(-R * 0.75, R * 0.2); 
    ctx.lineTo(-R * 1.15, R * 0.45); // Bottom tail line
    ctx.stroke();
  },

  // ── SWEETS ────────────────────────────────────────────────────────
  candy(ctx, R, color, detail) {
    ctx.fillStyle = color;
    // Fluted wrapper ends
    ctx.beginPath();
    ctx.moveTo(0,0); ctx.lineTo(-R * 1.5, -R * 0.6); ctx.quadraticCurveTo(-R*1.3, 0, -R * 1.5, R * 0.6); ctx.fill();
    ctx.beginPath();
    ctx.moveTo(0,0); ctx.lineTo(R * 1.5, -R * 0.6); ctx.quadraticCurveTo(R*1.3, 0, R * 1.5, R * 0.6); ctx.fill();
    
    // Center Sweet
    ctx.beginPath();
    ctx.arc(0, 0, R * 0.8, 0, Math.PI * 2);
    ctx.fill();
    
    // Peppermint swirl details
    ctx.strokeStyle = detail;
    ctx.lineWidth = R * 0.2;
    ctx.beginPath();
    ctx.moveTo(-R*0.6, -R*0.4); ctx.quadraticCurveTo(0, 0, R*0.6, R*0.4); ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(R*0.6, -R*0.4); ctx.quadraticCurveTo(0, 0, -R*0.6, R*0.4); ctx.stroke();
  },

  donut(ctx, R, color, detail) {
    // Dough
    ctx.fillStyle = color;
    ctx.beginPath(); ctx.arc(0, 0, R, 0, Math.PI * 2); ctx.fill();
    
    // Wavy Icing
    ctx.fillStyle = detail;
    ctx.beginPath();
    for(let i=0; i<8; i++) {
        let a = (i * Math.PI) / 4;
        ctx.arc(Math.cos(a) * R * 0.3, Math.sin(a) * R * 0.3, R * 0.65, 0, Math.PI * 2);
    }
    ctx.fill();

    // Inner hole (punch out everything in the center)
    ctx.globalCompositeOperation = 'destination-out';
    ctx.beginPath(); ctx.arc(0, 0, R * 0.3, 0, Math.PI * 2); ctx.fill();
    ctx.globalCompositeOperation = 'source-over';
  },

  cupcake(ctx, R, color, detail) {
    // Wrapper (Trapezoid with ridges)
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.moveTo(-R * 0.6, R * 0.8); ctx.lineTo(R * 0.6, R * 0.8);
    ctx.lineTo(R * 0.8, 0); ctx.lineTo(-R * 0.8, 0);
    ctx.closePath();
    ctx.fill();
    
    ctx.strokeStyle = detail;
    ctx.lineWidth = R * 0.05;
    for(let i=-0.4; i<=0.4; i+=0.2) {
       ctx.beginPath(); ctx.moveTo(i*R, R*0.8); ctx.lineTo(i*R*1.2, 0); ctx.stroke();
    }

    // Fluffy Frosting
    ctx.fillStyle = detail;
    ctx.beginPath(); ctx.arc(-R * 0.5, -R * 0.2, R * 0.45, 0, Math.PI * 2); ctx.fill();
    ctx.beginPath(); ctx.arc(R * 0.5, -R * 0.2, R * 0.45, 0, Math.PI * 2); ctx.fill();
    ctx.beginPath(); ctx.arc(0, -R * 0.5, R * 0.5, 0, Math.PI * 2); ctx.fill();
  },

  // ── FRUIT ────────────────────────────────────────────────────────
  cherry(ctx, R, color, detail) {
    // Stems (connecting to a single top node)
    ctx.strokeStyle = detail;
    ctx.lineWidth = R * 0.12;
    ctx.beginPath();
    ctx.moveTo(-R * 0.5, R * 0.1); ctx.quadraticCurveTo(-R * 0.2, -R * 1.2, 0, -R * 1.2); ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(R * 0.5, R * 0.1); ctx.quadraticCurveTo(R * 0.2, -R * 1.2, 0, -R * 1.2); ctx.stroke();
    
    // Top leaf/knot
    ctx.fillStyle = detail;
    ctx.beginPath(); ctx.arc(0, -R * 1.2, R * 0.15, 0, Math.PI * 2); ctx.fill();

    // Two Cherries
    ctx.fillStyle = color;
    ctx.beginPath(); ctx.arc(-R * 0.5, R * 0.4, R * 0.55, 0, Math.PI * 2); ctx.fill();
    ctx.beginPath(); ctx.arc(R * 0.5, R * 0.4, R * 0.55, 0, Math.PI * 2); ctx.fill();
  },
  
  strawberry(ctx, R, color, detail) {
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.moveTo(0, R * 0.9);
    // Plumper shoulders, sharper tip
    ctx.bezierCurveTo(-R * 1.2, R * 0.2, -R * 0.9, -R * 0.6, 0, -R * 0.7);
    ctx.bezierCurveTo(R * 0.9, -R * 0.6, R * 1.2, R * 0.2, 0, R * 0.9);
    ctx.fill();

    // Spiky Leaf Cap
    ctx.fillStyle = detail;
    ctx.beginPath();
    ctx.moveTo(0, -R * 0.9);
    ctx.lineTo(-R * 0.7, -R * 0.5); ctx.lineTo(-R * 0.3, -R * 0.6);
    ctx.lineTo(0, -R * 0.4);
    ctx.lineTo(R * 0.3, -R * 0.6); ctx.lineTo(R * 0.7, -R * 0.5);
    ctx.fill();
  },

  apple(ctx, R, color, detail) {
    ctx.fillStyle = color;
    ctx.beginPath();
    // True apple shape with a bottom and top dimple
    ctx.moveTo(0, -R * 0.6);
    ctx.bezierCurveTo(R * 1.2, -R * 1.1, R * 1.3, R * 0.5, R * 0.3, R * 0.8);
    ctx.quadraticCurveTo(0, R * 0.9, -R * 0.3, R * 0.8);
    ctx.bezierCurveTo(-R * 1.3, R * 0.5, -R * 1.2, -R * 1.1, 0, -R * 0.6);
    ctx.fill();
    
    // Curved Stem
    ctx.strokeStyle = detail;
    ctx.lineWidth = R * 0.15;
    ctx.beginPath();
    ctx.moveTo(0, -R * 0.5);
    ctx.quadraticCurveTo(R * 0.2, -R * 0.9, R * 0.4, -R * 1.1);
    ctx.stroke();
  },


ladybug(ctx, R, color, detail) {
    // Shift the body down slightly to make room for the head and antennae
    const bodyR = R * 0.85;
    const offsetY = R * 0.1;

    // 1. Antennae (drawn first so they go behind the head)
    ctx.strokeStyle = detail;
    ctx.fillStyle = detail;
    ctx.lineWidth = R * 0.08;
    ctx.lineCap = 'round';

    // Left antenna
    ctx.beginPath();
    ctx.moveTo(-R * 0.15, -R * 0.7); // Start inside head area
    ctx.quadraticCurveTo(-R * 0.3, -R * 1.0, -R * 0.45, -R * 0.95);
    ctx.stroke();
    // Left antenna tip
    ctx.beginPath(); ctx.arc(-R * 0.45, -R * 0.95, R * 0.08, 0, Math.PI*2); ctx.fill();

    // Right antenna
    ctx.beginPath();
    ctx.moveTo(R * 0.15, -R * 0.7);
    ctx.quadraticCurveTo(R * 0.3, -R * 1.0, R * 0.45, -R * 0.95);
    ctx.stroke();
    // Right antenna tip
    ctx.beginPath(); ctx.arc(R * 0.45, -R * 0.95, R * 0.08, 0, Math.PI*2); ctx.fill();

    // 2. Head (drawn behind the body so the wing curve stays perfectly round)
    ctx.fillStyle = detail;
    ctx.beginPath();
    ctx.arc(0, -bodyR * 0.75, R * 0.35, 0, Math.PI * 2);
    ctx.fill();

    // 3. Main Body
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.arc(0, offsetY, bodyR, 0, Math.PI * 2);
    ctx.fill();

    // 4. Wing Split Line
    // Starts exactly at the top of the body circle and goes to the bottom
    ctx.strokeStyle = detail;
    ctx.lineWidth = R * 0.08;
    ctx.beginPath();
    ctx.moveTo(0, offsetY - bodyR);
    ctx.lineTo(0, offsetY + bodyR);
    ctx.stroke();

    // 5. The 6 Iconic Dots (matching the curve of the wings)
    ctx.fillStyle = detail;
    const dotR = R * 0.12;

    // Left wing dots
    ctx.beginPath(); ctx.arc(-R * 0.28, -R * 0.25, dotR, 0, Math.PI*2); ctx.fill(); // Top
    ctx.beginPath(); ctx.arc(-R * 0.5,   R * 0.15, dotR, 0, Math.PI*2); ctx.fill(); // Middle
    ctx.beginPath(); ctx.arc(-R * 0.28,  R * 0.55, dotR, 0, Math.PI*2); ctx.fill(); // Bottom

    // Right wing dots
    ctx.beginPath(); ctx.arc( R * 0.28, -R * 0.25, dotR, 0, Math.PI*2); ctx.fill(); // Top
    ctx.beginPath(); ctx.arc( R * 0.5,   R * 0.15, dotR, 0, Math.PI*2); ctx.fill(); // Middle
    ctx.beginPath(); ctx.arc( R * 0.28,  R * 0.55, dotR, 0, Math.PI*2); ctx.fill(); // Bottom
  },

// ── UPDATED FLORALS ──────────────────────────────────────────────────

leaf(ctx, R, color, detail) {
    ctx.fillStyle = color;
    ctx.beginPath();
    
    // Start at the top tip
    ctx.moveTo(0, -R);
    
    // Curve down the right side to the bottom base
    ctx.bezierCurveTo(R * 0.8, -R * 0.5, R * 0.8, R * 0.5, 0, R * 0.9);
    
    // Curve up the left side back to the top tip
    ctx.bezierCurveTo(-R * 0.8, R * 0.5, -R * 0.8, -R * 0.5, 0, -R);
    
    ctx.closePath();
    ctx.fill();

    // Add a simple center vein and stem extending slightly past the base
    ctx.strokeStyle = detail || 'rgba(0,0,0,0.2)';
    ctx.lineWidth = R * 0.08;
    ctx.lineCap = 'round';
    
    ctx.beginPath();
    ctx.moveTo(0, -R * 0.8); // Vein starts just below the top tip
    ctx.lineTo(0, R * 1.2);  // Stem pops out the bottom
    ctx.stroke();
  },

clover(ctx, R, color, detail) {
    ctx.fillStyle = color;
    ctx.strokeStyle = detail || 'rgba(0,0,0,0.2)';
    ctx.lineWidth = R * 0.08;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';

    // Helper to draw a single heart-shaped leaf pointing outward
    const drawLeaf = (angle) => {
      ctx.save();
      ctx.rotate(angle);

      // Draw the heart petal
      ctx.beginPath();
      ctx.moveTo(0, R * 0.05); // Base of the leaf (near center)
      
      // Left outer curve up to the top-left lobe
      ctx.bezierCurveTo(-R * 0.7, -R * 0.1, -R * 0.7, -R * 0.8, -R * 0.25, -R * 0.8);
      // Dip into the center cleft
      ctx.quadraticCurveTo(0, -R * 0.8, 0, -R * 0.45);
      // Rise out of the center cleft to top-right lobe
      ctx.quadraticCurveTo(0, -R * 0.8, R * 0.25, -R * 0.8);
      // Right outer curve back down to the base
      ctx.bezierCurveTo(R * 0.7, -R * 0.8, R * 0.7, -R * 0.1, 0, R * 0.05);
      
      ctx.fill();
      ctx.stroke();

      // Draw the center vein inside the leaf
      ctx.beginPath();
      ctx.moveTo(0, R * 0.05);
      ctx.lineTo(0, -R * 0.35);
      ctx.stroke();

      ctx.restore();
    };

    // Draw the 3 leaves evenly spaced (0° is top, 120° is bottom-right, 240° is bottom-left)
    drawLeaf(0);
    drawLeaf(Math.PI * 2 / 3);
    drawLeaf(-Math.PI * 2 / 3);
  },

tulip(ctx, R, color, detail) {
    ctx.fillStyle = color;
    
    // Optional: adding a stroke of the same color with rounded joins 
    // forces the very edges of the canvas shape to anti-alias softly.
    ctx.strokeStyle = color;
    ctx.lineWidth = R * 0.05;
    ctx.lineJoin = 'round';
    ctx.lineCap = 'round';

    ctx.beginPath();
    
    // Start at the bottom center
    ctx.moveTo(0, R * 0.75);
    
    // Outer left wall up to the left petal tip
    ctx.bezierCurveTo(-R * 0.85, R * 0.75, -R * 0.8, -R * 0.2, -R * 0.55, -R * 0.45);
    
    // Softly round the left tip and dip smoothly into the left valley
    ctx.bezierCurveTo(-R * 0.45, -R * 0.6, -R * 0.35, -R * 0.15, -R * 0.25, -R * 0.2);
    
    // Create a perfectly rounded, plump center petal dome
    ctx.bezierCurveTo(-R * 0.1, -R * 0.85, R * 0.1, -R * 0.85, R * 0.25, -R * 0.2);
    
    // Gently rise out of the right valley and round off the right petal tip
    ctx.bezierCurveTo(R * 0.35, -R * 0.15, R * 0.45, -R * 0.6, R * 0.55, -R * 0.45);
    
    // Outer right wall down to the bottom center
    ctx.bezierCurveTo(R * 0.8, -R * 0.2, R * 0.85, R * 0.75, 0, R * 0.75);
    
    ctx.closePath();
    ctx.fill();
    ctx.stroke(); // Fills in any micro-sharpness on the path edges

    // Inner lines to visually separate the overlapping petals
    ctx.strokeStyle = detail || 'rgba(0,0,0,0.2)';
    ctx.lineWidth = R * 0.08;
    
    // Left inner sweeping line
    ctx.beginPath();
    ctx.moveTo(-R * 0.25, -R * 0.2);
    ctx.quadraticCurveTo(-R * 0.2, R * 0.4, 0, R * 0.65);
    ctx.stroke();

    // Right inner sweeping line
    ctx.beginPath();
    ctx.moveTo(R * 0.25, -R * 0.2);
    ctx.quadraticCurveTo(R * 0.2, R * 0.4, 0, R * 0.65);
    ctx.stroke();
  },
  // ── UPDATED BUGS ─────────────────────────────────────────────────────

  bee(ctx, R, color, detail) {
    // 1. Wings (drawn behind body, slightly transparent)
    ctx.fillStyle = detail;
    ctx.globalAlpha = 0.5;
    ctx.beginPath(); ctx.ellipse(-R * 0.25, -R * 0.5, R * 0.3, R * 0.6, -Math.PI / 5, 0, Math.PI * 2); ctx.fill();
    ctx.beginPath(); ctx.ellipse( R * 0.25, -R * 0.5, R * 0.3, R * 0.6,  Math.PI / 5, 0, Math.PI * 2); ctx.fill();
    ctx.globalAlpha = 1.0;

    // 2. Main Oval Body
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.ellipse(0, 0, R * 0.8, R * 0.55, 0, 0, Math.PI * 2);
    ctx.fill();

    // 3. Stripes (using a clipping mask so they stay perfectly inside the body)
    ctx.save();
    ctx.beginPath();
    ctx.ellipse(0, 0, R * 0.8, R * 0.55, 0, 0, Math.PI * 2);
    ctx.clip(); 
    ctx.fillStyle = detail;
    ctx.fillRect(-R * 0.4, -R, R * 0.2, R * 2); // Left stripe
    ctx.fillRect( R * 0.1, -R, R * 0.2, R * 2); // Right stripe
    ctx.restore();

    // 4. Head
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.arc(R * 0.75, 0, R * 0.3, 0, Math.PI * 2);
    ctx.fill();

    // 5. Eye, Antennae & Stinger
    ctx.fillStyle = detail;
    ctx.strokeStyle = detail;
    ctx.lineWidth = R * 0.08;
    ctx.lineCap = 'round';
    
    // Eye
    ctx.beginPath(); ctx.arc(R * 0.85, -R * 0.1, R * 0.08, 0, Math.PI * 2); ctx.fill(); 
    
    // Antennae
    ctx.beginPath(); ctx.moveTo(R * 0.75, -R * 0.25); ctx.lineTo(R * 0.7, -R * 0.6); ctx.stroke();
    ctx.beginPath(); ctx.moveTo(R * 0.9, -R * 0.15); ctx.lineTo(R * 1.1, -R * 0.4); ctx.stroke();
    
    // Stinger
    ctx.beginPath(); ctx.moveTo(-R * 0.75, -R * 0.1); ctx.lineTo(-R * 1.1, 0); ctx.lineTo(-R * 0.75, R * 0.1); ctx.fill();
  }
};