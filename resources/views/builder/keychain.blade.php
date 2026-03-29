<?php
$activePage   = 'keychain';
$maxBeads     = 12;
$productLabel = 'Keychain / Bag Charm';
$productConfig = ['product' => 'keychain', 'basePrice' => 65, 'maxBeads' => $maxBeads];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>ArtsyCrate — Keychain Builder</title>
  
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
      <i data-lucide="key" class="mr-2" style="width: 18px;"></i> Keychain Setup
    </div>

    <div class="overflow-auto flex-grow-1">
      
      <div class="psec open" id="sec-strands">
        <div class="psec-toggle" onclick="app.ui.toggleSec('sec-strands')">
          <span>Strands</span>
          <i data-lucide="chevron-down" class="psec-arr" style="width: 16px;"></i>
        </div>
        <div class="psec-body">
          <label class="font-weight-bold text-sm">Number of Strands</label>
          <div class="cpills d-flex gap-2">
            <div class="cpill strand-count-btn active" onclick="app.ui.setStrandCount(1,this)">1</div>
            <div class="cpill strand-count-btn" onclick="app.ui.setStrandCount(2,this)">2</div>
            <div class="cpill strand-count-btn" onclick="app.ui.setStrandCount(3,this)">3</div>
          </div>
        </div>
      </div>

      <div class="psec open" id="sec-ring">
        <div class="psec-toggle" onclick="app.ui.toggleSec('sec-ring')">
          <span>Ring</span>
          <i data-lucide="chevron-down" class="psec-arr" style="width: 16px;"></i>
        </div>
        <div class="psec-body">
          <div class="cpills d-flex flex-wrap gap-2 mb-3">
            <div class="cpill ring-type-btn active" onclick="app.ui.setRingType('ring',this)">Ring</div>
            <div class="cpill ring-type-btn" onclick="app.ui.setRingType('heart',this)">Heart</div>
            <div class="cpill ring-type-btn" onclick="app.ui.setRingType('carabiner',this)">Oval</div>
            <div class="cpill ring-type-btn" onclick="app.ui.setRingType('ballchain',this)">Ball Chain</div>
          </div>

          <label class="font-weight-bold text-sm">Ring Color</label>
          <div class="swatches" id="ring-sw">
            <div class="sw active" style="background:#F7A8C8;" onclick="app.ui.setRingCol('#F7A8C8',this)"></div>
            <div class="sw" style="background:#1AC8C4;" onclick="app.ui.setRingCol('#1AC8C4',this)"></div>
            <div class="sw" style="background:#A855F7;" onclick="app.ui.setRingCol('#A855F7',this)"></div>
            <div class="sw" style="background:#111118;" onclick="app.ui.setRingCol('#111118',this)"></div>
            <div class="sw" style="background:#C0C0C0;" onclick="app.ui.setRingCol('#C0C0C0',this)"></div>
            <div class="sw" style="background:#FFD700;" onclick="app.ui.setRingCol('#FFD700',this)"></div>
            <div class="sw" style="background:#3B82F6;" onclick="app.ui.setRingCol('#3B82F6',this)"></div>
            <div class="sw" style="background:#EF4444;" onclick="app.ui.setRingCol('#EF4444',this)"></div>
          </div>
        </div>
      </div>

      <div class="psec open" id="sec-cord">
        <div class="psec-toggle" onclick="app.ui.toggleSec('sec-cord')">
          <span>Cord</span>
          <i data-lucide="chevron-down" class="psec-arr" style="width: 16px;"></i>
        </div>
        <div class="psec-body">
          <label class="font-weight-bold text-sm">Cord Color</label>
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

          <label class="font-weight-bold text-sm">Cord Type</label>
          <select class="form-control form-control-sm mb-3 font-weight-bold" id="str-type" onchange="app.ui.setStrType(this.value)" style="border-radius: 8px; border: 2px solid #e9ecef;">
            <option value="Cord">Cord</option>
            <option value="Chain">Chain</option>
            <option value="Wire">Wire</option>
            <option value="Elastic">Elastic</option>
          </select>

          <label class="font-weight-bold text-sm">Length</label>
          <select class="form-control form-control-sm font-weight-bold" id="length-sel" style="border-radius: 8px; border: 2px solid #e9ecef;">
            <option value="small">Short — 8 cm</option>
            <option value="medium" selected>Medium — 12 cm</option>
            <option value="large">Long — 16 cm</option>
            <option value="custom">Custom</option>
          </select>
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