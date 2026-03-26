@extends('admin.includes.layout')
@section('title', 'Elements')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h5 class="mb-0 fw-bold" style="color:#2D2D3A;">Element Library</h5>
    <small class="text-muted">Beads, figures, and charms used in the builder</small>
  </div>
</div>

{{-- ── Category Cards ──────────────────────────────────────────────────── --}}
<div class="row g-4 mb-4">

  {{-- Beads --}}
  <div class="col-md-4">
    <div class="ac-card h-100" style="border-top: 4px solid #F9B8CF;">
      <div class="p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div>
            <div style="font-size:1.6rem;">🔵</div>
            <h5 class="fw-bold mb-0 mt-1" style="color:#2D2D3A;">Beads</h5>
            <small class="text-muted">Round, cube, heart, star...</small>
          </div>
          <div style="font-size:2.4rem; font-weight:800; color:#F9B8CF; line-height:1;">
            {{ $stats['beads']['total'] }}
          </div>
        </div>

        {{-- Mini stats --}}
        <div class="d-flex gap-2 mb-3" style="font-size:.75rem;">
          <span style="background:#D1FAE5;color:#065F46;padding:2px 8px;border-radius:20px;">
            {{ $stats['beads']['active'] }} active
          </span>
          @if($stats['beads']['low'] > 0)
          <span style="background:#FEF3C7;color:#92400E;padding:2px 8px;border-radius:20px;">
            {{ $stats['beads']['low'] }} low
          </span>
          @endif
          @if($stats['beads']['out'] > 0)
          <span style="background:#FEE2E2;color:#991B1B;padding:2px 8px;border-radius:20px;">
            {{ $stats['beads']['out'] }} out
          </span>
          @endif
        </div>

        <div class="d-flex gap-2">
          <a href="{{ route('admin.elements.beads') }}"
             class="btn btn-sm w-100 fw-semibold"
             style="background:#FFF0F6;color:#C0136A;border:1px solid #FFD6E8;border-radius:8px;">
            Manage Beads →
          </a>
          <a href="{{ route('admin.elements.create', ['cat' => 'beads']) }}"
             class="btn btn-sm fw-semibold"
             style="background:#FF5FA0;color:#fff;border-radius:8px;white-space:nowrap;">
            + Add
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- Figures --}}
  <div class="col-md-4">
    <div class="ac-card h-100" style="border-top: 4px solid #93C5FD;">
      <div class="p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div>
            <div style="font-size:1.6rem;">🟧</div>
            <h5 class="fw-bold mb-0 mt-1" style="color:#2D2D3A;">Figures</h5>
            <small class="text-muted">Cube shapes with designs</small>
          </div>
          <div style="font-size:2.4rem; font-weight:800; color:#93C5FD; line-height:1;">
            {{ $stats['figures']['total'] }}
          </div>
        </div>

        <div class="d-flex gap-2 mb-3" style="font-size:.75rem;">
          <span style="background:#D1FAE5;color:#065F46;padding:2px 8px;border-radius:20px;">
            {{ $stats['figures']['active'] }} active
          </span>
          @if($stats['figures']['low'] > 0)
          <span style="background:#FEF3C7;color:#92400E;padding:2px 8px;border-radius:20px;">
            {{ $stats['figures']['low'] }} low
          </span>
          @endif
          @if($stats['figures']['out'] > 0)
          <span style="background:#FEE2E2;color:#991B1B;padding:2px 8px;border-radius:20px;">
            {{ $stats['figures']['out'] }} out
          </span>
          @endif
        </div>

        <div class="d-flex gap-2">
          <a href="{{ route('admin.elements.figures') }}"
             class="btn btn-sm w-100 fw-semibold"
             style="background:#EFF6FF;color:#1D4ED8;border:1px solid #BFDBFE;border-radius:8px;">
            Manage Figures →
          </a>
          <a href="{{ route('admin.elements.create', ['cat' => 'figures']) }}"
             class="btn btn-sm fw-semibold"
             style="background:#3B82F6;color:#fff;border-radius:8px;white-space:nowrap;">
            + Add
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- Charms --}}
  <div class="col-md-4">
    <div class="ac-card h-100" style="border-top: 4px solid #C4B5FD;">
      <div class="p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div>
            <div style="font-size:1.6rem;">✨</div>
            <h5 class="fw-bold mb-0 mt-1" style="color:#2D2D3A;">Charms</h5>
            <small class="text-muted">Image-based charm pieces</small>
          </div>
          <div style="font-size:2.4rem; font-weight:800; color:#C4B5FD; line-height:1;">
            {{ $stats['charms']['total'] }}
          </div>
        </div>

        <div class="d-flex gap-2 mb-3" style="font-size:.75rem;">
          <span style="background:#D1FAE5;color:#065F46;padding:2px 8px;border-radius:20px;">
            {{ $stats['charms']['active'] }} active
          </span>
          @if($stats['charms']['low'] > 0)
          <span style="background:#FEF3C7;color:#92400E;padding:2px 8px;border-radius:20px;">
            {{ $stats['charms']['low'] }} low
          </span>
          @endif
          @if($stats['charms']['out'] > 0)
          <span style="background:#FEE2E2;color:#991B1B;padding:2px 8px;border-radius:20px;">
            {{ $stats['charms']['out'] }} out
          </span>
          @endif
        </div>

        <div class="d-flex gap-2">
          <a href="{{ route('admin.elements.charms') }}"
             class="btn btn-sm w-100 fw-semibold"
             style="background:#F5F3FF;color:#6D28D9;border:1px solid #DDD6FE;border-radius:8px;">
            Manage Charms →
          </a>
          <a href="{{ route('admin.elements.create', ['cat' => 'charms']) }}"
             class="btn btn-sm fw-semibold"
             style="background:#8B5CF6;color:#fff;border-radius:8px;white-space:nowrap;">
            + Add
          </a>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ── Quick totals bar ─────────────────────────────────────────────────── --}}
<div class="ac-card">
  <div class="p-4 d-flex gap-4 flex-wrap" style="font-size:.85rem;">
    @php $total = $stats['beads']['total'] + $stats['figures']['total'] + $stats['charms']['total']; @endphp
    <div>
      <span class="text-muted">Total Elements</span>
      <span class="fw-bold ms-2" style="font-size:1.1rem;">{{ $total }}</span>
    </div>
    <div style="color:#DDD;">|</div>
    <div>
      <span class="text-muted">Beads</span>
      <span class="fw-semibold ms-1">{{ $stats['beads']['total'] }}</span>
    </div>
    <div>
      <span class="text-muted">Figures</span>
      <span class="fw-semibold ms-1">{{ $stats['figures']['total'] }}</span>
    </div>
    <div>
      <span class="text-muted">Charms</span>
      <span class="fw-semibold ms-1">{{ $stats['charms']['total'] }}</span>
    </div>
    <div style="color:#DDD;">|</div>
    @php
      $totalOut = $stats['beads']['out'] + $stats['figures']['out'] + $stats['charms']['out'];
      $totalLow = $stats['beads']['low'] + $stats['figures']['low'] + $stats['charms']['low'];
    @endphp
    @if($totalLow > 0)
    <div style="color:#92400E;">
      <i data-lucide="alert-triangle"></i>
      {{ $totalLow }} low stock
    </div>
    @endif
    @if($totalOut > 0)
    <div style="color:#991B1B;">
      <i data-lucide="x-circle"></i>
      {{ $totalOut }} out of stock
    </div>
    @endif
  </div>
</div>

@endsection