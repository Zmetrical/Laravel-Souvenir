<?php
$activePage   = 'necklace';
$maxBeads     = 28;
$productLabel = 'Necklace';
$productConfig = ['product' => 'necklace', 'basePrice' => 100, 'maxBeads' => $maxBeads];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>ArtsyCrate — Necklace Builder</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  
  <meta name="csrf-token" content="{{ csrf_token() }}"/>

<link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}">
</head>
<body>

@include('builder.includes.topbar')

<div class="d-flex flex-row flex-nowrap h-100 overflow-hidden">

  <div class="builder-pane border-right" id="setup-panel">
    <div class="phead teal">
      <i data-lucide="gem" class="mr-2" style="width: 18px;"></i> Necklace Setup
    </div>

    <div class="overflow-auto flex-grow-1">
      <div class="psec open" id="sec-string">
        <div class="psec-toggle" onclick="app.ui.toggleSec('sec-string')">
          <span>Chain / Cord</span>
          <i data-lucide="chevron-down" class="psec-arr" style="width: 16px;"></i>
        </div>
        <div class="psec-body">
          
          <label class="font-weight-bold text-sm">String Color</label>
          <div class="swatches mb-3" id="str-sw">
            <div class="sw active" style="background:#FF5FA0;" onclick="app.ui.setStrCol('#FF5FA0',this)"></div>
            <div class="sw" style="background:#1AC8C4;" onclick="app.ui.setStrCol('#1AC8C4',this)"></div>
            <div class="sw" style="background:#A855F7;" onclick="app.ui.setStrCol('#A855F7',this)"></div>
            <div class="sw" style="background:#111118;" onclick="app.ui.setStrCol('#111118',this)"></div>
            <div class="sw" style="background:#fff;" onclick="app.ui.setStrCol('#ffffff',this)"></div>
            <div class="sw" style="background:#FFD700;" onclick="app.ui.setStrCol('#FFD700',this)"></div>
            <div class="sw" style="background:#3B82F6;" onclick="app.ui.setStrCol('#3B82F6',this)"></div>
            <div class="sw" style="background:#EF4444;" onclick="app.ui.setStrCol('#EF4444',this)"></div>
          </div>

          <label class="font-weight-bold text-sm">Chain / Cord Type</label>
          <select class="form-control form-control-sm mb-3 font-weight-bold" id="str-type" onchange="app.ui.setStrType(this.value)" style="border-radius: 8px; border: 2px solid #e9ecef;">
            <option value="Chain">Chain</option>
            <option value="Cord">Cord</option>
            <option value="Wire">Wire</option>
            <option value="Elastic">Elastic</option>
          </select>

          <label class="font-weight-bold text-sm">Length</label>
          <select class="form-control form-control-sm mb-3 font-weight-bold" id="length-sel" style="border-radius: 8px; border: 2px solid #e9ecef;">
            <option value="small">Choker — 40 cm</option>
            <option value="medium" selected>Princess — 45 cm</option>
            <option value="large">Matinee — 50 cm</option>
            <option value="custom">Custom</option>
          </select>

          <label class="font-weight-bold text-sm">Clasp</label>
          <div class="cpills d-flex gap-2">
            <div class="cpill active" onclick="app.ui.setClasp('none',this)">None</div>
            <div class="cpill" onclick="app.ui.setClasp('lobster',this)">Lobster</div>
            <div class="cpill" onclick="app.ui.setClasp('toggle',this)">Toggle</div>
          </div>

        </div>
      </div>
    </div>
  </div>

  @include('builder.includes.canvas')
  @include('builder.includes.design-panel')
  @include('builder.includes.library-panel')

</div>

@include('builder.includes.modal-preview')
@include('builder.includes.modal-order')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
  window.BUILDER_PRODUCT  = {!! json_encode($productConfig) !!};
  window.BUILDER_ELEMENTS = {!! json_encode($elements ?? []) !!};
</script>
<script type="module" src="{{ asset('js/builder/main.js') }}"></script>
</body>
</html>