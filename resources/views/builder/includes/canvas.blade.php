<div class="canvas-area position-relative d-flex align-items-center justify-content-center flex-grow-1" id="canvas-area" style="background: #F4F5F8; overflow: hidden;">
  
  <div class="position-absolute" style="top: 20px; right: 20px; z-index: 10;">
    <button class="btn font-weight-bold shadow rounded-pill px-4 py-2" style="color: var(--ink); border: 2px solid var(--lime-dk); transition: transform 0.2s;" onclick="app.ui.openPreview()" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
      <i data-lucide="eye" style="width:16px;" class="mr-1"></i> Preview
    </button>
  </div>

  <canvas id="main-canvas" width="680" height="480" class="ac-artboard"></canvas>

  <div class="position-absolute d-flex align-items-center shadow-lg bg-white rounded-pill px-3 py-2" style="bottom: 30px; z-index: 10; border: 1.5px solid var(--grey-200);">
    
    <div class="btn-group bg-light rounded-pill border mr-3 p-1">
      <button class="btn btn-sm font-weight-bold rounded-pill px-3 vtbtn active" id="vt-sil" onclick="app.ui.setView('silhouette')" style="transition: all 0.2s;">Arc</button>
      <button class="btn btn-sm font-weight-bold rounded-pill px-3 vtbtn" id="vt-flat" onclick="app.ui.setView('flatlay')" style="transition: all 0.2s;">Grid</button>
    </div>

    <div style="width: 1px; height: 24px; background: var(--grey-200); margin-right: 16px;"></div>

    <button class="btn btn-sm text-muted font-weight-bold px-2 mx-1" id="btn-undo" onclick="app.state.undo()" disabled style="transition: color 0.2s;">
      <i data-lucide="undo-2" style="width:18px;"></i>
    </button>
    <button class="btn btn-sm text-muted font-weight-bold px-2 mx-1" id="btn-redo" onclick="app.state.redo()" disabled style="transition: color 0.2s;">
      <i data-lucide="redo-2" style="width:18px;"></i>
    </button>

  </div>

</div>