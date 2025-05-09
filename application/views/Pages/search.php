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
          <h1>Info Produk</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Info Produk</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Barcode / Nama Produk / Kode Produk</h3>
        <div class="form-group">
          <input id="key" name="key" type="text" class="form-control ui-autocomplete-input" placeholder="Barcode atau Nama Produk" value="" autocomplete="off">
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">


         <table class="table table-hover">
          <tbody id="product_list">

          </tbody>
        </table>
      </div>
    </div>
    <!-- /.card-body -->
    <!-- /.card-footer-->
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

  $(document ).ready(function() {

    product_list_table();
  });


  function formatUang(subject) {
    rupiah = subject.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
    return `Rp${rupiah}`;
  }

  const rupiah = (number)=>{
    return new Intl.NumberFormat("id-ID", {
      style: "decimal"
    }).format(number);
  }

  function product_list_table(key = '') {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Search/product_list",
      dataType: "json",
      data: {key:key},
      success : function(data){
        let text = "";
        for (let i = 0; i < data.length; i++) {
          text+= '<tr onclick="popupOpen('+data[i].item_id+')"><td class="image-td"><img src="<?php echo base_url(); ?>assets/products/'+data[i].item_image+'" width="100%"></img></td><td>'+data[i].item_barcode+'<br />'+data[i].item_name+'<br /> <span class="badge badge-primary">Rp. '+rupiah(data[i].item_price_1)+'</span></td><td>'+data[i].item_stock+' '+data[i].unit_name +'</td></tr>';
        }       
        document.getElementById("product_list").innerHTML = text;
      }
    });
  }

  $('#key').on('input', function (event) {
    var key = this.value;
    product_list_table(key);
  })


  function popupOpen(id) {
    let link = window.location.origin + window.location.pathname + '/detailsearch?id='+id;
    Fancybox.show([
      {
        src: link,
        type: "iframe",
        preload: false,
        top:0,
      },
    ]);
  }

</script>
