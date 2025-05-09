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
          <h1>Laporan Penjualan</h1>
        </div>
        <div class="col-sm-6">

        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">

      <div class="card-body">
        <form>
          <div class="row">
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Tanggal Transaksi Dari:</label>
                <input id="start_date" name="start_date" type="date" class="form-control" value="<?php echo date('Y-m-01'); ?>">
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Tanggal Transaksi Sampai:</label>
                <input id="end_date" name="end_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
              </div>
            </div>
            <div class="col-sm-2">
              <!-- text input -->
              <div class="form-group">
                <label>&nbsp;</label>
                <div class="form-group">
                  <div class="btn-group">
                    <button id="btnsearch" type="button" class="btn btn-primary">Cari</button>
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu" style="">
                      <a class="dropdown-item" id="btndownloadexcell" href="">Download Excell</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- /.card-body -->
      <!-- /.card-footer-->
    </div>

    <div class="card">
      <div class="card-body">
        <iframe id="preview" src="<?php echo base_url(); ?>Reportsales/sales_minus_pdf" width="100%" height="1000px"></iframe>
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

<script type="text/javascript">

  $('#btnsearch').click(function(e) {
    e.preventDefault();
    let start_date = $('#start_date').val();
    let end_date = $('#end_date').val();

    let url = '<?php echo base_url(); ?>Reportsales/sales_minus_pdf?';
    url += '&start_date=' + start_date;
    url += '&end_date=' + end_date;
    
    $('#preview').attr('src', url);
  })


  $('#btndownloadexcell').click(function(e) {
    e.preventDefault();

     let start_date = $('#start_date').val();
    let end_date = $('#end_date').val();


    let url = '<?php echo base_url(); ?>Reportsales/sales_minus_excell?';
    url += '&start_date=' + start_date;
    url += '&end_date=' + end_date;

    window.open(url, '_blank');
  })
</script>
