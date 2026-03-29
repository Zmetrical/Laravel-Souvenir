{{--
  Shared form partial — used by create.blade.php and edit.blade.php
  Standardized to ArtsyCrate "App" Design System
--}}

@php
  $isEdit      = isset($element) && $element->exists;
  $lockedCat   = $preCategory ?? ($isEdit ? $element->category : 'beads');
  $old         = fn($field, $default = null) => old($field, $isEdit ? $element->$field : $default);

  $allShapes = [
    'beads' => [
      'Basic' => ['round', 'ellipse', 'tube', 'pearl', 'faceted'],
    ],
    'figures' => [
      'Cubes'     => [
        'cube', 'cube-dice1', 'cube-dice2', 'cube-dice3',
        'cube-dice4', 'cube-dice5', 'cube-dice6',
        'cube-heart', 'cube-star', 'cube-checker', 'cube-smile',
      ],
      'Celestial' => ['star', 'moon', 'sun', 'heart'],
      'Florals'   => ['flower', 'daisy', 'leaf', 'clover', 'tulip'],
      'Bugs'      => ['butterfly', 'ladybug', 'bee'],
      'Sea Life'  => ['shell', 'fish'],
      'Sweets'    => ['candy', 'donut', 'cupcake'],
      'Fruit'     => ['cherry', 'apple', 'strawberry'],
    ],
  ];

  $allShapes = $allShapes[$lockedCat] ?? [];

  $shapeToGroup = [];
  foreach ($allShapes as $grp => $opts) {
    foreach ($opts as $s) {
      $shapeToGroup[$s] = $grp;
    }
  }

  $catMeta = [
    'beads'   => ['label' => 'Bead',   'color' => 'var(--pink)',   'text' => 'var(--pink-dk)',   'icon' => 'circle'],
    'figures' => ['label' => 'Figure', 'color' => 'var(--teal)',   'text' => 'var(--teal-dk)',   'icon' => 'box'],
    'charms'  => ['label' => 'Charm',  'color' => 'var(--purple)', 'text' => 'var(--purple-dk)', 'icon' => 'sparkles'],
  ];
  $meta     = $catMeta[$lockedCat];
  $catLabel = $meta['label'];
@endphp

<style>
/* ── Shape Tiles ── */
.shape-tile {
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  gap: 8px; padding: 12px 4px; border-radius: 12px; border: 2px solid var(--grey-200);
  background: var(--offwhite); cursor: pointer; transition: all 0.2s; min-height: 85px;
}
.shape-tile:hover { border-color: var(--grey-300); transform: translateY(-2px); }
.shape-tile.selected { border-color: var(--pink); background: var(--pink-bg); box-shadow: 0 4px 12px rgba(255,95,160,0.1); }

