@extends('admin.includes.layout')
@section('title', 'Figures')

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
      <h5 class="mb-0 fw-bold" style="color:#2D2D3A;">Figures</h5>
      <small class="text-muted">{{ $elements->total() }} total</small>
    </div>
  </div>
  <a href="{{ route('admin.elements.create', ['cat' => 'figures']) }}"
     class="btn btn-sm fw-semibold"
     style="background:#3B82F6;color:#fff;border-radius:8px;padding:7px 18px;">
    + Add Figure
  </a>
</div>

{{-- ── Main card ─────────────────────────────────────────────────────────── --}}
<div class="ac-card">

  {{-- Filter bar --}}
  <form method="GET" action="{{ route('admin.elements.figures') }}">
    <div class="filter-bar">
      <input type="text" name="search" value="{{ request('search') }}"
             placeholder="Search figures..." style="width:180px;"/>

      <select name="group" style="width:160px;">
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
      <a href="{{ route('admin.elements.figures') }}" class="btn-reset">Reset</a>

      <span class="ms-auto" style="font-size:.75rem;color:#AAA;">
        Showing {{ $elements->firstItem() }}–{{ $elements->lastItem() }} of {{ $elements->total() }}
      </span>
    </div>
  </form>

  {{-- Figure grid — grouped ─────────────────────────────────────────────── --}}
  @if($elements->isEmpty())
    <div class="text-center py-5 text-muted">
      No figures found. <a href="{{ route('admin.elements.create', ['cat'=>'figures']) }}">Add one →</a>
    </div>
  @else
    @php
      $grouped = $elements->groupBy('group');
    @endphp

    <div class="el-grid">
      @foreach($grouped as $groupName => $items)

        <div class="group-label">{{ $groupName ?: 'Ungrouped' }}</div>

        @foreach($items as $el)
        <div class="el-card {{ !$el->is_active ? 'inactive' : '' }}">

          @if(!$el->is_active)
            <div class="inactive-badge">off</div>
          @endif

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

          {{-- ✦ Canvas shape preview — renders actual cube/figure shape ── --}}
          <canvas
            class="shape-canvas"
            width="52" height="52"
            data-shape="{{ $el->shape ?? 'cube' }}"
            data-color="{{ $el->color ?? '#93C5FD' }}"
            data-detail="{{ $el->detail_color ?? '#1D4ED8' }}"
            style="display:block; margin:0 auto 8px; border-radius:4px;">
          </canvas>

          <div class="el-name" title="{{ $el->name }}">{{ $el->name }}</div>
          <div class="el-price">₱{{ $el->price }}</div>

          <div class="mt-1">
            <span class="badge stock-{{ $el->stock }}" style="font-size:.62rem;">
              {{ ucfirst($el->stock) }}
            </span>
            @if($el->shape)
              <span class="badge"
                    style="font-size:.6rem;background:#F3F4F6;color:#6B7280;
                           font-family:monospace;">
                {{ $el->shape }}
              </span>
            @endif
          </div>

        </div>
        @endforeach

      @endforeach
    </div>

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
/* ─── Shape drawing helpers ───────────────────────────────────────────────── */
function roundRect(ctx, x, y, w, h, r) {
  ctx.beginPath();
  ctx.moveTo(x+r, y); ctx.lineTo(x+w-r, y); ctx.quadraticCurveTo(x+w, y, x+w, y+r);
  ctx.lineTo(x+w, y+h-r); ctx.quadraticCurveTo(x+w, y+h, x+w-r, y+h);
  ctx.lineTo(x+r, y+h); ctx.quadraticCurveTo(x, y+h, x, y+h-r);
  ctx.lineTo(x, y+r); ctx.quadraticCurveTo(x, y, x+r, y); ctx.closePath();
}

function drawCube(ctx, shape, R, color, detail) {
  const s = R * 1.75;

  /* Base cube face */
  ctx.fillStyle = color;
  ctx.beginPath(); roundRect(ctx, -s/2, -s/2, s, s, s*0.18); ctx.fill();

  /* Top-face highlight strip */
  ctx.fillStyle = 'rgba(255,255,255,.20)';
  ctx.beginPath(); roundRect(ctx, -s/2+2, -s/2+2, s-4, s*.40, s*0.12); ctx.fill();

  /* Bottom-edge shadow strip */
  ctx.fillStyle = 'rgba(0,0,0,.10)';
  ctx.beginPath(); roundRect(ctx, -s/2+2, s/2-s*.22, s-4, s*.20, s*0.10); ctx.fill();

  if (shape === 'cube') return;

  /* Detail / decoration */
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
    /* eyes */
    ctx.beginPath(); ctx.arc(-R*.32, -R*.18, R*.11, 0, Math.PI*2); ctx.fill();
    ctx.beginPath(); ctx.arc( R*.32, -R*.18, R*.11, 0, Math.PI*2); ctx.fill();
    /* mouth */
    ctx.lineWidth = R*.13; ctx.lineCap = 'round';
    ctx.beginPath(); ctx.arc(0, R*.10, R*.34, 0.22, Math.PI-0.22); ctx.stroke();

  } else {
    /* Dice dots */
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

/* ─── Render every canvas on page load ───────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('canvas.shape-canvas').forEach(canvas => {
    const shape  = canvas.dataset.shape  || 'cube';
    const color  = canvas.dataset.color  || '#93C5FD';
    const detail = canvas.dataset.detail || '#1D4ED8';

    const w = canvas.width, h = canvas.height;
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, w, h);
    ctx.imageSmoothingEnabled = true;

    /* drop shadow */
    ctx.shadowColor   = 'rgba(0,0,0,.16)';
    ctx.shadowBlur    = 5;
    ctx.shadowOffsetY = 2;

    ctx.save();
    ctx.translate(w/2, h/2);
    drawCube(ctx, shape, w * .36, color, detail);
    ctx.restore();
  });
});
</script>
@endpush