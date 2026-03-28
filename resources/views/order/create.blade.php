{{-- resources/views/order/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>ArtsyCrate — Place Your Order</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --pink:     #FF5FA0;
      --pink-lt:  #FFF0F6;
      --pink-bd:  #FFD0E8;
      --pink-dk:  #C0136A;
      --teal:     #1AC8C4;
      --teal-lt:  #E8FAFA;
      --lime:     #CCE86A;
      --lime-lt:  #F5FFD8;
      --ink:      #1C1C2E;
      --ink-2:    #3D3D52;
      --grey-50:  #FAFAFA;
      --grey-100: #F4F4F6;
      --grey-200: #E8E8EE;
      --grey-400: #A0A0B8;
      --white:    #FFFFFF;
      --fh: 'Syne', sans-serif;
      --fb: 'Nunito', sans-serif;
      --r: 14px; --r-sm: 8px;
      --shadow: 0 4px 24px rgba(0,0,0,.07);
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { font-size: 15px; }
    body { font-family: var(--fb); background: var(--grey-100); color: var(--ink); min-height: 100vh; }

    /* ── Topbar ──────────────────────────────────────────────────────────── */
    .topbar {
      height: 52px; background: var(--white);
      border-bottom: 1.5px solid var(--grey-200);
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 28px; position: sticky; top: 0; z-index: 50;
    }
    .logo { font-family: var(--fh); font-size: 1.15rem; color: var(--ink); text-decoration: none; }
    .logo b { color: var(--pink); }
    .back-link {
      display: flex; align-items: center; gap: 6px;
      font-size: .8rem; font-weight: 700; color: var(--ink-2);
      text-decoration: none; padding: 6px 14px;
      border-radius: 8px; border: 1.5px solid var(--grey-200);
      transition: border-color .15s, color .15s;
    }
    .back-link:hover { border-color: var(--pink); color: var(--pink); }
    .back-link svg { width: 12px; height: 12px; stroke: currentColor; fill: none; stroke-width: 2.5; }

    /* ── Page shell ──────────────────────────────────────────────────────── */
    .page { max-width: 1100px; margin: 0 auto; padding: 32px 20px 60px; }
    .page-title { font-family: var(--fh); font-size: 1.5rem; font-weight: 800; color: var(--ink); margin-bottom: 4px; }
    .page-sub   { font-size: .82rem; color: var(--grey-400); margin-bottom: 28px; }

    /* ── Grid ────────────────────────────────────────────────────────────── */
    .order-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: start; }
    @media (max-width: 740px) { .order-grid { grid-template-columns: 1fr; } }

    /* ── Card ────────────────────────────────────────────────────────────── */
    .card { background: var(--white); border-radius: var(--r); border: 1.5px solid var(--grey-200); box-shadow: var(--shadow); overflow: hidden; margin-bottom: 20px; }
    .card:last-child { margin-bottom: 0; }
    .card-head {
      padding: 13px 18px; border-bottom: 1.5px solid var(--grey-200);
      font-family: var(--fh); font-size: .75rem; font-weight: 800;
      letter-spacing: .05em; text-transform: uppercase;
      display: flex; align-items: center; gap: 8px;
    }
    .card-head.pink { color: var(--pink-dk); background: var(--pink-lt); }
    .card-head.teal { color: #0A8C88;         background: var(--teal-lt); }
    .card-head.lime { color: #5A7200;          background: var(--lime-lt); }
    .card-head.ink  { color: var(--ink-2);     background: var(--grey-100); }
    .card-head-dot  { width: 7px; height: 7px; border-radius: 50%; }
    .pink .card-head-dot { background: var(--pink); }
    .teal .card-head-dot { background: var(--teal); }
    .lime .card-head-dot { background: var(--lime); }
    .ink  .card-head-dot { background: var(--ink-2); }
    .card-head-count {
      margin-left: auto; background: var(--grey-200); color: var(--ink-2);
      border-radius: 4px; padding: 1px 7px; font-size: .6rem; font-weight: 900;
    }
    .card-body { padding: 18px; }

    /* ── Snapshot ────────────────────────────────────────────────────────── */
    .snapshot-wrap {
      background: var(--grey-50); border: 1.5px solid var(--grey-200);
      border-radius: var(--r-sm); overflow: hidden; text-align: center; margin-bottom: 16px;
    }
    .snapshot-wrap img { width: 100%; display: block; }
    .snapshot-none { padding: 32px 16px; color: var(--grey-400); font-size: .8rem; }

    /* ── Design specs grid ───────────────────────────────────────────────── */
    .specs-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px 20px; font-size: .8rem; margin-bottom: 14px; }
    .spec-lbl { font-size: .63rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: var(--grey-400); margin-bottom: 3px; }
    .spec-val { font-weight: 700; color: var(--ink); display: flex; align-items: center; gap: 6px; }
    .color-dot { width: 14px; height: 14px; border-radius: 50%; flex-shrink: 0; border: 1.5px solid rgba(0,0,0,.1); display: inline-block; }
    .spec-code { font-size: .72rem; color: var(--ink-2); font-family: monospace; }

    /* ── Divider ─────────────────────────────────────────────────────────── */
    .divider { height: 1px; background: var(--grey-200); margin: 14px 0; }

    /* ── Element list ────────────────────────────────────────────────────── */
    .elem-list { display: flex; flex-direction: column; gap: 2px; max-height: 320px; overflow-y: auto; padding-right: 2px; }
    .elem-row  { display: flex; align-items: center; gap: 10px; padding: 6px 8px; border-radius: 8px; transition: background .1s; }
    .elem-row:hover { background: var(--grey-50); }
    .elem-pos  {
      width: 20px; height: 20px; border-radius: 50%;
      background: var(--grey-100); color: var(--grey-400);
      font-size: .6rem; font-weight: 800; flex-shrink: 0;
      display: flex; align-items: center; justify-content: center;
    }
    .elem-thumb {
      width: 30px; height: 30px; border-radius: 6px; flex-shrink: 0;
      display: flex; align-items: center; justify-content: center;
      font-size: .8rem; font-weight: 900;
      border: 1.5px solid rgba(0,0,0,.07);
      overflow: hidden;
    }
    .elem-info  { flex: 1; min-width: 0; }
    .elem-name  { font-size: .78rem; font-weight: 700; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .elem-meta  { font-size: .67rem; color: var(--grey-400); margin-top: 1px; }
    .elem-price { font-size: .75rem; font-weight: 800; color: var(--pink); flex-shrink: 0; }
    .strand-label {
      font-size: .62rem; font-weight: 800; text-transform: uppercase; letter-spacing: .08em;
      color: var(--grey-400); padding: 6px 8px 2px;
      border-top: 1px solid var(--grey-100); margin-top: 2px;
    }
    .strand-label:first-child { border-top: none; margin-top: 0; }

    /* ── Summary rows ────────────────────────────────────────────────────── */
    .sum-rows { display: flex; flex-direction: column; }
    .sum-row  { display: flex; justify-content: space-between; align-items: center; font-size: .82rem; padding: 7px 0; border-bottom: 1px dashed var(--grey-200); }
    .sum-row:last-of-type { border-bottom: none; }
    .sum-lbl  { color: var(--grey-400); font-weight: 600; }
    .sum-val  { font-weight: 700; color: var(--ink); }
    .sum-total { margin-top: 12px; padding: 13px 16px; background: var(--pink-lt); border: 1.5px solid var(--pink-bd); border-radius: var(--r-sm); display: flex; justify-content: space-between; align-items: center; }
    .sum-total-lbl { font-family: var(--fh); font-size: .82rem; font-weight: 800; color: var(--ink-2); }
    .sum-total-val { font-family: var(--fh); font-size: 1.25rem; font-weight: 800; color: var(--pink-dk); }

    /* ── Notice ──────────────────────────────────────────────────────────── */
    .notice { display: flex; align-items: flex-start; gap: 9px; padding: 11px 13px; background: var(--teal-lt); border: 1.5px solid #A0E8E6; border-radius: var(--r-sm); font-size: .73rem; font-weight: 600; color: #0A6E6A; margin-top: 12px; line-height: 1.5; }
    .notice-ico { flex-shrink: 0; font-size: .95rem; margin-top: 1px; }

    /* ── Form ────────────────────────────────────────────────────────────── */
    .frow  { margin-bottom: 14px; }
    .frow2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px; }
    .flbl  { display: block; font-size: .7rem; font-weight: 800; color: var(--ink-2); margin-bottom: 5px; letter-spacing: .03em; text-transform: uppercase; }
    .flbl .req { color: var(--pink); margin-left: 2px; }
    .finput, .fselect, .ftextarea {
      width: 100%; padding: 10px 14px; border: 1.5px solid var(--grey-200); border-radius: var(--r-sm);
      font-family: var(--fb); font-size: .85rem; font-weight: 600; color: var(--ink); background: var(--white); outline: none;
      transition: border-color .15s, box-shadow .15s;
    }
    .finput:focus, .fselect:focus, .ftextarea:focus { border-color: var(--pink); box-shadow: 0 0 0 3px rgba(255,95,160,.1); }
    .finput.error { border-color: #EF4444; }
    .ftextarea { resize: vertical; min-height: 80px; }
    .field-hint { font-size: .68rem; color: #EF4444; margin-top: 3px; display: none; font-weight: 700; }
    .field-hint.show { display: block; }

    /* ── Submit ──────────────────────────────────────────────────────────── */
    .submit-btn {
      width: 100%; padding: 14px; border: none; border-radius: var(--r-sm);
      background: var(--pink); color: white; font-family: var(--fh); font-size: .95rem; font-weight: 800;
      cursor: pointer; letter-spacing: .02em; box-shadow: 0 4px 16px rgba(255,95,160,.3); margin-top: 4px;
      transition: background .15s, transform .1s, box-shadow .15s;
    }
    .submit-btn:hover { background: var(--pink-dk); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(192,19,106,.3); }
    .submit-btn:active { transform: translateY(0); }
    .submit-btn:disabled { background: var(--grey-400); box-shadow: none; cursor: not-allowed; transform: none; }

    /* ── Breadcrumb & steps ──────────────────────────────────────────────── */
    .breadcrumb { display: flex; align-items: center; gap: 6px; font-size: .72rem; font-weight: 700; color: var(--grey-400); margin-bottom: 18px; }
    .breadcrumb a { color: var(--pink); text-decoration: none; }
    .breadcrumb a:hover { text-decoration: underline; }
    .steps { display: flex; align-items: center; margin-bottom: 28px; }
    .step  { display: flex; align-items: center; gap: 7px; font-size: .72rem; font-weight: 800; color: var(--grey-400); }
    .step.done   { color: var(--teal); }
    .step.active { color: var(--ink); }
    .step-num { width: 22px; height: 22px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: .65rem; font-weight: 900; border: 2px solid currentColor; }
    .step.done   .step-num { background: var(--teal); border-color: var(--teal); color: white; }
    .step.active .step-num { background: var(--ink);  border-color: var(--ink);  color: white; }
    .step-line { height: 2px; flex: 1; background: var(--grey-200); margin: 0 8px; max-width: 40px; }
    .step-line.done { background: var(--teal); }
    .err-banner { padding: 10px 14px; background: #FEF2F2; border: 1.5px solid #FECACA; border-radius: 8px; margin-bottom: 16px; font-size: .78rem; font-weight: 700; color: #B91C1C; }
  </style>
</head>
<body>

@php
  $snap      = session('order_snapshot');
  $elems     = session('order_design') ? json_decode(session('order_design'), true) : [];
  $slug      = session('order_product_slug', 'bracelet');
  $length    = session('order_length', '—');
  $strColor  = session('order_str_color');
  $strType   = session('order_str_type');
  $clasp     = session('order_clasp');
  $view      = session('order_view');
  $strands   = (int) session('order_strands', 1);
  $ringType  = session('order_ring_type');
  $ringColor = session('order_ring_color');
  $ltrBg     = session('order_ltr_bg');
  $ltrText   = session('order_ltr_text');
  $ltrShape  = session('order_ltr_shape');

  $productLabel = match($slug) {
    'bracelet' => 'Bracelet',
    'necklace' => 'Necklace',
    'keychain' => 'Keychain / Bag Charm',
    default    => ucfirst($slug),
  };

  // Group elements by strand for display
  $byStrand  = [];
  $elemsCost = 0;
  foreach ($elems as $i => $el) {
    $byStrand[$el['strand'] ?? 0][] = array_merge($el, ['_pos' => $i]);
    $elemsCost += $el['price'] ?? 8;
  }
  $multiStrand = count($byStrand) > 1;
  $total       = ($product->base_price ?? 0) + $elemsCost;

  // Text specs — only show non-empty, non-default values
  $specs = array_filter([
    'Product'      => $productLabel,
    'Length'       => $length ?: null,
    'String Type'  => $strType ?: null,
    'Clasp'        => ($clasp && $clasp !== 'none') ? ucfirst($clasp) : null,
    'View'         => $view ? ucfirst($view) : null,
    'Ring Type'    => $ringType ? ucfirst($ringType) : null,
    'Strands'      => $strands > 1 ? $strands : null,
    'Letter Shape' => $ltrShape ? ucfirst($ltrShape) : null,
  ]);

  // Color specs
  $colorSpecs = array_filter([
    'String Color' => $strColor  ?: null,
    'Ring Color'   => $ringColor ?: null,
    'Letter BG'    => $ltrBg     ?: null,
    'Letter Text'  => $ltrText   ?: null,
  ]);

  // Round bead-like shapes for thumb border-radius
  $roundShapes = ['round', 'pearl', 'ellipse', 'tube', 'faceted'];
@endphp

<!-- Topbar -->
<div class="topbar">
  <a href="{{ route('builder.bracelet') }}" class="logo">Artsy<b>Crate</b></a>
  <a href="{{ url()->previous() }}" class="back-link">
    <svg viewBox="0 0 12 12"><polyline points="7,2 3,6 7,10"/><line x1="3" y1="6" x2="11" y2="6"/></svg>
    Back to Builder
  </a>
</div>

<div class="page">

  <div class="breadcrumb">
    <a href="{{ route('builder.bracelet') }}">Builder</a>
    <span style="color:var(--grey-200);">›</span>
    <span>Place Order</span>
  </div>

  <div class="steps">
    <div class="step done"><div class="step-num">✓</div> Design</div>
    <div class="step-line done"></div>
    <div class="step active"><div class="step-num">2</div> Order Details</div>
    <div class="step-line"></div>
    <div class="step"><div class="step-num">3</div> Confirmation</div>
  </div>

  <div class="page-title">Place Your Order</div>
  <div class="page-sub">Review your design and fill in your details — we'll reach out to confirm.</div>

  <form method="POST" action="{{ route('builder.order.store') }}" id="order-form" novalidate>
    @csrf

    <div class="order-grid">

      {{-- ══ LEFT — Design info ══════════════════════════════════════════════ --}}
      <div>

        {{-- Design Preview card --}}
        <div class="card">
          <div class="card-head teal">
            <div class="card-head-dot"></div>
            Your Design
          </div>
          <div class="card-body">

            {{-- Snapshot image --}}
            <div class="snapshot-wrap">
              @if($snap)
                <img src="{{ $snap }}" alt="Design snapshot"/>
              @else
                <div class="snapshot-none">
                  No snapshot available.
                  <a href="{{ url()->previous() }}" style="color:var(--pink);">Go back →</a>
                </div>
              @endif
            </div>

            {{-- Text specs --}}
            @if(count($specs))
              <div class="specs-grid">
                @foreach($specs as $label => $val)
                  <div>
                    <div class="spec-lbl">{{ $label }}</div>
                    <div class="spec-val">{{ $val }}</div>
                  </div>
                @endforeach
              </div>
              @if(count($colorSpecs)) <div class="divider"></div> @endif
            @endif

            {{-- Color swatches --}}
            @if(count($colorSpecs))
              <div class="specs-grid">
                @foreach($colorSpecs as $label => $hex)
                  <div>
                    <div class="spec-lbl">{{ $label }}</div>
                    <div class="spec-val">
                      <span class="color-dot" style="background:{{ $hex }};"></span>
                      <span class="spec-code">{{ $hex }}</span>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif

          </div>
        </div>

        {{-- Elements on Design card --}}
        @if(count($elems))
        <div class="card">
          <div class="card-head ink">
            <div class="card-head-dot"></div>
            Elements on Design
            <span class="card-head-count">{{ count($elems) }}</span>
          </div>
          <div class="card-body" style="padding:12px 14px;">
            <div class="elem-list">
              @foreach($byStrand as $strandIdx => $strandElems)

                @if($multiStrand)
                  <div class="strand-label">Strand {{ $strandIdx + 1 }}</div>
                @endif

                @foreach($strandElems as $el)
                  @php
                    $isLetter = !empty($el['isLetter']);
                    $pos      = $el['_pos'] + 1;
                    $elName   = $el['name'] ?? 'Element';
                    $elPrice  = $el['price'] ?? 8;
                    $elCat    = $el['category'] ?? '';
                    $elShape  = $el['shape'] ?? null;
                    $elColor  = $el['color'] ?? '#F9B8CF';
                    $useImg   = !empty($el['useImg']);
                    $imgSrc   = $el['imgSrc'] ?? null;
                    // Letter-specific
                    $lBg      = $el['ltrBg']      ?? '#F9B8CF';
                    $lTxt     = $el['ltrText']     ?? '#C0136A';
                    $lLabel   = $el['label']       ?? '?';
                    $lShape   = $el['letterShape'] ?? 'round';
                    // Thumb border-radius
                    $thumbR   = $isLetter
                      ? ($lShape === 'square' ? '6px' : '50%')
                      : (in_array($elShape, $roundShapes) ? '50%' : '6px');
                  @endphp

                  <div class="elem-row">
                    <span class="elem-pos">{{ $pos }}</span>

                    {{-- Thumbnail --}}
                    @if($isLetter)
                      <div class="elem-thumb"
                           style="background:{{ $lBg }};color:{{ $lTxt }};border-radius:{{ $thumbR }};">
                        {{ strtoupper($lLabel) }}
                      </div>
                    @elseif($useImg && $imgSrc)
                      <div class="elem-thumb" style="background:var(--grey-100);border-radius:6px;">
                        <img src="{{ $imgSrc }}" alt="{{ $elName }}"
                             style="width:30px;height:30px;object-fit:contain;"/>
                      </div>
                    @else
                      <div class="elem-thumb"
                           style="background:{{ $elColor }};border-radius:{{ $thumbR }};"></div>
                    @endif

                    <div class="elem-info">
                      <div class="elem-name">
                        @if($isLetter) Letter "{{ strtoupper($lLabel) }}"
                        @else          {{ $elName }}
                        @endif
                      </div>
                      <div class="elem-meta">
                        @if($isLetter) {{ ucfirst($lShape) }} tile
                        @else          {{ ucfirst($elCat) }}{{ $elShape ? ' · ' . $elShape : '' }}
                        @endif
                      </div>
                    </div>

                    <span class="elem-price">₱{{ $elPrice }}</span>
                  </div>
                @endforeach

              @endforeach
            </div>
          </div>
        </div>
        @endif

        {{-- Order Summary card --}}
        <div class="card">
          <div class="card-head lime">
            <div class="card-head-dot"></div>
            Order Summary
          </div>
          <div class="card-body">
            <div class="sum-rows">
              <div class="sum-row">
                <span class="sum-lbl">Product</span>
                <span class="sum-val">{{ $productLabel }}</span>
              </div>
              <div class="sum-row">
                <span class="sum-lbl">Length</span>
                <span class="sum-val">{{ $length }}</span>
              </div>
              <div class="sum-row">
                <span class="sum-lbl">Base Price</span>
                <span class="sum-val">₱{{ $product->base_price ?? 0 }}</span>
              </div>
              <div class="sum-row">
                <span class="sum-lbl">Elements ({{ count($elems) }})</span>
                <span class="sum-val">₱{{ $elemsCost }}</span>
              </div>
            </div>
            <div class="sum-total">
              <span class="sum-total-lbl">Estimated Total</span>
              <span class="sum-total-val">₱{{ $total }}.00</span>
            </div>
            <div class="notice">
              <span class="notice-ico">ℹ</span>
              <span>This is an estimate. Final pricing will be confirmed once we review your order and reach out to you.</span>
            </div>
          </div>
        </div>

      </div>{{-- /left --}}

      {{-- ══ RIGHT — Customer form ════════════════════════════════════════════ --}}
      <div>
        <div class="card">
          <div class="card-head pink">
            <div class="card-head-dot"></div>
            Your Details
          </div>
          <div class="card-body">

            @if($errors->any())
              <div class="err-banner">Please fix the errors below and try again.</div>
            @endif

            <div class="frow2">
              <div class="frow" style="margin-bottom:0;">
                <label class="flbl" for="first_name">First Name <span class="req">*</span></label>
                <input class="finput {{ $errors->has('first_name') ? 'error' : '' }}"
                       type="text" id="first_name" name="first_name"
                       value="{{ old('first_name') }}" placeholder="Maria" autocomplete="given-name"/>
                @error('first_name')<div class="field-hint show">{{ $message }}</div>@enderror
              </div>
              <div class="frow" style="margin-bottom:0;">
                <label class="flbl" for="last_name">Last Name <span class="req">*</span></label>
                <input class="finput {{ $errors->has('last_name') ? 'error' : '' }}"
                       type="text" id="last_name" name="last_name"
                       value="{{ old('last_name') }}" placeholder="Santos" autocomplete="family-name"/>
                @error('last_name')<div class="field-hint show">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="frow">
              <label class="flbl" for="contact_number">Contact Number <span class="req">*</span></label>
              <input class="finput {{ $errors->has('contact_number') ? 'error' : '' }}"
                     type="tel" id="contact_number" name="contact_number"
                     value="{{ old('contact_number') }}" placeholder="09xx-xxx-xxxx" autocomplete="tel"/>
              @error('contact_number')<div class="field-hint show">{{ $message }}</div>@enderror
            </div>

            <div class="frow">
              <label class="flbl" for="quantity">Quantity</label>
              <select class="fselect" id="quantity" name="quantity">
                @for($i = 1; $i <= 10; $i++)
                  <option value="{{ $i }}" {{ old('quantity', 1) == $i ? 'selected' : '' }}>
                    {{ $i }} piece{{ $i > 1 ? 's' : '' }}
                  </option>
                @endfor
              </select>
            </div>

            <div class="frow" style="margin-bottom:0;">
              <label class="flbl" for="notes">Special Notes</label>
              <textarea class="ftextarea" id="notes" name="notes"
                        placeholder="Any requests, colour preferences, gift messages…">{{ old('notes') }}</textarea>
            </div>

            <div class="notice" style="margin-top:16px;margin-bottom:16px;">
              <span class="notice-ico">💬</span>
              <span>We'll message you via your contact number to confirm availability, finalize the design, and arrange payment.</span>
            </div>

            <button type="submit" class="submit-btn" id="submit-btn">Submit Order ✓</button>

          </div>
        </div>
      </div>{{-- /right --}}

    </div>
  </form>
</div>

<script>
  document.getElementById('submit-btn').addEventListener('click', function () {
    this.disabled = true;
    this.textContent = 'Submitting…';
    this.closest('form').submit();
  });
</script>

</body>
</html>