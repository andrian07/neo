<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
<style>
  .table-scroll {
    position:relative;
    max-width:100%;
    margin:auto;
    overflow:hidden;
    border:1px solid #dee2e6;
  }
  .table-wrap {
    width:100%;
    overflow:auto;
  }
  .table-scroll table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
    font-size: 15px;
  }
  .table-scroll th{
    text-align: center;
  }
  .table-scroll th, .table-scroll td {
    padding:5px 10px;
    border:1px solid #dee2e6;
    white-space:nowrap;
    vertical-align:top;
  }
  .table-scroll thead, .table-scroll tfoot {
    background:#f9f9f9;
  }
  .clone {
    position:absolute;
    top:0;
    left:0;
    pointer-events:none;
  }
  .clone th, .clone td {
    visibility:hidden
  }
  .clone td, .clone th {
    border-color:transparent
  }
  .clone tbody th {
    visibility:visible;
    color:red;
  }
  .clone .fixed-side {
    border:1px solid #000;
    background:#eee;
    visibility:visible;
  }

  .ui-autocomplete { z-index:2147483647 !important; }

  .clone thead, .clone tfoot{background:transparent;}
  /*table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
    overflow-x: auto !important;
  }

  th, td {
    text-align: left;
    padding: 8px;
  }

  tr:nth-child(even){background-color: #f2f2f2}*/
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Produk Paket</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Produk Paket</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->

  <section class="content">
    <!-- Default box -->
    
    <form name="photo" id="frmaddproduct" enctype="multipart/form-data" action="<?php echo base_url();?>Masterdata/insert_package" method="post" class="form-horizontal form-space">
      <div class="card collapsed-card">
        <div class="card-header">
          <h3 class="card-title">Tambah Paket</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-4">
              <div class="form-group">
                <div class="proof">
                  <div class="imgArea" data-title="">
                    <input type="file" name="screenshoot" id="screenshoot" hidden accept="image/*" />
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <h4>upload screenshoot</h4>
                    <p>image size must be less than <span>2MB</span></p>
                  </div>
                  <button class="selectImage" type="button">Select Image</button>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label  class="col-form-label">Kode Barcode:</label>
                <input type="text" class="form-control" value="AUTO" readonly>
              </div>

              <div class="form-group">
                <label  class="col-form-label">Nama Produk Paket:</label>
                <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Nama Produk Paket" required="">
              </div>

              <div class="form-group">
                <label  class="col-form-label">Modal 1:</label>
                <input type="text" class="form-control curency" name="item_cogs" id="item_cogs" value="0" required="">
              </div>

              <div class="form-group">
                <label  class="col-form-label">Modal 2:</label>
                <input type="text" class="form-control curency2" name="item_cogs2" id="item_cogs2" value="0" required="">
              </div>

            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label  class="col-form-label">Harga Toko:</label>
                <input type="text" class="form-control curency3" name="item_price_1" id="item_price_1" value="0" required="">
              </div>

              <div class="form-group">
                <label  class="col-form-label">Harga Cabang:</label>
                <input type="text" class="form-control curency4" name="item_price_2" id="item_price_2" value="0" required="">
              </div>


              <div class="form-group">
                <label  class="col-form-label">Harga IG:</label>
                <input type="text" class="form-control curency5" name="item_price_3" id="item_price_3" value="0" required="">
              </div>

            </div>
          </div>
        </div>
        <div class="card-footer" style="text-align: right;">
          <?php if($data['check_role'][0]->add_ac == 'Y'){?>
            <button id="btnsave" class="btn btn-success button-header-custom-save"><i class="fas fa-save"></i> Simpan</button>
          <?php }else{ ?>
            <button id="btnsave" class="btn btn-success button-header-custom-save" disabled><i class="fas fa-save"></i> Simpan</button>
          <?php } ?>
        </div>
      </form>
      
    </div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Varian Produk</h3>
      </div>
      <div class="card-body">
        <div id="table-scroll" class="table-scroll">
          <div class="table-wrap">
            <table class="main-table">
              <thead>
                <tr>
                  <th>Action</th>
                  <th>Kode Barcode</th>
                  <th>Nama Paket</th>
                  <th>Modal 1</th>
                  <th>Modal 2</th>
                  <th>Harga Toko</th>
                  <th>Harga Cabang</th>
                  <th>Harga IG</th>
                  <th>Stock</th>
                  <th>Stock Belum Terkirim</th>
                  <th>Gambar</th>
                </tr>
              </thead>
              <tbody>
               <?php foreach($data['product_list_package'] as $row){ ?>
                <tr>
                  <td>
                    <?php if($data['check_role'][0]->edit_ac == 'Y'){?>
                      <button class="btn btn-sm btn-warning" data-toggle="modal" data-id="<?php echo $row->item_id; ?>" data-target="#exampleModaledit"><i class="fas fa-cog"></i></button>
                    <?php }else{ ?>
                      <button class="btn btn-sm btn-warning" data-toggle="modal" data-id="<?php echo $row->item_id; ?>" data-target="#exampleModaledit" disabled><i class="fas fa-cog"></i></button>
                    <?php } ?>
                    <?php if($data['check_role'][0]->delete_ac == 'Y'){?>
                      <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('<?php echo $row->item_id; ?>', '<?php echo $row->item_name; ?>')"><i class="fas fa-trash"></i></button>
                    <?php }else{ ?>
                      <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('<?php echo $row->item_id; ?>', '<?php echo $row->item_name; ?>')" disabled><i class="fas fa-trash"></i></button>
                    <?php } ?>
                    <?php if($data['check_role'][0]->edit_ac == 'Y'){?>
                      <button class="btn btn-sm btn-info" data-toggle="modal"  data-id="<?php echo $row->item_id; ?>" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
                    <?php }else{ ?>
                      <button class="btn btn-sm btn-info" data-toggle="modal"  data-id="<?php echo $row->item_id; ?>" data-target="#exampleModal" disabled><i class="fas fa-plus"></i></button>
                    <?php } ?>
                  </td>
                  <td><?php echo $row->item_barcode; ?></td>
                  <td><?php echo $row->item_name; ?></td>
                  <td><?php echo 'Rp. '.number_format($row->item_cogs); ?></td>
                  <td><?php echo 'Rp. '.number_format($row->item_cogs2); ?></td>
                  <td><?php echo 'Rp. '.number_format($row->item_price_1);  ?></td>
                  <td><?php echo 'Rp. '.number_format($row->item_price_2);  ?></td>
                  <td><?php echo 'Rp. '.number_format($row->item_price_3);  ?></td>
                  <td><?php echo $row->item_stock; ?></td>
                  <td><?php echo $row->item_not_send; ?></td>
                  <td><img src="<?php echo base_url(); ?>assets/products/<?php echo $row->item_image; ?>" width="100%"></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModaleditLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Isi Paket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label  class="col-form-label">Item:</label>
              <input type="hidden" id="master_package_item_id" name="master_package_item_id" class="form-control text-right" required="">
              <input type="hidden" id="item_id" name="item_id" class="form-control text-right" required="">
              <input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="ketikkan nama produk">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label  class="col-form-label">Qty:</label>
              <input type="number" class="form-control" name="qty_package" id="qty_package" placeholder="Qty" required="">
            </div>
          </div>
          <div class="col-md-1">
            <div class="form-group">
              <button id="btnadd_temp" class="btn btn-md btn-primary rounded-circle float-right" style="margin-top: 35px;"><i class="fas fa-plus"></i></button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body" style="border-top: 1px solid #dee2e6;">
       <table id="example" class="table table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>Kode</th>
            <th>Item</th>
            <th>Qty</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="temp">

        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

<!-- Tambah Stock -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Kode Barcode</label>
          <input type="hidden" class="form-control" id="item_stock_id" readonly>
          <input type="text" class="form-control" id="item_stock_barcode" readonly>
        </div>
        <div class="form-group">
          <label>Nama</label>
          <input type="text" class="form-control" id="item_stock_name" readonly>
        </div>
        <div class="form-group">
          <label>Stok Saat Ini</label>
          <input type="text" class="form-control" id="item_stock_now" readonly>
        </div>
        <div class="form-group">
          <label>Stok Di Tambahkan</label>
          <input type="number" class="form-control" id="item_stock_plus">
        </div>
        <div class="form-group">
          <label>Stok Total</label>
          <input type="number" class="form-control" id="item_stock_total">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="add_stock" class="btn btn-primary">Tambah Stok</button>
      </div>
    </div>
  </div>
</div>
<!-- End Tambah Stock -->
<!-- /.card -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>

<script type="text/javascript">

  let item_cogs = new AutoNumeric('#item_cogs', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_cogs2 = new AutoNumeric('#item_cogs2', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_price_1 = new AutoNumeric('#item_price_1', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_price_2 = new AutoNumeric('#item_price_2', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_price_3 = new AutoNumeric('#item_price_3', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  $('#exampleModaledit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id   = button.data('id');
    var modal = $(this)
    $('#master_package_item_id').val(id);
    get_temp(id);
  })

  $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id   = button.data('id');
    var modal = $(this)
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/package_info",
      dataType: "json",
      data: {id:id},
      success : function(data){
        $('#item_stock_id').val(id);
        $('#item_stock_barcode').val(data[0]['item_barcode']);
        $('#item_stock_name').val(data[0]['item_name']);
        $('#item_stock_now').val(data[0]['item_stock']);
      }
    });

  })

  function get_temp(id) {
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/get_package_detail",
      dataType: "json",
      data: {id:id},
      success : function(data){
        let text_temp = "";

        for (let i = 0; i < data.length; i++) {
          text_temp += '<tr><td>'+data[i].item_barcode+'</td><td width="50%">'+data[i].item_name+'</td><td width="50%">'+data[i].item_package_qty+'</td><td><button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes_containt('+data[i].product_packet_id+', '+data[i].item_barcode+', '+data[i].item_id+')"><i class="fas fa-trash"></i></button></td></tr>';
        }
        document.getElementById("temp").innerHTML = text_temp;
      }
    });
  }

  $("#item_stock_plus").on("input", function(){
    let item_stock_plus = $('#item_stock_plus').val();
    let item_stock_now = $('#item_stock_now').val();
    let item_stock_total = parseInt(item_stock_plus) + parseInt(item_stock_now);
    $('#item_stock_total').val(item_stock_total);
  });

  $(document).ready(function() {
    $('#btnadd_temp').click(function(e){
      e.preventDefault();
      var master_package_item_id   = $("#master_package_item_id").val();
      var item_id                  = $("#item_id").val();
      var qty_package              = $("#qty_package").val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Masterdata/add_package",
        dataType: "json",
        data: {master_package_item_id:master_package_item_id, item_id:item_id, qty_package:qty_package},
        success : function(data){
          if (data.code == "200"){
            var id = master_package_item_id;
            get_temp(id);
            clear_input();
            Swal.fire('Saved!', '', 'success');
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.result,
            })
          }
        }
      });
    });
  });

  $('#add_stock').click(function(e){
    e.preventDefault();
    var item_stock_id   = $("#item_stock_id").val();
    var item_stock_plus = $("#item_stock_plus").val();
    var item_stock_total = $("#item_stock_total").val();
    var item_stock_now = $('#item_stock_now').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/add_stock_package",
      dataType: "json",
      data: {item_stock_plus:item_stock_plus, item_stock_id:item_stock_id, item_stock_total:item_stock_total, item_stock_now:item_stock_now},
      success : function(data){
        if (data.code == "200"){
          location.reload();
          Swal.fire('Saved!', '', 'success'); 
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.result,
          })
        }
      }
    });
  });

  

  function clear_input(){
    $('#item_id').val('');
    $('#qty_package').val(0);
    $('#product_name').val('');
  }

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

  function deletes(id, name){
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus '"+name+"' ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Masterdata/delete_variant",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              location.reload();
              Swal.fire('Saved!', '', 'success'); 
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.msg,
              })
            }
          }
        });
      }
    })
  }


  $('#btnreload').click(function(e){
    e.preventDefault();
    location.reload();
  });


  /* image uplaod */
  const fileTypes = [
    "image/apng",
    "image/bmp",
    "image/gif",
    "image/jpeg",
    "image/pjpeg",
    "image/png",
    "image/svg+xml",
    "image/tiff",
    "image/webp",
    "image/x-icon",
    "image/avif",
  ];
  function validFileType(file) {
    return fileTypes.includes(file.type);
  }

  let inputHidden = document.querySelector("#screenshoot");
  let triggerInput = document.querySelector(".selectImage");
  let imgArea = document.querySelector(".imgArea");

  triggerInput.addEventListener("click",function(){
    inputHidden.click();
  })

  inputHidden.addEventListener("change",function(e){
    let image = e.target.files[0];
    if(!validFileType(image)){
      alert("invalid file type");
      return;
    }
    if(image.size > 2097152){
      alert("image size must be less than 2MB");
      return;
    }else{
      const reader = new FileReader();
      reader.addEventListener("load",function(){
        const allImgs = document.querySelectorAll(".imgArea img");
        allImgs.forEach((img) => {
          img.remove();
        })
        const imgUrl = reader.result;
        const img = document.createElement("img");
        img.src = imgUrl;
        imgArea.appendChild(img);
        imgArea.classList.add("active");
        imgArea.dataset.title = image.name;
      })
      reader.readAsDataURL(image);
    }
  })

  /* image uplaod */

  let inputHidden2 = document.querySelector("#screenshoot2");
  let triggerInput2 = document.querySelector(".selectImage2");
  let imgArea2 = document.querySelector(".imgArea2");

  triggerInput2.addEventListener("click",function(){
    inputHidden2.click();
  })

  inputHidden2.addEventListener("change",function(e){
    let image = e.target.files[0];
    if(!validFileType(image)){
      alert("invalid file type");
      return;
    }
    if(image.size > 2097152){
      alert("image size must be less than 2MB");
      return;
    }else{
      const reader = new FileReader();
      reader.addEventListener("load",function(){
        const allImgs = document.querySelectorAll(".imgArea2 img");
        allImgs.forEach((img) => {
          img.remove();
        })
        const imgUrl = reader.result;
        const img = document.createElement("img");
        img.src = imgUrl;
        imgArea2.appendChild(img);
        imgArea2.classList.add("active");
        imgArea2.dataset.title = image.name;
      })
      reader.readAsDataURL(image);
    }
  })  

  function deletes_containt(id, name, item_id){
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus '"+name+"' ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Masterdata/delete_containt",
          dataType: "json",
          data: {id:id},
          success : function(data){
            if (data.code == "200"){
              Swal.fire('Saved!', '', 'success'); 
              get_temp(item_id);
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.msg,
              })
            }
          }
        });
      }
    })
  }

</script>