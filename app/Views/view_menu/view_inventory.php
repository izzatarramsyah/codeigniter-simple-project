<?= $this->extend('layout/dashboard'); ?> <?= $this->section('content'); ?> 
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">INVENTORY</h3>
      </div>
      <div class="card-body">
        <div class="row float-right mb-3">
          <div class="col-md-1">
            <div id="btn-excel-inventory"></div>
          </div>
          <!-- <div class="col-md-4"></div>
          <div class="col-md-1">
          <button type="button" id="btn-export-inventory" class="btn btn-danger">PDF</button>
          <form id="idFormInventory" target="_blank" action=" <?=site_url('exportInventory') ?>" method="post" hidden></form>
          </div> -->
        </div>
        <div class="col-12 table-responsive mt-2">
          <table id="tbl-inventory" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="2%">No</th>
                <th width="20%">Product Name</th>
                <th width="15%">Qty Buy</th>
                <th width="20%">Remaining Qty</th>
                <th width="25%">Transaction Date</th>
                <th width="25%">Updated Date</th>
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
<!-- /.row --> <?= $this->endSection(); ?>