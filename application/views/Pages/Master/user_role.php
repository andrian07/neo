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
          <h1>Role</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active">Rolev</li>
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
        <h3 class="card-title">List Role</h3>

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
                    <label>Nama Role</label>
                    <input type="text" class="form-control" id="role_name" placeholder="Nama Role">
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
                  <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Nama User</label>
                    <input type="hidden" class="form-control" id="role_id" readonly>
                    <input type="text" class="form-control" id="role_name_edit">
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

      <!-- Seting Permision -->


      <div class="modal fade" id="exampleModalsetting" tabindex="-1" role="dialog" aria-labelledby="exampleModalsettingLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Setting Permission</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table mt-3" style="text-align:cen">
                <thead>
                  <tr>
                    <th scope="col">Module</th>
                    <th scope="col" colspan="2">Hak Akses</th>
                  </tr>
                </thead>

                <tbody id="temp">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- End Seting Permision -->


      <div class="card-body">
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>Role</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($data['role_list'] as $row){ ?>
              <tr>
                <td><?php echo $row->role_name; ?></td>
                <td>
                  <?php if($data['check_role'][0]->edit_ac == 'Y'){?>
                    <button data-id="<?php echo $row->role_id ; ?>" data-name="<?php echo $row->role_name; ?>" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModaledit"><i class="fas fa-edit"></i></button>
                  <?php }else{ ?>
                    <button data-id="<?php echo $row->role_id ; ?>" data-name="<?php echo $row->role_name; ?>" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModaledit" disabled><i class="fas fa-edit"></i></button>
                  <?php } ?>
                  <?php if($data['check_role'][0]->delete_ac == 'Y'){?>
                    <button data-name="<?php echo $row->role_name; ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('<?php echo $row->role_id; ?>', '<?php echo $row->role_name; ?>')"><i class="fas fa-trash"></i></button>
                  <?php }else{ ?>
                    <button data-name="<?php echo $row->role_name; ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" data-title="Hapus" data-original-title="" title="" onclick="deletes('<?php echo $row->role_id; ?>', '<?php echo $row->role_name; ?>')" disabled><i class="fas fa-trash"></i></button>
                  <?php } ?>
                  <?php if($data['check_role'][0]->edit_ac == 'Y'){?>
                    <button data-id="<?php echo $row->role_id ; ?>" data-name="<?php echo $row->role_name; ?>" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModalsetting"><i class="fas fa-cog sizing-fa"></i></button>
                  <?php }else{ ?>
                    <button data-id="<?php echo $row->role_id ; ?>" data-name="<?php echo $row->role_name; ?>" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModalsetting" disabled><i class="fas fa-cog sizing-fa"></i></button>
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
          url: "<?php echo base_url(); ?>Masterdata/delete_role",
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
      var role_name = $("#role_name").val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Masterdata/insert_role",
        dataType: "json",
        data: {role_name:role_name},
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


  $(document).ready(function() {
    $('#edit_access').click(function(e){
      e.preventDefault();
      var Brand_view = $('form').serialize()
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Masterdata/insert_permission",
        dataType: "json",
        data: {data_isi:data_isi},
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
    var id = $("#role_id").val();
    var role_name_edit = $("#role_name_edit").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/edit_role",
      dataType: "json",
      data: {id:id, role_name_edit:role_name_edit},
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
    var role_name_edit   = button.data('name')
    var modal = $(this)
    modal.find('.modal-title').text('Edit ' + role_name_edit)
    modal.find('#role_id').val(id)
    modal.find('#role_name_edit').val(role_name_edit)
  })

  $('#exampleModalsetting').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id   = button.data('id')
    var role_name   = 'Ubah Aksess';
    var modal = $(this)
    modal.find('.modal-title').text(role_name)
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/get_setting_permission",
      dataType: "json",
      data: {id:id},
      success : function(data){

        console.log(data);
        let text_temp = "";
        for (let i = 0; i < data.length; i++) {

          if(data[i].view_ac == 'Y'){var view = 'Lihat, ';}else{var view = '';}
          if(data[i].add_ac == 'Y'){var add = 'Tambah, ';}else{var add = '';}
          if(data[i].edit_ac == 'Y'){var edit = 'Edit, ';}else{var edit = '';}
          if(data[i].delete_ac == 'Y'){var deletes = 'Hapus';}else{var deletes = '';}

          if(data[i].view_ac == 'N' && data[i].add_ac == 'N' && data[i].edit_ac == 'N' && data[i].delete_ac == 'N'){var view = 'No Access';}


          text_temp += 
          '<tr><td>'+data[i].module_name+'</td><td class="'+data[i].module_name+'" onclick="tdclick(this)"><a href="#" id="'+data[i].module_name+'title" class"'+data[i].module_name+'-title">'+view+''+add+''+edit+''+deletes+'</a><div id="'+data[i].module_name+'" class="hide-permission">'+
          '<input class="form-check-input" type="checkbox" value="" id="'+data[i].module_name+'_view"><label class="form-check-label" for="flexCheckDefault">Lihat</label> <br />'+
          '<input class="form-check-input" type="checkbox" value="" id="'+data[i].module_name+'_add"><label class="form-check-label" for="flexCheckDefault">Tambah</label> <br />'+
          '<input class="form-check-input" type="checkbox" value="" id="'+data[i].module_name+'_edit"><label class="form-check-label" for="flexCheckDefault">Edit</label> <br />'+
          '<input class="form-check-input" type="checkbox" value="" id="'+data[i].module_name+'_delete"><label class="form-check-label" for="flexCheckDefault">Hapus</label> <br />'+
          '</div></td>'+
          '<td><a href="#" class="'+data[i].module_name+'" id="'+data[i].module_name+'cancel" onclick="hide(this)" style="display:none;">Tutup</a>'+
          '<a href="#" class="'+data[i].module_name+'" id="'+data[i].module_name+'change_permision" onclick="change_permision('+data[i].module_name+', '+data[i].role_id+')" style="display:none;">Ubah</a></td>'+
          '</tr>'
        }

        document.getElementById("temp").innerHTML = text_temp;

        for (let s = 0; s < data.length; s++) {
          if(data[s].view_ac == 'Y'){
           $("#"+data[s].module_name+"_view").prop("checked", true);
         }
         if(data[s].add_ac == 'Y'){
           $("#"+data[s].module_name+"_add").prop("checked", true);
         }
         if(data[s].edit_ac == 'Y'){
           $("#"+data[s].module_name+"_edit").prop("checked", true);
         }
         if(data[s].delete_ac == 'Y'){
           $("#"+data[s].module_name+"_delete").prop("checked", true);
         }
       }
     }
   });
  })

  function tdclick(id){
    var name = id.className;
    var title = name+'title';
    var cancel = name+'cancel';
    var change_permision = name+'change_permision';
    document.getElementById(name).style.display = "block";
    document.getElementById(title).style.display = "none";
    document.getElementById(cancel).style.display = "block";
    document.getElementById(change_permision).style.display = "block";
  };

  function hide(id){
    var name = id.className;
    var title = name+'title';
    var cancel = name+'cancel';
    var change_permision = name+'change_permision';
    document.getElementById(title).style.display = "block";
    document.getElementById(name).style.display = "none";
    document.getElementById(cancel).style.display = "none";
    document.getElementById(change_permision).style.display = "none";
  };

  function change_permision(id, role_id){
    var permision    = id.id;
    var title_view   = permision+'_view';
    var title_add    = permision+'_add';
    var title_edit   = permision+'_edit';
    var title_delete = permision+'_delete';
    var view_value   = $('#'+title_view).is(':checked'); 
    var add_value    = $('#'+title_add).is(':checked'); 
    var edit_value   = $('#'+title_edit).is(':checked'); 
    var delete_value = $('#'+title_delete).is(':checked'); 
    
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/change_permision",
      dataType: "json",
      data: {permision:permision, view_value:view_value, add_value:add_value, edit_value:edit_value, delete_value:delete_value, role_id:role_id},
      success : function(data){
        if (data.code == "200"){
         document.getElementById("temp").innerHTML = text_temp; 
       } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: data.result,
        })
      }
    }
  });
  };

</script>
