{{--
  Shared form partial — used by create.blade.php and edit.blade.php
  Variables:
    $element     — Element model (or absent for create)
    $seriesList  — collection of ElementSeries
    $action      — form action URL
    $method      — 'POST' or 'PUT'
    $preCategory — 'beads' | 'figures' | 'charms'  (locks the category radio)
--}}

@php
  $isEdit      = isset($element) && $element->exists;
  $lockedCat   = $preCategory ?? ($isEdit ? $element->category : 'beads');
  $old         = fn($field, $default = null) => old($field, $isEdit ? $element->$field : $default);

  $allShapes = [
    'Bead Shapes'   => ['round','ellipse','tube','pearl','faceted','heart','star','moon','flower','rainbow','bow','butterfly'],
    'Cube / Figure' => ['cube','cube-dice1','cube-dice2','cube-dice3','cube-dice4','cube-dice5','cube-dice6','cube-heart','cube-star','cube-checker','cube-smile'],
  ];

  $catMeta = [
    'beads'   => ['label' => 'Bead',   'color' => '#F9B8CF', 'text' => '#C0136A', 'icon' => 'circle'],
    'figures' => ['label' => 'Figure', 'color' => '#93C5FD', 'text' => '#1D4ED8', 'icon' => 'square'],
    'charms'  => ['label' => 'Charm',  'color' => '#C4B5FD', 'text' => '#7C3AED', 'icon' => 'sparkles'],
  ];
  $meta = $catMeta[$lockedCat];
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="element-form">
  @csrf
  @if($method === 'PUT') @method('PUT') @endif
  <input type="hidden" name="category" value="{{ $lockedCat }}"/>

  <div class="row g-4">

    {{-- ── LEFT COLUMN ─────────────────────────────────────────────────── --}}
    <div class="col-lg-7">

      {{-- Basic Info ──────────────────────────────────────────────────── --}}
      <div class="ac-card mb-3">
        <div class="ac-card-header">
          <i data-lucide="info"></i>
          Basic Info
          <span class="ms-auto" style="display:inline-flex;align-items:center;gap:5px;
                font-size:.7rem;font-weight:700;
                color:{{ $meta['text'] }};
                background:{{ $meta['color'] }}22;
                border:1px solid {{ $meta['color'] }};
                border-radius:5px;padding:2px 9px;">
            <i data-lucide="{{ $meta['icon'] }}" style="width:11px;height:11px;"></i>
            {{ $meta['label'] }}
          </span>
        </div>
        <div class="p-4">
          <div class="row g-3">

            <div class="col-md-8">
              <label class="form-label fw-semibold small mb-1">
                Name <span class="text-danger">*</span>
              </label>
              <input type="text" name="name" value="{{ $old('name') }}"
                     class="form-control form-control-sm @error('name') is-invalid @enderror"
                     placeholder="e.g. Round Blush"
                     oninput="autoSlug(this.value); schedulePreview()"/>
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold small mb-1">
                Slug <span class="text-danger">*</span>
              </label>
              <input type="text" name="slug" id="slug-input"
                     value="{{ $old('slug') }}"
                     class="form-control form-control-sm font-monospace @error('slug') is-invalid @enderror"
                     placeholder="auto-generated"/>
              @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold small mb-1">Group</label>
              <input type="text" name="group" value="{{ $old('group') }}"
                     class="form-control form-control-sm"
                     placeholder="e.g. Round, Plain Cubes"/>
              <div class="form-text">Groups elements in library tabs</div>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold small mb-1">
                Price (₱) <span class="text-danger">*</span>
              </label>
              <input type="number" name="price" value="{{ $old('price', 8) }}"
                     min="1" max="9999"
                     class="form-control form-control-sm @error('price') is-invalid @enderror"/>
              @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
              <label class="form-label fw-semibold small mb-1">
                Stock <span class="text-danger">*</span>
              </label>
              <select name="stock" class="form-select form-select-sm">
                @foreach(['in' => 'In Stock', 'low' => 'Low Stock', 'out' => 'Out of Stock'] as $val => $lbl)
                  <option value="{{ $val }}" {{ $old('stock', 'in') === $val ? 'selected' : '' }}>
                    {{ $lbl }}
                  </option>
                @endforeach
              </select>
            </div>

          </div>

          <div class="d-flex gap-4 mt-3 flex-wrap">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                     value="1" {{ $old('is_active', true) ? 'checked' : '' }}/>
              <label class="form-check-label small" for="is_active">Active</label>
            </div>
            @if($lockedCat === 'beads')
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="is_small" id="is_small"
                     value="1" {{ $old('is_small') ? 'checked' : '' }}
                     onchange="schedulePreview()"/>
              <label class="form-check-label small" for="is_small">Small bead</label>
            </div>
            @endif
            @if($lockedCat === 'charms')
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="is_large" id="is_large"
                     value="1" {{ $old('is_large') ? 'checked' : '' }}/>
              <label class="form-check-label small" for="is_large">Large charm</label>
            </div>
            @endif
          </div>
        </div>
      </div>

      {{-- Shape & Colors (beads + figures only) ───────────────────────── --}}
      @if($lockedCat !== 'charms')
      <div class="ac-card mb-3">
        <div class="ac-card-header">
          <i data-lucide="shapes"></i> Shape & Colors
        </div>
        <div class="p-4">
          <div class="row g-3">

            {{-- Shape selector with visual grid ─────────────────────── --}}
            <div class="col-12">
              <label class="form-label fw-semibold small mb-2">
                Shape <span class="text-danger">*</span>
              </label>

              {{-- Hidden real select (submitted with form) --}}
              <select name="shape" id="shape-select" class="d-none">
                <option value="">— Select shape —</option>
                @foreach($allShapes as $grp => $opts)
                  @if(
                    ($lockedCat === 'beads'   && $grp === 'Bead Shapes')   ||
                    ($lockedCat === 'figures' && $grp === 'Cube / Figure') ||
                    ($lockedCat === 'beads'   && $grp === 'Cube / Figure')
                  )
                    @foreach($opts as $s)
                      <option value="{{ $s }}" {{ $old('shape') === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                  @endif
                @endforeach
              </select>

              {{-- Visual shape picker ──────────────────────────────── --}}
              <div id="shape-picker" style="
                display:grid;
                grid-template-columns:repeat(auto-fill, minmax(68px, 1fr));
                gap:8px;
              ">
                @foreach($allShapes as $grp => $opts)
                  @if(
                    ($lockedCat === 'beads'   && $grp === 'Bead Shapes')   ||
                    ($lockedCat === 'figures' && $grp === 'Cube / Figure') ||
                    ($lockedCat === 'beads'   && $grp === 'Cube / Figure')
                  )
                    {{-- Group label --}}
                    <div style="
                      grid-column: 1/-1;
                      font-size:.62rem; font-weight:700; text-transform:uppercase;
                      letter-spacing:.08em; color:var(--grey-400);
                      padding-top:4px;
                      @if(!$loop->first) border-top:1px solid var(--grey-200); margin-top:4px; @endif
                    ">{{ $grp }}</div>

                    @foreach($opts as $s)
                      @php $isSelected = ($old('shape') === $s); @endphp
                      <button type="button"
                              class="shape-tile {{ $isSelected ? 'selected' : '' }}"
                              data-shape="{{ $s }}"
                              onclick="selectShape('{{ $s }}', this)"
                              title="{{ $s }}"
                              style="
                                display:flex; flex-direction:column;
                                align-items:center; justify-content:center;
                                gap:5px; padding:8px 4px;
                                border-radius:9px; border:2px solid;
                                border-color:{{ $isSelected ? 'var(--pink)' : 'var(--grey-200)' }};
                                background:{{ $isSelected ? 'var(--pink-lt)' : 'var(--grey-50)' }};
                                cursor:pointer; transition:all .14s;
                                min-height:72px; position:relative;
                              ">
                        <canvas
                          class="shape-tile-canvas"
                          width="40" height="40"
                          data-shape="{{ $s }}"
                          data-color="{{ $old('color', '#F9B8CF') }}"
                          data-detail="{{ $old('detail_color', '#C0136A') }}"
                          style="display:block; pointer-events:none;">
                        </canvas>
                        <span style="
                          font-size:.58rem; font-weight:600; color:var(--grey-600);
                          font-family:monospace; line-height:1.2; text-align:center;
                          word-break:break-all;
                        ">{{ $s }}</span>
                      </button>
                    @endforeach
                  @endif
                @endforeach
              </div>
            </div>

            {{-- Colors ──────────────────────────────────────────────── --}}
            <div class="col-md-6">
              <label class="form-label fw-semibold small mb-1">Main Color</label>
              <div class="d-flex gap-2 align-items-center">
                <input type="color" name="color" id="color-pick"
                       value="{{ $old('color', '#F9B8CF') }}"
                       class="form-control form-control-color form-control-sm"
                       style="width:40px;height:32px;padding:2px;"
                       oninput="document.getElementById('color-hex').value=this.value; refreshAllTiles(); schedulePreview()"/>
                <input type="text" id="color-hex" value="{{ $old('color', '#F9B8CF') }}"
                       class="form-control form-control-sm font-monospace" style="width:96px;"
                       oninput="syncColor('color-pick', this.value)"/>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold small mb-1">
                Detail Color
                <small class="text-muted fw-normal">(optional)</small>
              </label>
              <div class="d-flex gap-2 align-items-center">
                <input type="color" name="detail_color" id="detail-pick"
                       value="{{ $old('detail_color', '#C0136A') }}"
                       class="form-control form-control-color form-control-sm"
                       style="width:40px;height:32px;padding:2px;"
                       oninput="document.getElementById('detail-hex').value=this.value; refreshAllTiles(); schedulePreview()"/>
                <input type="text" id="detail-hex" value="{{ $old('detail_color', '#C0136A') }}"
                       class="form-control form-control-sm font-monospace" style="width:96px;"
                       oninput="syncColor('detail-pick', this.value)"/>
              </div>
              <div class="form-text">Dice dots, star fill, checker pattern, etc.</div>
            </div>

          </div>
        </div>
      </div>
      @endif

      {{-- Charm Image (charms only) ────────────────────────────────────── --}}
      @if($lockedCat === 'charms')
      <div class="ac-card mb-3">
        <div class="ac-card-header">
          <i data-lucide="image"></i> Charm Image
        </div>
        <div class="p-4">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label fw-semibold small mb-1">
                Series <span class="text-danger">*</span>
              </label>
              <select name="series_id" id="series-select"
                      class="form-select form-select-sm @error('series_id') is-invalid @enderror"
                      onchange="updateSeriesSlug(this)">
                <option value="">— Select series —</option>
                @foreach($seriesList as $series)
                  <option value="{{ $series->id }}"
                          data-slug="{{ $series->slug }}"
                          {{ $old('series_id') == $series->id ? 'selected' : '' }}>
                    {{ $series->name }}
                  </option>
                @endforeach
              </select>
              <input type="hidden" name="series_slug" id="series-slug-input"
                     value="{{ $isEdit ? $element->series?->slug : '' }}"/>
              @error('series_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold small mb-1">Image File</label>
              <input type="file" name="img_file" id="img-file-input"
                     accept="image/png,image/jpeg,image/webp"
                     class="form-control form-control-sm @error('img_file') is-invalid @enderror"
                     onchange="previewUploadedImage(this)"/>
              <div class="form-text">PNG recommended (transparent background).</div>
              @error('img_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            @if($isEdit && $element->img_path)
            <div class="col-12">
              <label class="form-label fw-semibold small mb-1">Current Image</label>
              <div class="d-flex align-items-center gap-3">
                <div style="width:56px;height:56px;border-radius:8px;
                            background:var(--grey-100);border:1px solid var(--grey-200);
                            display:flex;align-items:center;justify-content:center;padding:4px;">
                  <img src="{{ asset('img/builder/' . $element->img_path) }}"
                       style="width:100%;height:100%;object-fit:contain;"
                       alt="{{ $element->name }}"/>
                </div>
                <code style="font-size:.72rem;color:var(--grey-400);">{{ $element->img_path }}</code>
              </div>
              <div class="form-text">Upload a new file to replace it.</div>
            </div>
            @endif

          </div>
        </div>
      </div>
      @endif

    </div>

    {{-- ── RIGHT COLUMN — Live Preview ─────────────────────────────────── --}}
    <div class="col-lg-5">
      <div class="ac-card" style="position:sticky;top:80px;">
        <div class="ac-card-header">
          <i data-lucide="eye"></i> Live Preview
          <span id="prev-shape-badge" class="ms-auto"
                style="font-size:.68rem;font-family:monospace;
                       background:var(--grey-100);color:var(--grey-600);
                       padding:2px 8px;border-radius:4px;">
            {{ $old('shape', $isEdit ? ($element->shape ?? '—') : '—') }}
          </span>
        </div>

        <div class="p-4">

          {{-- Big preview canvas ──────────────────────────────────────── --}}
          <div style="background:var(--grey-50);
                      border:1px solid var(--grey-200);
                      border-radius:12px; padding:20px;
                      margin-bottom:16px;
                      display:flex; align-items:center; justify-content:center;
                      min-height:160px;">
            @if($lockedCat === 'charms')
              <div id="charm-img-preview" style="text-align:center;">
                @if($isEdit && $element->img_path)
                  <img id="charm-img"
                       style="width:120px;height:120px;object-fit:contain;border-radius:8px;"
                       src="{{ asset('img/builder/' . $element->img_path) }}" alt=""/>
                @else
                  <img id="charm-img"
                       style="width:120px;height:120px;object-fit:contain;border-radius:8px;display:none;"
                       src="" alt=""/>
                  <div id="charm-placeholder"
                       style="display:flex;flex-direction:column;align-items:center;gap:6px;opacity:.3;">
                    <i data-lucide="sparkles" style="width:36px;height:36px;"></i>
                    <span style="font-size:.72rem;">No image yet</span>
                  </div>
                @endif
              </div>
            @else
              {{-- Large preview canvas — same renderer as list thumbnails --}}
              <canvas id="preview-canvas"
                      class="shape-canvas"
                      width="120" height="120"
                      data-shape="{{ $old('shape', $isEdit ? ($element->shape ?? 'round') : 'round') }}"
                      data-color="{{ $old('color', $isEdit ? ($element->color ?? '#F9B8CF') : '#F9B8CF') }}"
                      data-detail="{{ $old('detail_color', $isEdit ? ($element->detail_color ?? '#C0136A') : '#C0136A') }}"
                      data-small="{{ ($old('is_small', $isEdit && $element->is_small)) ? '1' : '0' }}"
                      style="border-radius:6px;display:block;">
              </canvas>
            @endif
          </div>

          {{-- Color chips row ─────────────────────────────────────────── --}}
          @if($lockedCat !== 'charms')
          <div class="d-flex gap-2 mb-3 align-items-center">
            <div id="prev-main-chip"
                 style="width:22px;height:22px;border-radius:50%;
                        background:{{ $old('color', $isEdit ? ($element->color ?? '#F9B8CF') : '#F9B8CF') }};
                        border:2px solid rgba(0,0,0,.08);flex-shrink:0;"></div>
            <span id="prev-main-hex" style="font-size:.72rem;font-family:monospace;color:var(--grey-600);">
              {{ $old('color', $isEdit ? ($element->color ?? '#F9B8CF') : '#F9B8CF') }}
            </span>
            <div style="width:1px;height:14px;background:var(--grey-200);"></div>
            <div id="prev-detail-chip"
                 style="width:22px;height:22px;border-radius:50%;
                        background:{{ $old('detail_color', $isEdit ? ($element->detail_color ?? '#C0136A') : '#C0136A') }};
                        border:2px solid rgba(0,0,0,.08);flex-shrink:0;"></div>
            <span id="prev-detail-hex" style="font-size:.72rem;font-family:monospace;color:var(--grey-600);">
              {{ $old('detail_color', $isEdit ? ($element->detail_color ?? '#C0136A') : '#C0136A') }}
            </span>
          </div>
          @endif

          {{-- Summary ─────────────────────────────────────────────────── --}}
          <div style="font-size:.78rem;border-top:1px solid var(--grey-200);padding-top:12px;">
            <div class="d-flex justify-content-between mb-1">
              <span style="color:var(--grey-400);">Category</span>
              <span class="fw-semibold">{{ ucfirst($lockedCat) }}</span>
            </div>
            @if($lockedCat !== 'charms')
            <div class="d-flex justify-content-between mb-1">
              <span style="color:var(--grey-400);">Shape</span>
              <span id="prev-shape-label" class="fw-semibold font-monospace" style="font-size:.72rem;">
                {{ $old('shape', $isEdit ? ($element->shape ?? '—') : '—') }}
              </span>
            </div>
            <div class="d-flex justify-content-between">
              <span style="color:var(--grey-400);">Size</span>
              <span id="prev-size-label" class="fw-semibold" style="font-size:.72rem;">
                {{ ($old('is_small', $isEdit && isset($element) && $element->is_small)) ? 'Small' : 'Standard' }}
              </span>
            </div>
            @endif
          </div>

        </div>

        {{-- Submit ──────────────────────────────────────────────────────── --}}
        <div class="p-4 pt-0 d-flex flex-column gap-2">
          <button type="submit" class="btn w-100 fw-bold"
                  style="background:var(--pink);color:#fff;border-radius:8px;
                         padding:9px;font-size:.85rem;">
            <i data-lucide="{{ $isEdit ? 'save' : 'plus-circle' }}"
               style="width:14px;height:14px;margin-right:5px;"></i>
            {{ $isEdit ? 'Save Changes' : 'Add ' . ucfirst($lockedCat) }}
          </button>
          <a href="{{ route('admin.elements.' . $lockedCat) }}"
             class="btn btn-sm btn-outline-secondary w-100"
             style="border-radius:8px;font-size:.8rem;">
            Cancel
          </a>
        </div>
        
      </div>
    </div>

  </div>
</form>

@push('scripts')
{{-- Unified shape renderer --}}
<script src="{{ asset('js/builder/canvas/shaperenderer.js') }}"></script>

<script>
/* ─── State ───────────────────────────────────────────────────────────────── */
const IS_EDIT    = {{ $isEdit ? 'true' : 'false' }};
const LOCKED_CAT = '{{ $lockedCat }}';
let previewTimer = null;

/* ─── Slug auto-generate ─────────────────────────────────────────────────── */
function autoSlug(name) {
  if (IS_EDIT) return;
  document.getElementById('slug-input').value = name.toLowerCase()
    .replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
}

/* ─── Colour sync (hex text ↔ color picker) ─────────────────────────────── */
function syncColor(pickerId, hexVal) {
  if (/^#[0-9A-Fa-f]{6}$/.test(hexVal)) {
    document.getElementById(pickerId).value = hexVal;
    refreshAllTiles();
    schedulePreview();
  }
}

/* ─── Series slug helper (charms) ───────────────────────────────────────── */
function updateSeriesSlug(select) {
  const opt = select.options[select.selectedIndex];
  document.getElementById('series-slug-input').value = opt.dataset.slug || '';
}

/* ─── Charm image upload preview ────────────────────────────────────────── */
function previewUploadedImage(input) {
  if (!input.files || !input.files[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    const img = document.getElementById('charm-img');
    const ph  = document.getElementById('charm-placeholder');
    if (img) { img.src = e.target.result; img.style.display = ''; }
    if (ph)  ph.style.display = 'none';
  };
  reader.readAsDataURL(input.files[0]);
}

/* ─── Shape tile click ───────────────────────────────────────────────────── */
function selectShape(shape, btnEl) {
  document.getElementById('shape-select').value = shape;
  document.querySelectorAll('.shape-tile').forEach(t => {
    const sel = t.dataset.shape === shape;
    t.style.borderColor = sel ? 'var(--pink)'    : 'var(--grey-200)';
    t.style.background  = sel ? 'var(--pink-lt)' : 'var(--grey-50)';
  });
  updatePreview();
}

/* ─── Refresh all tile canvases with current colors ─────────────────────── */
function refreshAllTiles() {
  const color  = document.getElementById('color-pick')?.value  || '#F9B8CF';
  const detail = document.getElementById('detail-pick')?.value || '#C0136A';

  document.querySelectorAll('.shape-tile-canvas').forEach(c => {
    c.dataset.color  = color;
    c.dataset.detail = detail;
    ArtshapeRenderer.draw(c);
  });

  const mainChip   = document.getElementById('prev-main-chip');
  const mainHex    = document.getElementById('prev-main-hex');
  const detailChip = document.getElementById('prev-detail-chip');
  const detailHex  = document.getElementById('prev-detail-hex');
  if (mainChip)   mainChip.style.background  = color;
  if (mainHex)    mainHex.textContent         = color;
  if (detailChip) detailChip.style.background = detail;
  if (detailHex)  detailHex.textContent        = detail;
}

/* ─── Debounced preview update ───────────────────────────────────────────── */
function schedulePreview() {
  clearTimeout(previewTimer);
  previewTimer = setTimeout(updatePreview, 80);
}

/* ─── Update large preview canvas ───────────────────────────────────────── */
function updatePreview() {
  if (LOCKED_CAT === 'charms') return;

  const shape   = document.getElementById('shape-select')?.value || 'round';
  const color   = document.getElementById('color-pick')?.value   || '#F9B8CF';
  const detail  = document.getElementById('detail-pick')?.value  || '#C0136A';
  const isSmall = document.getElementById('is_small')?.checked   || false;

  const shapeLabel = document.getElementById('prev-shape-label');
  const shapeBadge = document.getElementById('prev-shape-badge');
  const sizeLabel  = document.getElementById('prev-size-label');
  if (shapeLabel) shapeLabel.textContent = shape || '—';
  if (shapeBadge) shapeBadge.textContent = shape || '—';
  if (sizeLabel)  sizeLabel.textContent  = isSmall ? 'Small' : 'Standard';

  const canvas = document.getElementById('preview-canvas');
  if (!canvas) return;

  canvas.dataset.shape  = shape;
  canvas.dataset.color  = color;
  canvas.dataset.detail = detail;
  canvas.dataset.small  = isSmall ? '1' : '0';

  ArtshapeRenderer.draw(canvas, { shape, color, detail, small: isSmall });
}

/* ─── Init — runs immediately (DOM already ready at bottom of <body>) ────── */
(function init() {
  if (LOCKED_CAT !== 'charms') {
    // Render all shape-picker tiles
    document.querySelectorAll('.shape-tile-canvas').forEach(c => {
      ArtshapeRenderer.draw(c);
    });
    // Render the large preview
    updatePreview();
  }
  // Re-init Lucide for any icons injected by Blade
  if (window.lucide) lucide.createIcons();
}());
</script>
@endpush