<?= $this->extend('layout/dashboard'); ?> <?= $this->section('content'); ?> 
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">FORM SEARCH</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Transaction ID</label>
              <div class="form-group">
                <div class="input-group" data-target-input="nearest">
                  <input type="text" id="inp-transaction-id" class="form-control" placeholder="Input Transaction ID" />
                </div>
              </div>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Start Date</label>
              <div class="form-group">
                <div class="input-group date" id="startdate" data-target-input="nearest">
                  <input type="text" id="inp-start-date" class="form-control datetimepicker-input" data-target="#startdate" />
                  <div class="input-group-append" data-target="#startdate" data-toggle="datetimepicker">
                    <div class="input-group-text">
                      <i class="fa fa-calendar"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="form-group">
              <label>End Date</label>
              <div class="form-group">
                <div class="input-group date" id="enddate" data-target-input="nearest">
                  <input type="text" id="inp-end-date" class="form-control datetimepicker-input" data-target="#enddate" />
                  <div class="input-group-append" data-target="#enddate" data-toggle="datetimepicker">
                    <div class="input-group-text">
                      <i class="fa fa-calendar"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.card-body -->
      <div class="card-footer clearfix">
        <button type="button" id="btn-search-transaction" class="btn btn-primary float-right" onclick="getInfoTransactionCustomer()">Search</button>
      </div>
      <!-- /.card-footer -->
    </div>
    <!-- /.card -->
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">TRANSACTION HISTORY</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
          <div class="row float-right mb-3">
            <div class="col-md-1">
              <div id="btn-excel-transaction"></div>
            </div>
            <!-- <div class="col-md-4"></div>
            <div class="col-md-1">
              <button type="button" id="btn-pdf-transaction" class="btn btn-danger ">PDF</button>
              <form id="idFormTransaction" target="_blank" action=" <?=site_url('exportTransaction') ?>" method="post" hidden>
                <input id="temp-transaction-type" type="hidden" name="temp-transaction-type">
                <input id="temp-start-date" type="hidden" name="temp-start-date">
                <input id="temp-end-date" type="hidden" name="temp-end-date">
              </form>
            </div> -->
          </div>
          <div class="col-md-12 table-responsive ">
            <table id="tbl-transaction" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th width="15%">Order ID</th>
                    <th width="15%">Status</th>
                    <th width="15%">Transaction Date</th>
                    <th width="20%">Action</th>
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

<div class="modal fade" id="modal-status-shipping">
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
                        <div class="form-group col-md-4">
                            <label>OrderID</label>
                            <input type="text" class="form-control" id="inp-orderId-shipping" value="" disabled>                      
                        </div>
                        <div class="form-group col-md-8">
                            <label>Status</label>
                            <select id="slc-status-shipping" class="form-control" style="width: 100%;">
                                <option value="" selected disabled>-- Select Shipping Status --</option>
                                <option value="Order Received. Waiting For Shipping">Order Received. Waiting For Shipping</option>
                                <option value="Order Is On The Way">Order Is On The Way</option>
                                <option value="Order Could Not Be Processed">Order Could Not Be Processed</option>
                            </select>                        
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-end">
                <button type="button" id="btn-update-status-shipping" class="btn btn-primary" data-dismiss="modal" >Update</button>
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?= $this->endSection(); ?>