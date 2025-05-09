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
          <h1>Brand</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Brand</li>
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
        <h3 class="card-title">List Brand</h3>

        <div class="card-tools"> 
          <?php if($data['check_role'][0]->add_ac == 'Y'){?>
            <button class="btn btn-warning" data-toggle="modal" data-target="#exampleModalImport"><i class="fas fa-file-excel"></i> Import</button> 
         <?php }else{ ?>
            <button class="btn btn-warning" data-toggle="modal" data-target="#exampleModalImport" disabled><i class="fas fa-file-excel"></i> Import</button>
          <?php } ?>

          <div class="modal fade bd-example-modal-md" id="exampleModalImport" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Upload Brand</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form name="photo" id="frmaddproduct" enctype="multipart/form-data" action="<?php echo base_url();?>TemplateExcell/import_brand" method="post" class="form-horizontal form-space">
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

          <?php if($data['check_role'][0]->add_ac == 'Y'){?>
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah</button>
          <?php }else{ ?>
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" disabled><i class="fas fa-plus"></i> Tambah</button>
          <?php } ?>
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Brand</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Nama Brand</label>
                    <input type="text" class="form-control" id="brand_name" placeholder="Nama Brand">
                  </div>
                  <div class="form-group">
                    <label>Keterangan Brand</label>
                    <textarea class="form-control" rows="3" id="brand_desc" placeholder="Keterangan ..."></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" id="add" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>


          <div class="modal fade" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModaleditLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Brand</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Nama Brand</label>
                    <input type="hidden" class="form-control" id="brand_id" readonly>
                    <input type="text" class="form-control" id="brand_name_edit" placeholder="Nama Brand">
                  </div>
                  <div class="form-group">
                    <label>Keterangan Brand</label>
                    <textarea class="form-control" rows="3" id="brand_desc_edit" placeholder="Keterangan ..."></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" id="edit" class="btn btn-primary">Save changes</button>
                </div>
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
              <th>Nama</th>
              <th>Deskripsi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($data['brand_list'] as $row){ ?>
              <tr>
                <td><?php echo $row->brand_name; ?></td>
                <td><?php echo $row->brand_desc; ?></td>
                <td>
                  <?php if($data['check_role'][0]->edit_ac == 'Y'){?>
                    <button data-id="<?php echo $row->brand_id; ?>" data-name="<?php echo $row->brand_name; ?>" data-desc="<?php echo $row->brand_desc; ?>" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModaledit"><i class="fas fa-edit"></i></button>
                  <?php }else{ ?>
                    <button data-id="<?php echo $row->brand_id; ?>" data-name="<?php echo $row->brand_name; ?>" data-desc="<?php echo $row->brand_desc; ?>" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModaledit" disabled><i class="fas fa-edit"></i></button>
                  <?php } ?>
                  <?php if($data['check_role'][0]->edit_ac == 'Y'){?>
                    <button data-name="<?php echo $row->brand_name; ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('<?php echo $row->brand_id; ?>', '<?php echo $row->brand_name; ?>')"><i class="fas fa-trash"></i></button>
                  <?php }else{ ?>
                    <button disabled data-name="<?php echo $row->brand_name; ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('<?php echo $row->brand_id; ?>', '<?php echo $row->brand_name; ?>')"><i class="fas fa-trash"></i></button>
                  <?php } ?>
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

<script type="text/javascript">
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
          url: "<?php echo base_url(); ?>Masterdata/delete_brand",
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
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#add').click(function(e){
      e.preventDefault();
      var brand_name = $("#brand_name").val();
      var brand_desc = $("#brand_desc").val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Masterdata/insert_brand",
        dataType: "json",
        data: {brand_name:brand_name, brand_desc:brand_desc},
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
  });


  $('#edit').click(function(e){
    e.preventDefault();
    var id = $("#brand_id").val();
    var brand_name_edit = $("#brand_name_edit").val();
    var brand_desc_edit = $("#brand_desc_edit").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/edit_brand",
      dataType: "json",
      data: {id:id, brand_name_edit:brand_name_edit, brand_desc_edit:brand_desc_edit},
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

  $('#btnreload').click(function(e){
    e.preventDefault();
    location.reload();
  });

  $('#exampleModaledit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id   = button.data('id')
    var brand_name_edit   = button.data('name')
    var brand_desc_edit   = button.data('desc')
    var modal = $(this)
    modal.find('.modal-title').text('Edit ' + brand_name_edit)
    modal.find('#brand_id').val(id)
    modal.find('#brand_name_edit').val(brand_name_edit)
    modal.find('#brand_desc_edit').val(brand_desc_edit)
  })
</script>
