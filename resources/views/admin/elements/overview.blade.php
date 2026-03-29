@extends('admin.includes.layout')
@section('title', 'Element Library')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h5 class="mb-0" style="font-family: var(--fh); font-size: 2rem; color: var(--ink); letter-spacing: 1px;">Element Library</h5>
    <small style="font-size: 0.95rem; font-weight: 700; color: var(--ink-md);">Manage the inventory for the custom design builder.</small>
  </div>
</div>

{{-- Category Cards ──────────────────────────────────────────────────────── --}}
<div class="row g-4 mb-4">

  {{-- Beads --}}
  <div class="col-md-4">
    <div class="ac-card h-100" style="border-top: 4px solid var(--pink);">
      <div class="p-4">
        <div class="d-flex align-items-start justify-content-between mb-3">
          <div>
            <div style="width:40px; height:40px; border-radius:12px; background:var(--pink-bg); display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
              <i data-lucide="circle" style="color:var(--pink-dk); width: 20px;"></i>
            </div>
            <div style="font-family: var(--fh); font-size: 1.4rem; color: var(--ink);">Beads</div>
            <div style="font-size: 0.75rem; font-weight: 800; color: var(--ink-md); text-transform: uppercase; letter-spacing: 0.05em;">Shapes & Spheres</div>
          </div>
          <div style="font-family: var(--fh); font-size: 2.8rem; color: var(--pink-bd); line-height: 1;">
            {{ $stats['beads']['total'] }}
          </div>
        </div>

        <div class="d-flex gap-2 mb-4" style="flex-wrap:wrap;">
          <span style="background:var(--grey-50); color:var(--ink-md); padding:4px 10px; border-radius:8px; font-size:0.7rem; font-weight:800; border: 1.5px solid var(--grey-200);">
            {{ $stats['beads']['active'] }} ACTIVE
          </span>
          @if($stats['beads']['low'] > 0)
          <span style="background:#FEF3C7; color:#92400E; padding:4px 10px; border-radius:8px; font-size:0.7rem; font-weight:800; border: 1.5px solid #FDE68A;">
            {{ $stats['beads']['low'] }} LOW
          </span>
          @endif
        </div>

        <div class="d-flex gap-2">
          <a href="{{ route('admin.elements.beads') }}" class="btn-ghost w-100 justify-content-center">Manage</a>
          <a href="{{ route('admin.elements.create', ['cat' => 'beads']) }}" class="btn-pink px-3" style="min-width: fit-content;"><i data-lucide="plus"></i></a>
        </div>
      </div>
    </div>
  </div>

  {{-- Figures --}}
  <div class="col-md-4">
    <div class="ac-card h-100" style="border-top: 4px solid var(--teal);">
      <div class="p-4">
        <div class="d-flex align-items-start justify-content-between mb-3">
          <div>
            <div style="width:40px; height:40px; border-radius:12px; background:var(--teal-bg); display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
              <i data-lucide="box" style="color:var(--teal-dk); width: 20px;"></i>
            </div>
            <div style="font-family: var(--fh); font-size: 1.4rem; color: var(--ink);">Figures</div>
            <div style="font-size: 0.75rem; font-weight: 800; color: var(--ink-md); text-transform: uppercase; letter-spacing: 0.05em;">Cube Designs</div>
          </div>
          <div style="font-family: var(--fh); font-size: 2.8rem; color: var(--teal-bg); line-height: 1;">
            {{ $stats['figures']['total'] }}
          </div>
        </div>

        <div class="d-flex gap-2 mb-4" style="flex-wrap:wrap;">
          <span style="background:var(--grey-50); color:var(--ink-md); padding:4px 10px; border-radius:8px; font-size:0.7rem; font-weight:800; border: 1.5px solid var(--grey-200);">
            {{ $stats['figures']['active'] }} ACTIVE
          </span>
        </div>

        <div class="d-flex gap-2">
          <a href="{{ route('admin.elements.figures') }}" class="btn-ghost w-100 justify-content-center" style="border-color: var(--teal); color: var(--teal-dk);">Manage</a>
          <a href="{{ route('admin.elements.create', ['cat' => 'figures']) }}" class="btn-pink px-3" style="background: var(--teal); min-width: fit-content;"><i data-lucide="plus"></i></a>
        </div>
      </div>
    </div>
  </div>

  {{-- Charms --}}
  <div class="col-md-4">
    <div class="ac-card h-100" style="border-top: 4px solid var(--purple);">
      <div class="p-4">
        <div class="d-flex align-items-start justify-content-between mb-3">
          <div>
            <div style="width:40px; height:40px; border-radius:12px; background:var(--purple-bg); display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
              <i data-lucide="sparkles" style="color:var(--purple-dk); width: 20px;"></i>
            </div>
            <div style="font-family: var(--fh); font-size: 1.4rem; color: var(--ink);">Charms</div>
            <div style="font-size: 0.75rem; font-weight: 800; color: var(--ink-md); text-transform: uppercase; letter-spacing: 0.05em;">Image Based</div>
          </div>
          <div style="font-family: var(--fh); font-size: 2.8rem; color: var(--purple-bg); line-height: 1;">
            {{ $stats['charms']['total'] }}
          </div>
        </div>

        <div class="d-flex gap-2 mb-4" style="flex-wrap:wrap;">
          <span style="background:var(--grey-50); color:var(--ink-md); padding:4px 10px; border-radius:8px; font-size:0.7rem; font-weight:800; border: 1.5px solid var(--grey-200);">
            {{ $stats['charms']['active'] }} ACTIVE
          </span>
        </div>

        <div class="d-flex gap-2">
          <a href="{{ route('admin.elements.charms') }}" class="btn-ghost w-100 justify-content-center" style="border-color: var(--purple); color: var(--purple-dk);">Manage</a>
          <a href="{{ route('admin.elements.create', ['cat' => 'charms']) }}" class="btn-pink px-3" style="background: var(--purple); min-width: fit-content;"><i data-lucide="plus"></i></a>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- Inventory Status ────────────────────────────────────────────────────── --}}
