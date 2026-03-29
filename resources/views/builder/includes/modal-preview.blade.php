<div class="modal fade" id="prev-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 16px;">
      <div class="modal-header bg-teal-light border-0">
        <h5 class="modal-title font-weight-bold mtitle m-0 text-teal">( Design Preview )</h5>
        <button type="button" class="close text-teal" data-dismiss="modal" aria-label="Close" onclick="app.ui.closeModal('prev-modal')">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center bg-light">
        <canvas id="preview-canvas" width="460" height="320" class="img-fluid bg-white rounded shadow-sm border"></canvas>
        <div class="minfo mt-3 text-left" id="prev-info"></div>
      </div>
      <div class="modal-footer border-0 bg-light justify-content-center">
        <button type="button" class="btn btn-pink" onclick="app.ui.downloadDesign()">Download PNG</button>
      </div>
    </div>
  </div>
</div>