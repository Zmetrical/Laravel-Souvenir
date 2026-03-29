const { beads: BEADS, figures: FIGURES, charms: CHARMS } = window.BUILDER_ELEMENTS || {};
const ELEM_MAP = {};
[...(BEADS||[]), ...(FIGURES||[]), ...(CHARMS||[])].forEach(e => { ELEM_MAP[e.id] = e; });

export class UIController {
  constructor(appInstance) {
    this.app = appInstance;
    this.toastTimer = null;

    this.isDragging = false;
    this.draggedUid = null;
    this.dragStartIndex = -1;
    this.dragInitialState = null;

    this.listDragSrcIdx = -1;
    this.setupListeners();
  }

  setupListeners() {
    const mainCanvas = document.getElementById('main-canvas');
    mainCanvas.addEventListener('mousedown', (e) => this.handleDragStart(e, mainCanvas));
    mainCanvas.addEventListener('mousemove', (e) => this.handleDragMove(e, mainCanvas));
    window.addEventListener('mouseup', (e) => this.handleDragEnd(e));

    // Bootstrap Modal handling for clicking outside (handled automatically by Bootstrap, but keeping fallback)
    document.querySelectorAll('.modal').forEach(m => {
      m.addEventListener('click', e => { 
        if (e.target === m && typeof $ !== 'undefined') $(m).modal('hide'); 
      });
    });
  }

  handleDragStart(e, canvas) {
    const rect = canvas.getBoundingClientRect();
    const mx = e.clientX - rect.left;
    const my = e.clientY - rect.top;

    const state = this.app.state;
    if (!state.elems.length) return;

    const positions = this.app.canvasEngine.getPositions(state);
    let hit = null;

    for (let i = state.elems.length - 1; i >= 0; i--) {
      const pos = positions[i];
      const el  = state.elems[i];
      let hx, hy, R;
      if (el.useImg) {
        hx = pos.x; hy = pos.y; R = 14;
      } else {
        hx = pos.x; hy = pos.y; R = (el.small ? 14 : el.large ? 28 : 22) + 6;
      }
      if ((mx - hx) ** 2 + (my - hy) ** 2 <= R ** 2) { hit = el.uid; break; }
    }

    if (hit) {
      this.dragInitialState = JSON.stringify(state.elems);
      this.isDragging = true;
      this.draggedUid = hit;
      this.dragStartIndex = state.elems.findIndex(el => el.uid === hit);
      state.selectedId = hit;
      const hitEl = state.elems[this.dragStartIndex];
      if (state.product === 'keychain' && hitEl?.strand != null) {
        state.activeStrand = hitEl.strand;
      }
      canvas.style.cursor = 'grabbing';
      this.updateInspector(state.elems[this.dragStartIndex]);
      this.app.render();
    } else {
      state.selectedId = null;
      this.updateInspector(null);
      this.app.render();
    }
  }

  handleDragMove(e, canvas) {
    if (!this.isDragging || !this.draggedUid) return;
    const rect = canvas.getBoundingClientRect();
    const mx = e.clientX - rect.left;
    const my = e.clientY - rect.top;

    const state = this.app.state;
    const positions = this.app.canvasEngine.getPositions(state);
    let closestIdx = -1, minDist = Infinity;

    for (let i = 0; i < positions.length; i++) {
      const dist = (mx - positions[i].x) ** 2 + (my - positions[i].y) ** 2;
      if (dist < minDist) { minDist = dist; closestIdx = i; }
    }

    const currIdx = state.elems.findIndex(el => el.uid === this.draggedUid);
    if (closestIdx !== -1 && closestIdx !== currIdx) {
      const [movedItem] = state.elems.splice(currIdx, 1);
      state.elems.splice(closestIdx, 0, movedItem);
      this.app.render();
    }
  }

  handleDragEnd(e) {
    if (this.isDragging) {
      document.getElementById('main-canvas').style.cursor = 'pointer';
      const state = this.app.state;
      const finalIdx = state.elems.findIndex(el => el.uid === this.draggedUid);
      if (finalIdx !== this.dragStartIndex && finalIdx !== -1) {
        state.history.push(this.dragInitialState);
        state.future = [];
        this.updateHistoryButtons();
      }
      this.isDragging = false;
      this.draggedUid = null;
    }
  }

  _getStrandBeadCount(strandIdx) {
    return this.app.state.elems.filter(e => (e.strand ?? 0) === strandIdx).length;
  }

  updateAll() {
    this.updateCounters();
    this.renderDesignList();
    this.updateHistoryButtons();
  }

  updateCounters() {
    const state = this.app.state;
    const beadCt  = document.getElementById('bead-ct');
    const beadMax = document.getElementById('bead-max');

    if (state.product === 'keychain' && state.keychainStrands > 1) {
      const cnt = this._getStrandBeadCount(state.activeStrand);
      if (beadCt)  beadCt.textContent  = `S${state.activeStrand + 1}: ${cnt}`;
      if (beadMax) beadMax.textContent = state.maxBeads;
    } else {
      if (beadCt)  beadCt.textContent  = state.elems.length;
      if (beadMax) beadMax.textContent = state.maxBeads;
    }
  }

  updateHistoryButtons() {
    const state = this.app.state;
    document.getElementById('btn-undo').disabled = !state.history.length;
    document.getElementById('btn-redo').disabled = !state.future.length;
  }

