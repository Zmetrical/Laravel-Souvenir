@extends('admin.includes.layout')
@section('title', 'Charms')

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
      <h5 class="mb-0 fw-bold" style="color:#2D2D3A;">Charms</h5>
      <small class="text-muted">{{ $elements->total() }} total</small>
    </div>
  </div>
  <a href="{{ route('admin.elements.create', ['cat' => 'charms']) }}"
     class="btn btn-sm fw-semibold"
     style="background:#8B5CF6;color:#fff;border-radius:8px;padding:7px 18px;">
    + Add Charm
  </a>
</div>

{{-- ── Main card ─────────────────────────────────────────────────────────── --}}
<div class="ac-card">

  {{-- Filter bar --}}
  <form method="GET" action="{{ route('admin.elements.charms') }}">
    <div class="filter-bar">
      <input type="text" name="search" value="{{ request('search') }}"
             placeholder="Search charms..." style="width:180px;"/>

      <select name="series" style="width:160px;">
        <option value="">All Series</option>
        @foreach($seriesList as $s)
          <option value="{{ $s->id }}" {{ request('series') == $s->id ? 'selected' : '' }}>
            {{ $s->name }}
          </option>
        @endforeach
      </select>

      <select name="stock" style="width:130px;">
        <option value="">All Stock</option>
        <option value="in"  {{ request('stock') === 'in'  ? 'selected' : '' }}>In Stock</option>
        <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low Stock</option>
        <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>Out of Stock</option>
      </select>

      <button type="submit" class="btn-filter">Search</button>
      <a href="{{ route('admin.elements.charms') }}" class="btn-reset">Reset</a>

      <span class="ms-auto" style="font-size:.75rem;color:#AAA;">
        Showing {{ $elements->firstItem() }}–{{ $elements->lastItem() }} of {{ $elements->total() }}
      </span>
    </div>
  </form>

  {{-- Charm image grid — grouped by series ─────────────────────────────── --}}
  @if($elements->isEmpty())
    <div class="text-center py-5 text-muted">
      No charms found. <a href="{{ route('admin.elements.create', ['cat'=>'charms']) }}">Add one →</a>
    </div>
  @else
    @php
      $grouped = $elements->groupBy(fn($el) => $el->series?->name ?? 'No Series');
    @endphp

    @foreach($grouped as $seriesName => $items)

      {{-- Series header --}}
      <div style="padding: 14px 16px 4px;
                  font-size:.72rem; font-weight:700; text-transform:uppercase;
                  letter-spacing:.08em; color:#999;
                  border-top: 1px solid #EEEDF3;">
        {{ $seriesName }}
        <span style="font-weight:400;color:#CCC;margin-left:6px;">{{ $items->count() }}</span>
      </div>

      <div class="charm-grid" style="padding-top:8px;">
        @foreach($items as $el)
        <div class="charm-card {{ !$el->is_active ? 'inactive' : '' }}">

          @if(!$el->is_active)
            <div class="inactive-badge" style="position:absolute;top:5px;left:5px;z-index:2;
                  font-size:.6rem;background:#374151;color:#fff;
                  border-radius:4px;padding:1px 5px;">off</div>
          @endif

          {{-- Hover actions --}}
          <div class="el-actions" style="z-index:2;">
            <a href="{{ route('admin.elements.edit', $el) }}" class="btn-edit" title="Edit">
              <i data-lucide="pencil" style="width:12px;height:12px;"></i>
            </a>
            <form action="{{ route('admin.elements.destroy', $el) }}" method="POST"
                  onsubmit="return confirm('Delete {{ addslashes($el->name) }}?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-delete" title="Delete">
                <i data-lucide="trash-2" style="width:12px;height:12px;"></i>
              </button>
            </form>
          </div>

          {{-- Thumbnail --}}
          <div class="thumb">
            @if($el->img_path)
              <img src="{{ asset('img/builder/' . $el->img_path) }}" alt="{{ $el->name }}"/>
            @else
              <span class="thumb-placeholder">✨</span>
            @endif
          </div>

          <div class="charm-info">
            <div class="charm-name" title="{{ $el->name }}">{{ $el->name }}</div>
            <div class="charm-series">{{ $el->series?->name ?? '—' }}</div>
            <div class="charm-price">₱{{ $el->price }}</div>
            <div class="mt-1">
              <span class="badge stock-{{ $el->stock }}" style="font-size:.6rem;">
                {{ ucfirst($el->stock) }}
              </span>
              @if($el->is_large)
                <span class="badge" style="font-size:.6rem;background:#F3F4F6;color:#6B7280;">lg</span>
              @endif
            </div>
          </div>

        </div>
        @endforeach
      </div>

    @endforeach

    @if($elements->hasPages())
    <div class="px-4 pb-4 pt-2 d-flex justify-content-center">
      {{ $elements->links() }}
    </div>
    @endif

  @endif

</div>

@endsection