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
          <h1>Detail Pembayaran Piutang</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Detail Pembayaran Piutang</li>
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
            <?php foreach($data['get_detail_payment_receivables_header'] as $row){ ?>
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                <address>
                  <strong><?php echo $row->customer_name; ?></strong><br>
                  <?php echo $row->customer_address; ?><br>
                  <?php echo $row->customer_phone; ?><br>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Invoice <?php echo $row->payment_receivable_invoice; ?></b><br>
                <br>
                <b>Tanngal Pembayaran:</b> <?php $date = date_create($row->payment_receivable_date); echo date_format($date,"d-M-Y"); ?><br>
                <b>Metod Pembayaran:</b>  <?php echo $row->payment_name; ?><br>
                <b>Status</b><?php if($row->payment_receivable_status == 'Success'){ echo '<span class="badge badge-success">Sukses</span>';}else{ echo '<span class="badge badge-danger">Cancel</span>';} ?><br />
              </div>
              <!-- /.col -->
            </div>
          <?php } ?>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>No Penjualan</th>
                      <th>Pembayaran</th>
                      <th>Diskon</th>
                      <th>Retur</th>
                      <th>Sisa Hutang</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($data['get_detail_payment_receivables_detail'] as $row){ ?>
                    <tr>
                      <td><?php echo $row->hd_sales_invoice; ?></td>
                      <td><?php echo 'Rp. '.number_format($row->dt_payment_receivable_nominal); ?></td>
                      <td><?php echo 'Rp. '.number_format($row->dt_payment_receivable_discount); ?></td>
                      <td><?php echo 'Rp. '.number_format($row->dt_payment_receivable_retur); ?></td>
                      <td><?php echo 'Rp. '.number_format($row->dt_payment_receivable_remaining); ?></td>
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
               

                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                    <?php foreach($data['get_detail_payment_receivables_header'] as $row){ ?>
                    <tr>
                      <th style="width:50%">Total Pembayaran:</th>
                      <td><?php echo 'Rp. '.number_format($row->payment_receivable_total_invoice); ?></td>
                    </tr>
                    <tr>
                      <th>Total Nota:</th>
                      <td><?php echo 'Rp. '.number_format($row->payment_receivable_total_pay); ?></td>
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