  addElement(id) {
    const item = ELEM_MAP[id];
    if (!item) return;
    const state = this.app.state;

    if (state.product === 'keychain') {
      const strandCount = this._getStrandBeadCount(state.activeStrand);
      if (strandCount >= state.maxBeads) { this.showToast(`Strand ${state.activeStrand + 1} is full!`); return; }
    } else {
      if (state.elems.length >= state.maxBeads) { this.showToast('Max elements reached!'); return; }
    }

    state.pushHistory();
    const newEl = { uid: state.generateId(), ...item };
    if (state.product === 'keychain') newEl.strand = state.activeStrand;

    const selectedIdx = state.elems.findIndex(e => e.uid === state.selectedId);
    const selEl = state.elems[selectedIdx];
    
    if (selectedIdx !== -1 && state.product === 'keychain' && (selEl?.strand ?? 0) === newEl.strand) {
      state.elems.splice(selectedIdx + 1, 0, newEl);
    } else if (selectedIdx !== -1 && state.product !== 'keychain') {
      state.elems.splice(selectedIdx + 1, 0, newEl);
    } else {
      state.elems.push(newEl);
    }

    state.selectedId = newEl.uid;
    this.updateInspector(newEl);
    this.app.render();
    this.showToast(`Added ${item.name}`);
  }

  addLetter(ch) {
    const state = this.app.state;
    if (state.product === 'keychain') {
      if (this._getStrandBeadCount(state.activeStrand) >= state.maxBeads) {
        this.showToast(`Strand ${state.activeStrand + 1} is full!`); return;
      }
    } else {
      if (state.elems.length >= state.maxBeads) { this.showToast('Max elements reached!'); return; }
    }

    state.pushHistory();

    const letterEl = {
      uid: state.generateId(), id: 'letter_' + ch, name: 'Letter ' + ch,
      isLetter: true, letterShape: state.letterShape || 'square',
      ltrBg: state.ltrColor.bg, ltrText: state.ltrColor.text,
      label: ch, price: 8, stock: 'in', category: 'letters',
      strand: state.product === 'keychain' ? state.activeStrand : undefined,
    };

    letterEl.imgUrl = this.app.canvasEngine.createSingleThumb(letterEl);
    const selectedIdx = state.elems.findIndex(e => e.uid === state.selectedId);
    
    if (selectedIdx !== -1 && state.product === 'keychain' && (state.elems[selectedIdx]?.strand ?? 0) === letterEl.strand) {
      state.elems.splice(selectedIdx + 1, 0, letterEl);
    } else if (selectedIdx !== -1 && state.product !== 'keychain') {
      state.elems.splice(selectedIdx + 1, 0, letterEl);
    } else {
      state.elems.push(letterEl);
    }

    state.selectedId = letterEl.uid;
    this.updateInspector(letterEl);
    this.app.render();
  }
setAddDir(dir, btnEl) {
    this.app.state.addDirection = dir;
    document.querySelectorAll('.dir-btn').forEach(b => {
      b.style.background = '#fff';
      b.style.color = 'var(--ink-md)';
      b.style.border = '1px solid #ced4da';
      b.classList.remove('active');
    });
    btnEl.classList.add('active');
    btnEl.style.background = 'var(--ink)';
    btnEl.style.color = '#fff';
    btnEl.style.border = '1px solid var(--ink)';
  }

  removeBead(uid) {
    this.app.state.pushHistory();
    this.app.state.elems = this.app.state.elems.filter(e => e.uid !== uid);
    if (this.app.state.selectedId === uid) { this.app.state.selectedId = null; this.updateInspector(null); }
    this.app.render();
  }

  dupeBead(uid) {
    if (this.app.state.elems.length >= this.app.state.maxBeads) { this.showToast('Max elements reached!'); return; }
    const idx = this.app.state.elems.findIndex(e => e.uid === uid);
    if (idx < 0) return;
    this.app.state.pushHistory();
    this.app.state.elems.splice(idx + 1, 0, { ...this.app.state.elems[idx], uid: this.app.state.generateId() });
    this.app.render();
    this.showToast('Duplicated!');
  }

  moveElem(uid, dir, ev) {
    if (ev) ev.stopPropagation();
    const state = this.app.state;
    const idx = state.elems.findIndex(e => e.uid === uid);
    const to = idx + dir;
    if (to < 0 || to >= state.elems.length) return;
    state.pushHistory();
    [state.elems[idx], state.elems[to]] = [state.elems[to], state.elems[idx]];
    this.app.render();
  }

  selectBead(uid) {
    this.app.state.selectedId = this.app.state.selectedId === uid ? null : uid;
    const el = this.app.state.elems.find(e => e.uid === uid);
    if (el && this.app.state.product === 'keychain' && el.strand != null) {
      this.app.state.activeStrand = el.strand;
    }
    this.updateInspector(el || null);
    this.app.render();
  }

