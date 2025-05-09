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
          <h1>Cetak Kartu Stock</h1>
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

            <div class="col-sm-5">
              <!-- text input -->
              <div class="form-group">
                <label>Nama Barang:</label>
                <input type="hidden" id="item_id" name="item_id" class="form-control text-right" required="">
                <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan nama produk">
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
                      <a class="dropdown-item" id="btnprint" href="">Print Kartu Stok</a>
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
        <iframe id="preview" src="<?php echo base_url(); ?>Utility/print_stock_card_pdf" width="100%" height="1000px"></iframe>
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


  $('#product_name').autocomplete({ 
    minLength: 2,
    source: function(req, add) {
      $.ajax({
        url: '<?php echo base_url(); ?>/Sales/search_product',
        dataType: 'json',
        type: 'GET',
        data: req,
        success: function(res) {
          if (res.success == true) {
            add(res.data);
          }else{
            $('#product_name').val('');
          }
        },
      });
    },
    select: function(event, ui) {
      $('#item_id').val(ui.item.id);
    },
  });

  $('#btnsearch').click(function(e) {
    e.preventDefault();
    let item_id = $('#item_id').val();
    let url = '<?php echo base_url(); ?>Utility/print_stock_card_pdf?';
    url += '&item_id=' + item_id;
    if(item_id == ''){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Silahkan Pilih Barang',
      });
    }else{
     $('#preview').attr('src', url);
   }

 })


  $('#btnprint').click(function(e) {
    e.preventDefault();
    let item_id = $('#item_id').val();
    let url = "<?php echo base_url(); ?>Utility/print_stock_card_pdf?";
    url += '&item_id=' + item_id;
    if(item_id == ''){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Silahkan Pilih Barang',
      });
    }else{
     window.open(url, '_blank').focus();
   }
 })

  
</script>
