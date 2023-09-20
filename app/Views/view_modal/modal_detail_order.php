<div class="modal fade" id="modal-detail-order">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <b><h4> Detail Order </h4></b>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                  <div class="row">
                      <div class="col-md-2 no-pad">
                        <label> <span class="label">ORDER ID</label>
                      </div>
                      <div class="col-md-1 no-pad"></div>
                      <div class="col-md-9 no-pad">
                        <div class="form-group sel">
                          <input class="form-control deft" id="detail-order-id" name="detail-order-id" type="text" disabled/>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2 no-pad">
                      <label> <span class="label">TRANSACTOIN DATE</label>
                    </div>
                    <div class="col-md-1 no-pad"></div>
                    <div class="col-md-9 no-pad">
                      <div class="form-group sel">
                        <input class="form-control deft" id="detail-order-dt" name="detail-order-dt" type="text" disabled/>
                      </div>
                    </div>
                  </div>
              </br>
              <div class="table-responsive">
                <table id="tbl-detail-order" class="table table-striped">
                  <thead>
                    <tr>
                      <th width="20%">Order ID</th>
                      <th width="20%">Quantity</th>
                      <th width="20%">Total Price</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <div class="modal-footer justify-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
