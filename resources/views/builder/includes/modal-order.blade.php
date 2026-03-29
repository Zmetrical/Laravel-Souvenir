<div class="modal fade" id="order-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 16px; border: 4px solid var(--pink);">
      <div class="modal-header border-0 bg-pink-light">
        <h5 class="modal-title font-weight-bold mtitle m-0 text-pink">( Place Your Order )</h5>
        <button type="button" class="close text-pink" data-dismiss="modal" onclick="app.ui.closeModal('order-modal')">&times;</button>
      </div>
      <div class="modal-body">
        <div id="order-form-view">
          <div class="row">
            <div class="col-6 mb-3">
              <label class="text-sm font-weight-bold text-muted">First Name <span class="text-danger">*</span></label>
              <input class="form-control rounded font-weight-bold" id="order-first-name" placeholder="Maria">
            </div>
            <div class="col-6 mb-3">
              <label class="text-sm font-weight-bold text-muted">Last Name <span class="text-danger">*</span></label>
              <input class="form-control rounded font-weight-bold" id="order-last-name" placeholder="Santos">
            </div>
          </div>
          <div class="mbtns mt-4 d-flex justify-content-between">
            <button class="btn btn-ghost w-50 mr-2" onclick="app.ui.closeModal('order-modal')">← Back</button>
            <button class="btn btn-pink w-50" id="order-submit-btn" onclick="app.ui.submitOrder()">Submit Order ✓</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>