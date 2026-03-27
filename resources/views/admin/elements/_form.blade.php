{{--
  Shared form partial — used by create.blade.php and edit.blade.php
  Variables:
    $element     — Element model (or absent for create)
    $action      — form action URL
    $method      — 'POST' or 'PUT'
    $preCategory — 'beads' | 'figures' | 'charms'  (locks the category radio)
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
    'beads'   => ['label' => 'Bead',   'color' => '#F9B8CF', 'text' => '#C0136A', 'icon' => 'circle'],
    'figures' => ['label' => 'Figure', 'color' => '#93C5FD', 'text' => '#1D4ED8', 'icon' => 'square'],
    'charms'  => ['label' => 'Charm',  'color' => '#C4B5FD', 'text' => '#7C3AED', 'icon' => 'sparkles'],
  ];
  $meta     = $catMeta[$lockedCat];
  $catLabel = $meta['label'];
@endphp

<style>
/* ── Variation rows ──────────────────────────────────────────────────────── */
.var-row {
  display: grid;
  grid-template-columns: 40px 1fr 148px 36px 36px;
  gap: 8px;
  align-items: center;
  padding: 8px 12px;
  border-radius: 10px;
  background: var(--grey-50, #fafafa);
  border: 1.5px solid var(--grey-150, #ebebeb);
  transition: border-color .15s, box-shadow .15s;
  position: relative;
}
.var-row.charm-row {
  grid-template-columns: 48px 1fr 1fr 36px;
}
.var-row:hover {
  border-color: #f7cfe0;
  box-shadow: 0 2px 8px rgba(240,80,140,.07);
}
.var-row.is-primary {
  background: #fff8fc;
  border-color: var(--pink, #F9B8CF);
}
.var-row.is-primary::before {
  content: 'Primary';
  position: absolute;
  top: -9px; left: 14px;
  font-size: .57rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: .09em;
  color: var(--pink-dark, #C0136A);
  background: #fff8fc;
  padding: 0 6px;
}
.var-remove-btn {
  background: none;
  border: none;
  cursor: pointer;
  color: var(--grey-300, #ccc);
  padding: 5px;
  border-radius: 6px;
  display: flex; align-items: center; justify-content: center;
  transition: color .15s, background .15s;
  line-height: 1;
}
.var-remove-btn:hover { color: #e85555; background: #fff0f0; }

/* ── Smart submit ────────────────────────────────────────────────────────── */
#smart-submit { transition: background .25s, transform .1s; }
#smart-submit:active { transform: scale(.98); }
#smart-submit .btn-sub { font-size:.67rem; font-weight:500; opacity:.8; display:block; margin-top:2px; }

/* ── Variation toggle button ─────────────────────────────────────────────── */
#var-toggle-btn {
  background: none; border: none; cursor: pointer;
  display: flex; align-items: center; gap: 5px;
  font-size: .72rem; font-weight: 600;
  color: var(--pink-dark, #C0136A);
  padding: 3px 8px; border-radius: 6px;
  transition: background .15s;
}
#var-toggle-btn:hover { background: var(--pink-lt, #fff0f6); }

/* ── Add variation button ────────────────────────────────────────────────── */
#add-var-btn {
  width: 100%; padding: 8px 12px;
  border: 1.5px dashed #e0c0cc;
  border-radius: 10px;
  background: transparent;
  color: #c07090;
  font-size: .78rem; font-weight: 600;
  cursor: pointer;
  transition: border-color .15s, color .15s, background .15s;
  display: flex; align-items: center; justify-content: center; gap: 6px;
}
#add-var-btn:hover {
  border-color: var(--pink-dark, #C0136A);
  color: var(--pink-dark, #C0136A);
  background: #fff3f7;
}

/* ── Column header row ───────────────────────────────────────────────────── */
.var-col-headers {
  display: grid;
  grid-template-columns: 40px 1fr 148px 36px 36px;
  gap: 8px;
  padding: 0 12px 6px;
  font-size: .59rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: .07em;
  color: var(--grey-300, #bbb);
}
.var-col-headers.charm-headers {
  grid-template-columns: 48px 1fr 1fr 36px;
}

/* ── Variation section divider ───────────────────────────────────────────── */
.var-divider {
  display: flex; align-items: center; gap: 10px;
  margin: 4px 0 10px;
  font-size: .61rem; font-weight: 700; text-transform: uppercase;
  letter-spacing: .08em; color: var(--grey-300, #ccc);
}
.var-divider::before, .var-divider::after {
  content: ''; flex: 1; height: 1px; background: var(--grey-150, #eee);
}

/* ── Hex mini input ──────────────────────────────────────────────────────── */
.var-hex { font-size:.7rem!important; font-family:monospace!important;
           padding:3px 5px!important; height:28px!important; width:80px!important; }

/* ── Charm thumb in variation rows ──────────────────────────────────────── */
.charm-var-thumb {
  width: 40px; height: 40px; border-radius: 7px;
  overflow: hidden;
  background: var(--grey-100);
  border: 1px solid var(--grey-200);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.charm-var-thumb img {
  width: 100%; height: 100%; object-fit: contain; display: none;
}
</style>

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="element-form">
  @csrf
  @if($method === 'PUT') @method('PUT') @endif
  <input type="hidden" name="category" value="{{ $lockedCat }}"/>
  <input type="hidden" name="_mode" id="mode-input" value="single"/>

  <div class="row g-4">

    {{-- ── LEFT COLUMN ──────────────────────────────────────────────────── --}}
    <div class="col-lg-7">

      {{-- Basic Info ───────────────────────────────────────────────────── --}}
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
              <input type="text" name="name" id="base-name-input"
                     value="{{ $old('name') }}"
                     class="form-control form-control-sm @error('name') is-invalid @enderror"
                     placeholder="e.g. Round Blush"
                     oninput="autoSlug(this.value); schedulePreview(); syncPrimaryLabel()"/>
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

            {{-- Group — used for ALL categories including charms ────────── --}}
            <div class="col-md-6">
              <label class="form-label fw-semibold small mb-1">Group</label>
              <input type="text" name="group" id="group-input"
                     value="{{ $old('group') }}"
                     class="form-control form-control-sm"
                     placeholder="{{ $lockedCat === 'charms' ? 'e.g. Hello Kitty, BTS, Sanrio…' : 'Auto-fills on shape pick' }}"/>
              <div class="form-text">
                {{ $lockedCat === 'charms'
                    ? 'Charms with the same group are displayed together.'
                    : 'Auto-filled when you pick a shape.' }}
              </div>
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

      {{-- ── Shape & Colors + Variations (beads + figures only) ──────────── --}}
      @if($lockedCat !== 'charms')
      <div class="ac-card mb-3">

        <div class="ac-card-header">
          <i data-lucide="shapes"></i>
          Shape &amp; Colors
          @if(!$isEdit)
          <div class="ms-auto">
            <button type="button" id="var-toggle-btn" onclick="toggleVarSection()">
              <i data-lucide="layers" style="width:13px;height:13px;"></i>
              <span id="var-toggle-label">+ Variations</span>
              <i data-lucide="chevron-down" id="var-chevron"
                 style="width:12px;height:12px;transition:transform .2s;display:none;"></i>
            </button>
          </div>
          @endif
        </div>

        <div class="p-4">
          <div class="row g-3">

            <div class="col-12">
              <label class="form-label fw-semibold small mb-2">
                Shape <span class="text-danger">*</span>
              </label>

              <select name="shape" id="shape-select" class="d-none">
                <option value="">— Select shape —</option>
                @foreach($allShapes as $grp => $opts)
                  <optgroup label="{{ $grp }}">
                    @foreach($opts as $s)
                      <option value="{{ $s }}" {{ $old('shape') === $s ? 'selected' : '' }}>
                        {{ $s }}
                      </option>
                    @endforeach
                  </optgroup>
                @endforeach
              </select>

              <div id="shape-picker" style="
                display:grid;
                grid-template-columns:repeat(auto-fill,minmax(68px,1fr));
                gap:8px;">
                @foreach($allShapes as $grp => $opts)
                  <div style="grid-column:1/-1;font-size:.62rem;font-weight:700;
                              text-transform:uppercase;letter-spacing:.08em;
                              color:var(--grey-400);padding-top:4px;
                              {{ !$loop->first ? 'border-top:1px solid var(--grey-200);margin-top:4px;' : '' }}">
                    {{ $grp }}
                  </div>
                  @foreach($opts as $s)
                    @php $isSel = ($old('shape') === $s); @endphp
                    <button type="button"
                            class="shape-tile {{ $isSel ? 'selected' : '' }}"
                            data-shape="{{ $s }}"
                            onclick="selectShape('{{ $s }}', this)"
                            title="{{ $s }}"
                            style="display:flex;flex-direction:column;
                                   align-items:center;justify-content:center;
                                   gap:5px;padding:8px 4px;border-radius:9px;
                                   border:2px solid;
                                   border-color:{{ $isSel ? 'var(--pink)' : 'var(--grey-200)' }};
                                   background:{{ $isSel ? 'var(--pink-lt)' : 'var(--grey-50)' }};
                                   cursor:pointer;transition:all .14s;min-height:72px;">
                      <canvas class="shape-tile-canvas" width="40" height="40"
                              data-shape="{{ $s }}"
                              data-color="{{ $old('color', '#F9B8CF') }}"
                              data-detail="{{ $old('detail_color', '#C0136A') }}"
                              style="display:block;pointer-events:none;"></canvas>
                      <span style="font-size:.58rem;font-weight:600;color:var(--grey-600);
                                   font-family:monospace;text-align:center;word-break:break-all;">
                        {{ $s }}
                      </span>
                    </button>
                  @endforeach
                @endforeach
              </div>
            </div>

            {{-- ── Colors + Variations ─────────────────────────────────── --}}
            <div class="col-12">
              <div style="border:1.5px solid var(--grey-150,#ebebeb);
                          border-radius:13px;overflow:hidden;">
                <div style="padding:16px;">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold small mb-1">Main Color</label>
                      <div class="d-flex gap-2 align-items-center">
                        <input type="color" name="color" id="color-pick"
                               value="{{ $old('color', '#F9B8CF') }}"
                               class="form-control form-control-color form-control-sm"
                               style="width:40px;height:32px;padding:2px;"
                               oninput="document.getElementById('color-hex').value=this.value;
                                        refreshAllTiles(); schedulePreview(); syncPrimaryRow()"/>
                        <input type="text" id="color-hex"
                               value="{{ $old('color', '#F9B8CF') }}"
                               class="form-control form-control-sm font-monospace"
                               style="width:96px;"
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
                               oninput="document.getElementById('detail-hex').value=this.value;
                                        refreshAllTiles(); schedulePreview(); syncPrimaryRow()"/>
                        <input type="text" id="detail-hex"
                               value="{{ $old('detail_color', '#C0136A') }}"
                               class="form-control form-control-sm font-monospace"
                               style="width:96px;"
                               oninput="syncColor('detail-pick', this.value)"/>
                      </div>
                      <div class="form-text">Dice dots, star fill, checker, etc.</div>
                    </div>
                  </div>
                </div>

                @if(!$isEdit)
                <div id="var-section-body" style="display:none;
                     border-top:1.5px solid var(--grey-100,#f2f2f2);">
                  <div style="padding:14px 16px 16px;">
                    <div class="var-divider">Additional Variations</div>
                    <div class="var-col-headers">
                      <span></span>
                      <span>Name Suffix</span>
                      <span>Main Color</span>
                      <span></span>
                      <span>Detail</span>
                    </div>
                    <div class="var-row is-primary mb-2">
                      <canvas id="primary-var-canvas" width="36" height="36"
                              data-color="{{ $old('color', '#F9B8CF') }}"
                              data-detail="{{ $old('detail_color', '#C0136A') }}"
                              style="border-radius:50%;display:block;flex-shrink:0;"></canvas>
                      <span id="primary-var-name"
                            style="font-size:.78rem;font-weight:600;color:var(--grey-600);
                                   white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $old('name') ?: '(base name)' }}
                      </span>
                      <div class="d-flex gap-2 align-items-center"
                           style="opacity:.5;pointer-events:none;cursor:default;">
                        <div id="primary-main-chip"
                             style="width:26px;height:26px;border-radius:6px;flex-shrink:0;
                                    background:{{ $old('color', '#F9B8CF') }};
                                    border:1.5px solid rgba(0,0,0,.08);"></div>
                        <div id="primary-detail-chip"
                             style="width:26px;height:26px;border-radius:6px;flex-shrink:0;
                                    background:{{ $old('detail_color', '#C0136A') }};
                                    border:1.5px solid rgba(0,0,0,.08);"></div>
                      </div>
                      <span></span><span></span>
                    </div>
                    <div id="variation-list" class="d-flex flex-column gap-2"></div>
                    <button type="button" id="add-var-btn"
                            onclick="addVariation()" class="mt-2">
                      <i data-lucide="plus" style="width:13px;height:13px;"></i>
                      Add Color Variation
                    </button>
                  </div>
                </div>
                @endif
              </div>
            </div>

          </div>
        </div>
      </div>
      @endif

      {{-- ── Charm Image + Variations (charms only) ───────────────────────── --}}
      @if($lockedCat === 'charms')
      <div class="ac-card mb-3">

        <div class="ac-card-header">
          <i data-lucide="image"></i>
          Charm Image
          @if(!$isEdit)
          <div class="ms-auto">
            <button type="button" id="var-toggle-btn" onclick="toggleVarSection()">
              <i data-lucide="layers" style="width:13px;height:13px;"></i>
              <span id="var-toggle-label">+ Variations</span>
              <i data-lucide="chevron-down" id="var-chevron"
                 style="width:12px;height:12px;transition:transform .2s;display:none;"></i>
            </button>
          </div>
          @endif
        </div>

        <div style="border:1.5px solid var(--grey-150,#ebebeb);
                    border-radius:13px;overflow:hidden;margin:16px;">

          <div style="padding:16px;">
            <div class="row g-3">
              <div class="{{ ($isEdit && $element->img_path) ? 'col-md-6' : 'col-12' }}">
                <label class="form-label fw-semibold small mb-1">
                  Image File
                  @if(!$isEdit)
                    <small class="text-muted fw-normal">(primary)</small>
                  @endif
                </label>
                <input type="file" name="img_file" id="img-file-input"
                       accept="image/png,image/jpeg,image/webp"
                       class="form-control form-control-sm @error('img_file') is-invalid @enderror"
                       onchange="previewUploadedImage(this); syncPrimaryCharmRow(this)"/>
                <div class="form-text">PNG recommended (transparent background).</div>
                @error('img_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              @if($isEdit && $element->img_path)
              <div class="col-md-6">
                <label class="form-label fw-semibold small mb-1">Current Image</label>
                <div class="d-flex align-items-center gap-3">
                  <div style="width:48px;height:48px;border-radius:8px;
                              background:var(--grey-100);border:1px solid var(--grey-200);
                              display:flex;align-items:center;justify-content:center;padding:3px;">
                    <img src="{{ asset('img/builder/' . $element->img_path) }}"
                         style="width:100%;height:100%;object-fit:contain;"
                         alt="{{ $element->name }}"/>
                  </div>
                  <code style="font-size:.68rem;color:var(--grey-400);">{{ $element->img_path }}</code>
                </div>
                <div class="form-text">Upload a new file to replace it.</div>
              </div>
              @endif
            </div>
          </div>

          @if(!$isEdit)
          <div id="var-section-body" style="display:none;
               border-top:1.5px solid var(--grey-100,#f2f2f2);">
            <div style="padding:14px 16px 16px;">

              <div class="var-divider">Additional Variations</div>

              <div class="var-col-headers charm-headers">
                <span></span>
                <span>Name Suffix</span>
                <span>Image File</span>
                <span></span>
              </div>

              <div class="var-row charm-row is-primary mb-2">
                <div id="primary-charm-thumb" class="charm-var-thumb">
                  <img id="primary-charm-img" src="" alt="" style="display:none;"/>
                  <i data-lucide="image" id="primary-charm-icon"
                     style="width:14px;height:14px;color:var(--grey-400);"></i>
                </div>
                <span id="primary-var-name"
                      style="font-size:.78rem;font-weight:600;color:var(--grey-600);
                             white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  {{ $old('name') ?: '(base name)' }}
                </span>
                <span style="font-size:.72rem;color:var(--grey-400);font-style:italic;">
                  image from above ↑
                </span>
                <span></span>
              </div>

              <div id="variation-list" class="d-flex flex-column gap-2"></div>

              <button type="button" id="add-var-btn"
                      onclick="addCharmVariation()" class="mt-2">
                <i data-lucide="plus" style="width:13px;height:13px;"></i>
                Add Image Variation
              </button>

            </div>
          </div>
          @endif

        </div>
      </div>
      @endif

    </div>{{-- /col-lg-7 --}}

    {{-- ── RIGHT COLUMN — Live Preview + Smart Submit ──────────────────── --}}
    <div class="col-lg-5">
      <div class="ac-card" style="position:sticky;top:80px;">
        <div class="ac-card-header">
          <i data-lucide="eye"></i> Live Preview
          <span id="prev-shape-badge" class="ms-auto"
                style="font-size:.68rem;font-family:monospace;
                       background:var(--grey-100);color:var(--grey-600);
                       padding:2px 8px;border-radius:4px;">
            {{ $lockedCat === 'charms' ? 'charm' : ($old('shape', $isEdit ? ($element->shape ?? '—') : '—')) }}
          </span>
        </div>

        <div class="p-4">

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
              <canvas id="preview-canvas" class="shape-canvas"
                      width="120" height="120"
                      data-shape="{{ $old('shape', $isEdit ? ($element->shape ?? 'round') : 'round') }}"
                      data-color="{{ $old('color', $isEdit ? ($element->color ?? '#F9B8CF') : '#F9B8CF') }}"
                      data-detail="{{ $old('detail_color', $isEdit ? ($element->detail_color ?? '#C0136A') : '#C0136A') }}"
                      data-small="{{ ($old('is_small', $isEdit && $element->is_small)) ? '1' : '0' }}"
                      style="border-radius:6px;display:block;">
              </canvas>
            @endif
          </div>

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
            <div class="d-flex justify-content-between mb-1">
              <span style="color:var(--grey-400);">Size</span>
              <span id="prev-size-label" class="fw-semibold" style="font-size:.72rem;">
                {{ ($old('is_small', $isEdit && isset($element) && $element->is_small)) ? 'Small' : 'Standard' }}
              </span>
            </div>
            @endif
            @if(!$isEdit)
            <div class="d-flex justify-content-between" id="creating-row"
                 style="display:none!important;
                        padding-top:8px;margin-top:6px;
                        border-top:1px dashed var(--grey-150,#eee);">
              <span style="color:var(--grey-400);">Creating</span>
              <span id="creating-label" class="fw-bold"
                    style="font-size:.75rem;color:var(--teal,#0d9488);">
                1 element
              </span>
            </div>
            @endif
          </div>

        </div>

        {{-- ── SMART SUBMIT ─────────────────────────────────────────────── --}}
        <div class="p-4 pt-0 d-flex flex-column gap-2">
          <button type="button" id="smart-submit"
                  onclick="handleSmartSubmit()"
                  class="btn w-100 fw-bold"
                  style="background:var(--pink);color:#fff;
                         border-radius:10px;padding:11px 16px;
                         font-size:.88rem;line-height:1.25;
                         display:flex;align-items:center;
                         justify-content:center;gap:8px;">
            <i data-lucide="{{ $isEdit ? 'save' : 'plus-circle' }}"
               id="smart-submit-icon"
               style="width:16px;height:16px;flex-shrink:0;"></i>
            <span style="text-align:left;">
              <span id="smart-submit-label">
                {{ $isEdit ? 'Save Changes' : 'Add ' . $catLabel }}
              </span>
              @if(!$isEdit)
              <span class="btn-sub" id="smart-submit-sub" style="display:none;"></span>
              @endif
            </span>
          </button>
          <a href="{{ route('admin.elements.' . $lockedCat) }}"
             class="btn btn-sm btn-outline-secondary w-100"
             style="border-radius:8px;font-size:.8rem;">
            Cancel
          </a>
        </div>

      </div>
    </div>{{-- /col-lg-5 --}}

  </div>
</form>

@push('scripts')
@vite(['resources/js/shapes.js'])

<script>
/* ─── Constants ──────────────────────────────────────────────────────────── */
const IS_EDIT      = {{ $isEdit ? 'true' : 'false' }};
const LOCKED_CAT   = '{{ $lockedCat }}';
const CAT_LABEL    = '{{ $catLabel }}';
const SHAPE_GROUPS = @json($shapeToGroup);

let previewTimer   = null;
let variationIndex = 0;
let varSectionOpen = false;

/* ═══════════════════════════════════════════════════════════════════════════
   BASIC HELPERS
═══════════════════════════════════════════════════════════════════════════ */

function autoSlug(name) {
  if (IS_EDIT) return;
  document.getElementById('slug-input').value = name.toLowerCase()
    .replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
}

function syncColor(pickerId, hexVal) {
  if (/^#[0-9A-Fa-f]{6}$/.test(hexVal)) {
    document.getElementById(pickerId).value = hexVal;
    refreshAllTiles();
    schedulePreview();
    syncPrimaryRow();
  }
}

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

/* ═══════════════════════════════════════════════════════════════════════════
   SHAPE PICKER  (beads / figures only)
═══════════════════════════════════════════════════════════════════════════ */

function selectShape(shape, btnEl) {
  document.getElementById('shape-select').value = shape;

  document.querySelectorAll('.shape-tile').forEach(t => {
    const sel = t.dataset.shape === shape;
    t.style.borderColor = sel ? 'var(--pink)'    : 'var(--grey-200)';
    t.style.background  = sel ? 'var(--pink-lt)' : 'var(--grey-50)';
  });

  const groupInput = document.getElementById('group-input');
  if (groupInput && !IS_EDIT && SHAPE_GROUPS[shape]) {
    groupInput.value = SHAPE_GROUPS[shape];
  }

  updatePreview();
  refreshVarCanvases();
}

/* ═══════════════════════════════════════════════════════════════════════════
   LIVE PREVIEW  (beads / figures only)
═══════════════════════════════════════════════════════════════════════════ */

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
  if (detailHex)  detailHex.textContent       = detail;
}

function schedulePreview() {
  clearTimeout(previewTimer);
  previewTimer = setTimeout(updatePreview, 80);
}

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

/* ═══════════════════════════════════════════════════════════════════════════
   VARIATIONS — shared toggle / remove / smart-button
═══════════════════════════════════════════════════════════════════════════ */

function toggleVarSection() {
  varSectionOpen = !varSectionOpen;

  const body    = document.getElementById('var-section-body');
  const chevron = document.getElementById('var-chevron');
  const label   = document.getElementById('var-toggle-label');

  if (body)    body.style.display      = varSectionOpen ? '' : 'none';
  if (chevron) {
    chevron.style.display   = varSectionOpen ? '' : 'none';
    chevron.style.transform = varSectionOpen ? 'rotate(180deg)' : '';
  }
  if (label) label.textContent = varSectionOpen ? 'Variations' : '+ Variations';

  if (varSectionOpen) requestAnimationFrame(() => {
    if (LOCKED_CAT !== 'charms') syncPrimaryRow();
  });
}

function removeVariation(btn) {
  btn.closest('.var-row').remove();
  updateSmartButton();
}

function updateSmartButton() {
  if (IS_EDIT) return;

  const extraRows   = document.querySelectorAll('#variation-list .var-row').length;
  const total       = extraRows + 1;

  const label       = document.getElementById('smart-submit-label');
  const sub         = document.getElementById('smart-submit-sub');
  const btn         = document.getElementById('smart-submit');
  const icon        = document.getElementById('smart-submit-icon');
  const creatingRow = document.getElementById('creating-row');
  const creatingLbl = document.getElementById('creating-label');

  if (extraRows === 0) {
    if (label) label.textContent    = `Add ${CAT_LABEL}`;
    if (sub)   sub.style.display    = 'none';
    if (btn)   btn.style.background = 'var(--pink)';
    if (icon)  icon.setAttribute('data-lucide', 'plus-circle');
    if (creatingRow) creatingRow.style.setProperty('display', 'none', 'important');
  } else {
    const varWord = extraRows === 1 ? 'Variation' : 'Variations';
    if (label) label.textContent = `Add ${CAT_LABEL} + ${extraRows} ${varWord}`;
    if (sub)   sub.style.display = 'block';
    if (icon)  icon.setAttribute('data-lucide', 'layers');
    if (creatingRow) creatingRow.style.removeProperty('display');
    if (creatingLbl) creatingLbl.textContent = `${total} element${total > 1 ? 's' : ''}`;
    lucide.createIcons();
  }
}

function handleSmartSubmit() {
  const extraRows = document.querySelectorAll('#variation-list .var-row').length;
  document.getElementById('mode-input').value = extraRows > 0 ? 'bulk' : 'single';
  document.getElementById('element-form').submit();
}

/* ═══════════════════════════════════════════════════════════════════════════
   VARIATIONS — beads / figures (color-based)
═══════════════════════════════════════════════════════════════════════════ */

function syncPrimaryLabel() {
  const el  = document.getElementById('primary-var-name');
  const val = document.getElementById('base-name-input')?.value?.trim();
  if (el) el.textContent = val || '(base name)';
}

function syncPrimaryRow() {
  if (LOCKED_CAT === 'charms') return;

  const color  = document.getElementById('color-pick')?.value  || '#F9B8CF';
  const detail = document.getElementById('detail-pick')?.value || '#C0136A';

  const mc = document.getElementById('primary-main-chip');
  const dc = document.getElementById('primary-detail-chip');
  if (mc) mc.style.background = color;
  if (dc) dc.style.background = detail;

  const canvas = document.getElementById('primary-var-canvas');
  if (canvas && window.ArtshapeRenderer) {
    const shape = document.getElementById('shape-select')?.value || 'round';
    canvas.dataset.color  = color;
    canvas.dataset.detail = detail;
    ArtshapeRenderer.draw(canvas, { shape, color, detail });
  }
}

function addVariation(color = '#F9B8CF', detail = '#C0136A', suffix = '') {
  if (!varSectionOpen) toggleVarSection();

  const idx  = variationIndex++;
  const list = document.getElementById('variation-list');
  if (!list) return;

  const row = document.createElement('div');
  row.className    = 'var-row';
  row.dataset.idx  = idx;

  row.innerHTML = `
    <canvas class="var-canvas"
            width="36" height="36"
            data-idx="${idx}"
            data-color="${color}"
            data-detail="${detail}"
            style="border-radius:50%;display:block;flex-shrink:0;"></canvas>
    <input type="text"
           name="variations[${idx}][suffix]"
           value="${suffix}"
           placeholder="e.g. Pink, Sky Blue…"
           class="form-control form-control-sm"
           style="font-size:.8rem;"/>
    <div class="d-flex gap-1 align-items-center">
      <input type="color"
             name="variations[${idx}][color]"
             value="${color}"
             class="form-control form-control-color form-control-sm"
             style="width:30px;height:28px;padding:1px;flex-shrink:0;"
             oninput="onVarColor(${idx},'color',this.value)"/>
      <input type="text"
             class="form-control var-hex var-color-hex"
             data-idx="${idx}" data-field="color"
             value="${color}"
             oninput="onVarHex(this)"/>
    </div>
    <input type="color"
           name="variations[${idx}][detail]"
           value="${detail}"
           class="form-control form-control-color form-control-sm"
           style="width:30px;height:28px;padding:1px;"
           oninput="onVarColor(${idx},'detail',this.value)"/>
    <button type="button" class="var-remove-btn"
            onclick="removeVariation(this)" title="Remove">
      <i data-lucide="x" style="width:13px;height:13px;"></i>
    </button>
  `;

  list.appendChild(row);
  lucide.createIcons();
  requestAnimationFrame(() => renderVarCanvas(idx));
  updateSmartButton();
}

function renderVarCanvas(idx) {
  const c = document.querySelector(`.var-canvas[data-idx="${idx}"]`);
  if (!c || !window.ArtshapeRenderer) return;
  ArtshapeRenderer.draw(c, {
    shape  : document.getElementById('shape-select')?.value || 'round',
    color  : c.dataset.color  || '#F9B8CF',
    detail : c.dataset.detail || '#C0136A',
  });
}

function refreshVarCanvases() {
  syncPrimaryRow();
  document.querySelectorAll('.var-canvas').forEach(c => renderVarCanvas(c.dataset.idx));
}

function onVarColor(idx, field, value) {
  const c = document.querySelector(`.var-canvas[data-idx="${idx}"]`);
  if (c) {
    if (field === 'color') c.dataset.color  = value;
    else                   c.dataset.detail = value;
    renderVarCanvas(idx);
  }
  const hex = document.querySelector(`.var-color-hex[data-idx="${idx}"][data-field="${field}"]`);
  if (hex) hex.value = value;
}

function onVarHex(input) {
  const val = input.value.trim();
  if (!/^#[0-9A-Fa-f]{6}$/.test(val)) return;
  const picker = input.previousElementSibling;
  if (picker?.type === 'color') picker.value = val;
  onVarColor(input.dataset.idx, input.dataset.field, val);
}

/* ═══════════════════════════════════════════════════════════════════════════
   VARIATIONS — charms (image-based)
═══════════════════════════════════════════════════════════════════════════ */

function syncPrimaryCharmRow(input) {
  if (!input.files || !input.files[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    const img  = document.getElementById('primary-charm-img');
    const icon = document.getElementById('primary-charm-icon');
    if (img)  { img.src = e.target.result; img.style.display = ''; }
    if (icon) icon.style.display = 'none';
  };
  reader.readAsDataURL(input.files[0]);
}

function addCharmVariation() {
  if (!varSectionOpen) toggleVarSection();

  const idx  = variationIndex++;
  const list = document.getElementById('variation-list');
  if (!list) return;

  const row = document.createElement('div');
  row.className   = 'var-row charm-row';
  row.dataset.idx = idx;

  row.innerHTML = `
    <div class="charm-var-thumb" id="charm-thumb-${idx}">
      <img class="charm-var-img" src="" alt=""
           style="width:100%;height:100%;object-fit:contain;display:none;"/>
      <i data-lucide="image"
         style="width:14px;height:14px;color:var(--grey-400);"></i>
    </div>
    <input type="text"
           name="variations[${idx}][suffix]"
           placeholder="e.g. Pink ver., v2…"
           class="form-control form-control-sm"
           style="font-size:.8rem;"/>
    <input type="file"
           name="variations[${idx}][img_file]"
           accept="image/png,image/jpeg,image/webp"
           class="form-control form-control-sm"
           style="font-size:.72rem;"
           onchange="previewCharmVar(this, ${idx})"/>
    <button type="button" class="var-remove-btn"
            onclick="removeVariation(this)" title="Remove">
      <i data-lucide="x" style="width:13px;height:13px;"></i>
    </button>
  `;

  list.appendChild(row);
  lucide.createIcons();
  updateSmartButton();
}

function previewCharmVar(input, idx) {
  if (!input.files || !input.files[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    const thumb = document.getElementById(`charm-thumb-${idx}`);
    if (!thumb) return;
    const img  = thumb.querySelector('.charm-var-img');
    const icon = thumb.querySelector('[data-lucide]');
    if (img)  { img.src = e.target.result; img.style.display = ''; }
    if (icon) icon.style.display = 'none';
  };
  reader.readAsDataURL(input.files[0]);
}

/* ═══════════════════════════════════════════════════════════════════════════
   INIT
═══════════════════════════════════════════════════════════════════════════ */

function init() {
  if (LOCKED_CAT !== 'charms') {
    document.querySelectorAll('.shape-tile-canvas').forEach(c => ArtshapeRenderer.draw(c));
    updatePreview();
  }
  if (window.lucide) lucide.createIcons();
  updateSmartButton();
}

if (window.ArtshapeRenderer) { init(); }
else { window.addEventListener('artshape:ready', init); }

// For charm form (no ArtshapeRenderer needed), still init
if (LOCKED_CAT === 'charms') {
  document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
    updateSmartButton();
  });
}
</script>
@endpush