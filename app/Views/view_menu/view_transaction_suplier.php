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
              <label>Transaction Type</label>
                <select id="slc-trx-type" class="form-control select2" style="width: 100%;">
                    <option value="stockOut" selected>Stock Out</option>
                    <option value="stockIn">Stock In</option>
                </select>
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
        <button type="button" id="btn-search-transaction" class="btn btn-primary float-right" onclick="getInfoTransactionSuplier()">Search</button>
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
              <div id="btn-excel-transaction-suplier"></div>
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
            <table id="tbl-transaction-suplier" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="20%">Order ID</th>
                    <th width="15%">Pick Up ID</th>
                    <th width="20%">Transaction Date</th>
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
<?= $this->endSection(); ?>