  renderDesignList() {
    const state = this.app.state;
    const list  = document.getElementById('design-list');

    // ── 1. STRAND SELECTOR (KEYCHAIN ONLY) ───────────────────────────────
    const selectorWrap = document.getElementById('strand-selector-panel');
    if (selectorWrap) {
      if (state.product === 'keychain' && state.keychainStrands > 1) {
        // Force display block so it shows up!
        selectorWrap.style.setProperty('display', 'block', 'important');
        
        const btns = document.getElementById('strand-selector-btns');
        if (btns) {
          btns.innerHTML = Array.from({ length: state.keychainStrands }, (_, i) => {
            const cnt = this._getStrandBeadCount(i);
            const isActive = state.activeStrand === i;
            
            // New UI styled pills
            return `<button class="cpill ${isActive ? 'active' : ''}" 
                            style="background: ${isActive ? 'var(--pink-bg)' : '#fff'}; 
                                   color: ${isActive ? 'var(--pink-dk)' : 'var(--ink-md)'};
                                   border: 1.5px solid ${isActive ? 'var(--pink)' : 'var(--ink-lt)'};"
                            onclick="app.ui.setActiveStrand(${i}, this)">
                      Strand ${i + 1}
                      <span style="opacity:0.6; margin-left:4px;">${cnt}/${state.maxBeads}</span>
                    </button>`;
          }).join('');
        }
      } else {
        selectorWrap.style.setProperty('display', 'none', 'important');
      }
    }

    // ── 2. FILTER ELEMENTS & UPDATE BADGES ───────────────────────────────
    const visibleElems = (state.product === 'keychain') 
      ? state.elems.filter(el => (el.strand ?? 0) === state.activeStrand) 
      : state.elems;
      
    const badge = document.getElementById('elem-count-badge');
    if (badge) {
      badge.textContent = state.product === 'keychain' 
        ? `${visibleElems.length}/${state.maxBeads}` 
        : state.elems.length;
    }

    // ── 3. RENDER THE LIST ───────────────────────────────────────────────
    if (!visibleElems.length) {
      list.innerHTML = `<div class="text-center p-4 text-muted font-weight-bold text-sm">
        <i data-lucide="asterisk" class="mb-2" style="width: 24px; color: var(--pink); opacity: 0.5;"></i><br>
        ${state.product === 'keychain' && state.keychainStrands > 1 ? `No elements on Strand ${state.activeStrand + 1} yet.` : 'No elements yet.'}<br>Pick from the library
      </div>`;
      if(window.lucide) lucide.createIcons();
      return;
    }

    list.innerHTML = visibleElems.map((el, i) => `
      <div class="ditem shadow-sm d-flex align-items-center p-2 mb-1 rounded border" 
           style="background: ${state.selectedId === el.uid ? 'var(--teal-bg)' : '#fff'}; border-color: ${state.selectedId === el.uid ? 'var(--teal)' : 'var(--ink-lt)'} !important; cursor: grab;"
           data-uid="${el.uid}" data-globalidx="${state.elems.indexOf(el)}" draggable="true"
           onclick="app.ui.selectBead('${el.uid}')">
        <span class="font-weight-bold text-center" style="width: 20px; font-size: 0.75rem; color: var(--ink-md);">${i + 1}</span>
        <div class="bg-white border rounded d-flex align-items-center justify-content-center mx-2" style="width: 30px; height: 30px; flex-shrink: 0;">
          <img src="${el.imgUrl}" style="max-width: 80%; max-height: 80%;" />
        </div>
        <div class="flex-grow-1 text-truncate font-weight-bold text-dark" style="font-size: 0.8rem;">${el.name}</div>
        <div class="font-weight-bold mr-2" style="font-size: 0.75rem; color: var(--pink);">₱${el.price || 8}</div>
        <div class="btn-group btn-group-sm ml-auto" style="flex-shrink: 0;">
          <button class="btn btn-light border p-1" style="color: var(--ink-md);" onclick="app.ui.moveElem('${el.uid}', -1, event)"><i data-lucide="arrow-up" style="width:12px;"></i></button>
          <button class="btn btn-light border p-1" style="color: var(--ink-md);" onclick="app.ui.moveElem('${el.uid}', 1, event)"><i data-lucide="arrow-down" style="width:12px;"></i></button>
          <button class="btn border p-1" style="background: var(--pink-bg); color: var(--pink-dk); border-color: var(--pink-dk) !important;" onclick="event.stopPropagation(); app.ui.removeBead('${el.uid}')"><i data-lucide="x" style="width:12px;"></i></button>
        </div>
      </div>`).join('');

    if(window.lucide) lucide.createIcons();
    this.attachDragEvents(list);
  }

  attachDragEvents(list) {
    list.querySelectorAll('.ditem').forEach(row => {
      row.addEventListener('dragstart', e => {
        this.listDragSrcUid = row.dataset.uid;
        this.app.state.pushHistory();
        row.style.opacity = '0.5';
        e.dataTransfer.effectAllowed = 'move';
      });
      row.addEventListener('dragend', () => {
        list.querySelectorAll('.ditem').forEach(r => { r.style.opacity = '1'; r.classList.remove('bg-info', 'text-white'); });
      });
      row.addEventListener('dragover', e => {
        e.preventDefault();
        list.querySelectorAll('.ditem').forEach(r => r.classList.remove('bg-info', 'text-white'));
        row.classList.add('bg-info', 'text-white');
      });
      row.addEventListener('dragleave', () => row.classList.remove('bg-info', 'text-white'));
      row.addEventListener('drop', e => {
        e.preventDefault(); e.stopPropagation();
        if (row.dataset.uid === this.listDragSrcUid) return;
        const elems   = this.app.state.elems;
        const srcIdx  = elems.findIndex(el => el.uid === this.listDragSrcUid);
        const destIdx = elems.findIndex(el => el.uid === row.dataset.uid);
        if (srcIdx === -1 || destIdx === -1) return;
        const [moved] = elems.splice(srcIdx, 1);
        elems.splice(destIdx, 0, moved);
        this.app.render();
      });
    });
  }

