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

  {{-- Bead grid — grouped ───────────────────────────────────────────────── --}}
  @if($elements->isEmpty())
    <div class="text-center py-5 text-muted">
      No beads found. <a href="{{ route('admin.elements.create', ['cat'=>'beads']) }}">Add one →</a>
    </div>
  @else
    @php $grouped = $elements->groupBy('group'); @endphp

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

          {{-- Shape canvas — rendered by shared ArtshapeRenderer --}}
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

    @if($elements->hasPages())
    <div class="px-4 pb-4 pt-2 d-flex justify-content-center">
      {{ $elements->links() }}
    </div>
    @endif

  @endif

</div>

@endsection

@push('scripts')
{{-- Unified renderer handles all canvas.shape-canvas elements automatically --}}
<script src="{{ asset('js/builder/canvas/shaperenderer.js') }}"></script>
@endpush