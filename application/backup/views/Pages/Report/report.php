<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Laporan</h1>
        </div>
        <div class="col-sm-6">

        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->

    <div class="row">
      <div class="col-md-4">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Master Data</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <ul class="list-group">
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Report/brand" class="text-primary">Daftar Brand</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Report/customer" class="text-primary">Daftar Customer</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Report/category" class="text-primary">Daftar Kategori</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Report/product" class="text-primary">Daftar Produk</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Report/product_under_stock" class="text-primary">Daftar Produk Di Bawah Stock</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Report/unit" class="text-primary">Daftar Satuan</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Report/sales" class="text-primary">Daftar Sales</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Report/supplier" class="text-primary">Daftar Supplier</a></li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>

      <?php if($_SESSION['user_role'] == 1){ ?>
      <div class="col-md-4">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Laporan Pembelian</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <ul class="list-group">

              <li class="list-group-item"><a href="<?php echo base_url(); ?>Reportpurchase/po_view" class="text-primary">Laporan PO</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Reportpurchase/purchase_view" class="text-primary">Laporan Pembelian</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Reportpurchase/retur_purchase_view" class="text-primary">Laporan Retur Pembelian</a></li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>

      <div class="col-md-4">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Laporan Penjualan</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <ul class="list-group">
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Reportsales/sales_view" class="text-primary">Laporan Penjualan</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Reportsales/sales_due_view" class="text-primary">Laporan Penjualan Jatuh Tempo</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Reportsales/sales_not_send_view" class="text-primary">Laporan Penjualan Belum Terkirim</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Reportsales/retur_sales_view" class="text-primary">Laporan Retur Penjualan</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Reportsales/sales_minus_view" class="text-primary">Laporan Penjualan Minus</a></li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <?php } ?>

      <div class="col-md-4">
        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title">Laporan Hutang</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <ul class="list-group">
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Reportpayment/debt_view" class="text-primary">Laporan Pembayaran Hutang</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Reportpayment/debt_pending_view" class="text-primary">Laporan Hutang Belum Lunas</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Reportpayment/repayment_view" class="text-primary">Laporan Pembayaran Piutang</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Reportpayment/repayment_pending_view" class="text-primary">Laporan Piutang Belum Lunas</a></li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>

      <div class="col-md-4">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Laporan</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <ul class="list-group">
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Utility/print_stock" class="text-primary">Kartu Stock</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Utility/print_laba" class="text-primary">Laba</a></li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>

      <div class="col-md-4">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Utilitas</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <ul class="list-group">
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Utility/print_catalog" class="text-primary">Cetak Catalog</a></li>
              <li class="list-group-item"><a href="<?php echo base_url(); ?>Utility/print_price" class="text-primary">Cetak Label Harga</a></li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>

    </div>


    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>