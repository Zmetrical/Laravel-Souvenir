{{--
  Shared form partial — used by both create.blade.php and edit.blade.php
  Variables expected:
    $element    — the Element model (or empty model for create)
    $seriesList — collection of ElementSeries
    $action     — form action URL
    $method     — 'POST' or 'PUT'
--}}

@php
  $isEdit = isset($element) && $element->exists;
  $old = fn($field, $default = null) => old($field, $isEdit ? $element->$field : $default);

  $shapes = [
    'Bead Shapes'   => ['round','ellipse','tube','pearl','faceted','heart','star','moon','flower','rainbow','bow','butterfly'],
    'Cube / Figure' => ['cube','cube-dice1','cube-dice2','cube-dice3','cube-dice4','cube-dice5','cube-dice6','cube-heart','cube-star','cube-checker','cube-smile'],
  ];
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="element-form">
  @csrf
  @if($method === 'PUT') @method('PUT') @endif

  <div class="row g-4">

    {{-- ══ LEFT COLUMN — Form fields ════════════════════════════════════════ --}}
    <div class="col-lg-7">

      {{-- ── Basic Info ──────────────────────────────────────────────────── --}}
      <div class="ac-card mb-4">
        <div class="ac-card-header">
          <i data-lucide="info" style="width:15px;height:15px;"></i> Basic Info
        </div>
        <div class="p-4">

          {{-- Category --}}
          <div class="mb-3">
            <label class="form-label fw-semibold small">Category <span class="text-danger">*</span></label>
            <div class="d-flex gap-2">
              @foreach(['beads' => '🔵 Bead', 'figures' => '🟧 Figure', 'charms' => '✨ Charm'] as $val => $label)
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="category"
                         id="cat_{{ $val }}" value="{{ $val }}"
                         {{ $old('category', 'beads') === $val ? 'checked' : '' }}
                         onchange="onCategoryChange(this.value)"/>
                  <label class="form-check-label small fw-semibold" for="cat_{{ $val }}">{{ $label }}</label>
                </div>
              @endforeach
            </div>
            @error('category') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
          </div>

          <div class="row g-3">
            {{-- Name --}}
            <div class="col-md-8">
              <label class="form-label fw-semibold small">Name <span class="text-danger">*</span></label>
              <input type="text" name="name" value="{{ $old('name') }}"
                     class="form-control form-control-sm @error('name') is-invalid @enderror"
                     placeholder="e.g. Round Blush"
                     oninput="autoSlug(this.value); updatePreview()"/>
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Slug --}}
            <div class="col-md-4">
              <label class="form-label fw-semibold small">Slug <span class="text-danger">*</span></label>
              <input type="text" name="slug" id="slug-input"
                     value="{{ $old('slug') }}"
                     class="form-control form-control-sm font-monospace @error('slug') is-invalid @enderror"
                     placeholder="auto-generated"/>
              @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Group --}}
            <div class="col-md-6">
              <label class="form-label fw-semibold small">Group</label>
              <input type="text" name="group" value="{{ $old('group') }}"
                     class="form-control form-control-sm"
                     placeholder="e.g. Round, Plain Cubes"/>
              <div class="form-text">Groups elements in the library panel tabs</div>
            </div>

            {{-- Price --}}
            <div class="col-md-3">
              <label class="form-label fw-semibold small">Price (₱) <span class="text-danger">*</span></label>
              <input type="number" name="price" value="{{ $old('price', 8) }}" min="1" max="9999"
                     class="form-control form-control-sm @error('price') is-invalid @enderror"/>
              @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Stock --}}
            <div class="col-md-3">
              <label class="form-label fw-semibold small">Stock <span class="text-danger">*</span></label>
              <select name="stock" class="form-select form-select-sm">
                @foreach(['in' => 'In Stock', 'low' => 'Low Stock', 'out' => 'Out of Stock'] as $val => $label)
                  <option value="{{ $val }}" {{ $old('stock', 'in') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
              </select>
            </div>
          </div>

          {{-- Flags --}}
          <div class="d-flex gap-4 mt-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                     value="1" {{ $old('is_active', true) ? 'checked' : '' }}/>
              <label class="form-check-label small" for="is_active">Active (visible in builder)</label>
            </div>
            <div class="form-check form-switch" id="flag-small">
              <input class="form-check-input" type="checkbox" name="is_small" id="is_small"
                     value="1" {{ $old('is_small') ? 'checked' : '' }}
                     onchange="updatePreview()"/>
              <label class="form-check-label small" for="is_small">Small bead</label>
            </div>
            <div class="form-check form-switch" id="flag-large">
              <input class="form-check-input" type="checkbox" name="is_large" id="is_large"
                     value="1" {{ $old('is_large') ? 'checked' : '' }}
                     onchange="updatePreview()"/>
              <label class="form-check-label small" for="is_large">Large charm</label>
            </div>
          </div>

        </div>
      </div>

      {{-- ── Shape & Colors (beads / figures) ───────────────────────────── --}}
      <div class="ac-card mb-4" id="section-shape">
        <div class="ac-card-header">
          <i data-lucide="shapes" style="width:15px;height:15px;"></i> Shape & Colors
        </div>
        <div class="p-4">
          <div class="row g-3">

            {{-- Shape --}}
            <div class="col-12">
              <label class="form-label fw-semibold small">Shape</label>
              <select name="shape" id="shape-select"
                      class="form-select form-select-sm"
                      onchange="updatePreview()">
                <option value="">— Select shape —</option>
                @foreach($shapes as $group => $opts)
                  <optgroup label="{{ $group }}">
                    @foreach($opts as $s)
                      <option value="{{ $s }}" {{ $old('shape') === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
            </div>

            {{-- Main Color --}}
            <div class="col-md-6">
              <label class="form-label fw-semibold small">Main Color</label>
              <div class="d-flex gap-2 align-items-center">
                <input type="color" name="color" id="color-pick"
                       value="{{ $old('color', '#F9B8CF') }}"
                       class="form-control form-control-color form-control-sm"
                       style="width:44px; height:34px; padding:2px;"
                       oninput="document.getElementById('color-hex').value=this.value; updatePreview()"/>
                <input type="text" id="color-hex" value="{{ $old('color', '#F9B8CF') }}"
                       class="form-control form-control-sm font-monospace" style="width:100px;"
                       oninput="syncColor('color-pick', this.value)"/>
              </div>
            </div>

            {{-- Detail Color --}}
            <div class="col-md-6">
              <label class="form-label fw-semibold small">Detail Color <small class="text-muted">(optional)</small></label>
              <div class="d-flex gap-2 align-items-center">
                <input type="color" name="detail_color" id="detail-pick"
                       value="{{ $old('detail_color', '#C0136A') }}"
                       class="form-control form-control-color form-control-sm"
                       style="width:44px; height:34px; padding:2px;"
                       oninput="document.getElementById('detail-hex').value=this.value; updatePreview()"/>
                <input type="text" id="detail-hex" value="{{ $old('detail_color', '#C0136A') }}"
                       class="form-control form-control-sm font-monospace" style="width:100px;"
                       oninput="syncColor('detail-pick', this.value)"/>
              </div>
              <div class="form-text">Used for dice dots, star fill, checker pattern, etc.</div>
            </div>

          </div>
        </div>
      </div>

      {{-- ── Charm Image (charms only) ───────────────────────────────────── --}}
      <div class="ac-card mb-4" id="section-charm" style="display:none;">
        <div class="ac-card-header">
          <i data-lucide="image" style="width:15px;height:15px;"></i> Charm Image
        </div>
        <div class="p-4">
          <div class="row g-3">

            {{-- Series --}}
            <div class="col-md-6">
              <label class="form-label fw-semibold small">Series <span class="text-danger">*</span></label>
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

            {{-- Upload --}}
            <div class="col-md-6">
              <label class="form-label fw-semibold small">Image File <span class="text-danger">*</span></label>
              <input type="file" name="img_file" id="img-file-input"
                     accept="image/png,image/jpeg,image/webp"
                     class="form-control form-control-sm @error('img_file') is-invalid @enderror"
                     onchange="previewUploadedImage(this)"/>
              <div class="form-text">PNG recommended. Saved to <code>public/img/builder/{series}/</code></div>
              @error('img_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Existing path (edit mode) --}}
            @if($isEdit && $element->img_path)
            <div class="col-12">
              <label class="form-label fw-semibold small">Current Image</label>
              <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('img/builder/' . $element->img_path) }}"
                     style="width:60px;height:60px;object-fit:contain;
                            border-radius:8px;background:#F8F7FA;border:1px solid #EEE;padding:4px;"
                     alt="{{ $element->name }}"/>
                <code class="text-muted small">{{ $element->img_path }}</code>
              </div>
              <div class="form-text">Upload a new file above to replace it.</div>
            </div>
            @endif

          </div>
        </div>
      </div>

    </div>

    {{-- ══ RIGHT COLUMN — Live Preview ════════════════════════════════════ --}}
    <div class="col-lg-5">
      <div class="ac-card" style="position:sticky;top:80px;">
        <div class="ac-card-header">
          <i data-lucide="eye" style="width:15px;height:15px;"></i> Live Preview
        </div>
        <div class="p-4 text-center">

          {{-- Canvas preview --}}
          <div style="background:linear-gradient(135deg,#FFF0F6,#F0F8FF);
                      border-radius:12px; padding:20px; margin-bottom:16px;
                      border:1px dashed #E2D9F3;">
            <canvas id="preview-canvas" width="160" height="160"
                    style="border-radius:8px;"></canvas>
            <div id="charm-img-preview" style="display:none;">
              <img id="charm-img" style="width:120px;height:120px;object-fit:contain;
                                         border-radius:8px;" src="" alt=""/>
            </div>
          </div>

          {{-- Summary --}}
          <div id="preview-summary" style="font-size:.82rem;">
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Shape</span>
              <span id="prev-shape" class="fw-semibold font-monospace">—</span>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Color</span>
              <span id="prev-color" class="fw-semibold">—</span>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Category</span>
              <span id="prev-cat" class="fw-semibold">—</span>
            </div>
          </div>

        </div>

        {{-- Submit --}}
        <div class="p-4 pt-0">
          <button type="submit" class="btn w-100 fw-bold"
                  style="background:#FF5FA0;color:#fff;border-radius:10px;padding:10px;">
            {{ $isEdit ? '✓ Save Changes' : '+ Add Element' }}
          </button>
          <a href="{{ route('admin.elements.index') }}"
             class="btn btn-outline-secondary w-100 mt-2" style="border-radius:10px;">
            Cancel
          </a>
        </div>
      </div>
    </div>

  </div>{{-- /row --}}
</form>

@push('scripts')
<script>
// ── Slug auto-gen ────────────────────────────────────────────────────────────
const isEdit = {{ $isEdit ? 'true' : 'false' }};
function autoSlug(name) {
  if (isEdit) return; // don't auto-change slug on edit
  const slug = name.toLowerCase()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-|-$/g, '');
  document.getElementById('slug-input').value = slug;
}

// ── Color sync (hex input ↔ color picker) ────────────────────────────────────
function syncColor(pickerId, hexVal) {
  if (/^#[0-9A-Fa-f]{6}$/.test(hexVal)) {
    document.getElementById(pickerId).value = hexVal;
    updatePreview();
  }
}

// ── Category toggle ──────────────────────────────────────────────────────────
function onCategoryChange(cat) {
  const isCharm = cat === 'charms';
  document.getElementById('section-shape').style.display = isCharm ? 'none' : '';
  document.getElementById('section-charm').style.display = isCharm ? '' : 'none';
  document.getElementById('flag-small').style.display    = cat === 'beads' ? '' : 'none';
  document.getElementById('flag-large').style.display    = isCharm ? '' : 'none';
  document.getElementById('charm-img-preview').style.display = 'none';
  document.getElementById('preview-canvas').style.display    = isCharm ? 'none' : '';
  updatePreview();
}

// ── Series slug helper ───────────────────────────────────────────────────────
function updateSeriesSlug(select) {
  const opt = select.options[select.selectedIndex];
  document.getElementById('series-slug-input').value = opt.dataset.slug || '';
}

// ── Uploaded image preview ───────────────────────────────────────────────────
function previewUploadedImage(input) {
  if (!input.files || !input.files[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    const img = document.getElementById('charm-img');
    img.src = e.target.result;
    document.getElementById('charm-img-preview').style.display = '';
    document.getElementById('preview-canvas').style.display = 'none';
  };
  reader.readAsDataURL(input.files[0]);
}

// ── Live canvas preview ──────────────────────────────────────────────────────
function updatePreview() {
  const cat    = document.querySelector('input[name="category"]:checked')?.value || 'beads';
  const shape  = document.getElementById('shape-select')?.value || 'round';
  const color  = document.getElementById('color-pick')?.value  || '#F9B8CF';
  const detail = document.getElementById('detail-pick')?.value || '#C0136A';
  const isSmall = document.getElementById('is_small')?.checked;

  document.getElementById('prev-shape').textContent = shape || '—';
  document.getElementById('prev-color').innerHTML   =
    `<span style="display:inline-block;width:12px;height:12px;border-radius:50%;
                  background:${color};border:1px solid rgba(0,0,0,.15);
                  margin-right:4px;vertical-align:middle;"></span>${color}`;
  document.getElementById('prev-cat').textContent = ucfirst(cat);

  if (cat === 'charms') return;

  const canvas = document.getElementById('preview-canvas');
  canvas.style.display = '';
  const ctx = canvas.getContext('2d');
  ctx.clearRect(0, 0, 160, 160);
  ctx.imageSmoothingEnabled = true;
  ctx.imageSmoothingQuality = 'high';

  ctx.save();
  ctx.translate(80, 80);
  const R = isSmall ? 20 : 36;
  drawShape(ctx, shape, R, color, detail);
  ctx.restore();
}

// ── Shape drawing (mirrors canvasengine.js logic) ────────────────────────────
function drawShape(ctx, shape, R, color, detail) {
  ctx.fillStyle = color;

  if (shape === 'round' || shape === 'pearl') {
    ctx.beginPath(); ctx.arc(0, 0, R, 0, Math.PI * 2); ctx.fill();
  }
  else if (shape === 'ellipse') {
    ctx.beginPath(); ctx.ellipse(0, 0, R * 1.55, R * 0.78, 0, 0, Math.PI * 2); ctx.fill();
  }
  else if (shape === 'tube') {
    ctx.beginPath(); ctx.ellipse(0, 0, R * 0.7, R * 1.58, 0, 0, Math.PI * 2); ctx.fill();
  }
  else if (shape === 'faceted') {
    ctx.beginPath();
    for (let i = 0; i < 6; i++) {
      ctx.lineTo(Math.cos(i * Math.PI / 3) * R, Math.sin(i * Math.PI / 3) * R);
    }
    ctx.closePath(); ctx.fill();
  }
  else if (shape === 'heart') {
    ctx.beginPath();
    ctx.moveTo(0, R * 0.3);
    ctx.bezierCurveTo(R, -R * 1.2, R * 2.2, R * 0.4, 0, R);
    ctx.bezierCurveTo(-R * 2.2, R * 0.4, -R, -R * 1.2, 0, R * 0.3);
    ctx.fill();
  }
  else if (shape === 'star') {
    ctx.beginPath();
    for (let i = 0; i < 10; i++) {
      const rad = i % 2 === 0 ? R : R * 0.44;
      ctx.lineTo(Math.cos(i * Math.PI / 5 - Math.PI / 2) * rad,
                 Math.sin(i * Math.PI / 5 - Math.PI / 2) * rad);
    }
    ctx.closePath(); ctx.fill();
  }
  else if (shape === 'moon') {
    ctx.beginPath();
    ctx.arc(0, 0, R, Math.PI * 0.15, Math.PI * 1.85, true);
    ctx.quadraticCurveTo(-R * 0.4, 0, Math.cos(Math.PI * 0.15) * R, Math.sin(Math.PI * 0.15) * R);
    ctx.fill();
  }
  else if (shape === 'bow') {
    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.bezierCurveTo(-R * 1.4, -R * 0.9, -R * 1.6, R * 0.4, -R * 0.2, R * 0.15);
    ctx.closePath(); ctx.fill();
    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.bezierCurveTo(R * 1.4, -R * 0.9, R * 1.6, R * 0.4, R * 0.2, R * 0.15);
    ctx.closePath(); ctx.fill();
    ctx.fillStyle = detail;
    ctx.beginPath(); ctx.arc(0, R * 0.06, R * 0.3, 0, Math.PI * 2); ctx.fill();
  }
  else if (shape.startsWith('cube')) {
    drawCubeShape(ctx, shape, R, color, detail);
  }
  else {
    // Fallback — plain circle
    ctx.beginPath(); ctx.arc(0, 0, R, 0, Math.PI * 2); ctx.fill();
  }
}

function drawCubeShape(ctx, shape, R, color, detail) {
  const s = R * 1.8;
  ctx.fillStyle = color;
  ctx.beginPath();
  roundRect(ctx, -s/2, -s/2, s, s, s * 0.18);
  ctx.fill();

  if (shape === 'cube') return;

  ctx.fillStyle = detail;

  if (shape === 'cube-heart') {
    const hr = R * 0.55;
    ctx.beginPath();
    ctx.moveTo(0, hr * 0.3);
    ctx.bezierCurveTo(hr, -hr*1.2, hr*2.2, hr*0.4, 0, hr);
    ctx.bezierCurveTo(-hr*2.2, hr*0.4, -hr, -hr*1.2, 0, hr*0.3);
    ctx.fill();
  }
  else if (shape === 'cube-star') {
    const sr = R * 0.6;
    ctx.beginPath();
    for (let i = 0; i < 10; i++) {
      const rad = i % 2 === 0 ? sr : sr * 0.44;
      ctx.lineTo(Math.cos(i * Math.PI / 5 - Math.PI / 2) * rad,
                 Math.sin(i * Math.PI / 5 - Math.PI / 2) * rad);
    }
    ctx.closePath(); ctx.fill();
  }
  else if (shape === 'cube-checker') {
    ctx.save();
    ctx.beginPath(); roundRect(ctx, -s/2, -s/2, s, s, s * 0.18); ctx.clip();
    const cs = s / 4;
    for (let row = 0; row < 4; row++) {
      for (let col = 0; col < 4; col++) {
        if ((row + col) % 2 === 0) ctx.fillRect(-s/2 + col*cs, -s/2 + row*cs, cs, cs);
      }
    }
    ctx.restore();
  }
  else if (shape === 'cube-smile') {
    ctx.strokeStyle = detail; ctx.lineWidth = R * 0.14; ctx.lineCap = 'round';
    ctx.beginPath(); ctx.arc(-R*0.35, -R*0.2, R*0.13, 0, Math.PI*2); ctx.fill();
    ctx.beginPath(); ctx.arc( R*0.35, -R*0.2, R*0.13, 0, Math.PI*2); ctx.fill();
    ctx.beginPath(); ctx.arc(0, R*0.1, R*0.38, 0.2, Math.PI-0.2); ctx.stroke();
  }
  else {
    // Dice dots
    const diceMap = {
      'cube-dice1': [[0,0]],
      'cube-dice2': [[-1,1],[1,-1]],
      'cube-dice3': [[-1,1],[0,0],[1,-1]],
      'cube-dice4': [[-1,-1],[1,-1],[-1,1],[1,1]],
      'cube-dice5': [[-1,-1],[1,-1],[0,0],[-1,1],[1,1]],
      'cube-dice6': [[-1,-1],[1,-1],[-1,0],[1,0],[-1,1],[1,1]],
    };
    const dots = diceMap[shape] || [];
    const h = (s/2) * 0.38;
    const dr = R * 0.18;
    dots.forEach(([dx, dy]) => {
      ctx.beginPath(); ctx.arc(dx*h, dy*h, dr, 0, Math.PI*2); ctx.fill();
    });
  }
}

function roundRect(ctx, x, y, w, h, r) {
  ctx.beginPath();
  ctx.moveTo(x + r, y); ctx.lineTo(x + w - r, y); ctx.quadraticCurveTo(x + w, y, x + w, y + r);
  ctx.lineTo(x + w, y + h - r); ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
  ctx.lineTo(x + r, y + h); ctx.quadraticCurveTo(x, y + h, x, y + h - r);
  ctx.lineTo(x, y + r); ctx.quadraticCurveTo(x, y, x + r, y); ctx.closePath();
}

function ucfirst(str) { return str.charAt(0).toUpperCase() + str.slice(1); }

// ── Init ─────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  const cat = document.querySelector('input[name="category"]:checked')?.value || 'beads';
  onCategoryChange(cat);
  updatePreview();
});
</script>
@endpush