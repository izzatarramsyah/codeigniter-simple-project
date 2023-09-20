<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Registration Page</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  </head>
  <body class="hold-transition register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href="../../index2.html">
          <b>Admin</b>LTE </a>
      </div>
      <div class="card">
        <div class="card-body register-card-body">
          <p class="login-box-msg">Register a new membership</p> 
          <?php if(session()->getFlashdata('status') == 'success'):?> 
            <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>
              <i class="icon fas fa-check"></i> <?= session()->getFlashdata('message') ?>
            </p> 
          </div> 
          <?php endif;?> 
          <?php if(session()->getFlashdata('status')  == 'failed'):?> 
            <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5>
              <i class="icon fas fa-ban"></i> <?= session()->getFlashdata('message') ?>
            </h5> 
          </div> 
          <?php endif;?> 
          <?php $validation = \Config\Services::validation(); ?> 
          <form action="<?= base_url('/doRegister'); ?>" method="post">
            <div class="form-group">
              <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
              </div> <?php if($validation->getError('email')) {?> <div class='alert alert-danger mt-2'> <?= $error = $validation->getError('email'); ?> </div> <?php }?>
            </div>
            <div class="form-group">
              <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div> <?php if($validation->getError('password')) {?> <div class='alert alert-danger mt-2'> <?= $error = $validation->getError('password'); ?> </div> <?php }?>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                  <label for="agreeTerms"> I agree to the <a href="#">terms</a>
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Register</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
          <p class="mt-4 text-center">
            <a href="<?= base_url('/login') ?>" class="text-center">I already have a membership</a>
          </p>
        </div>
        <!-- /.form-box -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.register-box -->
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
  </body>
</html>