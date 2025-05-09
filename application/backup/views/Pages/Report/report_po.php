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
          <h1>Laporan PO</h1>
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
                <label>Dari Tanggal:</label>
                <input id="start_date" name="start_date" type="date" class="form-control" value="<?php echo date('Y-m-01'); ?>">
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Sampai Tanggal:</label>
                <input id="end_date" name="end_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Golongan:</label>
                <select id="product_tax" name="product_tax" class="form-control">
                  <option value="" selected="">Semua</option>
                  <option value="Y">Pajak</option>
                  <option value="N">Non Pajak</option>
                </select>
              </div>
            </div>

            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Supplier:</label>
                <select class="form-control select2" name="supplier_id" id="supplier_id" >
                  <option></option>
                  <?php foreach($supplier_list as $row){ ?>
                    <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>
                  <?php  } ?>
                </select>
              </div>
            </div>

            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Status Pesanan:</label>
                <select id="status_po" name="status_po" class="form-control">
                  <option value="">Semua</option>
                  <option value="pending">Pending</option>
                  <option value="success">Selesai</option>
                  <option value="cancel">Cancel</option>
                </select>
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
        <iframe id="preview" src="<?php echo base_url(); ?>Reportpurchase/po_pdf" width="100%" height="1000px"></iframe>
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
    let product_tax = $('#product_tax').val();
    let supplier_id = $('#supplier_id').val();
    let status_po = $('#status_po').val();

    let url = '<?php echo base_url(); ?>Reportpurchase/po_pdf?';
    url += '&start_date=' + start_date;
    url += '&end_date=' + end_date;
    url += '&product_tax=' + product_tax;
    url += '&supplier_id=' + supplier_id;
    url += '&status_po=' + status_po;
    $('#preview').attr('src', url);
  })


  $('#btndownloadexcell').click(function(e) {
    e.preventDefault();

    let start_date = $('#start_date').val();
    let end_date = $('#end_date').val();
    let product_tax = $('#product_tax').val();
    let supplier_id = $('#supplier_id').val();
    let status_po = $('#status_po').val();

    let url = '<?php echo base_url(); ?>Reportpurchase/po_excell?';
    url += '&start_date=' + start_date;
    url += '&end_date=' + end_date;
    url += '&product_tax=' + product_tax;
    url += '&supplier_id=' + supplier_id;
    url += '&status_po=' + status_po;

    window.open(url, '_blank');
  })
</script>
