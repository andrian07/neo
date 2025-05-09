<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Back Office</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/adminlte.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/style.css">

  
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/fancy.css" />

  <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.css">


</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed  sidebar-collapse">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="<?php echo base_url(); ?>dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?php echo base_url();?>" class="brand-link">
        <img src="<?php echo base_url(); ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Homeliving</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <li class="nav-item">
            <a href="<?php echo base_url();?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url();?>Search" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Cari Produk
              </p>
            </a>
          </li>


          <?php if($_SESSION['role_access_header'][0]->user_module_header_acc == 'Y'){ ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-database"></i>
                <p>
                  Master Data
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php if($_SESSION['role_access'][0]->nav_bar == 'Y'){ ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url(); ?>Masterdata/brand" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Brand</p>
                    </a>
                  </li>
                <?php } ?>
                <?php if($_SESSION['role_access'][1]->nav_bar == 'Y'){ ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url(); ?>Masterdata/customer" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Customer</p>
                    </a>
                  </li>
                <?php } ?>
                <?php if($_SESSION['role_access'][2]->nav_bar == 'Y'){ ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url(); ?>Masterdata/category" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Kategori</p>
                    </a>
                  </li>
                <?php } ?>
                <?php if($_SESSION['role_access'][3]->nav_bar == 'Y'){ ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url(); ?>Masterdata/product" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Produk</p>
                    </a>
                  </li>
                <?php } ?>
                <?php if($_SESSION['role_access'][4]->nav_bar == 'Y'){ ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url(); ?>Masterdata/productpacket" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Produk Paket</p>
                    </a>
                  </li>
                <?php } ?>
                <?php if($_SESSION['role_access'][5]->nav_bar == 'Y'){ ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url(); ?>Masterdata/unit" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Satuan</p>
                    </a>
                  </li>
                <?php } ?>
                <?php if($_SESSION['role_access'][6]->nav_bar == 'Y'){ ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url(); ?>Masterdata/sales" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Sales</p>
                    </a>
                  </li>
                <?php } ?>
                <?php if($_SESSION['role_access'][7]->nav_bar == 'Y'){ ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url(); ?>Masterdata/supplier" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Supplier</p>
                    </a>
                  </li>
                <?php } ?>
                <?php if($_SESSION['role_access'][8]->nav_bar == 'Y'){ ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url(); ?>Masterdata/user" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>User</p>
                    </a>
                  </li>
                <?php } ?>
                <?php if($_SESSION['role_access'][9]->nav_bar == 'Y'){ ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url(); ?>Masterdata/user_role" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Role</p>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </li>
          <?php } ?>

          <?php if($_SESSION['role_access_header'][1]->user_module_header_acc == 'Y'){ ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>
                  Pembelian
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php if($_SESSION['role_access'][10]->nav_bar == 'Y'){ ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url(); ?>Purchase/po" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>PO</p>
                    </a>
                  </li>
                <?php } ?>
                <?php if($_SESSION['role_access'][11]->nav_bar == 'Y'){ ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url(); ?>Purchase/purchase" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pembelian</p>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </li> 
          <?php } ?>

          <?php if($_SESSION['role_access_header'][2]->user_module_header_acc == 'Y'){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>Sales" class="nav-link">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>
                  Penjualan
                </p>
              </a>
            </li> 
          <?php } ?>

          <?php if($_SESSION['role_access_header'][3]->user_module_header_acc == 'Y'){ ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-exchange-alt"></i>
                <p>
                  Retur
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php if($_SESSION['role_access'][13]->nav_bar == 'Y'){ ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url(); ?>Retur/retursales" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Retur Penjualan</p>
                    </a>
                  </li>
                <?php } ?>
                <?php if($_SESSION['role_access'][14]->nav_bar == 'Y'){ ?>
                  <li class="nav-item">
                    <a href="<?php echo base_url(); ?>Retur/returpurchase" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Retur Pembelian</p>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </li> 
          <?php } ?>

          <?php if($_SESSION['role_access_header'][4]->user_module_header_acc == 'Y'){ ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-money-bill"></i>
                <p>
                  Pelunasan
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
               <?php if($_SESSION['role_access'][15]->nav_bar == 'Y'){ ?>
                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>Payment/receivables" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pelunasan Piutang</p>
                  </a>
                </li>
              <?php } ?>
              <?php if($_SESSION['role_access'][16]->nav_bar == 'Y'){ ?>
                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>Payment/debt" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pelunas Hutang</p>
                  </a>
                </li>
              <?php } ?>
            </ul>
          </li> 
        <?php } ?>

        <?php if($_SESSION['role_access_header'][5]->user_module_header_acc == 'Y'){ ?>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>Opname/opname_list" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Stock Opname
              </p>
            </a>
          </li> 
        <?php } ?>

        <?php if($_SESSION['role_access_header'][6]->user_module_header_acc == 'Y'){ ?>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>Report" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Laporan
              </p>
            </a>
          </li> 
        <?php } ?>

        <li class="nav-item">
          <a href="<?php echo base_url(); ?>Auth/changepass" class="nav-link">
            <i class="nav-icon fas fa-key"></i>
            <p>
              Ganti Password
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo base_url(); ?>Auth/processlogout" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Logout
            </p>
          </a>
        </li>  

        

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>