  buildFiguresGrid(items) {
    const container = document.getElementById('grid-figures');
    if (!container) return;

    const figItems = items.filter(i => i.category === 'figures');
    const groups   = {};
    figItems.forEach(item => {
      const g = item.group || 'Other';
      if (!groups[g]) groups[g] = [];
      groups[g].push(item);
    });

    container.innerHTML = Object.entries(groups).map(([groupName, beads], idx) => `
      <div class="bgroup ${idx === 0 ? 'open' : ''} bg-white rounded border mb-2 shadow-sm w-100">
        <div class="bgroup-head d-flex justify-content-between align-items-center p-2 border-bottom" onclick="this.closest('.bgroup').classList.toggle('open')">
          <div class="d-flex align-items-center">
            <img src="${beads[0].imgUrl}" alt="${groupName}" style="width:24px; height:24px; border-radius:4px;" class="mr-2"/>
            <span class="font-weight-bold text-dark" style="font-size: 0.85rem;">${groupName}</span>
          </div>
          <div class="d-flex align-items-center">
            <span class="badge bg-pink-light text-pink mr-2">₱${beads[0].price}</span>
            <i class="fas fa-chevron-down text-muted" style="font-size:0.7rem;"></i>
          </div>
        </div>
        <div class="bgroup-body p-2 bg-light">
          <div class="d-flex flex-wrap gap-2">
            ${beads.map(item => `
              <div class="bswatch border shadow-sm ${item.stock === 'out' ? 'opacity-50' : ''}"
                   onclick="${item.stock !== 'out' ? `app.ui.addElement('${item.id}')` : ''}"
                   title="${item.name}"
                   style="width:34px;height:34px;border-radius:6px; cursor:pointer; background:#fff; display:flex; align-items:center; justify-content:center; position:relative;">
                <img src="${item.imgUrl}" alt="${item.name}" style="border-radius:4px; max-width:85%; max-height:85%;"/>
                ${item.stock === 'low' ? '<span class="position-absolute badge badge-warning p-1" style="top:-5px; right:-5px; font-size:10px;">!</span>' : ''}
              </div>`).join('')}
          </div>
        </div>
      </div>`).join('');
  }

  // Charms tab — image-based series grouped in accordions
  buildCharmsGrid(items) {
    const container = document.getElementById('grid-charms') || document.getElementById('charms-groups-wrap');
    if (!container) return;

    const groups = {};
    items.forEach(item => {
      const g = item.series || 'Other';
      if (!groups[g]) groups[g] = [];
      groups[g].push(item);
    });

    container.style.cssText = 'overflow-y:auto;flex:1;padding:8px;display:flex;flex-direction:column;gap:5px;';
    
    container.innerHTML = Object.entries(groups).map(([seriesName, figs], idx) => `
      <div class="bgroup charm-group ${idx === 0 ? 'open' : ''}">
        <div class="bgroup-head" onclick="this.closest('.bgroup').classList.toggle('open')">
          <div class="bgroup-head-l d-flex align-items-center">
            <img class="bgroup-preview" src="${figs[0].imgUrl}" alt="${seriesName}" style="border-radius:6px; width:24px; height:24px; margin-right:8px;"/>
            <span class="bgroup-lbl font-weight-bold text-dark">${seriesName}</span>
          </div>
          <div class="bgroup-head-r d-flex align-items-center">
            <span class="bgroup-price text-pink font-weight-bold mr-2" style="font-size: 0.8rem;">₱${figs[0].price}</span>
            <svg class="bgroup-arr" viewBox="0 0 10 10" style="width:12px; stroke:var(--ink-md); fill:none; stroke-width:2;"><polyline points="2,3 5,7 8,3"/></svg>
          </div>
        </div>
        <div class="bgroup-body bg-light p-2">
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
            ${figs.map(item => {
              // Determine Stock Style
              let stockClass = '';
              let stockText = '';
              if (item.stock === 'in') {
                stockClass = 'stock-in'; stockText = 'In Stock';
              } else if (item.stock === 'low') {
                stockClass = 'stock-low'; stockText = 'Low Stock';
              } else {
                stockClass = 'stock-out'; stockText = 'Out of Stock';
              }

              return `
              <div class="ecard charm-litem figure${item.stock === 'out' ? ' out' : ''} bg-white shadow-sm"
                   data-search="${(item.name + ' ' + seriesName).toLowerCase()}"
                   onclick="${item.stock !== 'out' ? `app.ui.addElement('${item.id}')` : ''}"
                   title="${item.name}">
                <div class="eprev-img d-flex justify-content-center align-items-center mb-2" style="height:64px;">
                  <img src="${item.imgUrl}" alt="${item.name}" style="max-width:100%; max-height:100%;"/>
                </div>
                <div class="ename font-weight-bold text-dark mb-2 text-truncate" style="font-size:0.8rem;">${item.name}</div>
                <span class="stock-badge ${stockClass}">${stockText}</span>
              </div>`;
            }).join('')}
          </div>
        </div>
      </div>`).join('');
  }

