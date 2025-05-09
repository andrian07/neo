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
          <h1>Print Katalog</h1>
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
                <label>Kategori:</label>
                <select class="form-control select2" name="category_id" id="category_id" >
                  <?php foreach($data['category_list'] as $row){ ?>
                    <option value="<?php echo $row->category_id; ?>"><?php echo $row->category_name; ?></option>
                  <?php  } ?>
                </select>
              </div>
            </div>
            
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Brand:</label>
                <select class="form-control select2" name="brand_id" id="brand_id" >
                  <?php foreach($data['brand_list'] as $row){ ?>
                    <option value="<?php echo $row->brand_id; ?>"><?php echo $row->brand_name; ?></option>
                  <?php  } ?>
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
                      <a class="dropdown-item" id="btnprint" href="">Print Catalog</a>
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
        <iframe id="preview" src="<?php echo base_url(); ?>Utility/print_catalog_pdf" width="100%" height="1000px"></iframe>
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
    let category_id = $('#category_id').val();
    let brand_id = $('#brand_id').val();

    let url = '<?php echo base_url(); ?>Utility/print_catalog_pdf?';
    url += '&category_id=' + category_id;
    url += '&brand_id=' + brand_id;
    if(category_id == '' && brand_id == ''){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Silahkan Pilih Kategory atau Brand',
      });
    }else{
     $('#preview').attr('src', url);
   }

 })


  $('#btnprint').click(function(e) {
    e.preventDefault();
    let category_id = $('#category_id').val();
    let brand_id = $('#brand_id').val();
    let url = "<?php echo base_url(); ?>Utility/print_catalog_pdf?";
    url += '&category_id=' + category_id;
    url += '&brand_id=' + brand_id;
    if(category_id == '' && brand_id == ''){
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Silahkan Pilih Kategory atau Brand',
      });
    }else{
     window.open(url, '_blank').focus();
   }
 })

  
</script>
