@extends('admin.includes.layout')
@section('title', 'Beads')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
  <div class="d-flex align-items-center gap-3">
    <a href="{{ route('admin.elements.index') }}" class="btn-ghost"><i data-lucide="arrow-left" style="width: 14px;"></i> Elements</a>
    <div>
      <h5 class="mb-0" style="font-family: var(--fh); font-size: 1.8rem;">Beads</h5>
      <small style="font-weight: 700; color: var(--grey-400);">Total: {{ $elements->total() }} pieces</small>
    </div>
  </div>
  <a href="{{ route('admin.elements.create', ['cat' => 'beads']) }}" class="btn-pink">
    <i data-lucide="plus"></i> Add Bead
  </a>
</div>

<div class="ac-card">
  <form method="GET" action="{{ route('admin.elements.beads') }}">
    <div class="filter-bar">
      <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name..."/>
      
      <select name="group" class="form-select">
        <option value="">All Groups</option>
        @foreach($groups as $g)
          <option value="{{ $g }}" {{ request('group') === $g ? 'selected' : '' }}>{{ $g }}</option>
        @endforeach
      </select>

      <select name="stock" class="form-select">
        <option value="">All Stock</option>
        <option value="in" {{ request('stock') === 'in' ? 'selected' : '' }}>In Stock</option>
        <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low Stock</option>
        <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>Out of Stock</option>
      </select>

      <button type="submit" class="btn-filter">Search</button>
      <a href="{{ route('admin.elements.beads') }}" class="btn-reset">Reset</a>
    </div>
  </form>

  <div class="p-4">
    @php $grouped = $elements->groupBy('group'); @endphp
    @foreach($grouped as $groupName => $items)
      <div class="group-label" style="font-size: 0.7rem; font-weight: 900; letter-spacing: 0.1em; color: var(--pink-dk); background: var(--pink-bg); padding: 4px 12px; border-radius: 6px; display: inline-block; margin-bottom: 15px; margin-top: {{ !$loop->first ? '20px' : '0' }};">
        {{ strtoupper($groupName ?: 'Ungrouped') }}
      </div>
      
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 16px;">
        @foreach($items as $el)
          <div class="ac-card {{ !$el->is_active ? 'inactive' : '' }}" style="padding: 16px; text-align: center; position: relative;">
            <div style="position: absolute; top: 8px; right: 8px;">
              <a href="{{ route('admin.elements.edit', $el) }}" style="color: var(--grey-400);"><i data-lucide="pencil" style="width: 14px;"></i></a>
            </div>

            {{-- ── THE CANVAS ── --}}
            <canvas class="shape-canvas" width="52" height="52" 
                    data-shape="{{ $el->shape ?? 'round' }}" 
                    data-color="{{ $el->color ?? '#F9B8CF' }}" 
                    data-detail="{{ $el->detail_color ?? '#C0136A' }}" 
                    data-small="{{ $el->is_small ? '1' : '0' }}" 
                    style="display: block; margin: 0 auto 12px; width: 52px; height: 52px;">
            </canvas>

            <div style="font-size: 0.85rem; font-weight: 800; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $el->name }}</div>
            <div style="font-size: 0.8rem; font-weight: 800; color: var(--pink);">₱{{ $el->price }}</div>
            <div class="mt-2">
               <span style="font-size: 0.65rem; font-weight: 900; text-transform: uppercase; color: {{ $el->stock === 'in' ? 'var(--lime-dk)' : ($el->stock === 'low' ? '#D97706' : '#DC2626') }};">
                 {{ $el->stock }}
               </span>
            </div>
          </div>
        @endforeach
      </div>
    @endforeach
  </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/shapes.js'])
<script>
  // Force a redraw once the script is loaded
  document.addEventListener('artshape:ready', () => {
    if(window.ArtshapeRenderer) window.ArtshapeRenderer.renderAll();
  });
</script>
@endpush