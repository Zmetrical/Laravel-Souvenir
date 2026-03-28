<?php
$productLabel = $productLabel ?? 'Custom Order';
?>
<div class="overlay" id="order-modal">
  <div class="mbox">
    <div class="mhead pink">
      <div class="mtitle">( Place Your Order )</div>
      <button class="mclose" onclick="app.ui.closeModal('order-modal')">×</button>
    </div>
    <div class="mbody">

      {{-- ── FORM VIEW ──────────────────────────────────────────────── --}}
      <div class="form-col" id="order-form-view">
        <div class="frow2">
          <div class="frow">
            <label class="flbl">First Name <span style="color:#FF5FA0;">*</span></label>
            <input class="finput" id="order-first-name" placeholder="Maria" autocomplete="given-name"/>
          </div>
          <div class="frow">
            <label class="flbl">Last Name <span style="color:#FF5FA0;">*</span></label>
            <input class="finput" id="order-last-name" placeholder="Santos" autocomplete="family-name"/>
          </div>
        </div>
        <div class="frow">
          <label class="flbl">Contact No. <span style="color:#FF5FA0;">*</span></label>
          <input class="finput" id="order-contact" placeholder="09xx-xxx-xxxx" type="tel" autocomplete="tel"/>
        </div>
        <div class="frow">
          <label class="flbl">Special Notes</label>
          <input class="finput" id="order-notes" placeholder="Any message for the shop…"/>
        </div>

        {{-- Error message --}}
        <div id="order-error"
             style="display:none;background:#FFF1F2;border:1px solid #FDA4AF;
                    color:#9F1239;border-radius:8px;padding:8px 12px;
                    font-size:.78rem;font-weight:500;"></div>

        <div class="osum">
          <div class="osum-t">Order Summary</div>
          <div class="osum-row">
            <span id="os-prod">{{ $productLabel }}</span>
            <span id="os-base">₱0</span>
          </div>
          <div class="osum-row">
            <span id="os-elems">0 elements</span>
            <span id="os-ecost">₱0</span>
          </div>
          <div class="osum-total">
            <span>Total Estimate</span>
            <span id="os-total" style="color:var(--pink-dk);">₱0.00</span>
          </div>
        </div>

        <div id="order-design-thumb" style="display:none;margin-top:8px;">
          <div class="slbl">Design Reference</div>
          <canvas id="order-canvas" width="300" height="140"
                  style="width:100%;border-radius:10px;
                         background:var(--grey-50);
                         border:1.5px solid var(--grey-200);"></canvas>
        </div>

        <div class="mbtns" style="margin-top:10px;">
          <button class="mbtn secondary" onclick="app.ui.closeModal('order-modal')">← Back</button>
          <button class="mbtn primary" id="order-submit-btn" onclick="app.ui.submitOrder()">
            Submit Order ✓
          </button>
        </div>
      </div>

      {{-- ── SUCCESS VIEW ────────────────────────────────────────────── --}}
      <div id="order-success-view"
           style="display:none;text-align:center;padding:24px 16px;">
        <div style="font-size:2.2rem;margin-bottom:10px;">🌸</div>
        <div style="font-size:1rem;font-weight:800;color:#1E1E2A;margin-bottom:6px;">
          Order Placed!
        </div>
        <div style="font-size:.82rem;color:#9896A8;margin-bottom:16px;">
          Your order code is
        </div>
        <div id="success-order-code"
             style="font-family:monospace;font-size:1.1rem;font-weight:900;
                    background:#FFF0F6;color:#C0136A;
                    border:2px dashed #F9B8CF;border-radius:10px;
                    padding:10px 20px;display:inline-block;
                    margin-bottom:16px;letter-spacing:.05em;">
          —
        </div>
        <div style="font-size:.78rem;color:#9896A8;margin-bottom:20px;line-height:1.5;">
          We'll contact you at your number to confirm. <br/>
          You can also show this code at the store.
        </div>
        <button class="mbtn primary"
                onclick="app.ui.closeModal('order-modal'); app.ui._resetOrderModal();"
                style="width:100%;">
          Done ✓
        </button>
      </div>

    </div>
  </div>
</div>