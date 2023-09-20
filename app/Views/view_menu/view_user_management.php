<?= $this->extend('layout/dashboard'); ?> <?= $this->section('content'); ?> 
<div class="row">
  <div class="col-md-12">
    <div class="card card-default">
      <form id="form_add_stock" method="post" enctype="multipart/form-data" class="form-wizard">
        <div class="card-header">
          <h3 class="card-title">Add User</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" >
                  <label> Email </label>
                  <input type="text" id="inp-email" name="inp-email" class="form-control" placeholder="Email">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" >
                  <label> Password </label>
                  <input type="password" id="inp-password" name="inp-password" class="form-control" placeholder="Password">
                  <i class="fas fa-eye" id="togglePassword" style="position:absolute;top:50%;right:2%;"></i>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" >
                  <label> Role </label>
                  <select id="slc-role" class="form-control" style="width: 100%;">
                    <option value="" selected disabled>-- Choose Role --</option>
                    <option value="2">Admin</option>
                    <option value="3">Courier</option>
                  </select>
                </div>
              </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
          <button type="button" class="btn btn-primary float-right" onclick="addUser()">Submit</button>
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
        <h3 class="card-title">List User</h3>
      </div>
      <div class="card-body">
        <div class="row float-right mb-3">
          <div class="col-md-1">
            <div id="btn-excel-user"></div>
          </div>
        </div>
        <div class="col-md-12 table-responsive mt-2">
            <table id="tbl-list-user" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="10%">Username</th>
                  <th width="10%">Email</th>
                  <th width="10%">Join Date</th>
                  <th width="2%">Status</th>
                  <th width="13%">Action</th>
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
<div class="modal fade" id="modal-edit-user">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <b><h4> Edit User </h4></b>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Email</label>
                            <input type="text" class="form-control" id="inp-edit-email" value="">
                        </div>
                    </div>
                    <input type="text" id="idUser" name="idUser" value="" hidden>
                </form>
            </div>
            <div class="modal-footer justify-end">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateUser()">Update</button>
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?= $this->endSection(); ?>