/* ── Variation rows ── */
.var-row {
  display: grid; grid-template-columns: 44px 1fr 160px 40px; gap: 12px;
  align-items: center; padding: 12px; border-radius: 12px;
  background: var(--white); border: 1.5px solid var(--grey-200); margin-bottom: 8px;
}
.var-row.is-primary { border-color: var(--pink); background: var(--pink-bg); position: relative; }
.var-row.is-primary::after { content: 'PRIMARY'; position: absolute; top: -8px; left: 12px; font-size: 0.6rem; font-weight: 900; background: var(--pink); color: #fff; padding: 2px 8px; border-radius: 4px; }

.var-remove-btn { background: var(--offwhite); border: 1.5px solid var(--grey-200); color: var(--ink-md); padding: 8px; border-radius: 8px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; }
.var-remove-btn:hover { background: #FEE2E2; color: #DC2626; border-color: #FECACA; }

/* ── Form Styling Overrides ── */
.form-section-title { font-family: var(--fh); font-size: 0.85rem; color: var(--ink-md); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
.form-section-title::after { content: ''; flex: 1; height: 1.5px; background: var(--grey-100); }

.hex-input { font-family: monospace; font-weight: 800; text-transform: uppercase; }

.smart-btn-sub { font-size: 0.75rem; font-weight: 700; opacity: 0.9; display: block; margin-top: 2px; }
</style>

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="element-form">
  @csrf
  @if($method === 'PUT') @method('PUT') @endif
  <input type="hidden" name="category" value="{{ $lockedCat }}"/>
  <input type="hidden" name="_mode" id="mode-input" value="single"/>

  <div class="row g-4">
    {{-- ══ LEFT COLUMN ══ --}}
    <div class="col-lg-7">
      
      {{-- Basic Info Card --}}
      <div class="ac-card mb-4">
        <div class="ac-card-header">
          <i data-lucide="info"></i> Basic Details
          <span class="ms-auto" style="padding: 4px 12px; border-radius: 8px; font-size: 0.7rem; font-weight: 900; text-transform: uppercase; background: {{ $meta['color'] }}22; color: {{ $meta['text'] }}; border: 1.5px solid {{ $meta['color'] }};">
            {{ $catLabel }} Element
          </span>
        </div>
        <div class="p-4">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label">Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="base-name-input" value="{{ $old('name') }}" class="form-control" placeholder="e.g. Round Blush" oninput="autoSlug(this.value); syncPrimaryLabel()"/>
            </div>
            <div class="col-md-4">
              <label class="form-label">Slug <span class="text-danger">*</span></label>
              <input type="text" name="slug" id="slug-input" value="{{ $old('slug') }}" class="form-control font-monospace" placeholder="auto-generated"/>
            </div>
            <div class="col-md-6">
              <label class="form-label">Group / Series</label>
              <input type="text" name="group" id="group-input" value="{{ $old('group') }}" class="form-control" placeholder="{{ $lockedCat === 'charms' ? 'e.g. Sanrio, BTS...' : 'Select a shape to auto-fill' }}"/>
            </div>
            <div class="col-md-3">
              <label class="form-label">Price (₱)</label>
              <input type="number" name="price" value="{{ $old('price', 8) }}" class="form-control fw-bold" style="color: var(--pink);"/>
            </div>
            <div class="col-md-3">
              <label class="form-label">Stock</label>
              <select name="stock" class="form-select">
                <option value="in" {{ $old('stock') == 'in' ? 'selected' : '' }}>In Stock</option>
                <option value="low" {{ $old('stock') == 'low' ? 'selected' : '' }}>Low Stock</option>
                <option value="out" {{ $old('stock') == 'out' ? 'selected' : '' }}>Out of Stock</option>
              </select>
            </div>
          </div>

          <div class="d-flex gap-4 mt-4">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $old('is_active', true) ? 'checked' : '' }}/>
              <label class="form-check-label fw-bold small" for="is_active">Visible in Builder</label>
            </div>
            @if($lockedCat === 'beads')
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_small" id="is_small" value="1" {{ $old('is_small') ? 'checked' : '' }} onchange="schedulePreview()"/>
                <label class="form-check-label fw-bold small" for="is_small">Small Bead</label>
              </div>
            @endif
          </div>
        </div>
      </div>

      {{-- Shape / Image Picker Card --}}
      <div class="ac-card mb-4">
        <div class="ac-card-header">
          <i data-lucide="{{ $lockedCat === 'charms' ? 'image' : 'shapes' }}"></i>
          {{ $lockedCat === 'charms' ? 'Charm Visual' : 'Shape & Color' }}
          @if(!$isEdit)
            <button type="button" class="ms-auto btn-ghost" style="padding: 4px 10px; font-size: 0.75rem;" onclick="toggleVarSection()">
              <i data-lucide="layers" style="width: 14px;"></i> <span id="var-toggle-label">+ Variations</span>
            </button>
          @endif
        </div>
        <div class="p-4">
          @if($lockedCat !== 'charms')
            {{-- Shape Grid --}}
            <label class="form-label mb-3">Select Shape <span class="text-danger">*</span></label>
            <input type="hidden" name="shape" id="shape-select" value="{{ $old('shape') }}"/>
            <div id="shape-picker" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(75px, 1fr)); gap: 10px;">
              @foreach($allShapes as $grp => $opts)
                <div style="grid-column: 1/-1;" class="form-section-title mt-2">{{ $grp }}</div>
                @foreach($opts as $s)
                  @php $isSel = ($old('shape') === $s); @endphp
                  <div class="shape-tile {{ $isSel ? 'selected' : '' }}" data-shape="{{ $s }}" onclick="selectShape('{{ $s }}', this)">
                    <canvas class="shape-tile-canvas" width="40" height="40" data-shape="{{ $s }}" data-color="{{ $old('color', '#F9B8CF') }}" data-detail="{{ $old('detail_color', '#C0136A') }}"></canvas>
                    <span style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">{{ $s }}</span>
                  </div>
                @endforeach
              @endforeach
            </div>

            {{-- Main Color Selectors --}}
            <div class="row g-3 mt-4 pt-4 border-top">
              <div class="col-md-6">
                <label class="form-label">Base Color</label>
                <div class="d-flex gap-2">
                  <input type="color" name="color" id="color-pick" value="{{ $old('color', '#F9B8CF') }}" class="form-control form-control-color" oninput="syncColorInput(this, 'color-hex')"/>
                  <input type="text" id="color-hex" value="{{ $old('color', '#F9B8CF') }}" class="form-control hex-input" oninput="syncPickerInput(this, 'color-pick')"/>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Detail Color</label>
                <div class="d-flex gap-2">
                  <input type="color" name="detail_color" id="detail-pick" value="{{ $old('detail_color', '#C0136A') }}" class="form-control form-control-color" oninput="syncColorInput(this, 'detail-hex')"/>
                  <input type="text" id="detail-hex" value="{{ $old('detail_color', '#C0136A') }}" class="form-control hex-input" oninput="syncPickerInput(this, 'detail-pick')"/>
                </div>
              </div>
            </div>
          @else
            {{-- Charm Upload --}}
            <div class="row g-4 align-items-center">
              <div class="col-md-8">
                <label class="form-label">Upload Image File</label>
                <input type="file" name="img_file" class="form-control" accept="image/*" onchange="previewUploadedImage(this); syncPrimaryCharmRow(this)"/>
                <div class="form-text">Transparent PNG recommended.</div>
              </div>
              @if($isEdit && $element->img_path)
                <div class="col-md-4 text-center">
                  <div style="padding: 10px; background: var(--offwhite); border: 1.5px solid var(--grey-200); border-radius: 12px;">
                    <img src="{{ asset('img/builder/' . $element->img_path) }}" style="max-width: 100%; height: 60px; object-fit: contain;"/>
                    <div style="font-size: 0.6rem; font-weight: 800; color: var(--ink-md); margin-top: 4px;">CURRENT</div>
                  </div>
                </div>
              @endif
            </div>
          @endif

          {{-- ── Bulk Variation System ── --}}
          <div id="var-section-body" style="display: none;" class="mt-4 pt-4 border-top">
            <div class="form-section-title mb-4">Color Variations</div>
            <div id="variation-list">
               {{-- Dynamic Rows Go Here --}}
            </div>
            <button type="button" class="btn-ghost w-100 justify-content-center mt-2" onclick="{{ $lockedCat === 'charms' ? 'addCharmVariation()' : 'addVariation()' }}">
              <i data-lucide="plus-circle"></i> Add Another Variation
            </button>
          </div>
        </div>
      </div>
    </div>

    {{-- ══ RIGHT COLUMN ══ --}}
    <div class="col-lg-5">
      <div class="ac-card" style="position: sticky; top: 20px;">
        <div class="ac-card-header"><i data-lucide="eye"></i> Live Preview</div>
        <div class="p-4">
          <div style="background: var(--offwhite); border: 1.5px solid var(--grey-200); border-radius: 16px; height: 200px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; background-image: radial-gradient(var(--grey-200) 1px, transparent 1px); background-size: 16px 16px;">
            @if($lockedCat === 'charms')
              <div id="charm-img-preview" style="text-align: center;">
                <img id="charm-img" src="{{ ($isEdit && $element->img_path) ? asset('img/builder/' . $element->img_path) : '' }}" style="max-height: 140px; {{ ($isEdit && $element->img_path) ? '' : 'display:none;' }}"/>
                @if(!$isEdit || !$element->img_path)
                  <div id="charm-placeholder" class="text-muted"><i data-lucide="image" style="width: 48px; height: 48px; opacity: 0.2;"></i></div>
                @endif
              </div>
            @else
              <canvas id="preview-canvas" width="140" height="140"></canvas>
            @endif
          </div>

          <div style="background: var(--grey-50); border-radius: 12px; padding: 16px; border: 1.5px solid var(--grey-200);">
            <div class="d-flex justify-content-between mb-2">
              <span class="form-label mb-0">Category</span>
              <span class="fw-bold">{{ ucfirst($lockedCat) }}</span>
            </div>
            <div class="d-flex justify-content-between">
              <span class="form-label mb-0">Mode</span>
              <span id="mode-badge" class="badge" style="background: var(--teal-bg); color: var(--teal-dk); font-weight: 900;">SINGLE ENTRY</span>
            </div>
          </div>

          <div class="mt-4 pt-2">
            <button type="button" id="smart-submit" onclick="handleSmartSubmit()" class="btn-pink w-100 justify-content-center" style="padding: 16px;">
              <i data-lucide="{{ $isEdit ? 'save' : 'plus-circle' }}" style="width: 20px;"></i>
              <div class="text-start">
                <span id="smart-submit-label">{{ $isEdit ? 'Save Changes' : 'Create Element' }}</span>
                <span id="smart-submit-sub" class="smart-btn-sub" style="display: none;"></span>
              </div>
            </button>
            <a href="{{ url()->previous() }}" class="btn-ghost w-100 justify-content-center mt-2 border-0" style="color: var(--ink-md);">Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

