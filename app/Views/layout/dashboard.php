<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin LTE</title>
    <base href="/">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../../../plugins/jqvmap/jqvmap.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../../plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../../plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../../plugins/summernote/summernote-bs4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../../plugins/toastr/toastr.min.css">
        <!-- Toastr -->
        <!-- <script src="../../../css/slider.css"> -->
        <link rel="stylesheet" href="../../../css/slider.css">
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
     
      <!-- Preloader -->
      <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
      </div>

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
              <i class="fas fa-bars"></i>
            </a>
          </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto"> <?php if ( $dataUser == null ): ?> 
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/login') ?>">
              <i class="fas fa-sign-in-alt"></i>
            </a>
          </li> <?php endif ?> <?php if ( $dataUser != null ): ?>
          <!-- Account Dropdown Menu -->
          <?php if ( $dataUser[0]['role'] == 'customer' ): ?>
            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-heart"></i>
                <span class="badge badge-danger navbar-badge badge-cart"></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-center" style="max-height:200px; overflow-y: auto;">
                <div class="view-cart" ></div>
                <li><div class="dropdown-divider"></div></li>
                <li><a id="btn-view-cart" type="button" class="dropdown-item dropdown-footer view-all-cart" onclick="viewAllCart()">See All Cart</a></li>
              </ul>
            </li>
          <?php endif ?>
          <li class="nav-item dropdown">
            <a class="nav-link" href="<?= base_url('/logout') ?>"> <i class="fas fa-sign-out-alt"></i></a>
            <!-- <a class="nav-link" data-toggle="dropdown" href="<?= base_url('/logout') ?>">
              <i class="fas fa-sign-out-alt"></i>
            </a> -->
          </li> <?php endif ?>
        </ul>
      </nav>
      <!-- /.navbar -->
      
      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
          <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>
        
        <!-- Sidebar -->
        <div class="sidebar">

          <!-- Sidebar user (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="<?= base_url('/profile') ?>" class="d-block"><?php print_r($dataUser[0]['username']) ?></a>
              <input id="username" value="<?php echo $dataUser[0]['username'] ?>" hidden>
            </div>
          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
              <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-sidebar">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library --> 
              <?php for ($i = 0; $i < count($profileMenu); $i++) { ?>
                <li class="nav-item">
                  <a href="<?= base_url($profileMenu[$i]['url']) ?>" class="nav-link  
                    <?= $pageTitle == $profileMenu[$i]['menu'] ? 'active' : ''; ?>">
                    <!-- <i class="nav-icon fas fa-tshirt"></i> -->
                    <p> <?php echo $profileMenu[$i]['menu'] ?> </p>
                  </a>
                </li> 
              <?php } ?>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
      
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0"> <?= (isset($pageTitle)) ? $pageTitle : ''; ?> </h1>
              </div>
              <!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item">
                    <a href="#">Home</a>
                  </li>
                  <li class="breadcrumb-item active"> <?= (isset($pageTitle)) ? $pageTitle : ''; ?> </li>
                </ol>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid"> <?php if ( $dataUser != null && $dataUser[0]['role'] == 'suplier' ): ?>
            <!-- Info boxes -->
            <div class="row">
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-info elevation-1">
                    <i class="fas fa-dollar-sign"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Income</span>
                    <span class="info-box-number">Rp. <?php echo $dashboard[0]['income'] ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              
              <!-- /.col -->
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-danger elevation-1">
                    <i class="fas fa-users"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Customer</span>
                    <span class="info-box-number"><?php echo $dashboard[0]['customer'] ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->

              <!-- fix for small devices only -->
              <div class="clearfix hidden-md-up"></div>

              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-success elevation-1">
                    <i class="fas fa-shopping-cart "></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Stock Out</span>
                    <span class="info-box-number"><?php echo $dashboard[0]['stockOut'] ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>

              <!-- /.col -->
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-warning elevation-1">
                    <i class="fas fa-shopping-cart"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Stock In</span>
                    <span class="info-box-number"><?php echo $dashboard[0]['stockIn'] ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->

            </div> <?php endif ?>
          </div>
          <!-- /.container-fluid --> <?= $this->renderSection('content') ?>
        </section>
        <!-- /.content -->
      </div>

      <!-- Modal --> 
      <?= $this->include('view_modal/alert') ?> 
      <?= $this->include('view_modal/loading') ?>

    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="../../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../dist/js/adminlte.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../../plugins/jszip/jszip.min.js"></script>
    <script src="../../../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- ChartJS -->
    <script src="../../../plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="../../../plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="../../../plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="../../../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../../../plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="../../../plugins/moment/moment.min.js"></script>
    <script src="../../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="../../../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="../../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../dist/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../../../dist/js/pages/dashboard.js"></script>
    <!-- SweetAlert2 -->
    <script src="../../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../../../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../dist/js/adminlte.min.js"></script>
    <!-- JS Function -->
    <script src="../../../js/function.js"></script>
    <script src="../../../js/js_menu/<?php echo $menu ?>.js">
    </script>
  </body>
</html>