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
          <h1>Detail Opname</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Detail Opname</li>
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
            <?php foreach($data['get_detail_opname_header'] as $row){ ?>
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
               
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Invoice <?php echo $row->opname_code; ?></b><br>
                <br>
                <b>Tanngal:</b> <?php $date = date_create($row->hd_opname_date); echo date_format($date,"d-M-Y"); ?><br>
                <b>Status</b><?php if($row->hd_opname_status == 'success'){ echo '<span class="badge badge-success">Sukses</span>';}else{ echo '<span class="badge badge-danger">Cancel</span>';} ?><br />
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
                      <th>Kode Item</th>
                      <th>Nama</th>
                      <th>Stok Awal</th>
                      <th>Stok Akhir</th>
                      <th>Selisih Stok</th>
                      <th>Selisih Rupiah</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($data['get_detail_opname_detail'] as $row){ ?>
                    <tr>
                      <td><?php echo $row->item_barcode; ?></td>
                      <td><?php echo $row->item_name; ?></td>
                      <td><?php echo $row->dt_opname_stock_awal; ?></td>
                      <td><?php echo $row->dt_opname_stock_akhir; ?></td>
                      <td><?php echo $row->dt_opname_stock_difference; ?></td>
                      <td><?php echo 'Rp. '.number_format($row->dt_opname_total_price); ?></td>
                      <td><?php echo $row->dt_opname_detail_remark; ?></td>
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
                    <?php foreach($data['get_detail_opname_header'] as $row){ ?>
                    <tr>
                      <th style="width:50%">Total Selisih:</th>
                      <td><?php echo 'Rp. '.number_format($row->hd_opname_total_price); ?></td>
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



