<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Revise Design — {{ $order->order_code }} — ArtsyCrate</title>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    /* ── Revision notice bar above the builder ─────────────────────── */
    .revision-bar {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 1000;
      background: linear-gradient(90deg, #7C3AED 0%, #6D28D9 100%);
      color: #fff;
      padding: 10px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 14px;
      font-family: 'Nunito', sans-serif;
      font-size: .82rem;
      font-weight: 700;
    }
    .revision-bar .rbar-l {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .revision-bar .rbar-badge {
      background: rgba(255,255,255,.2);
      border-radius: 20px;
      padding: 3px 11px;
      font-size: .7rem;
      font-weight: 900;
      letter-spacing: .04em;
    }
    .revision-bar .rbar-code {
      font-family: monospace;
      background: rgba(255,255,255,.15);
      border-radius: 6px;
      padding: 2px 9px;
      font-size: .8rem;
    }
    .revision-bar .rbar-cancel {
      background: rgba(255,255,255,.15);
      border: 1.5px solid rgba(255,255,255,.3);
      color: #fff;
      border-radius: 8px;
      padding: 5px 14px;
      font-family: 'Nunito', sans-serif;
      font-weight: 700;
      font-size: .78rem;
      cursor: pointer;
      text-decoration: none;
      transition: background .13s;
    }
    .revision-bar .rbar-cancel:hover {
      background: rgba(255,255,255,.25);
      color: #fff;
    }

    /* ── Push builder content down by the bar height ─────────────────── */
    body { padding-top: 46px !important; }
    .builder { top: 46px !important; }

    /* ── Submit revision overlay on the order modal ──────────────────── */
    .rev-submit-note {
      background: #F3E8FF;
      border: 1.5px solid #DDD6FE;
      border-radius: 10px;
      padding: 12px 14px;
      margin-bottom: 12px;
    }
    .rev-submit-note .rsn-title {
      font-size: .78rem;
      font-weight: 800;
      color: #6D28D9;
      margin-bottom: 4px;
    }
    .rev-submit-note .rsn-body {
      font-size: .74rem;
      font-weight: 600;
      color: #7C3AED;
      line-height: 1.5;
    }
  </style>
</head>
<body>

{{-- ── Revision notice bar ─────────────────────────────────────────────────── --}}
<div class="revision-bar">
  <div class="rbar-l">
    <span class="rbar-badge">✏️ Revising Design</span>
    <span>Order</span>
    <span class="rbar-code">{{ $order->order_code }}</span>
    <span style="opacity:.65;font-weight:600;">for {{ $order->first_name }}</span>
  </div>
  <a href="{{ route('account.orders.show', $order->order_code) }}" class="rbar-cancel">
    ← Back to Order
  </a>
</div>

{{-- ── Builder (same as product pages but we inject revision context) ──────── --}}
<div class="builder">

  {{-- Reuse the same setup panel from the product (hidden for simplicity) --}}
  @php
    $productSlug = $order->product->slug ?? 'bracelet';
  @endphp

  @include('builder.includes.library-panel')
  @include('builder.includes.canvas')
  @include('builder.includes.design-panel')
  @include('builder.includes.modal-preview')

  {{-- ── Revision Order Modal (replaces standard order modal) ──────────────── --}}
  <div class="overlay" id="order-modal">
    <div class="mbox">
      <div class="mhead" style="background:linear-gradient(135deg,#7C3AED,#6D28D9);">
        <div class="mtitle">( Submit Revised Design )</div>
        <button class="mclose" onclick="app.ui.closeModal('order-modal')">×</button>
      </div>
      <div class="mbody">
        <div class="form-col" id="order-form-view">

          <div class="rev-submit-note">
            <div class="rsn-title">✏️ You're submitting a revision</div>
            <div class="rsn-body">
              Your updated design will be sent to ArtsyCrate for review.
              They'll send you a new mockup once it's ready!
            </div>
          </div>

          <div class="frow">
            <label class="flbl">Anything to note about your changes?</label>
            <input class="finput" id="revision-note"
                   placeholder="e.g. Swapped the blue bead for pink, added my initial 'K'…"/>
          </div>

          <div id="order-error" style="display:none;background:#FFF1F2;border:1px solid #FDA4AF;
               color:#9F1239;border-radius:8px;padding:8px 12px;font-size:.78rem;font-weight:500;"></div>

          <div id="order-design-thumb" style="display:none;margin-top:8px;">
            <div class="slbl">Your Revised Design</div>
            <canvas id="order-canvas" width="300" height="140"
                    style="width:100%;border-radius:10px;
                           background:var(--grey-50);border:1.5px solid var(--grey-200);"></canvas>
          </div>

          <div class="mbtns" style="margin-top:10px;">
            <button class="mbtn secondary" onclick="app.ui.closeModal('order-modal')">← Edit More</button>
            <button class="mbtn primary" id="order-submit-btn"
                    onclick="submitRevision()"
                    style="background:linear-gradient(135deg,#7C3AED,#6D28D9);">
              Submit Revision ✓
            </button>
          </div>
        </div>

        <div id="order-success-view" style="display:none;text-align:center;padding:24px 16px;">
          <div style="font-size:2.2rem;margin-bottom:10px;">🔄</div>
          <div style="font-size:1rem;font-weight:800;color:#1E1E2A;margin-bottom:6px;">Revision Submitted!</div>
          <div style="font-size:.82rem;color:#9896A8;margin-bottom:20px;line-height:1.5;">
            We'll review your revised design and send you an updated mockup. 🌷
          </div>
          <a href="{{ route('account.orders.show', $order->order_code) }}"
             class="mbtn primary" style="display:inline-block;text-decoration:none;width:100%;">
            Back to Order →
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="toast" id="toast"></div>

</div>{{-- /.builder --}}

<script>
  // ── Inject product config + elements ──────────────────────────────────────
  window.BUILDER_PRODUCT = {!! json_encode([
    'product'   => $productSlug,
    'basePrice' => $order->product->base_price ?? 80,
    'maxBeads'  => $order->product->max_beads  ?? 20,
  ]) !!};

  window.BUILDER_ELEMENTS = {!! json_encode($elements) !!};

  // ── Pre-load the existing design JSON ─────────────────────────────────────
  // The builder's main.js calls app.state.importDesign(json) if this is set.
  window.BUILDER_PRELOAD_DESIGN = {!! $existingJson !!};

  // ── Revision submit function ───────────────────────────────────────────────
  // Replaces the standard app.ui.submitOrder() for the revision flow
  async function submitRevision() {
    const btn = document.getElementById('order-submit-btn');
    btn.disabled = true;
    btn.textContent = 'Submitting…';

    // Get design state from the builder app
    const designJson = JSON.stringify(app.state.getElements());
    const note       = document.getElementById('revision-note')?.value?.trim() || '';
    const snapshot   = app.canvas.exportDataURL?.() ?? null;

    try {
      const formData = new FormData();
      formData.append('_token', document.querySelector('meta[name=csrf-token]').content);
      formData.append('design', designJson);
      formData.append('body',   note);
      if (snapshot) formData.append('snapshot', snapshot);

      const res = await fetch('{{ route('orders.revise', $order->order_code) }}', {
        method: 'POST',
        body:   formData,
      });

      if (res.ok || res.redirected) {
        // Show success view
        document.getElementById('order-form-view').style.display  = 'none';
        document.getElementById('order-success-view').style.display = '';
      } else {
        const err = document.getElementById('order-error');
        err.textContent = 'Something went wrong. Please try again.';
        err.style.display = '';
        btn.disabled = false;
        btn.textContent = 'Submit Revision ✓';
      }
    } catch (e) {
      console.error(e);
      btn.disabled = false;
      btn.textContent = 'Submit Revision ✓';
    }
  }
</script>

<script type="module" src="{{ asset('js/builder/main.js') }}"></script>

</body>
</html>