  buildBeadsPanel(items) {
    const container = document.getElementById('bead-groups');
    if(!container) return;

    const groups = {};
    items.forEach(item => {
      const g = item.group || 'Other';
      if (!groups[g]) groups[g] = [];
      groups[g].push(item);
    });

    container.innerHTML = Object.entries(groups).map(([groupName, beads], idx) => `
      <div class="bgroup ${idx === 0 ? 'open' : ''} bg-white rounded border mb-2 shadow-sm w-100">
        <div class="bgroup-head d-flex justify-content-between align-items-center p-2 border-bottom" onclick="this.closest('.bgroup').classList.toggle('open')">
          <div class="d-flex align-items-center">
            <img src="${beads[0].imgUrl}" alt="${groupName}" style="width:24px; height:24px; border-radius:4px;" class="mr-2"/>
            <span class="font-weight-bold text-dark" style="font-size: 0.85rem;">${groupName}</span>
          </div>
          <div class="d-flex align-items-center">
            <span class="badge bg-pink-light text-pink mr-2">₱${beads[0].price}</span>
            <i class="fas fa-chevron-down text-muted" style="font-size:0.7rem;"></i>
          </div>
        </div>
        <div class="bgroup-body p-2 bg-light">
          <div class="d-flex flex-wrap gap-2">
            ${beads.map(item => `
              <div class="bswatch border shadow-sm ${item.stock === 'out' ? 'opacity-50' : ''}"
                   onclick="${item.stock !== 'out' ? `app.ui.addElement('${item.id}')` : ''}"
                   title="${item.name}"
                   style="width:34px;height:34px;border-radius:50%; cursor:pointer; background:#fff; display:flex; align-items:center; justify-content:center; position:relative;">
                <img src="${item.imgUrl}" alt="${item.name}" style="max-width:85%; max-height:85%;"/>
                ${item.stock === 'low' ? '<span class="position-absolute badge badge-warning p-1" style="top:-5px; right:-5px; font-size:10px;">!</span>' : ''}
              </div>`).join('')}
          </div>
        </div>
      </div>`).join('');
  }

buildLetters() {
    const state = this.app.state;
    const isSquare = state.letterShape === 'square';
    document.getElementById('grid-ltrs').innerHTML = [...'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'].map(ch => `
      <div class="shadow-sm font-weight-bold d-inline-flex align-items-center justify-content-center" 
           onclick="app.ui.addLetter('${ch}')"
           style="background:${state.ltrColor.bg}; color:${state.ltrColor.text}; border: 2px solid var(--ink-lt);
                  width: 36px; height: 36px; border-radius:${isSquare ? '8px' : '50%'}; font-size: 1.1rem; cursor: pointer; transition: transform 0.1s;">
        ${ch}
      </div>`).join('');
  }

setLetterShape(shape, btnEl) {
    this.app.state.letterShape = shape;
    document.querySelectorAll('.lshape-btn').forEach(b => {
      b.style.background = '#fff';
      b.style.color = 'var(--ink-md)';
      b.style.border = '1px solid #ced4da';
      b.classList.remove('active');
    });
    btnEl.classList.add('active');
    btnEl.style.background = 'var(--pink-bg)';
    btnEl.style.color = 'var(--pink)';
    btnEl.style.border = '1px solid var(--pink-dk)';
    this.buildLetters();
  }

  // BOOTSTRAP INSPECTOR PANEL
// 1. UPDATE INSPECTOR TO USE THEME COLORS
  updateInspector(el) {
    const b = document.getElementById('insp-body');
    if (!el) { 
      b.innerHTML = '<div class="text-center p-4 text-muted font-weight-bold"><i data-lucide="mouse-pointer-click" class="mb-2" style="width: 28px; height: 28px; color: var(--pink); opacity: 0.5;"></i><br>Click any element on the canvas to edit</div>'; 
      if(window.lucide) lucide.createIcons();
      return; 
    }

    // Determine stock badge styling based on your theme
    let stockStyle = '';
    let stockText = '';
    if (el.stock === 'in') {
      stockStyle = 'background: var(--lime-bg); color: var(--lime-dk); border: 1px solid var(--lime);';
      stockText = 'In Stock';
    } else if (el.stock === 'low') {
      stockStyle = 'background: #FFF7E0; color: #A07200; border: 1px solid #FFD93D;';
      stockText = 'Low Stock';
    } else {
      stockStyle = 'background: var(--pink-bg); color: var(--pink-dk); border: 1px solid var(--pink);';
      stockText = 'Out of Stock';
    }

    b.innerHTML = `
      <div class="p-3 bg-white">
        <div class="d-flex align-items-center mb-3">
          <div class="mr-3 bg-light border rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
            <img src="${el.imgUrl}" style="max-width: 80%; max-height: 80%;" />
          </div>
          <div class="flex-grow-1">
            <div class="font-weight-bold text-dark" style="font-size: 1rem; line-height: 1.2;">${el.name}</div>
            <span class="badge mt-1" style="background: var(--pink-bg); color: var(--pink); border: 1px solid var(--pink-dk); font-size: 0.8rem;">₱${el.price || 8}</span>
          </div>
        </div>
        <div class="mb-3 d-flex" style="gap: 8px;">
          <span class="badge" style="background: var(--offwhite); color: var(--ink-md); border: 1px solid var(--ink-lt); padding: 6px; text-transform: uppercase;">${el.category || 'bead'}</span>
          <span class="badge" style="padding: 6px; text-transform: uppercase; ${stockStyle}">
            ${stockText}
          </span>
        </div>
        <div class="d-flex justify-content-between" style="gap: 8px;">
          <button class="btn font-weight-bold w-100 d-flex align-items-center justify-content-center" style="background: var(--teal-bg); color: var(--teal-dk); border: 1px solid var(--teal);" onclick="app.ui.dupeBead('${el.uid}')">
            <i data-lucide="copy" class="mr-1" style="width:14px;"></i> Dupe
          </button>
          <button class="btn font-weight-bold w-100 d-flex align-items-center justify-content-center" style="background: var(--pink-bg); color: var(--pink-dk); border: 1px solid var(--pink);" onclick="app.ui.removeBead('${el.uid}')">
            <i data-lucide="trash-2" class="mr-1" style="width:14px;"></i> Remove
          </button>
        </div>
      </div>`;
    if(window.lucide) lucide.createIcons();
  }

