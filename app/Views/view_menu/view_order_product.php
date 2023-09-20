<?= $this->extend('layout/dashboard'); ?>
<?= $this->section('content'); ?> 
<div class="row">
  <div class="col-12">
    <div class="card card-solid">
      <div class="card-body pb-0">
        <div class="row view-product">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Invoice -->
<div class="modal fade" id="modal-invoice-order">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Invoice</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="invoice p-3 mb-3">
          <!-- title row -->
          <div class="row">
            <div class="col-12">
              <h4>
                <i class="fas fa-globe"></i> AdminLTE, Inc. <small class="float-right">Date: <?php setlocale(LC_TIME, 'Indonesian'); $dateS = strftime( "%d %B %Y", time()); echo $dateS;  ?> </small>
              </h4>
            </div>
          </div>
          <!-- Table row -->
          <div class="row mt-4">
            <div class="col-12 table-responsive">
              <table id="tbl-invoice-order" class="table table-striped">
                <thead>
                  <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          </br>
          <div class="row">
            <div class="col-6">
            </div>
            <!-- /.col -->
            <div class="col-6">
              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th>Total:</th>
                    <td id="total-payment"></td>
                  </tr>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-12">
              <button type="button" class="btn btn-success float-right" onclick="orderProduct()">
                <i class="far fa-credit-card"></i> Submit Payment </button>
              <a href="invoice-print.html" target="_blank" class="btn btn-primary float-right" style="margin-right: 5px;" id="btn-print-payment">
                <i class="fas fa-print"></i> Print Invoice </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?= $this->endSection(); ?>