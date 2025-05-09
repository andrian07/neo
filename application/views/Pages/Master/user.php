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
          <h1>User</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">User</li>
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
        <h3 class="card-title">List User</h3>

        <div class="card-tools"> 
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
                    <label>Nama User</label>
                    <input type="text" class="form-control" id="user_name" placeholder="Nama User">
                  </div>
                  <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" id="user_role">
                      <?php foreach($data['role_list'] as $row){ ?>
                        <option value="<?php echo $row->role_id ?>"><?php echo $row->role_name ?></option>
                      <?php } ?>
                    </select>
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
                    <label>Nama User</label>
                    <input type="hidden" class="form-control" id="user_id" readonly>
                    <input type="text" class="form-control" id="user_name_edit">
                  </div>
                  <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" id="user_role_edit">
                      <?php foreach($data['role_list'] as $row){ ?>
                        <option value="<?php echo $row->role_id ?>"><?php echo $row->role_name ?></option>
                      <?php } ?>
                    </select>
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
              <th>Role</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($data['user_list'] as $row){ ?>
              <tr>
                <td><?php echo $row->user_name; ?></td>
                <td>
                  <?php if($row->user_role == 1)
                  {
                    echo 'Superadmin'; 
                  }else{
                    echo 'Admin';
                  } ?>
                </td>
                <td>
                  <?php if($data['check_role'][0]->edit_ac == 'Y'){?>
                    <button data-id="<?php echo $row->user_id; ?>" data-name="<?php echo $row->user_name; ?>" data-roles="<?php echo $row->user_role; ?>" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModaledit"><i class="fas fa-edit"></i></button>
                  <?php }else{ ?>
                    <button data-id="<?php echo $row->user_id; ?>" data-name="<?php echo $row->user_name; ?>" data-roles="<?php echo $row->user_role; ?>" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModaledit" disabled><i class="fas fa-edit"></i></button>
                  <?php } ?>

                  <?php if($data['check_role'][0]->delete_ac == 'Y'){?>
                    <button data-name="<?php echo $row->user_name; ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('<?php echo $row->user_id; ?>', '<?php echo $row->user_name; ?>')"><i class="fas fa-trash"></i></button>
                  <?php }else{ ?>
                    <button data-name="<?php echo $row->user_name; ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('<?php echo $row->user_id; ?>', '<?php echo $row->user_name; ?>')"><i class="fas fa-trash"></i></button>
                  <?php } ?>

                  <?php if($data['check_role'][0]->edit_ac == 'Y'){?>
                    <button data-id="<?php echo $row->user_id; ?>" data-name="<?php echo $row->user_name; ?>" data-roles="<?php echo $row->user_role; ?>" class="btn btn-sm btn-info"><i class="fas fa-key"></i></button>
                  <?php }else{ ?>
                    <button data-id="<?php echo $row->user_id; ?>" data-name="<?php echo $row->user_name; ?>" data-roles="<?php echo $row->user_role; ?>" class="btn btn-sm btn-info" disabled><i class="fas fa-key"></i></button>
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
          url: "<?php echo base_url(); ?>Masterdata/delete_user",
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
      var user_name = $("#user_name").val();
      var user_role = $("#user_role").val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Masterdata/insert_user",
        dataType: "json",
        data: {user_name:user_name, user_role:user_role},
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
    var id = $("#user_id").val();
    var user_name_edit = $("#user_name_edit").val();
    var user_role_edit = $("#user_role_edit").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/edit_user",
      dataType: "json",
      data: {id:id, user_name_edit:user_name_edit, user_role_edit:user_role_edit},
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
    var user_name_edit   = button.data('name')
    var user_role_edit   = button.data('roles')
    var modal = $(this)
    modal.find('.modal-title').text('Edit ' + user_name_edit)
    modal.find('#user_id').val(id)
    modal.find('#user_name_edit').val(user_name_edit)
    modal.find('#user_role_edit').val(user_role_edit)
  })
</script>
