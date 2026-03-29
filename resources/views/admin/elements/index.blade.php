@extends('admin.includes.layout')
@section('title', 'All Elements')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h5 class="mb-0" style="font-family: var(--fh); font-size: 2rem; color: var(--ink); letter-spacing: 1px;">Element Inventory</h5>
    <small style="font-size: 0.95rem; font-weight: 700; color: var(--ink-md);">Full list of items available in the builder.</small>
  </div>
  <a href="{{ route('admin.elements.create') }}" class="btn-pink">
    <i data-lucide="plus"></i> Add Element
  </a>
</div>

{{-- ── Filters ─────────────────────────────────────────────────────────── --}}
<div class="ac-card mb-4">
  <form method="GET" action="{{ route('admin.elements.index') }}">
    <div class="filter-bar">
      <div class="d-flex align-items-center gap-2" style="flex: 1;">
        <i data-lucide="search" style="width:16px; color: var(--grey-400);"></i>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 bg-transparent" placeholder="Search by name..."/>
      </div>
      
      <select name="category" class="form-select" style="width: 180px;">
        <option value="">All Categories</option>
        <option value="beads" {{ request('category') === 'beads' ? 'selected' : '' }}>Beads</option>
        <option value="figures" {{ request('category') === 'figures' ? 'selected' : '' }}>Figures</option>
        <option value="charms" {{ request('category') === 'charms' ? 'selected' : '' }}>Charms</option>
      </select>

      <button type="submit" class="btn-ghost" style="background: var(--ink); color: #fff; border-color: var(--ink);">Search</button>
      <a href="{{ route('admin.elements.index') }}" class="btn-ghost">Reset</a>
    </div>
  </form>
</div>

{{-- ── Table ────────────────────────────────────────────────────────────── --}}
<div class="ac-card">
  <div class="table-responsive">
    <table class="table table-borderless align-middle mb-0" style="font-size: 0.9rem; font-weight: 700;">
      <thead style="background: var(--offwhite); border-bottom: 1.5px solid var(--grey-200); font-size: 0.75rem; text-transform: uppercase; color: var(--ink-md); letter-spacing: 0.05em;">
        <tr>
          <th class="ps-4 py-3">Preview</th>
          <th class="py-3">Name / Slug</th>
          <th class="py-3">Category</th>
          <th class="py-3">Price</th>
          <th class="py-3">Stock</th>
          <th class="py-3">Status</th>
          <th class="py-3 text-end pe-4">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($elements as $el)
        <tr style="border-bottom: 1px solid var(--grey-100);">
          <td class="ps-4 py-2">
            @if($el->category === 'charms' && $el->img_path)
              <img src="{{ asset('img/builder/' . $el->img_path) }}" style="width:40px; height:40px; object-fit:contain; border-radius:8px; background:var(--white); border:1.5px solid var(--grey-200); padding:2px;"/>
            @else
              {{-- Unified Shape Canvas for consistency --}}
              <canvas class="shape-canvas" width="44" height="44" 
                      data-shape="{{ $el->shape ?? 'round' }}" 
                      data-color="{{ $el->color ?? '#F9B8CF' }}" 
                      data-detail="{{ $el->detail_color ?? '#C0136A' }}" 
                      data-small="{{ $el->is_small ? '1' : '0' }}" 
                      style="display: block; width: 44px; height: 44px;">
              </canvas>
            @endif
          </td>

          <td class="py-2">
            <div style="color: var(--ink); font-weight: 800;">{{ $el->name }}</div>
            <div style="font-size: 0.7rem; font-family: monospace; color: var(--grey-400);">{{ $el->slug }}</div>
          </td>

          <td class="py-2">
            @php
              $badge = match($el->category) {
                'beads'   => ['bg' => 'var(--pink-bg)', 'text' => 'var(--pink-dk)'],
                'figures' => ['bg' => 'var(--teal-bg)', 'text' => 'var(--teal-dk)'],
                'charms'  => ['bg' => 'var(--purple-bg)', 'text' => 'var(--purple-dk)'],
                default   => ['bg' => 'var(--grey-100)', 'text' => 'var(--ink-md)'],
              };
            @endphp
            <span style="background: {{ $badge['bg'] }}; color: {{ $badge['text'] }}; padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 900; text-transform: uppercase;">
              {{ $el->category }}
            </span>
          </td>

          <td class="py-2" style="color: var(--pink); font-weight: 800;">₱{{ $el->price }}</td>

          <td class="py-2">
             @php $sColors = ['in' => 'var(--lime-dk)', 'low' => '#D97706', 'out' => '#DC2626']; @endphp
             <span style="font-size: 0.7rem; font-weight: 900; text-transform: uppercase; color: {{ $sColors[$el->stock] ?? 'var(--ink-md)' }};">
               {{ $el->stock }}
             </span>
          </td>

          <td class="py-2">
            @if($el->is_active)
              <span style="color: var(--lime-dk); font-size: 0.7rem; font-weight: 900; text-transform: uppercase; display: flex; align-items: center; gap: 4px;">
                <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></span> Live
              </span>
            @else
              <span style="color: var(--grey-400); font-size: 0.7rem; font-weight: 900; text-transform: uppercase; display: flex; align-items: center; gap: 4px;">
                <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></span> Hidden
              </span>
            @endif
          </td>

          <td class="py-2 text-end pe-4">
            <a href="{{ route('admin.elements.edit', $el) }}" class="btn-ghost" style="padding: 6px 12px; font-size: 0.8rem;">Edit</a>
            <form action="{{ route('admin.elements.destroy', $el) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this element?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-danger-ghost" style="padding: 6px 12px; font-size: 0.8rem; border-radius: 8px;">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center py-5 fw-bold text-muted">No elements matching your filters.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($elements->hasPages())
    <div class="p-3 border-top d-flex justify-content-center">{{ $elements->links() }}</div>
  @endif
</div>

@endsection

@push('scripts')
@vite(['resources/js/shapes.js'])
<script>
  document.addEventListener('artshape:ready', () => {
    if(window.ArtshapeRenderer) window.ArtshapeRenderer.renderAll();
  });
</script>
@endpush