@push('scripts')
@vite(['resources/js/shapes.js'])
<script>
  const LOCKED_CAT = '{{ $lockedCat }}';
  const IS_EDIT = {{ $isEdit ? 'true' : 'false' }};
  const SHAPE_GROUPS = @json($shapeToGroup);
  let variationIndex = 0;

  function selectShape(shape, el) {
    document.getElementById('shape-select').value = shape;
    document.querySelectorAll('.shape-tile').forEach(t => t.classList.remove('selected'));
    el.classList.add('selected');
    if (!IS_EDIT && SHAPE_GROUPS[shape]) document.getElementById('group-input').value = SHAPE_GROUPS[shape];
    updatePreview();
  }

  function syncColorInput(picker, hexId) {
    document.getElementById(hexId).value = picker.value.toUpperCase();
    updatePreview();
    refreshAllTiles();
  }

  function syncPickerInput(hexInput, pickerId) {
    if(/^#[0-9A-F]{6}$/i.test(hexInput.value)) {
      document.getElementById(pickerId).value = hexInput.value;
      updatePreview();
      refreshAllTiles();
    }
  }

  function updatePreview() {
    if (LOCKED_CAT === 'charms') return;
    const canvas = document.getElementById('preview-canvas');
    const shape = document.getElementById('shape-select').value || 'round';
    const color = document.getElementById('color-pick').value;
    const detail = document.getElementById('detail-pick').value;
    const isSmall = document.getElementById('is_small')?.checked || false;
    if (window.ArtshapeRenderer) ArtshapeRenderer.draw(canvas, { shape, color, detail, small: isSmall });
  }

  function toggleVarSection() {
    const section = document.getElementById('var-section-body');
    const label = document.getElementById('var-toggle-label');
    section.style.display = section.style.display === 'none' ? 'block' : 'none';
    label.innerText = section.style.display === 'none' ? '+ Variations' : 'Hide Variations';
  }

  function handleSmartSubmit() {
    const extraRows = document.querySelectorAll('#variation-list .var-row').length;
    document.getElementById('mode-input').value = extraRows > 0 ? 'bulk' : 'single';
    document.getElementById('element-form').submit();
  }

  function addVariation() {
    const list = document.getElementById('variation-list');
    const idx = variationIndex++;
    const row = document.createElement('div');
    row.className = 'var-row';
    row.innerHTML = `
      <canvas class="var-canvas" width="36" height="36" data-idx="${idx}"></canvas>
      <input type="text" name="variations[${idx}][suffix]" class="form-control" placeholder="Suffix (e.g. Blue)"/>
      <div class="d-flex gap-2">
        <input type="color" name="variations[${idx}][color]" value="#F9B8CF" class="form-control form-control-color" style="width:40px;"/>
        <input type="color" name="variations[${idx}][detail]" value="#C0136A" class="form-control form-control-color" style="width:40px;"/>
      </div>
      <button type="button" class="var-remove-btn" onclick="this.parentElement.remove(); updateSmartButton();"><i data-lucide="x" style="width:14px;"></i></button>
    `;
    list.appendChild(row);
    lucide.createIcons();
    updateSmartButton();
  }

