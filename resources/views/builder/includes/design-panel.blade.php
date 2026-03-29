<?php
// $maxBeads must be set by the parent page before including this file
$maxBeads = $maxBeads ?? 20;
?>
<div class="design-panel border-left" id="design-panel" style="width: 260px; min-width: 260px; background: var(--offwhite); display: flex; flex-direction: column;">
  <div class="design-inner d-flex flex-column h-100">

    <div class="insp-section border-bottom bg-white" style="min-height: 160px; flex-shrink: 0;">
      <div class="phead" style="margin-top: 0 !important;">
        <i data-lucide="mouse-pointer-click" style="width: 18px;"></i> Selected
      </div>
      <div id="insp-body" class="p-3">
        <div class="text-center p-4 text-muted font-weight-bold text-sm">
          <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px;">
            <i data-lucide="info" class="text-pink opacity-50" style="width: 24px;"></i>
          </div>
          <br>Click a bead on the canvas to inspect it
        </div>
      </div>
    </div>

    <div class="placed-list-wrap d-flex flex-column flex-grow-1 overflow-hidden bg-light">
      <div class="phead justify-content-between" style="margin-top: 0 !important;">
        <div><i data-lucide="layers" style="width: 18px;"></i> My Design</div>
        <span id="elem-count-badge" class="badge badge-pill badge-dark" style="font-family: var(--fb); font-size: 0.8rem;">0</span>
      </div>

      <div id="strand-selector-panel" style="display: none; border-bottom: 1.5px solid var(--grey-200); padding: 10px 14px; background: #fff;">
        <div class="cpills d-flex" id="strand-selector-btns" style="gap: 6px;"></div>
      </div>

      <div class="dlist flex-grow-1 overflow-auto p-3" id="design-list">
        <div class="text-center p-4 text-muted font-weight-bold text-sm">
          <i data-lucide="sparkles" class="text-pink mb-2 opacity-50" style="width: 28px;"></i><br>
          No elements yet.<br>Pick from the library ←
        </div>
      </div>

      <div class="p-3 bg-white border-top shadow-sm" style="z-index: 10; flex-shrink: 0;">
        <div class="d-flex justify-content-between align-items-center text-sm font-weight-bold text-muted mb-3">
          <span>Total Beads</span>
          <span class="badge badge-light border px-2 py-1"><span id="bead-ct" class="text-dark">0</span> / <span id="bead-max">{{ $maxBeads }}</span></span>
        </div>
        <button class="btn btn-outline-danger btn-sm btn-block rounded-pill font-weight-bold shadow-sm" onclick="app.state.clearAll()">
          <i data-lucide="trash-2" class="mr-1" style="width: 14px;"></i> Clear Canvas
        </button>
      </div>
    </div>

  </div>
</div>