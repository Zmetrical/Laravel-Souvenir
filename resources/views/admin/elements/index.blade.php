@extends('admin.includes.layout')
@section('title', 'Elements')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h5 class="mb-0 fw-bold" style="color:#2D2D3A;">Element Library</h5>
    <small class="text-muted">Manage beads, figures, and charms used in the builder</small>
  </div>
  <a href="{{ route('admin.elements.create') }}" class="btn btn-sm fw-semibold"
     style="background:#FF5FA0;color:#fff;border-radius:8px;padding:8px 18px;">
    + Add Element
  </a>
</div>

{{-- ── Filters ─────────────────────────────────────────────────────────── --}}
<div class="ac-card mb-4">
  <div class="ac-card-header">
    <i data-lucide="filter" style="width:15px;height:15px;"></i> Filter & Search
  </div>
  <div class="p-3">
    <form method="GET" action="{{ route('admin.elements.index') }}" class="row g-2 align-items-end">
      <div class="col-md-4">
        <label class="form-label small fw-semibold mb-1">Search</label>
        <input type="text" name="search" value="{{ request('search') }}"
               class="form-control form-control-sm" placeholder="Element name..."/>
      </div>
      <div class="col-md-3">
        <label class="form-label small fw-semibold mb-1">Category</label>
        <select name="category" class="form-select form-select-sm">
          <option value="">All Categories</option>
          <option value="beads"   {{ request('category') === 'beads'   ? 'selected' : '' }}>Beads</option>
          <option value="figures" {{ request('category') === 'figures' ? 'selected' : '' }}>Figures</option>
          <option value="charms"  {{ request('category') === 'charms'  ? 'selected' : '' }}>Charms</option>
        </select>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-sm btn-dark w-100">Search</button>
      </div>
      <div class="col-md-2">
        <a href="{{ route('admin.elements.index') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
      </div>
    </form>
  </div>
</div>

{{-- ── Table ────────────────────────────────────────────────────────────── --}}
<div class="ac-card">
  <div class="ac-card-header">
    <i data-lucide="list" style="width:15px;height:15px;"></i>
    All Elements
    <span class="badge ms-auto" style="background:#F3F0FF;color:#7C3AED;font-size:.7rem;">
      {{ $elements->total() }} total
    </span>
  </div>

  <div class="table-responsive">
    <table class="table table-hover mb-0" style="font-size:.85rem;">
      <thead style="background:#F8F7FA; font-size:.75rem; text-transform:uppercase; letter-spacing:.05em;">
        <tr>
          <th class="ps-4 py-3" style="width:50px;">Preview</th>
          <th class="py-3">Name / Slug</th>
          <th class="py-3">Category</th>
          <th class="py-3">Group</th>
          <th class="py-3">Shape</th>
          <th class="py-3">Price</th>
          <th class="py-3">Stock</th>
          <th class="py-3">Active</th>
          <th class="py-3 pe-4 text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($elements as $el)
        <tr>
          {{-- Preview ──────────────────────────────────────────────────── --}}
          <td class="ps-4 py-2 align-middle">
            @if($el->use_img && $el->img_path)
              <img src="{{ asset('img/builder/' . $el->img_path) }}"
                   style="width:36px;height:36px;object-fit:contain;border-radius:6px;
                          background:#F8F7FA;border:1px solid #EEE;padding:2px;"
                   alt="{{ $el->name }}"/>
            @else
              {{-- Color swatch preview for bead/figure --}}
              <div style="width:36px;height:36px;border-radius:50%;
                          background:{{ $el->color ?? '#DDD' }};
                          border:1px solid rgba(0,0,0,.1);
                          display:flex;align-items:center;justify-content:center;
                          font-size:10px;color:rgba(0,0,0,.4);">
                {{ strtoupper(substr($el->shape ?? '?', 0, 1)) }}
              </div>
            @endif
          </td>

          {{-- Name / Slug ──────────────────────────────────────────────── --}}
          <td class="py-2 align-middle">
            <div class="fw-semibold" style="color:#2D2D3A;">{{ $el->name }}</div>
            <small class="text-muted font-monospace">{{ $el->slug }}</small>
          </td>

          {{-- Category ─────────────────────────────────────────────────── --}}
          <td class="py-2 align-middle">
            @php
              $catColor = match($el->category) {
                'beads'   => 'background:#FFD6E8;color:#C0136A;',
                'figures' => 'background:#D6F0FF;color:#0369A1;',
                'charms'  => 'background:#EDE9FE;color:#7C3AED;',
                default   => 'background:#F3F4F6;color:#374151;',
              };
            @endphp
            <span class="badge" style="{{ $catColor }} font-size:.72rem;">{{ ucfirst($el->category) }}</span>
          </td>

          {{-- Group ───────────────────────────────────────────────────── --}}
          <td class="py-2 align-middle text-muted">{{ $el->group ?? '—' }}</td>

          {{-- Shape ───────────────────────────────────────────────────── --}}
          <td class="py-2 align-middle">
            <code style="font-size:.75rem;background:#F3F4F6;padding:2px 6px;border-radius:4px;">
              {{ $el->shape ?? '—' }}
            </code>
          </td>

          {{-- Price ───────────────────────────────────────────────────── --}}
          <td class="py-2 align-middle fw-semibold" style="color:#FF5FA0;">₱{{ $el->price }}</td>

          {{-- Stock ───────────────────────────────────────────────────── --}}
          <td class="py-2 align-middle">
            <span class="badge stock-{{ $el->stock }}" style="font-size:.72rem;">
              {{ ucfirst($el->stock) }}
            </span>
          </td>

          {{-- Active ──────────────────────────────────────────────────── --}}
          <td class="py-2 align-middle">
            @if($el->is_active)
              <span style="color:#10B981;font-size:1rem;">●</span>
            @else
              <span style="color:#D1D5DB;font-size:1rem;">●</span>
            @endif
          </td>

          {{-- Actions ─────────────────────────────────────────────────── --}}
          <td class="py-2 pe-4 align-middle text-end">
            <a href="{{ route('admin.elements.edit', $el) }}"
               class="btn btn-xs btn-outline-secondary me-1"
               style="padding:3px 10px;font-size:.75rem;border-radius:6px;">
              Edit
            </a>
            <form action="{{ route('admin.elements.destroy', $el) }}" method="POST"
                  style="display:inline;"
                  onsubmit="return confirm('Delete {{ addslashes($el->name) }}? This cannot be undone.')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-xs"
                      style="padding:3px 10px;font-size:.75rem;border-radius:6px;
                             background:#FEE2E2;color:#991B1B;border:none;">
                Delete
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" class="text-center py-5 text-muted">
            No elements found. <a href="{{ route('admin.elements.create') }}">Add one →</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($elements->hasPages())
  <div class="p-3 border-top">
    {{ $elements->links() }}
  </div>
  @endif
</div>

@endsection