  setProduct(el) {
    this.app.state.product = el.dataset.prod;
    this.app.state.basePrice = +el.dataset.price;
    this.app.state.maxBeads = +el.dataset.max;
    this.updateCounters();
    this.app.render();
  }
  setStrCol(col, el) {
    this.app.state.strColor = col;
    document.querySelectorAll('#str-sw .sw').forEach(s => s.classList.remove('active', 'border-dark'));
    el.classList.add('active', 'border-dark');
    this.app.render();
  }
  setRingCol(col, el) {
    this.app.state.ringColor = col;
    document.querySelectorAll('#ring-sw .sw').forEach(s => s.classList.remove('active', 'border-dark'));
    el.classList.add('active', 'border-dark');
    this.app.render();
  }
  setStrType(type) { this.app.state.strType = type; this.app.render(); }
  setLtrCol(bg, text, el) {
    this.app.state.ltrColor = { bg, text };
    document.querySelectorAll('#ltr-sw .sw').forEach(s => s.classList.remove('active', 'border-dark'));
    el.classList.add('active', 'border-dark');
    this.buildLetters();
  }
  setClasp(c, el) {
    this.app.state.clasp = c;
    document.querySelectorAll('.cpill').forEach(p => p.classList.remove('active', 'bg-pink-light', 'text-pink', 'border-pink'));
    el.classList.add('active', 'bg-pink-light', 'text-pink', 'border-pink');
    this.app.render();
  }
  setView(v) {
    this.app.state.view = v;
    document.getElementById('vt-sil').classList.toggle('active', v === 'silhouette');
    document.getElementById('vt-flat').classList.toggle('active', v === 'flatlay');
    this.app.render();
  }

  toggleSec(id) { 
    const el = document.getElementById(id);
    el.classList.toggle('open'); 
    const icon = el.querySelector('.psec-arr');
    if(icon) {
      icon.style.transform = el.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
      icon.style.transition = 'transform 0.2s';
    }
  }

  setStrandCount(n, btnEl) {
    this.app.state.keychainStrands = n;
    if (this.app.state.activeStrand >= n) this.app.state.activeStrand = 0;
    document.querySelectorAll('.strand-count-btn').forEach(b => b.classList.remove('active', 'btn-pink'));
    document.querySelectorAll('.strand-count-btn').forEach(b => b.classList.add('btn-outline-secondary'));
    btnEl.classList.remove('btn-outline-secondary');
    btnEl.classList.add('active', 'btn-pink');
    this.app.render();
  }

  setActiveStrand(n, btnEl) {
    this.app.state.activeStrand = n;
    this.app.render();
  }

  setRingType(type, btnEl) {
    this.app.state.ringType = type;
    document.querySelectorAll('.ring-type-btn').forEach(b => b.classList.remove('active', 'btn-pink'));
    document.querySelectorAll('.ring-type-btn').forEach(b => b.classList.add('btn-outline-secondary'));
    btnEl.classList.remove('btn-outline-secondary');
    btnEl.classList.add('active', 'btn-pink');
    this.app.render();
  }

switchTab(el) {
    const tab = el.dataset.tab;
    ['beads', 'figures', 'charms', 'letters'].forEach(t => {
      const el2 = document.getElementById('tab-' + t);
      if (el2) {
        // Because of Bootstrap's flex utilities, we need to explicitly use flex here
        el2.style.setProperty('display', t === tab ? 'flex' : 'none', 'important');
      }
    });
    
    document.querySelectorAll('.ltab').forEach(t => {
      t.style.color = '#6c757d'; 
      t.style.borderBottomColor = 'transparent';
      t.classList.remove('active');
    });
    
    el.classList.add('active');
    el.style.color = 'var(--pink)';
    el.style.borderBottomColor = 'var(--pink)';
  }

  filterCharms(input, target) {
    const q = input.value.trim().toLowerCase();
    const wrap = document.getElementById(target);
    if (!wrap) return;

    if (target === 'charms-groups-wrap') {
      const items = wrap.querySelectorAll('.charm-litem');
      items.forEach(item => {
        const haystack = (item.dataset.search || '').toLowerCase();
        const match = !q || haystack.includes(q);
        item.style.display = match ? '' : 'none';
      });

      wrap.querySelectorAll('.charm-group').forEach(group => {
        const anyVisible = [...group.querySelectorAll('.charm-litem')].some(el => el.style.display !== 'none');
        group.style.display = anyVisible ? '' : 'none';
      });
    } else {
      const items = wrap.querySelectorAll('.litem');
      items.forEach(item => {
        const name = (item.dataset.name || '').toLowerCase();
        item.style.display = (!q || name.includes(q)) ? '' : 'none';
      });
    }
  }

