<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Revise Design — {{ $order->order_code }} — ArtsyCrate</title>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    /* ── Revision notice bar above the builder ── */
    .revision-bar {
      position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
      background: var(--purple); color: #fff; padding: 12px 24px;
      display: flex; align-items: center; justify-content: space-between; gap: 16px;
      font-family: var(--fb); font-size: 0.9rem; font-weight: 800; box-shadow: 0 4px 12px rgba(123, 95, 212, 0.2);
    }
    .revision-bar .rbar-l { display: flex; align-items: center; gap: 12px; }
    .revision-bar .rbar-badge { background: #fff; color: var(--purple); border-radius: 8px; padding: 6px 12px; font-size: 0.8rem; font-weight: 900; letter-spacing: 0.05em; text-transform: uppercase; }
    .revision-bar .rbar-code { font-family: var(--fh); background: rgba(255,255,255,0.2); border-radius: 8px; padding: 4px 12px; font-size: 1.1rem; letter-spacing: 1px;}
    .revision-bar .rbar-cancel {
      background: transparent; border: 1.5px solid rgba(255,255,255,0.4); color: #fff; border-radius: 10px;
      padding: 8px 16px; font-weight: 800; font-size: 0.85rem; cursor: pointer; text-decoration: none; transition: all 0.2s;
    }
    .revision-bar .rbar-cancel:hover { background: rgba(255,255,255,0.2); color: #fff; }

    /* Push builder content down by the bar height */
    body { padding-top: 56px !important; }
    .builder-workspace { height: calc(100vh - 56px) !important; }

    /* Modal styling */
    .overlay { display: none; position: fixed; inset: 0; background: rgba(30,30,46,0.6); z-index: 2000; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
    .overlay.open { display: flex; }
    .mbox { background: var(--white); border-radius: 20px; max-width: 460px; width: 90%; text-align: left; box-shadow: 0 12px 32px rgba(0,0,0,0.1); border: 1.5px solid var(--grey-200); overflow: hidden; }
    
    .mhead { padding: 20px 24px; border-bottom: 1.5px solid var(--grey-200); display: flex; justify-content: space-between; align-items: center; background: #fff; }
    .mtitle { font-family: var(--fh); font-size: 1.4rem; color: var(--ink); }
    .mclose { background: var(--offwhite); border: 1.5px solid var(--grey-200); border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; cursor: pointer; color: var(--ink-md); transition: all 0.2s; }
    .mclose:hover { background: var(--pink-bg); border-color: var(--pink); color: var(--pink-dk); }
    
    .mbody { padding: 24px; background: var(--offwhite); }
    .rev-submit-note { background: var(--purple-bg); border: 1.5px solid var(--purple); border-radius: 12px; padding: 16px; margin-bottom: 20px; }
    .rev-submit-note .rsn-title { font-size: 0.9rem; font-weight: 800; color: var(--purple-dk); margin-bottom: 6px; }
    .rev-submit-note .rsn-body { font-size: 0.8rem; font-weight: 700; color: var(--purple); line-height: 1.5; }

    .flbl { display: block; font-size: 0.75rem; font-weight: 800; color: var(--ink-md); margin-bottom: 8px; text-transform: uppercase; }
    .finput { width: 100%; padding: 12px 16px; border: 1.5px solid var(--grey-200); border-radius: 10px; font-family: var(--fb); font-size: 0.9rem; font-weight: 700; color: var(--ink); background: var(--white); transition: all 0.2s; margin-bottom: 20px; }
    .finput:focus { outline: none; border-color: var(--purple); box-shadow: 0 0 0 4px var(--purple-bg); }

    .mbtns { display: flex; gap: 12px; }
    .mbtn { flex: 1; padding: 14px; border-radius: 12px; font-family: var(--fh); font-size: 1.1rem; cursor: pointer; transition: all 0.2s; border: none; text-align: center; }
    .mbtn.secondary { background: var(--white); border: 1.5px solid var(--grey-200); color: var(--ink-md); font-family: var(--fb); font-weight: 800; font-size: 0.95rem; }
    .mbtn.secondary:hover { background: var(--grey-50); color: var(--ink); }
    .mbtn.primary { background: var(--purple); color: var(--white); box-shadow: 0 4px 12px rgba(123, 95, 212, 0.3); }
    .mbtn.primary:hover { background: var(--purple-dk); transform: translateY(-2px); }
  </style>
</head>
<body>

{{-- ── Revision notice bar ── --}}
<div class="revision-bar">
  <div class="rbar-l">
    <span class="rbar-badge">✏️ Revising Design</span>
    <span>Order</span>
    <span class="rbar-code">{{ $order->order_code }}</span>
    <span style="opacity:0.8; font-weight:700;">for {{ $order->first_name }}</span>
  </div>
  <a href="{{ route('account.orders.show', $order->order_code) }}" class="rbar-cancel">← Cancel Revision</a>
</div>

{{-- ── 3-Zone Builder Layout ── --}}
<div class="builder-workspace d-flex flex-row flex-nowrap w-100">

  @php
    $productSlug = $order->product->slug ?? 'bracelet';
  @endphp

  <div class="d-flex justify-content-start" style="flex: 1; max-width: 540px; min-width: 240px;">
    <div class="builder-pane border-right shadow-sm" id="setup-panel" style="width: 240px; flex-shrink: 0; z-index: 10;">
      <div class="phead teal"><i data-lucide="settings" class="mr-2" style="width: 18px;"></i> Setup</div>
      <div class="p-3 text-center text-muted font-weight-bold" style="font-size: 0.85rem; margin-top: 40px;">
        <i data-lucide="info" class="text-teal mb-3" style="width: 32px; height: 32px; opacity: 0.5;"></i><br>
        String options are locked during a revision. Please use the canvas to update your layout!
      </div>
    </div>
  </div>

  @include('builder.includes.canvas')

  <div class="d-flex shadow-sm" style="flex: 1; max-width: 540px; min-width: 540px; z-index: 10;">
    @include('builder.includes.design-panel')
    @include('builder.includes.library-panel')
  </div>

</div>

{{-- ── Revision Modal ── --}}
<div class="overlay" id="order-modal">
  <div class="mbox">
    <div class="mhead">
      <div class="mtitle">Submit Revision</div>
      <button class="mclose" onclick="app.ui.closeModal('order-modal')">×</button>
    </div>
    <div class="mbody">
      <div id="order-form-view">

        <div class="rev-submit-note">
          <div class="rsn-title">✏️ You're submitting a revision</div>
          <div class="rsn-body">Your updated design will be sent to ArtsyCrate for review. We'll send you a new mockup once it's ready!</div>
        </div>

        <div>
          <label class="flbl">Anything to note about your changes?</label>
          <input class="finput" id="revision-note" placeholder="e.g. Swapped the blue bead for pink..."/>
        </div>

        <div id="order-error" style="display:none; background: var(--pink-bg); border: 1.5px solid var(--pink); color: var(--pink-dk); border-radius: 10px; padding: 12px; font-size: 0.85rem; font-weight: 800; margin-bottom: 20px;"></div>

        <div class="mbtns">
          <button class="mbtn secondary" onclick="app.ui.closeModal('order-modal')">Cancel</button>
          <button class="mbtn primary" id="order-submit-btn" onclick="submitRevision()">Submit Revision <i data-lucide="check" style="width: 18px; margin-left: 6px;"></i></button>
        </div>
      </div>

      <div id="order-success-view" style="display:none; text-align:center; padding: 24px 16px;">
        <div style="font-size: 3.5rem; margin-bottom: 16px; color: var(--lime);">🔄</div>
        <div style="font-family: var(--fh); font-size: 1.8rem; color: var(--ink); margin-bottom: 8px;">Revision Submitted!</div>
        <div style="font-size: 0.95rem; font-weight: 700; color: var(--ink-md); margin-bottom: 32px; line-height: 1.5;">
          We'll review your revised design and send you an updated mockup. 🌷
        </div>
        <a href="{{ route('account.orders.show', $order->order_code) }}" class="mbtn primary" style="display:block; text-decoration:none; width:100%;">
          Back to Order Tracker
        </a>
      </div>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => lucide.createIcons());

  window.BUILDER_PRODUCT = {!! json_encode([
    'product'   => $productSlug,
    'basePrice' => $order->product->base_price ?? 80,
    'maxBeads'  => $order->product->max_beads  ?? 20,
  ]) !!};

  window.BUILDER_ELEMENTS = {!! json_encode($elements ?? []) !!};
  window.BUILDER_PRELOAD_DESIGN = {!! $existingJson !!};

  async function submitRevision() {
    const btn = document.getElementById('order-submit-btn');
    btn.disabled = true;
    btn.innerHTML = 'Submitting... <i data-lucide="loader" class="fa-spin" style="width: 18px; margin-left: 6px;"></i>';
    lucide.createIcons();

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
        method: 'POST', body: formData,
      });

      if (res.ok || res.redirected) {
        document.getElementById('order-form-view').style.display  = 'none';
        document.getElementById('order-success-view').style.display = 'block';
      } else {
        const err = document.getElementById('order-error');
        err.textContent = 'Something went wrong. Please try again.';
        err.style.display = 'block';
        btn.disabled = false;
        btn.innerHTML = 'Submit Revision <i data-lucide="check" style="width: 18px; margin-left: 6px;"></i>';
        lucide.createIcons();
      }
    } catch (e) {
      console.error(e);
      btn.disabled = false;
      btn.innerHTML = 'Submit Revision <i data-lucide="check" style="width: 18px; margin-left: 6px;"></i>';
      lucide.createIcons();
    }
  }
</script>

<script type="module" src="{{ asset('js/builder/main.js') }}"></script>

</body>
</html>