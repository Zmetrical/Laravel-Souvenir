<div class="builder-pane border-left h-100" style="width: 280px; min-width: 280px; background: #fff;">  <div class="rhead d-flex justify-content-between align-items-center border-bottom p-3" style="background: var(--purple-bg); border-left: 4px solid var(--purple);">
    <span class="font-weight-bold" style="font-family: var(--fh); font-size: 1.15rem; color: var(--pink-dk);">
      <i data-lucide="library" class="mr-2" style="width:18px;"></i> Element Library
    </span>
  </div>

  <div class="p-2 border-bottom bg-light d-flex align-items-center justify-content-between">
    <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.65rem;">Insert At:</span>
    <div class="btn-group btn-group-sm shadow-sm">
      <button class="btn font-weight-bold dir-btn" style="background: #fff; border: 1px solid #ced4da; color: var(--ink-md);" onclick="app.ui.setAddDir('left', this)">← Left</button>
      <button class="btn font-weight-bold dir-btn active" style="background: var(--ink); border: 1px solid var(--ink); color: #fff;" onclick="app.ui.setAddDir('right', this)">Right →</button>
    </div>
  </div>

  <div class="ltabs d-flex border-bottom bg-white" id="lib-tabs">
    <div class="ltab active flex-fill text-center py-2 font-weight-bold" style="font-size:0.75rem; cursor:pointer; color: var(--pink); border-bottom: 3px solid var(--pink);" data-tab="beads" onclick="app.ui.switchTab(this)">Beads</div>
    <div class="ltab flex-fill text-center py-2 font-weight-bold text-muted" style="font-size:0.75rem; cursor:pointer; border-bottom: 3px solid transparent;" data-tab="figures" onclick="app.ui.switchTab(this)">Figures</div>
    <div class="ltab flex-fill text-center py-2 font-weight-bold text-muted" style="font-size:0.75rem; cursor:pointer; border-bottom: 3px solid transparent;" data-tab="charms" onclick="app.ui.switchTab(this)">Charms</div>
    <div class="ltab flex-fill text-center py-2 font-weight-bold text-muted" style="font-size:0.75rem; cursor:pointer; border-bottom: 3px solid transparent;" data-tab="letters" onclick="app.ui.switchTab(this)">A–Z</div>
  </div>

  <div id="tab-beads" class="flex-grow-1 overflow-auto bg-light p-2 d-flex flex-column">
    <div class="bead-groups d-flex flex-column w-100" style="gap: 8px;" id="bead-groups"></div>
  </div>

  <div id="tab-figures" class="flex-grow-1 overflow-auto bg-light p-2 d-flex flex-column" style="display:none !important;">
    <input type="text" class="form-control form-control-sm rounded-pill mb-2 font-weight-bold shadow-sm border-0 px-3 w-100" placeholder="Search figures…" oninput="app.ui.filterCharms(this, 'grid-figures')"/>
    <div class="d-flex flex-column w-100" style="gap: 8px;" id="grid-figures"></div>
  </div>
  
  <div id="tab-charms" class="flex-grow-1 overflow-auto bg-light p-2 d-flex flex-column" style="display:none !important;">
    <input type="text" class="form-control form-control-sm rounded-pill mb-2 font-weight-bold shadow-sm border-0 px-3 w-100" placeholder="Search charms…" oninput="app.ui.filterCharms(this, 'charms-groups-wrap')"/>
    <div class="d-flex flex-column w-100" style="gap: 8px;" id="charms-groups-wrap"></div>
  </div>
  
  <div id="tab-letters" class="flex-grow-1 overflow-auto bg-light p-2 d-flex flex-column" style="display:none !important;">
    
    <div class="bg-white rounded border shadow-sm p-2 mb-2 d-flex align-items-center justify-content-between w-100">
      <span class="text-muted text-uppercase font-weight-bold" style="font-size: 0.65rem;">Tile Shape:</span>
      <div class="btn-group btn-group-sm">
        <button class="btn font-weight-bold lshape-btn active" style="background: var(--pink-bg); color: var(--pink); border: 1px solid var(--pink-dk);" onclick="app.ui.setLetterShape('square', this)">Square</button>
        <button class="btn font-weight-bold lshape-btn" style="background: #fff; color: var(--ink-md); border: 1px solid #ced4da;" onclick="app.ui.setLetterShape('round', this)">Circle</button>
      </div>
    </div>
    
    <div class="bg-white rounded border shadow-sm p-2 mb-2 w-100">
      <span class="text-muted text-uppercase font-weight-bold d-block mb-2" style="font-size: 0.65rem;">Tile Color:</span>
      <div class="d-flex flex-wrap" style="gap: 8px;" id="ltr-sw">
        <div class="sw active border-dark shadow-sm" style="background:#fff; width:28px; height:28px; cursor:pointer; border-radius: 50%;" onclick="app.ui.setLtrCol('#ffffff','#333344',this)"></div>
        <div class="sw shadow-sm" style="background:#F9B8CF; width:28px; height:28px; cursor:pointer; border-radius: 50%; border: 2px solid transparent;" onclick="app.ui.setLtrCol('#F9B8CF','#ffffff',this)"></div>
        <div class="sw shadow-sm" style="background:#90DDD9; width:28px; height:28px; cursor:pointer; border-radius: 50%; border: 2px solid transparent;" onclick="app.ui.setLtrCol('#90DDD9','#ffffff',this)"></div>
        <div class="sw shadow-sm" style="background:#C9A9F0; width:28px; height:28px; cursor:pointer; border-radius: 50%; border: 2px solid transparent;" onclick="app.ui.setLtrCol('#C9A9F0','#ffffff',this)"></div>
        <div class="sw shadow-sm" style="background:#FFE07A; width:28px; height:28px; cursor:pointer; border-radius: 50%; border: 2px solid transparent;" onclick="app.ui.setLtrCol('#FFE07A','#ffffff',this)"></div>
        <div class="sw shadow-sm" style="background:#3D3D52; width:28px; height:28px; cursor:pointer; border-radius: 50%; border: 2px solid transparent;" onclick="app.ui.setLtrCol('#3D3D52','#ffffff',this)"></div>
      </div>
    </div>

    <div class="bg-white rounded border shadow-sm p-2 flex-grow-1 w-100">
      <div class="d-flex flex-wrap justify-content-center" style="gap: 6px;" id="grid-ltrs"></div>
    </div>

  </div>
</div>