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
        <h3 class="card-title">List Produk</h3>

        <div class="card-tools">  
          <div class="btn-group">
            <form id="frmuploadexcel" name="frmupload" method="POST" action="" enctype="multipart/form-data">
              <input type="files" id="file_import" name="file_import" hidden="">
            </form>
            <button id="btnimport" type="button" class="btn btn-success"><i class="fas fa-file-excel"></i> Import Excel</button>
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu" role="menu" style="">
              <a class="dropdown-item" href="<?php echo base_url(); ?>TemplateExcell/download_product_template">Download Template</a>
              <a class="dropdown-item" data-toggle="modal" data-target="#exampleModalUpload">Upload Product</a>
            </div>
          </div>
          <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah</button>
          <div class="modal fade bd-example-modal-xl" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Product</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form name="photo" id="frmaddproduct" enctype="multipart/form-data" action="<?php echo base_url();?>Masterdata/insert_header_product" method="post" class="form-horizontal form-space">
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
                          <label  class="col-form-label">Kode Produk:</label>
                          <input type="text" class="form-control" value="AUTO" readonly>
                        </div>

                        <div class="form-group">
                          <label  class="col-form-label">Nama Produk:</label>
                          <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Nama Produk" required="">
                        </div>

                        <div class="form-group">
                          <label  class="col-form-label">Brand:</label>
                          <select class="form-control select2" name="brand_id" id="brand_id" required="">
                            <option></option>
                            <?php foreach($data['brand_list'] as $row){ ?>
                              <option value="<?php echo $row->brand_id; ?>"><?php echo $row->brand_name; ?></option>
                            <?php  } ?>
                          </select>
                        </div>

                        <div class="form-group">
                          <label  class="col-form-label">Kategori:</label>
                          <select class="form-control" name="category_id" id="category_id" required="">
                            <option></option>
                            <?php foreach($data['category_list'] as $row){ ?>
                              <option value="<?php echo $row->category_id; ?>"><?php echo $row->category_name; ?></option>
                            <?php  } ?>
                          </select>
                        </div>

                      </div>

                      <div class="col-lg-4">

                        <div class="form-group">
                          <label  class="col-form-label">Supplier:</label>
                          <select class="select2" multiple="multiple" name="supplier_id[]" id="supplier_id" >
                            <option></option>
                            <?php foreach($data['supplier_list'] as $row){ ?>
                              <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>
                            <?php  } ?>
                          </select>

                        </div>

                        <div class="form-group">
                          <label  class="col-form-label">Satuan:</label>
                          <select class="form-control" name="unit_id" id="unit_id" required="">
                            <option></option>
                            <?php foreach($data['unit_list'] as $row){ ?>
                              <option value="<?php echo $row->unit_id; ?>"><?php echo $row->unit_name; ?></option>
                            <?php  } ?>
                          </select>
                        </div>


                        <div class="form-group">
                          <label  class="col-form-label">PPN:</label>
                          <select class="form-control" name="ppn" id="ppn" required="">
                            <option value="N">Non PPN</option>
                            <option value="Y">PPN</option>
                          </select>
                        </div>

                        <div class="form-group">
                          <label  class="col-form-label">Minimal Stock:</label>
                          <input type="text" class="form-control" name="min_stock" id="min_stock" value="0" required="">
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

          <div class="modal fade bd-example-modal-md" id="exampleModalUpload" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Upload Product</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form name="photo" id="frmaddproduct" enctype="multipart/form-data" action="<?php echo base_url();?>TemplateExcell/import_product" method="post" class="form-horizontal form-space">
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label  class="col-form-label">Upload File:</label>
                          <input type="file" class="form-control" name="file_upload">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="modal fade bd-example-modal-xl" id="exampleModaledit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
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
                        <label  class="col-form-label">Kode Produk:</label>
                        <input type="hidden" class="form-control" name="product_id" id="product_id_edit" readonly>
                        <input type="text" class="form-control" name="product_code" id="product_code_edit" readonly>
                      </div>

                      <div class="form-group">
                        <label  class="col-form-label">Nama Produk:</label>
                        <input type="text" class="form-control" name="product_name" id="product_name_edit" placeholder="Nama Produk" required="">
                      </div>

                      <div class="form-group">
                        <label  class="col-form-label">Brand:</label>
                        <select class="form-control select2" name="brand_id" id="brand_id_edit" required="">
                          <option></option>
                          <?php foreach($data['brand_list'] as $row){ ?>
                            <option value="<?php echo $row->brand_id; ?>"><?php echo $row->brand_name; ?></option>
                          <?php  } ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label  class="col-form-label">Kategori:</label>
                        <select class="form-control" name="category_id" id="category_id_edit" required="">
                          <option></option>
                          <?php foreach($data['category_list'] as $row){ ?>
                            <option value="<?php echo $row->category_id; ?>"><?php echo $row->category_name; ?></option>
                          <?php  } ?>
                        </select>
                      </div>

                    </div>

                    <div class="col-lg-4">

                      <div class="form-group">
                        <label  class="col-form-label">Supplier:</label>
                        <select class="select2" multiple="multiple" name="supplier_id[]" id="supplier_id_edit" >
                          <option></option>
                          <?php foreach($data['supplier_list'] as $row){ ?>
                            <option value="<?php echo $row->supplier_id; ?>"><?php echo $row->supplier_name; ?></option>
                          <?php  } ?>
                        </select>

                      </div>

                      <div class="form-group">
                        <label  class="col-form-label">Satuan:</label>
                        <select class="form-control" name="unit_id" id="unit_id_edit" required="">
                          <option></option>
                          <?php foreach($data['unit_list'] as $row){ ?>
                            <option value="<?php echo $row->unit_id; ?>"><?php echo $row->unit_name; ?></option>
                          <?php  } ?>
                        </select>
                      </div>


                      <div class="form-group">
                        <label  class="col-form-label">PPN:</label>
                        <select class="form-control" name="ppn" id="ppn_edit" required="">
                          <option value="N">Non PPN</option>
                          <option value="Y">PPN</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label  class="col-form-label">Minimal Stock:</label>
                        <input type="text" class="form-control" name="min_stock" id="min_stock_edit" value="0" required="">
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


        <button id="btnreload" class="btn btn-secondary"><i class="fas fa-sync"></i> Reload</button>

      </div>
    </div>
    <div class="card-body">
      <table id="example" class="table table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>Nama Product</th>
            <th>Brand</th>
            <th>Kategori</th>
            <th>Min Stock</th>
            <th>PPN</th>
            <th>Gambar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($data['product_list'] as $row){ ?>
            <tr>
              <td><?php echo $row['product_name']; ?></td>
              <td><?php echo $row['brand_name']; ?></td>
              <td><?php echo $row['category_name']; ?></td>
              <td><?php echo $row['min_stock']; ?></td>
              <td><?php if($row['ppn'] == 'N'){echo '<span class="badge badge-danger"><i class="fas fa-times-circle"></i></span>';}else{ echo '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';} ?></td>
              <td><img src="<?php echo base_url();?>assets/products/<?php echo $row['product_picture']; ?>" width="80px" height="60px"/></td>
              <td>
                <button class="btn btn-sm btn-warning" data-toggle="modal" data-id="<?php echo $row['product_id']; ?>" data-target="#exampleModaledit"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('<?php echo $row['product_id']; ?>', '<?php echo $row['product_code']; ?>')"><i class="fas fa-trash"></i></button>
                <button class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" data-title="Pengaturan Produk" onclick="insert_detail_product('<?php echo $row['product_id']; ?>')"><i class="fas fa-cog"></i></button>
              
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
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


<script>
  var tabel = null;
  $(document).ready(function() {
    tabel = $('#table-artikel').DataTable({
      "processing": true,
      "responsive":true,
      "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax":
            {
                "url": "<?= base_url('datatables/view_data');?>", // URL file untuk proses select datanya
                "type": "POST"
              },
              "deferRender": true,
            "aLengthMenu": [[5, 10, 50],[ 5, 10, 50]], // Combobox Limit
            "columns": [
            {"data": 'id_artikel',"sortable": false, 
            render: function (data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }  
          },
                { "data": "judul" }, // Tampilkan judul
                { "data": "kategori" },  // Tampilkan kategori
                { "data": "penulis" },  // Tampilkan penulis
                { "data": "tgl_posting" },  // Tampilkan tgl posting
                { "data": "id_artikel",
                "render": 
                function( data, type, row, meta ) {
                  return '<a href="show/'+data+'">Show</a>';
                }
              },
              ],
            });
  });
</script>


<script type="text/javascript">
  function deletes(id, code){
    Swal.fire({
      title: 'Konfirmasi?',
      text: "Apakah Anda Yakin Menghapus '"+code+"' ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Masterdata/delete_product",
          dataType: "json",
          data: {id:id, code:code},
          success : function(data){
            if (data.code == "200"){
              location.reload();
              Swal.fire('Saved!', '', 'success'); 
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data Tidak Bisa Hapus',
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

  $('#exampleModaledit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id   = button.data('id')
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/get_edited_product",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          var supplier_id_group = data.msg[0].supplier_id_group.replace(/\s/g, '') ;
          const supplier_id_group_array = supplier_id_group.split(",");
          document.getElementById('product_id_edit').value = data.msg[0].product_id;
          document.getElementById('product_code_edit').value = data.msg[0].product_code;
          document.getElementById('product_name_edit').value = data.msg[0].product_name;
          $('#brand_id_edit').val(data.msg[0].brand_id);
          $('#brand_id_edit').trigger('change'); 
          $('#category_id_edit').val(data.msg[0].category_id);
          $('#category_id_edit').trigger('change');
          $('#supplier_id_edit').val(supplier_id_group_array);
          $('#supplier_id_edit').trigger('change');
          $('#unit_id_edit').val(data.msg[0].unit_id);
          $('#unit_id_edit').trigger('change');
          $('#ppn_edit').val(data.msg[0].ppn);
          $('#min_stock_edit').val(data.msg[0].min_stock);

          var elem = document.createElement("img");
          document.getElementById("active-image").appendChild(elem);
          elem.src = '<?php echo base_url(); ?>assets/products/'+data.msg[0].product_picture;

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