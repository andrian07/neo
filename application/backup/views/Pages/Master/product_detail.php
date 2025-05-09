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
          <h1>Produk</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Produk</li>
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
        <h3 class="card-title">Varian Produk</h3>

        <div class="card-tools">  
          <!--
          <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah</button>\
        -->
        <div class="modal fade bd-example-modal-xl" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Varian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form name="photo" id="frmaddproduct" enctype="multipart/form-data" action="<?php echo base_url();?>Masterdata/insert_variant" method="post" class="form-horizontal form-space">
                <div class="modal-body">
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
                        <input type="hidden" class="form-control" name="product_id" value="<?php echo $_GET['id'] ?>" readonly>
                        <input type="text" class="form-control" value="AUTO" readonly>
                      </div>

                      <div class="form-group">
                        <label  class="col-form-label">Nama Varian:</label>
                        <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Nama Varian" required="">
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
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" id="add" class="btn btn-primary">Save changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>


        <div class="modal fade bd-example-modal-xl" id="exampleModaledit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form name="photo" id="frmaddproduct" enctype="multipart/form-data" action="<?php echo base_url();?>Masterdata/edit_product_header" method="post" class="form-horizontal form-space">
                <div class="modal-body">
                  <div class="row">
                    <div class="col-lg-4">
                     <div class="form-group">
                      <div class="proof">
                        <div class="imgArea2" data-title="">
                          <input type="file" name="screenshoot2" id="screenshoot2" hidden accept="image/*" value="" />
                          <i class="fa-solid fa-cloud-arrow-up"></i>
                          <h4>upload screenshoot</h4>
                          <p>image size must be less than <span>2MB</span></p>
                          <div id="active-image"></div>
                        </div>
                        <button class="selectImage2" type="button">Select Image</button>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label  class="col-form-label">Kode Barcode:</label>
                      <input type="hidden" class="form-control" name="item_id_edit" id="item_id_edit" readonly>
                      <input type="text" class="form-control" name="item_code_edit" id="item_code_edit" readonly>
                    </div>

                    <div class="form-group">
                      <label  class="col-form-label">Nama Varian:</label>
                      <input type="text" class="form-control" name="item_name" id="item_name_edit" required="">
                    </div>

                    <div class="form-group">
                      <label  class="col-form-label">Modal 1:</label>
                      <input type="text" class="form-control curency" name="item_cogs" id="item_cogs_edit" required="">
                    </div>

                    <div class="form-group">
                      <label  class="col-form-label">Modal 2:</label>
                      <input type="text" class="form-control curency2" name="item_cogs2" id="item_cogs2_edit" required="">
                    </div>

                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label  class="col-form-label">Harga Toko:</label>
                      <input type="text" class="form-control curency3" name="item_price_1" id="item_price_1_edit" required="">
                    </div>

                    <div class="form-group">
                      <label  class="col-form-label">Harga Cabang:</label>
                      <input type="text" class="form-control curency4" name="item_price_2" id="item_price_2_edit" required="">
                    </div>


                    <div class="form-group">
                      <label  class="col-form-label">Harga IG:</label>
                      <input type="text" class="form-control curency5" name="item_price_3" id="item_price_3_edit" required="">
                    </div>

                  </div>

                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="add" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="modal fade bd-example-modal-xl" id="exampleModaleditafkir" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Afkir</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">

                  <div class="form-group">
                    <label  class="col-form-label">Total Stok:</label>
                    <input type="hidden" class="form-control" name="product_id_afkir" id="product_id_afkir" readonly>
                    <input type="text" class="form-control" name="total_stock_now" id="total_stock_now" value="0" required="" readonly>
                  </div>

                  <div class="form-group">
                    <label  class="col-form-label">Total Afkir:</label>
                    <input type="text" class="form-control" name="total_afkir_now" id="total_afkir_now" value="0" required="" readonly>
                  </div>

                  <div class="form-group">
                    <label  class="col-form-label">Tambah Afkir:</label>
                    <input type="text" class="form-control" name="new_afkir" id="new_afkir" value="0" required="">
                  </div>

                </div>

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" id="addafkir" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="card-body">
    <table width="100%" class="mb-3">
      <tbody>
        <?php foreach ($data['get_header_product'] as $row_header) {?>
          <tr>
            <th width="15%">Nama Produk</th>
            <td width="1%">:</td>
            <td width="84%" id="setup_product_name"><?php echo $row_header['product_name']; ?></td>
          </tr>
          <tr>
            <th>Satuan Dasar</th>
            <td>:</td>
            <td id="setup_base_unit"><?php echo $row_header['unit_name']; ?></td>
          </tr>
          <tr>
            <th>Kategori</th>
            <td>:</td>
            <td id="setup_base_unit"><?php echo $row_header['category_name']; ?></td>
          </tr>
          <tr>
            <th>Brand</th>
            <td>:</td>
            <td id="setup_base_unit"><?php echo $row_header['brand_name']; ?></td>
          </tr>
        <?php } ?>
      </tbody></table>

      <div id="table-scroll" class="table-scroll">
        <div class="table-wrap">
          <table class="main-table">
            <thead>
              <tr>
                <th>Action</th>
                <th>Kode Barcode</th>
                <th>Nama Variant</th>
                <th>Modal 1</th>
                <th>Modal 2</th>
                <th>Harga Toko</th>
                <th>Harga Cabang</th>
                <th>Harga IG</th>
                <th>Stock</th>
                <th>Stock Belum Terkirim</th>
                <th>Stock Afkir</th>
                <th>Gambar</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($data['get_detail_product'] as $row){ ?>
                <tr>
                  <td>
                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-id="<?php echo $row['item_id']; ?>" data-target="#exampleModaledit"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('<?php echo $row['item_id']; ?>', '<?php echo $row['item_name']; ?>')"><i class="fas fa-trash"></i></button>
                    <button class="btn btn-sm btn-primary" data-placement="top" data-title="Afkir" data-toggle="modal" data-id="<?php echo $row['item_id']; ?>" data-target="#exampleModaleditafkir"><i class="fas fa-wrench"></i></button>
                  </td>
                  <td><?php echo $row['item_barcode']; ?></td>
                  <td><?php echo $row['item_name']; ?></td>
                  <td><?php echo 'Rp. '.number_format($row['item_cogs']); ?></td>
                  <td><?php echo 'Rp. '.number_format($row['item_cogs2']); ?></td>
                  <td><?php echo 'Rp. '.number_format($row['item_price_1']);  ?></td>
                  <td><?php echo 'Rp. '.number_format($row['item_price_2']);  ?></td>
                  <td><?php echo 'Rp. '.number_format($row['item_price_3']);  ?></td>
                  <td><?php echo $row['item_stock']; ?></td>
                  <td><?php echo $row['item_not_send']; ?></td>
                  <td><?php echo $row['item_afkir']; ?></td>
                  <td><img src="<?php echo base_url(); ?>assets/products/<?php echo $row['item_image']; ?>" width="100%"></td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="10">
                  <a href="#" data-toggle="modal" data-target="#exampleModal">
                    <i class="fas fa-plus"></i> Tambahkan
                  </a>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <a href="<?php echo base_url(); ?>Masterdata/product">
        <button class="btn btn-danger close-setup-page" style="margin-top: 20px;"><i class="fas fa-arrow-circle-left"></i> Kembali</button>
      </a>
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

  let item_cogs_edit = new AutoNumeric('#item_cogs_edit', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_cogs2_edit = new AutoNumeric('#item_cogs2_edit', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_price_1_edit = new AutoNumeric('#item_price_1_edit', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_price_2_edit = new AutoNumeric('#item_price_2_edit', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_price_3_edit = new AutoNumeric('#item_price_3_edit', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
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

  function insert_detail_product(id){
    window.location.href = 'product_detail?id='+id;
  }

  $('#btnreload').click(function(e){
    e.preventDefault();
    location.reload();
  });
  
  $('#exampleModaleditafkir').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id   = button.data('id')
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/get_afkir",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          console.log(data);
          document.getElementById('total_stock_now').value = data.msg[0].item_stock;
          document.getElementById('total_afkir_now').value = data.msg[0].item_afkir;
          document.getElementById('product_id_afkir').value = id;
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Data Tidak Ditemukan",
          })
        }
      }
    });
  })


  $('#addafkir').click(function(e){
    e.preventDefault();
    var product_id_afkir    = $("#product_id_afkir").val();
    var total_stock_now     = $("#total_stock_now").val();
    var total_afkir_now     = $("#total_afkir_now").val();
    var new_afkir           = $("#new_afkir").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/update_afkir",
      dataType: "json",
      data: {product_id_afkir:product_id_afkir, total_stock_now:total_stock_now, total_afkir_now:total_afkir_now, new_afkir:new_afkir},
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

  $('#exampleModaledit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id   = button.data('id')
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/get_edited_variant",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          document.getElementById('item_id_edit').value = data.msg[0].item_id;
          document.getElementById('item_code_edit').value = data.msg[0].item_barcode;
          document.getElementById('item_name_edit').value = data.msg[0].item_name;
          item_cogs_edit.set(data.msg[0].item_cogs);
          item_cogs2_edit.set(data.msg[0].item_cogs2);
          item_price_1_edit.set(data.msg[0].item_price_1);
          item_price_2_edit.set(data.msg[0].item_price_2);
          item_price_3_edit.set(data.msg[0].item_price_3);

          var elem = document.createElement("img");
          document.getElementById("active-image").appendChild(elem);
          elem.src = '<?php echo base_url(); ?>assets/products/'+data.msg[0].item_image;

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Data Tidak Ditemukan",
          })
        }
      }
    });
  })

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
</script>