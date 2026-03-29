@extends('admin.includes.layout')
@section('title', 'Charms')

@section('content')

{{-- ── Page header ── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
  <div class="d-flex align-items-center gap-3">
    <a href="{{ route('admin.elements.index') }}" class="btn-ghost"><i data-lucide="arrow-left" style="width: 14px;"></i> Elements</a>
    <div>
      <h5 class="mb-0" style="font-family: var(--fh); font-size: 1.8rem;">Charms</h5>
      <small style="font-weight: 700; color: var(--grey-400);">Total: {{ $elements->total() }} pieces</small>
    </div>
  </div>
  <a href="{{ route('admin.elements.create', ['cat' => 'charms']) }}" class="btn-pink" style="background: var(--purple); box-shadow: 0 4px 12px rgba(168,85,247,0.2);">
    <i data-lucide="plus"></i> Add Charm
  </a>
</div>

<div class="ac-card">
  {{-- Filter bar --}}
  <form method="GET" action="{{ route('admin.elements.charms') }}">
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
      <a href="{{ route('admin.elements.charms') }}" class="btn-reset">Reset</a>
    </div>
  </form>

  <div class="p-4">
    @if($elements->isEmpty())
      <div class="text-center py-5 fw-bold text-muted">No charms found.</div>
    @else
      @php $grouped = $elements->groupBy('group'); @endphp
      @foreach($grouped as $groupName => $items)
        <div class="group-label" style="font-size: 0.7rem; font-weight: 900; letter-spacing: 0.1em; color: var(--purple-dk); background: var(--purple-bg); padding: 4px 12px; border-radius: 6px; display: inline-block; margin-bottom: 15px; margin-top: {{ !$loop->first ? '20px' : '0' }};">
          {{ strtoupper($groupName ?: 'No Group') }}
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 16px; margin-bottom: 30px;">
          @foreach($items as $el)
            <div class="ac-card {{ !$el->is_active ? 'inactive' : '' }}" style="overflow: hidden; text-align: center; position: relative;">
              <div style="position: absolute; top: 8px; right: 8px; z-index: 10;">
                <a href="{{ route('admin.elements.edit', $el) }}" style="color: var(--grey-400);"><i data-lucide="pencil" style="width: 14px;"></i></a>
              </div>

              {{-- Image Preview Section --}}
              <div style="aspect-ratio: 1; background: var(--grey-50); display: flex; align-items: center; justify-content: center; border-bottom: 1.5px solid var(--grey-200);">
                @if($el->img_path)
                  <img src="{{ asset('img/builder/' . $el->img_path) }}" style="max-width: 80%; max-height: 80%; object-fit: contain;"/>
                @else
                  <span style="font-size: 1.5rem;">✨</span>
                @endif
              </div>

              <div class="p-3">
                <div style="font-size: 0.85rem; font-weight: 800; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $el->name }}">{{ $el->name }}</div>
                <div style="font-size: 0.8rem; font-weight: 800; color: var(--purple-dk);">₱{{ $el->price }}</div>
                <div class="mt-2">
                   <span style="font-size: 0.65rem; font-weight: 900; text-transform: uppercase; color: {{ $el->stock === 'in' ? 'var(--lime-dk)' : ($el->stock === 'low' ? '#D97706' : '#DC2626') }};">
                     {{ $el->stock }}
                   </span>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endforeach
    @endif
  </div>
</div>
@endsection