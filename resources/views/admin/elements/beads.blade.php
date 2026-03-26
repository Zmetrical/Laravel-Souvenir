@extends('admin.includes.layout')
@section('title', 'Beads')

@section('content')

{{-- ── Page header ──────────────────────────────────────────────────────── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
  <div class="d-flex align-items-center gap-3">
    <a href="{{ route('admin.elements.index') }}"
       style="color:#999;text-decoration:none;font-size:.85rem;">
      ← Elements
    </a>
    <span style="color:#DDD;">/</span>
    <div>
      <h5 class="mb-0 fw-bold" style="color:#2D2D3A;">Beads</h5>
      <small class="text-muted">{{ $elements->total() }} total</small>
    </div>
  </div>
  <a href="{{ route('admin.elements.create', ['cat' => 'beads']) }}"
     class="btn btn-sm fw-semibold"
     style="background:#FF5FA0;color:#fff;border-radius:8px;padding:7px 18px;">
    + Add Bead
  </a>
</div>

{{-- ── Main card ─────────────────────────────────────────────────────────── --}}
<div class="ac-card">

  {{-- Filter bar --}}
  <form method="GET" action="{{ route('admin.elements.beads') }}">
    <div class="filter-bar">
      <input type="text" name="search" value="{{ request('search') }}"
             placeholder="Search beads..." style="width:180px;"/>

      <select name="group" style="width:150px;">
        <option value="">All Groups</option>
        @foreach($groups as $g)
          <option value="{{ $g }}" {{ request('group') === $g ? 'selected' : '' }}>{{ $g }}</option>
        @endforeach
      </select>

      <select name="stock" style="width:130px;">
        <option value="">All Stock</option>
        <option value="in"  {{ request('stock') === 'in'  ? 'selected' : '' }}>In Stock</option>
        <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low Stock</option>
        <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>Out of Stock</option>
      </select>

      <button type="submit" class="btn-filter">Search</button>
      <a href="{{ route('admin.elements.beads') }}" class="btn-reset">Reset</a>

      <span class="ms-auto" style="font-size:.75rem;color:#AAA;">
        Showing {{ $elements->firstItem() }}–{{ $elements->lastItem() }} of {{ $elements->total() }}
      </span>
    </div>
  </form>

  {{-- Bead grid — grouped by group ─────────────────────────────────────── --}}
  @if($elements->isEmpty())
    <div class="text-center py-5 text-muted">
      No beads found. <a href="{{ route('admin.elements.create', ['cat'=>'beads']) }}">Add one →</a>
    </div>
  @else
    @php
      $grouped = $elements->groupBy('group');
    @endphp

    <div class="el-grid">
      @foreach($grouped as $groupName => $items)

        {{-- Group label --}}
        <div class="group-label">{{ $groupName ?: 'Ungrouped' }}</div>

        @foreach($items as $el)
        <div class="el-card {{ !$el->is_active ? 'inactive' : '' }}">

          @if(!$el->is_active)
            <div class="inactive-badge">off</div>
          @endif

          {{-- Hover actions --}}
          <div class="el-actions">
            <a href="{{ route('admin.elements.edit', $el) }}" class="btn-edit" title="Edit">
              <i data-lucide="pencil" style="width:11px;height:11px;"></i>
            </a>
            <form action="{{ route('admin.elements.destroy', $el) }}" method="POST"
                  onsubmit="return confirm('Delete {{ addslashes($el->name) }}?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-delete" title="Delete">
                <i data-lucide="trash-2" style="width:11px;height:11px;"></i>
              </button>
            </form>
          </div>

          {{-- ✦ Canvas shape preview instead of plain swatch ─────────── --}}
          <canvas
            class="shape-canvas"
            width="52" height="52"
            data-shape="{{ $el->shape ?? 'round' }}"
            data-color="{{ $el->color ?? '#F9B8CF' }}"
            data-detail="{{ $el->detail_color ?? '#C0136A' }}"
            data-small="{{ $el->is_small ? '1' : '0' }}"
            style="display:block; margin:0 auto 8px; border-radius:4px;">
          </canvas>

          <div class="el-name" title="{{ $el->name }}">{{ $el->name }}</div>
          <div class="el-price">₱{{ $el->price }}</div>

          {{-- Stock badge --}}
          <div class="mt-1">
            <span class="badge stock-{{ $el->stock }}" style="font-size:.62rem;">
              {{ ucfirst($el->stock) }}
            </span>
            @if($el->is_small)
              <span class="badge" style="font-size:.6rem;background:#F3F4F6;color:#6B7280;">sm</span>
            @endif
          </div>

        </div>
        @endforeach

      @endforeach
    </div>

    {{-- Pagination --}}
    @if($elements->hasPages())
    <div class="px-4 pb-4 pt-2 d-flex justify-content-center">
      {{ $elements->links() }}
    </div>
    @endif

  @endif

</div>

@endsection

@push('scripts')
<script>
/* ─── Shape drawing helpers (shared with _form.blade.php) ─────────────── */
function roundRect(ctx, x, y, w, h, r) {
  ctx.beginPath();
  ctx.moveTo(x+r, y); ctx.lineTo(x+w-r, y); ctx.quadraticCurveTo(x+w, y, x+w, y+r);
  ctx.lineTo(x+w, y+h-r); ctx.quadraticCurveTo(x+w, y+h, x+w-r, y+h);
  ctx.lineTo(x+r, y+h); ctx.quadraticCurveTo(x, y+h, x, y+h-r);
  ctx.lineTo(x, y+r); ctx.quadraticCurveTo(x, y, x+r, y); ctx.closePath();
}

function drawShape(ctx, shape, R, color, detail) {
  ctx.fillStyle = color;

  if (!shape || shape === 'round') {
    ctx.beginPath(); ctx.arc(0, 0, R, 0, Math.PI*2); ctx.fill();

  } else if (shape === 'pearl') {
    /* Pearl: circle with a subtle sheen */
    const grad = ctx.createRadialGradient(-R*.28, -R*.28, R*.05, 0, 0, R);
    grad.addColorStop(0,   lighten(color, 48));
    grad.addColorStop(0.5, color);
    grad.addColorStop(1,   darken(color, 18));
    ctx.fillStyle = grad;
    ctx.beginPath(); ctx.arc(0, 0, R, 0, Math.PI*2); ctx.fill();

  } else if (shape === 'ellipse') {
    ctx.beginPath(); ctx.ellipse(0, 0, R*1.55, R*0.78, 0, 0, Math.PI*2); ctx.fill();

  } else if (shape === 'tube') {
    ctx.beginPath(); ctx.ellipse(0, 0, R*0.7, R*1.58, 0, 0, Math.PI*2); ctx.fill();

  } else if (shape === 'faceted') {
    ctx.beginPath();
    for (let i = 0; i < 6; i++)
      ctx.lineTo(Math.cos(i*Math.PI/3)*R, Math.sin(i*Math.PI/3)*R);
    ctx.closePath(); ctx.fill();
    /* facet lines */
    ctx.strokeStyle = darken(color, 14); ctx.lineWidth = 0.8; ctx.globalAlpha = .5;
    for (let i = 0; i < 6; i++) {
      ctx.beginPath(); ctx.moveTo(0,0);
      ctx.lineTo(Math.cos(i*Math.PI/3)*R, Math.sin(i*Math.PI/3)*R);
      ctx.stroke();
    }
    ctx.globalAlpha = 1;

  } else if (shape === 'heart') {
    ctx.beginPath();
    ctx.moveTo(0, R*0.3);
    ctx.bezierCurveTo( R, -R*1.2,  R*2.2, R*0.4, 0, R);
    ctx.bezierCurveTo(-R*2.2, R*0.4, -R, -R*1.2, 0, R*0.3);
    ctx.fill();

  } else if (shape === 'star') {
    ctx.beginPath();
    for (let i = 0; i < 10; i++) {
      const r = i%2===0 ? R : R*0.44;
      ctx.lineTo(Math.cos(i*Math.PI/5 - Math.PI/2)*r, Math.sin(i*Math.PI/5 - Math.PI/2)*r);
    }
    ctx.closePath(); ctx.fill();

  } else if (shape === 'moon') {
    ctx.beginPath();
    ctx.arc(0, 0, R, Math.PI*0.15, Math.PI*1.85, true);
    ctx.quadraticCurveTo(-R*0.4, 0, Math.cos(Math.PI*0.15)*R, Math.sin(Math.PI*0.15)*R);
    ctx.fill();

  } else if (shape === 'flower') {
    for (let i = 0; i < 5; i++) {
      const a = i * Math.PI*2/5 - Math.PI/2;
      ctx.beginPath();
      ctx.ellipse(Math.cos(a)*R*.55, Math.sin(a)*R*.55, R*.42, R*.26, a, 0, Math.PI*2);
      ctx.fill();
    }
    ctx.fillStyle = detail;
    ctx.beginPath(); ctx.arc(0, 0, R*.28, 0, Math.PI*2); ctx.fill();

  } else if (shape === 'rainbow') {
    ctx.beginPath();
    ctx.arc(0, R*.2, R, Math.PI, 0); ctx.fill();
    ctx.fillStyle = 'white';
    ctx.beginPath();
    ctx.arc(0, R*.2, R*.55, Math.PI, 0); ctx.fill();

  } else if (shape === 'butterfly') {
    /* two wing pairs */
    [[-.7,-1.2,.1,.2],[ .7,-1.2,-.1,.2],
     [-.7, .8, .1,-.2],[ .7, .8,-.1,-.2]].forEach(([cx1,cy1,cx2,cy2]) => {
      ctx.beginPath(); ctx.moveTo(0,0);
      ctx.bezierCurveTo(cx1*R,cy1*R,cx2*R,cy2*R,0,0); ctx.fill();
    });

  } else if (shape === 'bow') {
    ctx.beginPath(); ctx.moveTo(0, 0);
    ctx.bezierCurveTo(-R*1.4,-R*0.9,-R*1.6,R*0.4,-R*0.2,R*0.15);
    ctx.closePath(); ctx.fill();
    ctx.beginPath(); ctx.moveTo(0, 0);
    ctx.bezierCurveTo( R*1.4,-R*0.9, R*1.6,R*0.4, R*0.2,R*0.15);
    ctx.closePath(); ctx.fill();
    ctx.fillStyle = detail;
    ctx.beginPath(); ctx.arc(0, R*0.06, R*0.28, 0, Math.PI*2); ctx.fill();

  } else if (shape && shape.startsWith('cube')) {
    drawCube(ctx, shape, R, color, detail);

  } else {
    /* fallback – round */
    ctx.beginPath(); ctx.arc(0, 0, R, 0, Math.PI*2); ctx.fill();
  }
}

function drawCube(ctx, shape, R, color, detail) {
  const s = R * 1.75;
  ctx.fillStyle = color;
  ctx.beginPath(); roundRect(ctx, -s/2, -s/2, s, s, s*0.18); ctx.fill();

  /* top-face highlight */
  ctx.fillStyle = 'rgba(255,255,255,.18)';
  ctx.beginPath(); roundRect(ctx, -s/2+2, -s/2+2, s-4, s*.42, s*0.12); ctx.fill();

  if (shape === 'cube') return;

  ctx.fillStyle = detail;

  if (shape === 'cube-heart') {
    const hr = R*.52;
    ctx.beginPath();
    ctx.moveTo(0, hr*.3);
    ctx.bezierCurveTo( hr, -hr*1.2,  hr*2.2, hr*.4, 0, hr);
    ctx.bezierCurveTo(-hr*2.2, hr*.4, -hr, -hr*1.2, 0, hr*.3);
    ctx.fill();

  } else if (shape === 'cube-star') {
    const sr = R*.55;
    ctx.beginPath();
    for (let i = 0; i < 10; i++) {
      const r = i%2===0 ? sr : sr*.44;
      ctx.lineTo(Math.cos(i*Math.PI/5 - Math.PI/2)*r, Math.sin(i*Math.PI/5 - Math.PI/2)*r);
    }
    ctx.closePath(); ctx.fill();

  } else if (shape === 'cube-checker') {
    ctx.save();
    ctx.beginPath(); roundRect(ctx, -s/2, -s/2, s, s, s*.18); ctx.clip();
    const cs = s/4;
    for (let row = 0; row < 4; row++)
      for (let col = 0; col < 4; col++)
        if ((row+col)%2===0)
          ctx.fillRect(-s/2+col*cs, -s/2+row*cs, cs, cs);
    ctx.restore();

  } else if (shape === 'cube-smile') {
    ctx.beginPath(); ctx.arc(-R*.33, -R*.18, R*.12, 0, Math.PI*2); ctx.fill();
    ctx.beginPath(); ctx.arc( R*.33, -R*.18, R*.12, 0, Math.PI*2); ctx.fill();
    ctx.strokeStyle = detail; ctx.lineWidth = R*.13; ctx.lineCap = 'round';
    ctx.beginPath(); ctx.arc(0, R*.12, R*.36, 0.2, Math.PI-0.2); ctx.stroke();

  } else {
    const diceMap = {
      'cube-dice1': [[0,0]],
      'cube-dice2': [[-1,1],[1,-1]],
      'cube-dice3': [[-1,1],[0,0],[1,-1]],
      'cube-dice4': [[-1,-1],[1,-1],[-1,1],[1,1]],
      'cube-dice5': [[-1,-1],[1,-1],[0,0],[-1,1],[1,1]],
      'cube-dice6': [[-1,-1],[1,-1],[-1,0],[1,0],[-1,1],[1,1]],
    };
    const dots = diceMap[shape] || [];
    const h = (s/2)*.36, dr = R*.16;
    dots.forEach(([dx,dy]) => {
      ctx.beginPath(); ctx.arc(dx*h, dy*h, dr, 0, Math.PI*2); ctx.fill();
    });
  }
}

/* ─── Colour helpers ─────────────────────────────────────────────────────── */
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

/* ─── Render all canvases on the page ────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('canvas.shape-canvas').forEach(canvas => {
    const shape  = canvas.dataset.shape  || 'round';
    const color  = canvas.dataset.color  || '#F9B8CF';
    const detail = canvas.dataset.detail || '#C0136A';
    const small  = canvas.dataset.small  === '1';

    const w = canvas.width;
    const h = canvas.height;
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, w, h);
    ctx.imageSmoothingEnabled = true;

    /* soft drop shadow */
    ctx.shadowColor   = 'rgba(0,0,0,.14)';
    ctx.shadowBlur    = 4;
    ctx.shadowOffsetY = 2;

    ctx.save();
    ctx.translate(w/2, h/2);
    const R = small ? w*.24 : w*.36;
    drawShape(ctx, shape, R, color, detail);
    ctx.restore();
  });
});
</script>
@endpush