// ─── Draw a specific variation canvas ──────────────────────────────────────
function renderVarCanvas(idx) {
    const canvas = document.querySelector(`.var-canvas[data-idx="${idx}"]`);
    if (!canvas || !window.ArtshapeRenderer) return;

    // Get values directly from the inputs in this specific row
    const color = document.querySelector(`input[name="variations[${idx}][color]"]`).value;
    const detail = document.querySelector(`input[name="variations[${idx}][detail]"]`).value;
    const shape = document.getElementById('shape-select').value || 'round';
    const isSmall = document.getElementById('is_small')?.checked || false;

    // Trigger the renderer
    ArtshapeRenderer.draw(canvas, { 
        shape: shape, 
        color: color, 
        detail: detail, 
        small: isSmall 
    });
}

// ─── Add Variation Row ──────────────────────────────────────────────────────
function addVariation() {
    const list = document.getElementById('variation-list');
    const idx = variationIndex++; // Increment global index
    const row = document.createElement('div');
    row.className = 'var-row';
    
    // We pass 'this.value' into renderVarCanvas whenever the color picker changes
    row.innerHTML = `
      <canvas class="var-canvas" width="44" height="44" data-idx="${idx}" style="width:44px; height:44px;"></canvas>
      <input type="text" name="variations[${idx}][suffix]" class="form-control" placeholder="Suffix (e.g. Blue)"/>
      <div class="d-flex gap-2">
        <input type="color" name="variations[${idx}][color]" value="#F9B8CF" 
               class="form-control form-control-color" style="width:40px;"
               oninput="renderVarCanvas(${idx})">
        <input type="color" name="variations[${idx}][detail]" value="#C0136A" 
               class="form-control form-control-color" style="width:40px;"
               oninput="renderVarCanvas(${idx})">
      </div>
      <button type="button" class="var-remove-btn" onclick="this.parentElement.remove(); updateSmartButton();">
        <i data-lucide="x" style="width:14px;"></i>
      </button>
    `;

    list.appendChild(row);
    lucide.createIcons();
    
    // 💡 IMPORTANT: Draw it immediately after adding to DOM
    setTimeout(() => renderVarCanvas(idx), 10); 
    updateSmartButton();
}

