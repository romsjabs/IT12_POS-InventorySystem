<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="transactionModalLabel">Transaction Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="transaction-details-loading" class="text-center py-3" style="display:none;">
            <div class="spinner-border" role="status"></div>
            <div>Loading...</div>
        </div>
        <div id="transaction-details-content"></div>
      </div>
    </div>
  </div>
</div>