<?= $this->extend('layout/dashboard'); ?> <?= $this->section('content'); ?> 
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">List Pick Up</h3>
      </div>
      <div class="card-body">
        <div class="row float-right mb-3">
          <div class="col-md-1">
            <div id="btn-excel-list-pickup-product"></div>
          </div>
        </div>
        <div class="col-md-12 table-responsive mt-2">
            <table id="tbl-list-pickup-product" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="20%">Order ID</th>
                  <th width="15%">Date</th>
                  <th width="15%">Action</th>
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
<div class="modal fade" id="modal-detail-order">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
              <b><h4> Detail Order </h4></b>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="table-responsive">
                <table id="tbl-detail-order" class="table table-striped">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th width="20%">Product Code</th>
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
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?= $this->endSection(); ?>