<div class="ac-card">
  <div class="p-3 d-flex gap-4 flex-wrap align-items-center" style="font-size: .85rem; font-weight: 700;">
    @php $total = $stats['beads']['total'] + $stats['figures']['total'] + $stats['charms']['total']; @endphp
    <div style="color:var(--ink);">
      Inventory Summary:
      <span class="ms-1" style="font-family: var(--fh); font-size: 1.1rem; color: var(--pink);">{{ $total }} Elements</span>
    </div>
    
    <div style="width:1.5px; height:20px; background:var(--grey-200);"></div>
    
    @php
      $totalOut = $stats['beads']['out'] + $stats['figures']['out'] + $stats['charms']['out'];
      $totalLow = $stats['beads']['low'] + $stats['figures']['low'] + $stats['charms']['low'];
    @endphp

    <div class="d-flex align-items-center gap-4">
      @if($totalLow > 0)
      <div style="color:#D97706; display:flex; align-items:center; gap:6px;">
        <i data-lucide="alert-triangle" style="width:16px;"></i> {{ $totalLow }} LOW STOCK
      </div>
      @endif
      
      @if($totalOut > 0)
      <div style="color:#DC2626; display:flex; align-items:center; gap:6px;">
        <i data-lucide="x-circle" style="width:16px;"></i> {{ $totalOut }} OUT OF STOCK
      </div>
      @endif

      @if($totalLow == 0 && $totalOut == 0)
        <div style="color: var(--lime-dk); display:flex; align-items:center; gap:6px;">
          <i data-lucide="check-circle" style="width:16px;"></i> ALL STOCK HEALTHY
        </div>
      @endif
    </div>
  </div>
</div>

@endsection