  renderToCanvas(targetCanvas, W, H) {
    targetCanvas.width = W; targetCanvas.height = H;
    const ctx = targetCanvas.getContext('2d');
    ctx.fillStyle = '#FFFFFF'; ctx.fillRect(0, 0, W, H);
    const previousSelection = this.app.state.selectedId;
    this.app.state.selectedId = null;
    this.app.canvasEngine.draw(targetCanvas, this.app.state, false);
    this.app.state.selectedId = previousSelection;
  }

  downloadDesign() {
    const ec = document.createElement('canvas');
    this.renderToCanvas(ec, 680, 480);
    const link = document.createElement('a');
    link.download = `artsycrate-design-${Date.now()}.png`;
    link.href = ec.toDataURL('image/png');
    link.click();
    this.showToast('Downloaded!');
  }

  // BOOTSTRAP PREVIEW MODAL INTEGRATION
  openPreview() {
    const state = this.app.state;
    const ec = state.elems.reduce((s, e) => s + (e.price || 8), 0);
    const lenVal = document.getElementById('length-sel')?.value || 'medium';
    const lenMap = { small: '16cm', medium: '18cm', large: '20cm', custom: 'Custom' };
    const prodMap = { bracelet: 'Bracelet', necklace: 'Necklace', keychain: 'Keychain' };

    document.getElementById('prev-info').innerHTML = `
      <div class="d-flex justify-content-between border-bottom py-2"><span class="text-muted font-weight-bold text-uppercase" style="font-size:0.75rem;">Product</span><span class="font-weight-bold text-dark">${prodMap[state.product]}</span></div>
      <div class="d-flex justify-content-between border-bottom py-2"><span class="text-muted font-weight-bold text-uppercase" style="font-size:0.75rem;">Elements</span><span class="font-weight-bold text-dark">${state.elems.length}</span></div>
      <div class="d-flex justify-content-between border-bottom py-2"><span class="text-muted font-weight-bold text-uppercase" style="font-size:0.75rem;">Length</span><span class="font-weight-bold text-dark">${lenMap[lenVal] || 'Standard'}</span></div>
      <div class="d-flex justify-content-between py-2 mt-1"><span class="text-muted font-weight-bold text-uppercase" style="font-size:0.75rem;">Est. Price</span><span class="font-weight-bold text-pink" style="font-size:1.1rem;">₱${state.basePrice + ec}</span></div>`;

    if (typeof $ !== 'undefined') {
      $('#prev-modal').modal('show');
    }
this.renderToCanvas(document.getElementById('preview-canvas'), 680, 480);  }

openOrder() {
    const state = this.app.state;

    // 1. Validate that the canvas isn't empty
    if (!state.elems.length) {
      this.showToast('Add at least one element first!');
      return;
    }

    // Optional: Make the button look like it's loading
    const btn = document.querySelector('.btn-order');
    if (btn) {
      btn.style.pointerEvents = 'none';
      btn.innerHTML = 'Preparing... <i data-lucide="loader" class="fa-spin" style="width:14px; margin-left:6px;"></i>';
      if(window.lucide) lucide.createIcons();
    }

    // 2. Render canvas to a base64 PNG snapshot
    const snapshotDataUrl = this._captureSnapshot(680, 480);

    // 3. Read the length & string type from the DOM
    const lenEl     = document.getElementById('length-sel');
    const lenText   = lenEl?.selectedOptions[0]?.text || lenEl?.value || 'Standard';
    const strTypeEl = document.getElementById('str-type');

    // 4. Build a hidden form to seamlessly POST data to Laravel
    const form = document.createElement('form');
    form.method = 'POST';
    
    // 👇 IMPORTANT: Change this URL to match your Laravel route that handles the checkout transition!
    // (e.g., if your route is Route::post('/builder/checkout', ...))
    form.action = '/builder/order/preview';  
    
    form.style.display = 'none';

    // 5. Package all the data
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const fields = {
      _token:            csrfToken,
      design:            JSON.stringify(state.elems),
      snapshot:          snapshotDataUrl,
      product_slug:      state.product,
      length:            lenText,
      str_color:         state.strColor          || '',
      str_type:          strTypeEl?.value        || state.strType || '',
      clasp:             state.clasp             || '',
      view:              state.view              || '',
      keychain_strands:  state.keychainStrands   || 1,
      ring_type:         state.ringType          || '',
      ring_color:        state.ringColor         || '',
      letter_bg_color:   state.ltrColor?.bg      || '',
      letter_text_color: state.ltrColor?.text    || '',
      letter_shape:      state.letterShape       || '',
    };

    // 6. Attach data to form and submit
    Object.entries(fields).forEach(([name, value]) => {
      const input = document.createElement('input');
      input.type  = 'hidden';
      input.name  = name;
      input.value = value ?? '';
      form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
  }

  closeModal(id) {
    if (typeof $ !== 'undefined') {
      $(`#${id}`).modal('hide');
    }
  }

  async submitOrder() {
    const state = this.app.state;
  
    const firstName = document.getElementById('order-first-name')?.value.trim();
    const lastName  = document.getElementById('order-last-name')?.value.trim();
    const contact   = document.getElementById('order-contact')?.value.trim();
    const notes     = document.getElementById('order-notes')?.value.trim();
  
    if (!firstName || !lastName || !contact) { 
      this.showToast('Please fill all required fields!'); 
      return; 
    }
    if (state.elems.length === 0) { 
      this.showToast('Your design is empty!'); 
      return; 
    }
  
    const btn = document.getElementById('order-submit-btn');
    const originalText = btn?.innerHTML;
    if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...'; }
  
    try {
      const snapshotDataUrl = this._captureSnapshot(680, 480);
      const lengthSelect  = document.getElementById('length-sel');
      const lengthText    = lengthSelect?.selectedOptions[0]?.text || lengthSelect?.value || '';
      const elemCost      = state.elems.reduce((s, e) => s + (e.price || 8), 0);
      const totalPrice    = state.basePrice + elemCost;
  
      const items = state.elems.map((el, i) => ({
        element_slug      : el.isLetter ? null : (el.slug || el.id || null),
        letter            : el.isLetter ? el.label : null,
        letter_bg         : el.isLetter ? el.ltrBg   : null,
        letter_text_color : el.isLetter ? el.ltrText  : null,
        letter_shape      : el.isLetter ? (el.letterShape || null) : null,
        strand            : el.strand ?? 0,
        price             : el.price || 8,
      }));
  
      const payload = {
        first_name     : firstName,
        last_name      : lastName,
        contact_number : contact,
        notes          : notes || null,
        product_slug   : window.BUILDER_PRODUCT?.product ? this._productToSlug(window.BUILDER_PRODUCT.product) : 'keychain-standard',
        length         : lengthText,
        base_price     : state.basePrice,
        elements_cost  : elemCost,
        total_price    : totalPrice,
        design_json    : JSON.stringify(state.elems),
        snapshot       : snapshotDataUrl,
        str_color      : state.strColor   || null,
        str_type       : state.strType    || null,
        clasp          : state.clasp      || null,
        view           : state.view       || null,
        keychain_strands : state.keychainStrands || 1,
        ring_type      : state.ringType   || null,
        ring_color     : state.ringColor  || null,
        letter_bg_color   : state.ltrColor?.bg   || null,
        letter_text_color : state.ltrColor?.text  || null,
        letter_shape      : state.letterShape    || null,
        items,
      };
  
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || window.CSRF_TOKEN || '';
      const response = await fetch('/builder/order', {
        method : 'POST',
        headers: {
          'Content-Type'    : 'application/json',
          'Accept'          : 'application/json',
          'X-CSRF-TOKEN'    : csrfToken,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify(payload),
      });
  
      const data = await response.json();
  
      if (!response.ok || !data.success) {
        throw new Error(data.message || 'Server error. Please try again.');
      }
  
      // Simulate Success View using Bootstrap classes
      const formView = document.getElementById('order-form-view');
      formView.innerHTML = `
        <div class="text-center p-4">
          <i class="fas fa-check-circle text-success mb-3" style="font-size: 3rem;"></i>
          <h4 class="font-weight-bold text-dark">Order Placed!</h4>
          <p class="text-muted">Your order code is:</p>
          <div class="bg-pink-light text-pink border border-pink rounded p-3 mb-3 d-inline-block font-weight-bold" style="font-size: 1.5rem; letter-spacing: 2px;">
            ${data.order_code || 'SUCCESS'}
          </div>
          <p class="text-sm text-muted">We'll contact you at your number to confirm.</p>
          <button class="btn btn-pink w-100 font-weight-bold" onclick="app.ui.closeModal('order-modal'); setTimeout(() => location.reload(), 500);">Done</button>
        </div>
      `;
  
    } catch (err) {
      this.showToast(err.message || 'Something went wrong.');
      console.error('[ArtsyCrate] Order submission error:', err);
    } finally {
      if (btn) { btn.disabled = false; btn.innerHTML = originalText; }
    }
  }

  _productToSlug(product) {
    const map = { bracelet : 'bracelet-standard', necklace : 'necklace-standard', keychain : 'keychain-standard' };
    return map[product] || product;
  }

  _captureSnapshot(W = 680, H = 480) {
    const offscreen = document.createElement('canvas');
    offscreen.width  = W;
    offscreen.height = H;
    const ctx = offscreen.getContext('2d');
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';
    ctx.fillStyle = '#FFFFFF';
    ctx.fillRect(0, 0, W, H);
    const savedSelection = this.app.state.selectedId;
    this.app.state.selectedId = null;
    this.app.canvasEngine.draw(offscreen, this.app.state, false);
    this.app.state.selectedId = savedSelection;
    return offscreen.toDataURL('image/png');
  }

  // BOOTSTRAP TOAST IMPLEMENTATION
  showToast(msg) {
    let t = document.getElementById('toast');
    if (!t) {
      t = document.createElement('div');
      t.id = 'toast';
      document.body.appendChild(t);
    }
    
    // Inject Bootstrap utility classes to the dynamically created/grabbed toast
    t.className = 'toast position-fixed bg-dark text-white py-2 px-4 rounded-pill shadow align-items-center justify-content-center font-weight-bold';
    t.style.bottom = '20px';
    t.style.left = '50%';
    t.style.transform = 'translateX(-50%)';
    t.style.zIndex = '9999';
    t.style.opacity = '1';
    t.style.transition = 'opacity 0.3s ease-in-out';
    t.style.display = 'flex';
    t.innerHTML = `<i class="fas fa-info-circle mr-2"></i> ${msg}`;

    clearTimeout(this.toastTimer);
    this.toastTimer = setTimeout(() => {
      t.style.opacity = '0';
      setTimeout(() => t.style.display = 'none', 300);
    }, 2600);
  }
}