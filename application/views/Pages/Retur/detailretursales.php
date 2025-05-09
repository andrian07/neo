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
          <h1>Detail Retur Penjualan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Detail Retur Penjualan</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
        


          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  
                  
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <?php foreach($data['get_detail_retur_sales_header'] as $row){ ?>
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                <address>
                  <strong><?php echo $row->customer_name; ?></strong><br>
                  <?php echo $row->customer_address; ?><br>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Invoice <?php echo $row->hd_retur_sales_invoice; ?></b><br>
                <br>
                <b>Tanngal Penjualan:</b> <?php $date = date_create($row->hd_retur_date); echo date_format($date,"d-M-Y"); ?><br>
                <b>Status</b><?php if($row->hd_retur_status  == 'success'){ echo '<span class="badge badge-success">Sukses</span>';}else if($row->hd_retur_status == 'cancel'){ echo '<span class="badge badge-danger">Cancel</span>';}else{echo '<span class="badge badge-primary">Pending</span>';} ?><br />
              </div>
              <!-- /.col -->
            </div>
          <?php } ?>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row" style="margin-top: 20px;">
              <div class="col-12 table-respurchasensive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Kode Item</th>
                      <th>Nama</th>
                      <th>Harga</th>
                      <th>Qty</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($data['get_detail_retur_sales_detail'] as $row){ ?>
                    <tr>
                      <td><?php echo $row->item_barcode; ?></td>
                      <td><?php echo $row->item_name; ?></td>
                      <td><?php echo 'Rp. '.number_format($row->dt_retur_price); ?></td>
                      <td><?php echo $row->dt_retur_qty; ?></td>
                      <td><?php echo 'Rp. '.number_format($row->dt_retur_total); ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">
                
              </div>
              <!-- /.col -->
              <div class="col-6">
               

                <div class="table-respurchasensive">
                  <table class="table">
                    <tbody>
                    <?php foreach($data['get_detail_retur_sales_header'] as $row){ ?>
                    <tr>
                      <th>Total:</th>
                      <td><?php echo 'Rp. '.number_format($row->hd_retur_total_transaction); ?></td>
                    </tr>
                  <?php } ?>
                  </tbody></table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>



