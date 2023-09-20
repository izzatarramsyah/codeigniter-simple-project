<?= $this->extend('layout/dashboard'); ?> <?= $this->section('content'); ?> 
<div class="row">
  <div class="col-md-12">
    <?php if(session()->getFlashdata('message')):?>
    <div class="alert alert-<?= session()->getFlashdata('flag') ?> alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h5>
        <i class="icon fas fa-check"></i> <?= session()->getFlashdata('status') ?>
      </h5> <?= session()->getFlashdata('message') ?>
    </div>
    <?php endif;?>
    <div class="card card-default">
      <form id="form_add_stock" method="post" enctype="multipart/form-data" class="form-wizard">
        <div class="card-header">
          <h3 class="card-title">Add Product</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> Input Type </label>
                <select id="slc-add-stock" name="slc-add-stock" class="form-control" style="width: 100%;">
                  <option value='' selected disabled> -- Please Select -- </option>  
                  <option value='single'> Single Input </option>
                  <option value='multiple'> Multiple Input </option>
                </select>
              </div>
            </div>
          </div>
          <div class="single-input" hidden>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label> Product Code </label>
                  <input type="text" id="inp-product-code" name="inp-product-code" class="form-control single" placeholder="Product Code"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label> Product Name </label>
                  <input type="text" id="inp-product-name" name="inp-product-name" class="form-control single" placeholder="Product Name"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" >
                  <label> Product Price </label>
                  <input type="text" id="inp-product-price" name="inp-product-price" class="form-control single inp-number" onkeyup="inputPrice()" placeholder="Product Price"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label> Quantity </label>
                  <input type="text" id="inp-product-qty" name="inp-product-qty" class="form-control single inp-number" placeholder="Quantity"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label> Product Description </label>
                  <input type="text" id="inp-product-desc" name="inp-product-desc" class="form-control single" placeholder="Product Description"/>
                </div>
              </div>
            </div>
          </div>
          <div class="bulk-input" hidden>
            <div class="col-md-12">
              <div class="form-group">
                <label> Multiple Input </label>
                <div class="input-group input-group-md">
                  <input type="file" id="file-add-stock" name="file-add-stock" class="form-control multiple" >
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <a href="${pageContext.request.contextPath}/assets/other/template_kontak.xlsx" class="btn btn-primary multiple" download>Download Template</a>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
          <button type="button" class="btn btn-primary float-right" onclick="addProduct()">Submit</button>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">List Product</h3>
      </div>
      <div class="card-body">
        <div class="row float-right mb-3">
          <div class="col-md-1">
            <div id="btn-excel-product"></div>
          </div>
          <!-- <div class="col-md-4"></div>
          <div class="col-md-1">
            <button type="button" id="btn-export-product" class="btn btn-danger">PDF</button>
            <form id="idFormProduct" target="_blank" action=" <?=site_url('exportProduct') ?>" method="post" hidden></form>
          </div> -->
        </div>
        <div class="col-md-12 table-responsive mt-2">
            <table id="tbl-list-product" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="20%">Product Code</th>
                  <th width="20%">Product Name</th>
                  <th width="20%">Description</th>
                  <th width="10%">Price</th>
                  <th width="10%">Quantity</th>
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

<div class="modal fade" id="modal-edit-product">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
              <b><h4> Edit Product </h4></b>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label>Product Code</label>
                          <input type="text" class="form-control" id="inp-edit-product-code" value="" disabled>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label>Product Name</label>
                        <input type="text" class="form-control" id="inp-edit-product-name" value=""/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label>Product Price</label>
                        <input type="text" class="form-control inp-number" id="inp-edit-product-price" onkeyup="inputPrice1()" value=""/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label>Quantity</label>
                        <input type="text" class="form-control inp-number" id="inp-edit-product-qty" value=""/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label>Description</label>
                        <input type="text" class="form-control" id="inp-edit-product-desc" value=""/>
                      </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-end">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateProduct()">Update</button>
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?= $this->endSection(); ?>