// ─── Sync variations if the base shape changes ──────────────────────────────
function selectShape(shape, el) {
    document.getElementById('shape-select').value = shape;
    document.querySelectorAll('.shape-tile').forEach(t => t.classList.remove('selected'));
    el.classList.add('selected');
    
    if (!IS_EDIT && SHAPE_GROUPS[shape]) {
        document.getElementById('group-input').value = SHAPE_GROUPS[shape];
    }

    updatePreview(); // Update large preview
    
    // 💡 ALSO update all existing variation canvases to the new shape
    document.querySelectorAll('.var-canvas').forEach(canvas => {
        renderVarCanvas(canvas.dataset.idx);
    });
}
  function updateSmartButton() {
    const extraRows = document.querySelectorAll('#variation-list .var-row').length;
    const label = document.getElementById('smart-submit-label');
    const sub = document.getElementById('smart-submit-sub');
    const mode = document.getElementById('mode-badge');
    if (extraRows > 0) {
      label.innerText = `Add Element + ${extraRows} Variations`;
      sub.innerText = `Creating ${extraRows + 1} elements total`;
      sub.style.display = 'block';
      mode.innerText = 'BULK MODE';
      mode.style.background = 'var(--pink-bg)';
      mode.style.color = 'var(--pink-dk)';
    } else {
      label.innerText = 'Create Element';
      sub.style.display = 'none';
      mode.innerText = 'SINGLE ENTRY';
      mode.style.background = 'var(--teal-bg)';
      mode.style.color = 'var(--teal-dk)';
    }
  }

  document.addEventListener('artshape:ready', () => {
    updatePreview();
    refreshAllTiles();
  });
</script>
@endpush