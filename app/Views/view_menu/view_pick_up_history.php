<?= $this->extend('layout/dashboard'); ?> <?= $this->section('content'); ?> 
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Pick Up History</h3>
      </div>
      <div class="card-body">
        <div class="row float-right mb-3">
          <div class="col-md-1">
            <div id="btn-excel-pickup-history"></div>
          </div>
        </div>
        <div class="col-md-12 table-responsive mt-2">
            <table id="tbl-pickup-history" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="10%">Order ID</th>
                  <th width="10%">Pick Up ID</th>
                  <th width="10%">Status</th>
                  <th width="10%">Transaction Date</th>
                  <th width="10%">Updated Date</th>
                  <th width="5%">Action</th>
                </tr>
              </thead>
            </table>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div> 
<div class="modal fade" id="modal-status-pickup">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
              <b><h4> Status </h4></b>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form>
                  <div class="row">
                      <div class="form-group col-md-12">
                        <label>Status</label>
                        <select id="slc-status-pickup" class="form-control" style="width: 100%;" onchange="orderStatusChanged()">
                          <option value="" selected disabled>-- Select Order Status --</option>
                          <option value="ON PROGRESS">Order Is On The Way</option>
                          <option value="ORDER FAILED">Order Could Not Be Processed</option>
                          <option value="ORDER FAILED">Order Returned to Suplier</option>
                          <option value="ORDER RECEIVED">Order Received by Customer</option>
                        </select>                        
                      </div>
                  </div>
                  <input type="text" id="idPickUp" name="idPickUp" value="" hidden>
                </form>
            </div>
            <div class="modal-footer justify-end">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updatePickupStatus()">Update</button>
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?= $this->endSection(); ?>