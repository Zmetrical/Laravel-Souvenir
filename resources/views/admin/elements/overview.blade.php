@extends('admin.includes.layout')
@section('title', 'Elements')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h5 class="mb-0 fw-bold" style="color:var(--ink);">Element Library</h5>
    <small style="color:var(--grey-400);">Beads, figures, and charms used in the builder</small>
  </div>
</div>

{{-- Category Cards ──────────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">

  {{-- Beads --}}
  <div class="col-md-4">
    <div class="ac-card h-100" style="border-top: 3px solid #F9B8CF;">
      <div class="p-4">

        <div class="d-flex align-items-start justify-content-between mb-3">
          <div>
            <div style="width:32px;height:32px;border-radius:8px;
                        background:var(--grey-100);
                        display:flex;align-items:center;justify-content:center;
                        margin-bottom:10px;">
              <i data-lucide="circle" style="width:14px;height:14px;color:var(--pink-dk);"></i>
            </div>
            <div class="fw-bold" style="font-size:.95rem;color:var(--ink);">Beads</div>
            <div style="font-size:.75rem;color:var(--grey-400);margin-top:1px;">Round, cube, heart, star...</div>
          </div>
          <div style="font-size:2rem;font-weight:900;color:#F9B8CF;line-height:1;letter-spacing:-1px;">
            {{ $stats['beads']['total'] }}
          </div>
        </div>

        <div class="d-flex gap-2 mb-3" style="flex-wrap:wrap;">
          <span style="background:var(--grey-100);color:var(--grey-600);
                       padding:2px 9px;border-radius:4px;font-size:.7rem;font-weight:600;">
            {{ $stats['beads']['active'] }} active
          </span>
          @if($stats['beads']['low'] > 0)
          <span style="background:#FEF3C7;color:#92400E;padding:2px 9px;border-radius:4px;font-size:.7rem;font-weight:600;">
            {{ $stats['beads']['low'] }} low
          </span>
          @endif
          @if($stats['beads']['out'] > 0)
          <span style="background:#FEE2E2;color:#991B1B;padding:2px 9px;border-radius:4px;font-size:.7rem;font-weight:600;">
            {{ $stats['beads']['out'] }} out
          </span>
          @endif
        </div>

        <div class="d-flex gap-2">
          <a href="{{ route('admin.elements.beads') }}"
             class="btn btn-sm w-100"
             style="background:var(--grey-50);color:var(--ink-2);
                    border:1px solid var(--grey-200);border-radius:7px;
                    font-size:.78rem;font-weight:600;">
            Manage
          </a>
          <a href="{{ route('admin.elements.create', ['cat' => 'beads']) }}"
             class="btn btn-sm"
             style="background:var(--pink);color:#fff;border-radius:7px;
                    white-space:nowrap;font-size:.78rem;font-weight:600;
                    padding-left:14px;padding-right:14px;">
            + Add
          </a>
        </div>

      </div>
    </div>
  </div>

  {{-- Figures --}}
  <div class="col-md-4">
    <div class="ac-card h-100" style="border-top: 3px solid #93C5FD;">
      <div class="p-4">

        <div class="d-flex align-items-start justify-content-between mb-3">
          <div>
            <div style="width:32px;height:32px;border-radius:8px;
                        background:var(--grey-100);
                        display:flex;align-items:center;justify-content:center;
                        margin-bottom:10px;">
              <i data-lucide="square" style="width:14px;height:14px;color:#1D4ED8;"></i>
            </div>
            <div class="fw-bold" style="font-size:.95rem;color:var(--ink);">Figures</div>
            <div style="font-size:.75rem;color:var(--grey-400);margin-top:1px;">Cube shapes with designs</div>
          </div>
          <div style="font-size:2rem;font-weight:900;color:#93C5FD;line-height:1;letter-spacing:-1px;">
            {{ $stats['figures']['total'] }}
          </div>
        </div>

        <div class="d-flex gap-2 mb-3" style="flex-wrap:wrap;">
          <span style="background:var(--grey-100);color:var(--grey-600);
                       padding:2px 9px;border-radius:4px;font-size:.7rem;font-weight:600;">
            {{ $stats['figures']['active'] }} active
          </span>
          @if($stats['figures']['low'] > 0)
          <span style="background:#FEF3C7;color:#92400E;padding:2px 9px;border-radius:4px;font-size:.7rem;font-weight:600;">
            {{ $stats['figures']['low'] }} low
          </span>
          @endif
          @if($stats['figures']['out'] > 0)
          <span style="background:#FEE2E2;color:#991B1B;padding:2px 9px;border-radius:4px;font-size:.7rem;font-weight:600;">
            {{ $stats['figures']['out'] }} out
          </span>
          @endif
        </div>

        <div class="d-flex gap-2">
          <a href="{{ route('admin.elements.figures') }}"
             class="btn btn-sm w-100"
             style="background:var(--grey-50);color:var(--ink-2);
                    border:1px solid var(--grey-200);border-radius:7px;
                    font-size:.78rem;font-weight:600;">
            Manage
          </a>
          <a href="{{ route('admin.elements.create', ['cat' => 'figures']) }}"
             class="btn btn-sm"
             style="background:#3B82F6;color:#fff;border-radius:7px;
                    white-space:nowrap;font-size:.78rem;font-weight:600;
                    padding-left:14px;padding-right:14px;">
            + Add
          </a>
        </div>

      </div>
    </div>
  </div>

  {{-- Charms --}}
  <div class="col-md-4">
    <div class="ac-card h-100" style="border-top: 3px solid #C4B5FD;">
      <div class="p-4">

        <div class="d-flex align-items-start justify-content-between mb-3">
          <div>
            <div style="width:32px;height:32px;border-radius:8px;
                        background:var(--grey-100);
                        display:flex;align-items:center;justify-content:center;
                        margin-bottom:10px;">
              <i data-lucide="sparkles" style="width:14px;height:14px;color:#7C3AED;"></i>
            </div>
            <div class="fw-bold" style="font-size:.95rem;color:var(--ink);">Charms</div>
            <div style="font-size:.75rem;color:var(--grey-400);margin-top:1px;">Image-based charm pieces</div>
          </div>
          <div style="font-size:2rem;font-weight:900;color:#C4B5FD;line-height:1;letter-spacing:-1px;">
            {{ $stats['charms']['total'] }}
          </div>
        </div>

        <div class="d-flex gap-2 mb-3" style="flex-wrap:wrap;">
          <span style="background:var(--grey-100);color:var(--grey-600);
                       padding:2px 9px;border-radius:4px;font-size:.7rem;font-weight:600;">
            {{ $stats['charms']['active'] }} active
          </span>
          @if($stats['charms']['low'] > 0)
          <span style="background:#FEF3C7;color:#92400E;padding:2px 9px;border-radius:4px;font-size:.7rem;font-weight:600;">
            {{ $stats['charms']['low'] }} low
          </span>
          @endif
          @if($stats['charms']['out'] > 0)
          <span style="background:#FEE2E2;color:#991B1B;padding:2px 9px;border-radius:4px;font-size:.7rem;font-weight:600;">
            {{ $stats['charms']['out'] }} out
          </span>
          @endif
        </div>

        <div class="d-flex gap-2">
          <a href="{{ route('admin.elements.charms') }}"
             class="btn btn-sm w-100"
             style="background:var(--grey-50);color:var(--ink-2);
                    border:1px solid var(--grey-200);border-radius:7px;
                    font-size:.78rem;font-weight:600;">
            Manage
          </a>
          <a href="{{ route('admin.elements.create', ['cat' => 'charms']) }}"
             class="btn btn-sm"
             style="background:#8B5CF6;color:#fff;border-radius:7px;
                    white-space:nowrap;font-size:.78rem;font-weight:600;
                    padding-left:14px;padding-right:14px;">
            + Add
          </a>
        </div>

      </div>
    </div>
  </div>

</div>

{{-- Totals bar ───────────────────────────────────────────────────────────── --}}
<div class="ac-card">
  <div class="p-3 d-flex gap-4 flex-wrap align-items-center" style="font-size:.8rem;">
    @php $total = $stats['beads']['total'] + $stats['figures']['total'] + $stats['charms']['total']; @endphp
    <div style="color:var(--grey-400);">
      Total Elements
      <span class="fw-bold ms-1" style="color:var(--ink);font-size:.9rem;">{{ $total }}</span>
    </div>
    <div style="width:1px;height:14px;background:var(--grey-200);"></div>
    <div style="color:var(--grey-400);">Beads <span class="fw-semibold ms-1" style="color:var(--ink);">{{ $stats['beads']['total'] }}</span></div>
    <div style="color:var(--grey-400);">Figures <span class="fw-semibold ms-1" style="color:var(--ink);">{{ $stats['figures']['total'] }}</span></div>
    <div style="color:var(--grey-400);">Charms <span class="fw-semibold ms-1" style="color:var(--ink);">{{ $stats['charms']['total'] }}</span></div>
    @php
      $totalOut = $stats['beads']['out'] + $stats['figures']['out'] + $stats['charms']['out'];
      $totalLow = $stats['beads']['low'] + $stats['figures']['low'] + $stats['charms']['low'];
    @endphp
    @if($totalLow > 0 || $totalOut > 0)
    <div style="width:1px;height:14px;background:var(--grey-200);"></div>
    @endif
    @if($totalLow > 0)
    <div style="color:#92400E;display:flex;align-items:center;gap:5px;">
      <i data-lucide="alert-triangle" style="width:13px;height:13px;"></i>
      {{ $totalLow }} low stock
    </div>
    @endif
    @if($totalOut > 0)
    <div style="color:#991B1B;display:flex;align-items:center;gap:5px;">
      <i data-lucide="x-circle" style="width:13px;height:13px;"></i>
      {{ $totalOut }} out of stock
    </div>
    @endif
  </div>
</div>

@endsection